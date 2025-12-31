<?php
session_start();
require_once( '../db_connection/connection.php' );

// Check if form is submitted
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {

    // Get form data
    $email_or_username = trim( $_POST[ 'email' ] );
    $password = $_POST[ 'password' ];
    $remember = isset( $_POST[ 'remember' ] ) ? 1 : 0;

    // Basic validation
    if ( empty( $email_or_username ) || empty( $password ) ) {
        $_SESSION[ 'login_error' ] = 'Please fill in all fields';
        header( 'Location: ../join.php#form' );
        exit();
    }

    // Prepare SQL query to find user by email or username
    $query = 'SELECT * FROM users WHERE (email = ? OR username = ?) ';
    $stmt = mysqli_prepare( $conn, $query );

    if ( $stmt ) {
        // Bind parameters
        mysqli_stmt_bind_param( $stmt, 'ss', $email_or_username, $email_or_username );

        // Execute query
        if ( mysqli_stmt_execute( $stmt ) ) {
            $result = mysqli_stmt_get_result( $stmt );

            // Check if user exists
            if ( $user = mysqli_fetch_assoc( $result ) ) {

                // Verify password
                if ( password_verify( $password, $user[ 'password' ] ) ) {

                    // Set session variables
                    $_SESSION[ 'user_id' ] = $user[ 'id' ];
                    $_SESSION[ 'user_name' ] = $user[ 'first_name' ] . ' ' . $user[ 'last_name' ];
                    $_SESSION[ 'user_email' ] = $user[ 'email' ];
                    $_SESSION[ 'username' ] = $user[ 'username' ];
                    $_SESSION[ 'logged_in' ] = true;

                    // Update last login time
                    // $updateQuery = 'UPDATE users SET last_login = NOW() WHERE id = ?';
                    // $updateStmt = mysqli_prepare( $conn, $updateQuery );
                    // mysqli_stmt_bind_param( $updateStmt, 'i', $user[ 'id' ] );
                    // mysqli_stmt_execute( $updateStmt );
                    // mysqli_stmt_close( $updateStmt );

                    // Set remember me cookie if requested
                    if ( $remember ) {
                        $token = bin2hex( random_bytes( 32 ) );
                        setcookie( 'remember_token', $token, time() + ( 30 * 24 * 60 * 60 ), '/' );
                    }

                    // Redirect to homepage or dashboard
                    header( 'Location: ../index.php' );
                    exit();

                } else {
                    $_SESSION[ 'login_error' ] = 'Invalid email/username or password';
                }

            } else {
                $_SESSION[ 'login_error' ] = 'Invalid email/username or password';
            }

        } else {
            $_SESSION[ 'login_error' ] = 'Database error occurred';
        }

        mysqli_stmt_close( $stmt );

    } else {
        $_SESSION[ 'login_error' ] = 'Database connection error';
    }

    // Redirect back to login page with error
    header( 'Location: ../join_us.php#form' );
    exit();

} else {
    // If not POST request, redirect to login page
    header( 'Location: ../join_us.php' );
    exit();
}
?>