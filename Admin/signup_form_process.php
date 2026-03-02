<?php
session_start();
include '../db_connection/connection.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $first_name = isset( $_POST[ 'firstName' ] ) ? trim( $_POST[ 'firstName' ] ) : '';
    $last_name = isset( $_POST[ 'lastName' ] ) ? trim( $_POST[ 'lastName' ] ) : '';
    $email = isset( $_POST[ 'email' ] ) ? trim( $_POST[ 'email' ] ) : '';
    $username = isset( $_POST[ 'username' ] ) ? trim( $_POST[ 'username' ] ) : '';
    $password = isset( $_POST[ 'password' ] ) ? $_POST[ 'password' ] : '';
    $confirm_password = isset( $_POST[ 'confirmPassword' ] ) ? $_POST[ 'confirmPassword' ] : '';

    // Basic validation
    if ( empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $username ) || empty( $password ) ) {
        $_SESSION[ 'error' ] = 'Please fill in all required fields.';
        header( 'Location: ../join_us.php#form' );
        exit;
    }

    if ( $password !== $confirm_password ) {
        $_SESSION[ 'error' ] = 'Passwords do not match!';
        header( 'Location: ../join_us.php#form' );
        exit;
    }

    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        $_SESSION[ 'error' ] = 'Please provide a valid email address.';
        header( 'Location: ../join_us.php#form' );
        exit;
    }

    // Check for existing email or username
    $check_stmt = $conn->prepare( 'SELECT id FROM users WHERE email = ? OR username = ? LIMIT 1' );
    if ( !$check_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: ../join_us.php#form' );
        exit;
    }
    $check_stmt->bind_param( 'ss', $email, $username );
    $check_stmt->execute();
    $res = $check_stmt->get_result();
    if ( $res && $res->num_rows > 0 ) {
        $_SESSION[ 'error' ] = 'Email or username already in use.';
        $check_stmt->close();
        header( 'Location: ../join_us.php#form' );
        exit;
    }
    $check_stmt->close();

    $hashed_password = password_hash( $password, PASSWORD_DEFAULT );

    $stmt = $conn->prepare( 'INSERT INTO users (first_name, last_name, email, username, password) VALUES (?, ?, ?, ?, ?)' );
    if ( !$stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: ../join_us.php#form' );
        exit;
    }
    $stmt->bind_param( 'sssss', $first_name, $last_name, $email, $username, $hashed_password );

    if ( $stmt->execute() ) {
        // Do NOT auto-login. Instruct user to sign in.
        $stmt->close();
        $conn->close();

        $_SESSION[ 'signup_success' ] = 'Account created successfully. Please sign in using your credentials.';
        header( 'Location: ../join_us.php#form' );
        exit;
    } else {
        $_SESSION[ 'error' ] = 'Error creating account: ' . $stmt->error;
        $stmt->close();
        $conn->close();
        header( 'Location: ../join_us.php#form' );
        exit;
    }
}
// If not POST, redirect back
header( 'Location: ../join_us.php#form' );
exit;
?>