<?php
session_start();
include 'include/db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $contact_name = mysqli_real_escape_string($con, $_POST['name']);
    $contact_email = mysqli_real_escape_string($con, $_POST['email']);
    $contact_heading = mysqli_real_escape_string($con, $_POST['subject']);
    $contact_desc = mysqli_real_escape_string($con, $_POST['message']);

    // SQL query to insert data into the database
    $insert_query = "INSERT INTO contact_us (name, contact_email, contact_heading, contact_desc)
VALUES ('$contact_name', '$contact_email', '$contact_heading', '$contact_desc')";

    if (mysqli_query($con, $insert_query)) {
        // Redirect to a thank you page or show success message
        echo "<script>alert('Your message has been sent successfully!');</script>";
        echo "<script>window.open('contact.php', '_self');</script>";
    } else {
        // Handle error
        echo "Error: " . $insert_query . "<br>" . mysqli_error($con);
    }
}
