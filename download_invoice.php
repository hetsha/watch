<?php
require('fpdf/fpdf.php');

// Database connection
$servername = "localhost";
$username = "root"; // Change as per your database credentials
$password = "";
$dbname = "ecom_store";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order ID from the URL
$order_id = (int)$_GET['order_id'];

// Fetch order details
$stmt = $conn->prepare("
    SELECT o.order_id, o.order_total, o.order_date, c.customer_name, c.customer_email, c.customer_address, c.customer_city, c.state, c.zip_code, c.customer_contact, c.phone_number
    FROM customer_orders o
    JOIN customers c ON o.customer_id = c.customer_id
    WHERE o.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderDetails = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch order items
$stmt = $conn->prepare("
    SELECT oi.product_id, p.product_title, oi.qty, oi.price
    FROM order_items oi
    JOIN products p ON oi.product_id = p.product_id
    WHERE oi.order_id = ?
");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$orderItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Title
$pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

// Order Details
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Order ID: ' . htmlspecialchars($orderDetails['order_id']), 0, 1);
$pdf->Cell(0, 10, 'Customer Name: ' . htmlspecialchars($orderDetails['customer_name']), 0, 1);
$pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($orderDetails['customer_email']), 0, 1);
$pdf->Cell(0, 10, 'Order Date: ' . htmlspecialchars($orderDetails['order_date']), 0, 1);
$pdf->Cell(0, 10, 'Total Amount: ₹' . htmlspecialchars($orderDetails['order_total']), 0, 1);
$pdf->Ln(10);

// Shipping Address
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Shipping Address', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, htmlspecialchars($orderDetails['customer_address']) . ', ' . htmlspecialchars($orderDetails['customer_city']) . ', ' . htmlspecialchars($orderDetails['state']) . ', ' . htmlspecialchars($orderDetails['zip_code']));

// Order Items
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(80, 10, 'Product Name', 1);
$pdf->Cell(30, 10, 'Quantity', 1);
$pdf->Cell(40, 10, 'Price', 1);
$pdf->Cell(40, 10, 'Total', 1);
$pdf->SetFont('Arial', '', 12);

foreach ($orderItems as $item) {
    $pdf->Cell(80, 10, htmlspecialchars($item['product_title']), 1);
    $pdf->Cell(30, 10, htmlspecialchars($item['qty']), 1);
    $pdf->Cell(40, 10, '₹' . htmlspecialchars($item['price']), 1);
    $pdf->Cell(40, 10, '₹' . ($item['qty'] * $item['price']), 1);
    $pdf->Ln();
}

// Output the PDF
$pdf->Output('D', 'Invoice_' . $order_id . '.pdf');

$conn->close();
exit();
?>
