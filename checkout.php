<?php
session_start();
include 'include/db.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if the customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Get customer ID from session
$customerID = (int)$_SESSION['customer_id'];

// Fetch customer details from the database
$stmt = $con->prepare("
    SELECT customer_name, customer_email, customer_address, customer_city, state, zip_code, customer_contact, phone_number
    FROM customers
    WHERE customer_id = ?
");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();
$customerDetails = $result->fetch_assoc();

// Fetch cart items
$stmt = $con->prepare("
    SELECT cart.product_id, cart.qty AS quantity, cart.p_price AS price, products.product_title
    FROM cart
    JOIN products ON cart.product_id = products.product_id
    WHERE cart.customer_id = ?
");
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$orderItems = [];

if ($result->num_rows === 0) {
    echo "Error: Cart is empty.";
    exit();
}

while ($row = $result->fetch_assoc()) {
    $orderItems[] = $row;
    $total += $row['price'] * $row['quantity'];
}

$_SESSION['cart_total'] = $total;

// Shiprocket API Credentials
$shiprocket_email = "hetshah6312@gmail.com";
$shiprocket_password = "Het@9117";

// Indian State Codes Map
$state_codes = [
    "Andhra Pradesh" => "AP",
    "Gujarat" => "GJ",
    "Maharashtra" => "MH",
    "Delhi" => "DL",
    "Rajasthan" => "RJ",
    "Tamil Nadu" => "TN",
    "Uttar Pradesh" => "UP",
    "West Bengal" => "WB"
];

// Get Shiprocket Token
function getShiprocketToken($email, $password)
{
    $url = "https://apiv2.shiprocket.in/v1/external/auth/login";
    $data = json_encode(["email" => $email, "password" => $password]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    return $json['token'] ?? null;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect billing info
    $payment_mode = htmlspecialchars(trim($_POST['payment_mode']));

    // Validation
    $required_fields = ['customer_name', 'customer_email', 'customer_address', 'customer_city', 'state', 'zip_code', 'phone_number'];
    foreach ($required_fields as $field) {
        if (empty($customerDetails[$field])) {
            echo "Error: All fields are required.";
            exit();
        }
    }

    // Convert state name to code
    $billing_state_code = $state_codes[$customerDetails['state']] ?? $customerDetails['state'];

    // Shiprocket Integration
    $token = getShiprocketToken($shiprocket_email, $shiprocket_password);
    if (!$token) {
        echo "Error: Unable to authenticate with Shiprocket.";
        exit();
    }

    // Generate order ID before using it
    $order_id = $customerID . time();

    // Build Shiprocket Order Payload
    // Build Shiprocket Order Payload
    $shiprocket_order_data = [
        "order_id" => $order_id,
        "order_date" => date("Y-m-d H:i"),
        "pickup_location" => "Primary",
        "billing_address" => [
            "customer_name" => $customerDetails['customer_name'] ?? '',
            "email" => $customerDetails['customer_email'] ?? '',
            "address" => $customerDetails['customer_address'] ?? '',
            "city" => $customerDetails['customer_city'] ?? '',
            "state" => $billing_state_code,
            "pincode" => (int)($customerDetails['zip_code'] ?? 0),
            "country" => "India",
            "phone" => (string)($customerDetails['phone_number'] ?? 0)
        ],
        "shipping_is_billing" => true,
        "order_items" => array_map(function ($item) {
            return [
                "name" => $item['product_title'],
                "sku" => "PROD" . $item['product_id'],
                "units" => (int)$item['quantity'],
                "selling_price" => (float)$item['price']
            ];
        }, $orderItems),
        "payment_method" => $payment_mode,
        "sub_total" => (float)$total,
        "length" => 10.0,
        "breadth" => 10.0,
        "height" => 10.0,
        "weight" => 0.5
    ];

    // Debug Payload
    echo "<h3>Shiprocket Payload:</h3>";
    echo "<pre>" . json_encode($shiprocket_order_data, JSON_PRETTY_PRINT) . "</pre>";

    // Send Order to Shiprocket
    $ch = curl_init("https://apiv2.shiprocket.in/v1/external/orders/create/adhoc");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($shiprocket_order_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    ]);

    function getShiprocketOrderDetails($order_id, $token)
    {
        $url = "https://apiv2.shiprocket.in/v1/external/orders/show/" . $order_id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $token"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    // Example usage:
    // $order_id is already defined earlier
    $orderDetails = getShiprocketOrderDetails($order_id, $token);

    echo "<h3>Shiprocket Order Details:</h3>";
    echo "<pre>" . json_encode($orderDetails, JSON_PRETTY_PRINT) . "</pre>";

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $shiprocket_response = json_decode($response, true);

    echo "<h3>Shiprocket Response (HTTP Code: $http_code):</h3>";
    echo "<pre>" . json_encode($shiprocket_response, JSON_PRETTY_PRINT) . "</pre>";

    if ($http_code !== 200) {
        echo "Error: Failed to create Shiprocket order.";
        exit();
    }

    echo "<h3>Order successfully sent to Shiprocket!</h3>";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - ORA</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="assets/img/favicon.png" sizes="32x32" />
    <link rel="icon" href="assets/img/favicon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/assets/img/favicon.png" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <style>
        .btn-primary {
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #004085;
        }

        input,
        select {
            transition: border 0.3s ease;
        }

        input:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.6);
        }
    </style>
</head>

<body>
    <?php include 'include/navbar.php'; ?>
    <main class="wrapper">
        <section class="hero blog-hero">
            <div class="container-fluid">
                <h2>Checkout</h2>
                <p>Review your order and enter your billing information.</p>
            </div>
        </section>
        <section class="order-details">
            <div class="container">
                <br>
                <h3>Order Summary</h3>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price']); ?></td>
                                <td>₹<?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total Amount</strong></td>
                            <td><strong>₹<?php echo htmlspecialchars($total); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
                <h4>Billing Information</h4>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="customer_address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="customer_address" id="customer_address"
                            value="<?php echo htmlspecialchars($customerDetails['customer_address']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_city" class="form-label">City</label>
                        <input type="text" class="form-control" name="customer_city" id="customer_city"
                            value="<?php echo htmlspecialchars($customerDetails['customer_city']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <input type="text" class="form-control" name="state" id="state"
                            value="<?php echo htmlspecialchars($customerDetails['state']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" class="form-control" name="zip_code" id="zip_code"
                            value="<?php echo htmlspecialchars($customerDetails['zip_code']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_contact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" name="customer_contact" id="customer_contact"
                            value="<?php echo htmlspecialchars($customerDetails['customer_contact']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number" id="phone_number"
                            value="<?php echo htmlspecialchars($customerDetails['phone_number']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select" name="payment_mode" id="payment_mode" required>
                            <option value="" disabled>Select Payment Mode</option>
                            <option value="Credit Card">Credit Card</option>
                            <option value="Debit Card">Debit Card</option>
                            <option value="Net Banking">Net Banking</option>
                            <option value="UPI">UPI</option>
                            <option value="COD">COD(CASH ON DEILIVERY)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Place Order</button>
                    <button type="button" class="btn btn-primary" onclick="window.location.href='cart.php';">
                        Go to Cart
                    </button>
                </form>
            </div>
        </section>
    </main>
    <br>
    <?php
    include 'include/news.php';
    include 'include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>