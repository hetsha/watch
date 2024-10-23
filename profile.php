<?php
session_start();
include 'include/db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$user_id = $_SESSION['customer_id']; // Fetch customer_id from session
$query = "SELECT customer_name, customer_email, created_at, customer_pass, profile_pic FROM customers WHERE customer_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Initialize order and invoice results
$order_result = null;
$invoice_result = null;

// Message variable
$message = '';

// Fetch user orders
$order_query = "SELECT order_id, order_date, order_total FROM customer_orders WHERE customer_id = ?";
$order_stmt = $con->prepare($order_query);
$order_stmt->bind_param('i', $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

// Fetch user invoices
$invoice_query = "SELECT invoice_id, order_id, order_date AS invoice_date, invoice_number FROM invoices WHERE customer_id = ?";
$invoice_stmt = $con->prepare($invoice_query);
$invoice_stmt->bind_param('i', $user_id);
$invoice_stmt->execute();
$invoice_result = $invoice_stmt->get_result();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Handle profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['profile_pic']['name']);
        $target_file = $upload_dir . uniqid() . '-' . $file_name;
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
            // Update profile picture path in database
            $update_pic_query = "UPDATE customers SET profile_pic = ? WHERE customer_id = ?";
            $pic_stmt = $con->prepare($update_pic_query);
            $pic_stmt->bind_param('si', $target_file, $user_id);
            $pic_stmt->execute();
        }
    }

    // Update user information
    $update_query = "UPDATE customers SET customer_name = ?, customer_email = ? WHERE customer_id = ?";
    $update_stmt = $con->prepare($update_query);
    $update_stmt->bind_param('ssi', $new_username, $new_email, $user_id);

    if ($update_stmt->execute()) {
        $_SESSION['customer_name'] = $new_username; // Update session username if needed
        $message = "<div class='alert alert-success'>Profile updated successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Failed to update profile.</div>";
    }

    // Update password
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        // Verify current password (without hashing)
        if ($current_password === $user['customer_pass']) {
            if ($new_password === $confirm_password) {
                // Update password in database
                $password_update_query = "UPDATE customers SET customer_pass = ? WHERE customer_id = ?";
                $password_stmt = $con->prepare($password_update_query);
                $password_stmt->bind_param('si', $new_password, $user_id);

                if ($password_stmt->execute()) {
                    $message = "<div class='alert alert-success'>Password updated successfully!</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Failed to update password.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>New password and confirmation do not match.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>Current password is incorrect.</div>";
        }
    }

    // Re-fetch user details after update
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ORA - Watches</title>
    <meta name="description" content="ORA - Watches &amp; Jewelry | Products">
    <meta name="author" content="Author Name">
    <meta name="keywords" content="Or&euml; Dore, Syze, Bizhuteri, Aksesore, Outlet etc..." />
    <?php include 'include/fav.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .profile-container {
            display: flex;
            align-items: center;
            /* Align items vertically */
            margin-bottom: 20px;
            /* Space below the profile section */
        }

        .profile-pic {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 15px;
            /* Space between image and text */
        }
    </style>
</head>

<body>

    <?php include 'include/navbar.php'; ?>
    <section class="hero blog-hero">
        <div class="container-fluid">
            <h2>User Profile</h2>
            <p>Every day is a new beginning. Take a deep breath, smile, and start again.</p>
        </div>
    </section>
    <br>
    <div class="container mt-5 text-center">
        <!-- <h2>User Profile</h2> -->
        <div class="profile-container">
            <?php if (!empty($user['profile_pic'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic">
            <?php else: ?>
                <img src="path/to/default/profile_pic.jpg" alt="Default Profile Picture" class="profile-pic">
            <?php endif; ?>
            <div>
                <h4><?php echo htmlspecialchars($user['customer_name']); ?></h4>
                <p><?php echo htmlspecialchars($user['customer_email']); ?></p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="card mb-4">
            <div class="card-header">Personal Information</div>
            <div class="card-body">
                <?php if ($message): ?>
                    <div id="message"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['customer_name']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['customer_email']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="created_at" class="form-label">Account Created:</label>
                        <input type="text" id="created_at" class="form-control" value="<?php echo htmlspecialchars($user['created_at']); ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password:</label>
                        <div class="input-group">
                            <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Enter current password" required>
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">Show</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="profile_pic" class="form-label">Profile Picture:</label>
                        <input type="file" id="profile_pic" name="profile_pic" class="form-control" accept="image/*">
                        <?php if (!empty($user['profile_pic'])): ?>
                            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Profile Picture" class="profile-pic mt-2">
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="card mb-4">
            <div class="card-header">Your Orders</div>
            <div class="card-body">
                <?php if ($order_result && $order_result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $order_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                    <td><?php echo htmlspecialchars($order['order_total']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No orders found.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Invoices Section -->
        <div class="card mb-4">
            <div class="card-header">Your Invoices</div>
            <div class="card-body">
                <?php if ($invoice_result && $invoice_result->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>Invoice Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($invoice = $invoice_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($invoice['invoice_id']); ?></td>
                                    <td><?php echo htmlspecialchars($invoice['invoice_date']); ?></td>
                                    <td><?php echo htmlspecialchars($invoice['invoice_number']); ?></td>
                                    <td>
                                        <a href="download_invoice.php?order_id=<?php echo urlencode($invoice['order_id']); ?>" class="btn btn-primary">
                                            Download Invoice
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No invoices found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- JavaScript to hide messages after 3 seconds -->
    <script>
        window.onload = function() {
            const messageDiv = document.getElementById('message');
            if (messageDiv) {
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        };

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const currentPasswordInput = document.getElementById('current_password');
        togglePassword.addEventListener('click', () => {
            const type = currentPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            currentPasswordInput.setAttribute('type', type);
            togglePassword.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    include 'include/news.php';
    include 'include/footer.php';
    ?>
</body>

</html>