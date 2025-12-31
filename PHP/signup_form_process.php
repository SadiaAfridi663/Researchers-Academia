<?php
include '../db_connection/connection.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $first_name = trim( $_POST[ 'firstName' ] );
    $last_name = trim( $_POST[ 'lastName' ] );
    $email = trim( $_POST[ 'email' ] );
    $username = trim( $_POST[ 'username' ] );
    $password = trim( $_POST[ 'password' ] );
    $confirm_password = trim( $_POST[ 'confirmPassword' ] );

    if ( $password !== $confirm_password ) {
        die( 'Passwords do not match!' );
    }

    $hashed_password = password_hash( $password, PASSWORD_DEFAULT );

    $stmt = $conn->prepare( 'INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)' );
    $stmt->bind_param( 'sssss', $first_name, $last_name, $email, $username, $hashed_password );

    if ( $stmt->execute() ) {
        echo 'Signup successful!';
        header( 'Location: ../join_us.php' );
        exit;
    } else {
        echo 'Error: ' . $stmt->error;
    }

    // header( 'location:../join_us.php' );
    $stmt->close();
    $conn->close();
}
?>