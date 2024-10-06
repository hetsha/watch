<?php
// Include the DOMPDF library
require 'vendor/autoload.php'; // If you installed via Composer

// Use the DOMPDF namespace
use Dompdf\Dompdf;
use Dompdf\Options;

// Create a new instance of DOMPDF
$options = new Options();
$options->set('defaultFont', 'Arial'); // Set a default font (optional)
$options->set('isHtml5ParserEnabled', true); // Enable HTML5 parser
$dompdf = new Dompdf($options);

// Sample data (replace this with your actual order data)
$orderDetails = [
    'order_id' => 33,
    'customer_name' => 'het',
    'customer_email' => 'hetshah6315@gmail.com',
    'order_date' => '2024-10-06 22:26:11',
    'order_total' => 1856.00,
    'customer_address' => 'Ahmedabad',
    'customer_city' => 'Ahmedabad',
    'state' => 'Gujarat',
    'zip_code' => '380007'
];

$orderItems = [
    ['product_title' => 'test2', 'qty' => 8, 'price' => 232.00]
];

// Create HTML for the PDF
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<h2>Invoice</h2>
<p>Order ID: ' . htmlspecialchars($orderDetails['order_id']) . '</p>
<p>Customer Name: ' . htmlspecialchars($orderDetails['customer_name']) . '</p>
<p>Email: ' . htmlspecialchars($orderDetails['customer_email']) . '</p>
<p>Order Date: ' . htmlspecialchars($orderDetails['order_date']) . '</p>
<p>Total Amount: ₹' . htmlspecialchars(number_format($orderDetails['order_total'], 2)) . '</p>
<h3>Shipping Address</h3>
<p>' . htmlspecialchars($orderDetails['customer_address']) . ', ' . htmlspecialchars($orderDetails['customer_city']) . ', ' . htmlspecialchars($orderDetails['state']) . ', ' . htmlspecialchars($orderDetails['zip_code']) . '</p>
<h3>Order Items</h3>
<table>
    <tr>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total</th>
    </tr>';

$total = 0; // Initialize total for calculating the total amount of the invoice

foreach ($orderItems as $item) {
    $itemTotal = $item['qty'] * $item['price'];
    $total += $itemTotal; // Accumulate total
    $html .= '<tr>
                <td>' . htmlspecialchars($item['product_title']) . '</td>
                <td>' . htmlspecialchars($item['qty']) . '</td>
                <td>₹' . htmlspecialchars(number_format($item['price'], 2)) . '</td>
                <td>₹' . htmlspecialchars(number_format($itemTotal, 2)) . '</td>
              </tr>';
}

$html .= '</table>';
$html .= '<h3>Final Total Amount: ₹' . number_format($total, 2) . '</h3>';
$html .= '</body></html>';

// Load the HTML content into DOMPDF
$dompdf->loadHtml($html);

// Set paper size and orientation (A4, portrait)
$dompdf->setPaper('A4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to browser for download
$dompdf->stream('invoice_' . $orderDetails['order_id'] . '.pdf', ['Attachment' => true]);
?>
