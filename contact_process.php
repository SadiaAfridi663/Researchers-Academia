<?php
// contact_process.php
// Handles the contact form submission - beginner level, step by step

// Step 1 – Connect to the database
include 'db_connection/connection.php';

// Step 2 – Only run if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Step 3 – Get the data the user typed in the form
    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $phone      = trim($_POST['phone']);
    $department = trim($_POST['department']);
    $subject    = trim($_POST['subject']);
    $message    = trim($_POST['message']);

    // Step 4 – Basic checks: name, email and message must not be empty
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        // Go back to the form with an error
        header('Location: contact_us.php?status=error&msg=Please+fill+in+all+required+fields');
        exit();
    }

    // Step 5 – Make the data safe before putting it in the database
    $name       = mysqli_real_escape_string($conn, $name);
    $email      = mysqli_real_escape_string($conn, $email);
    $phone      = mysqli_real_escape_string($conn, $phone);
    $department = mysqli_real_escape_string($conn, $department);
    $subject    = mysqli_real_escape_string($conn, $subject);
    $message    = mysqli_real_escape_string($conn, $message);

    // Step 6 – Write the SQL query to save the message
    $sql = "INSERT INTO contact_messages (name, email, phone, department, subject, message)
            VALUES ('$name', '$email', '$phone', '$department', '$subject', '$message')";

    // Step 7 – Run the query
    $result = mysqli_query($conn, $sql);

    // Step 8 – Check if it worked
    if ($result) {
        // Success! Go back to the contact page with a success message
        header('Location: contact_us.php?status=success');
        exit();
    } else {
        // Something went wrong with the database
        header('Location: contact_us.php?status=error&msg=Something+went+wrong+Please+try+again');
        exit();
    }

} else {
    // If someone visits this file directly without submitting the form, send them back
    header('Location: contact_us.php');
    exit();
}
?>
