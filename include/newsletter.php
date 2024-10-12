<?php
// Include your database connection file
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email from the form
    $email = $_POST['email'];

    // Prepare the SQL statement to insert the email into the enquiry_types table
    $insert_query = "INSERT INTO enquiry_types (enquiry_title) VALUES ('$email')";

    // Execute the query
    if (mysqli_query($con, $insert_query)) {
        echo "<script>alert('Thank you for signing up! You will receive updates via email.')</script>";
        echo "<script>window.open('../index.php', '_self')</script>"; // Redirect to your home page or another page
    } else {
        echo "<script>alert('Error: Could not sign you up. Please try again later.')</script>";
        echo "<script>window.open('../index.php', '_self')</script>";
    }
}
?>
