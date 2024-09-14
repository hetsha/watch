<?php
include("include/db.php");

// SQL query to create the table
$sql = "CREATE TABLE `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `quantity` INT NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `customer_orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
);";

// Execute the query
if ($con->query($sql) === TRUE) {
    echo "Table 'order_items' created successfully.";
} else {
    echo "Error creating table: " . $con->error;
}

// Close the connection
$con->close();
?>
