<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'include/db.php'; // Include your database connection
require 'vendor/fpdf/fpdf.php'; // Adjust the path if needed

header('Content-Type: text/html; charset=utf-8'); // Set UTF-8 encoding

$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Check database connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Fetch order, customer, invoice, and order items details in a single query
    $orderDetailsQuery = "
        SELECT o.*, c.customer_name, c.customer_email, c.customer_address, c.customer_city, c.state, c.zip_code, i.invoice_number,
               oi.product_id, oi.qty, oi.price, p.product_title
        FROM customer_orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN invoices i ON o.order_id = i.order_id
        JOIN order_items oi ON o.order_id = oi.order_id
        JOIN products p ON oi.product_id = p.product_id
        WHERE o.order_id = $order_id";

    $orderResult = $con->query($orderDetailsQuery);

    // Check for SQL error
    if (!$orderResult) {
        die("SQL Error: " . $con->error);
    }

    if ($orderResult->num_rows > 0) {
        $orderItems = [];
        while ($row = $orderResult->fetch_assoc()) {
            $orderDetails = $row; // Fetch the main order details (this will be the same for all rows)
            $orderItems[] = $row; // Fetch the order items (this will be different for each row)
        }

        if (empty($orderItems)) {
            echo "No items found for this order.";
            exit;
        }

        // Create PDF
        ob_start(); // Start output buffering
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 12); // Set the font to Arial

        // Company Info
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'ORA WATCH', 0, 1, 'C'); // Replace with your company name
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Lorem ipsum dolor, sit amet consectetur adipisicing', 0, 1, 'C'); // Replace with your company address
        $pdf->Cell(0, 10, 'Phone: +91 8345678906', 0, 1, 'C'); // Replace with your company phone
        $pdf->Cell(0, 10, 'Email: orawatch@gmail.com', 0, 1, 'C'); // Replace with your company email

        // Logo
        $pdf->Image('assets/img/other/logo-dark.jpeg', 10, 10, 30); // Adjust path and size as needed

        // Set title
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

        // Set font for invoice details
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Order ID: ' . htmlspecialchars($orderDetails['order_id']), 0, 1);
        $pdf->Cell(0, 10, 'Invoice No: ' . htmlspecialchars($orderDetails['invoice_number'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 10, 'Customer Name: ' . htmlspecialchars($orderDetails['customer_name'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . htmlspecialchars($orderDetails['customer_email'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 10, 'Order Date: ' . htmlspecialchars($orderDetails['order_date'] ?? 'N/A'), 0, 1);
        $pdf->Cell(0, 10, 'Total Amount: Rs ' . htmlspecialchars(number_format($orderDetails['order_total'], 2)), 0, 1);

        // Shipping Address
        $addressLines = [
            htmlspecialchars($orderDetails['customer_name'] ?? 'N/A'),
            htmlspecialchars($orderDetails['customer_address'] ?? 'N/A'),
            htmlspecialchars($orderDetails['customer_city'] ?? 'N/A') . ', ' .
                htmlspecialchars($orderDetails['state'] ?? 'N/A') . ', ' .
                htmlspecialchars($orderDetails['zip_code'] ?? 'N/A')
        ];

        $pdf->MultiCell(0, 10, 'Shipping Address:');
        foreach ($addressLines as $line) {
            $pdf->MultiCell(0, 10, $line);
        }

        // Order Items Table Header
        $pdf->SetFillColor(200, 220, 255); // Light blue background
        $pdf->Cell(80, 10, 'Product Name', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Price', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);

        $total = 0;
        foreach ($orderItems as $item) {
            $itemTotal = $item['qty'] * $item['price'];
            $total += $itemTotal;

            // Display product title
            $pdf->Cell(80, 10, htmlspecialchars($item['product_title'] ?? 'N/A'), 1);
            $pdf->Cell(30, 10, htmlspecialchars($item['qty'] ?? 'N/A'), 1);
            $pdf->Cell(30, 10, 'Rs ' . htmlspecialchars(number_format($item['price'], 2) ?? 0), 1);
            $pdf->Cell(30, 10, 'Rs ' . htmlspecialchars(number_format($itemTotal, 2)), 1);
            $pdf->Ln();
        }

        $pdf->Cell(140, 10, 'Final Total Amount:', 1);
        $pdf->Cell(30, 10, 'Rs ' . number_format($total, 2), 1);
        $pdf->Ln();

        // Thank You Message
        $pdf->Ln(10); // Add some space
        $pdf->SetFont('Arial', 'I', 12); // Italic font
        $pdf->Cell(0, 10, 'Thank you for your purchase!', 0, 1, 'C');
        $pdf->Cell(0, 10, 'We appreciate your business!', 0, 1, 'C');

        // Output the PDF
        $pdf->Output('D', 'invoice_' . htmlspecialchars($order_id) . '.pdf');
        ob_end_flush(); // Flush output buffer
    } else {
        echo "No order found for Order ID: $order_id"; // Show order ID in the message
    }

    $con->close();
} else {
    echo "Invalid order ID.";
}
