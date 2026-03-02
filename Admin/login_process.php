<?php
session_start();
require_once( '../db_connection/connection.php' );

if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {

    $email_or_username = trim( $_POST[ 'email' ] );
    $password = $_POST[ 'password' ];
    $remember = isset( $_POST[ 'remember' ] ) ? 1 : 0;

    if ( empty( $email_or_username ) || empty( $password ) ) {
        $_SESSION[ 'login_error' ] = 'Please fill in all fields';
        header( 'Location: ../join_us.php#form' );
        exit();
    }

    $query = 'SELECT * FROM users WHERE (email = ? OR username = ?) ';
    $stmt = mysqli_prepare( $conn, $query );

    if ( $stmt ) {
        // Bind parameters
        mysqli_stmt_bind_param( $stmt, 'ss', $email_or_username, $email_or_username );

        if ( mysqli_stmt_execute( $stmt ) ) {
            $result = mysqli_stmt_get_result( $stmt );

            // Check if user exists
            if ( $user = mysqli_fetch_assoc( $result ) ) {

                if ( password_verify( $password, $user[ 'password' ] ) ) {

                    session_regenerate_id( true );

                    // Set session variables ( consistent with navbar expectations )
                    $_SESSION[ 'user_id' ] = $user[ 'id' ];
                    $_SESSION[ 'user_name' ] = trim( ( $user[ 'first_name' ] ?? '' ) . ' ' . ( $user[ 'last_name' ] ?? '' ) ) ?: ( $user[ 'username' ] ?? '' );
                    $_SESSION[ 'user_email' ] = $user[ 'email' ];
                    $_SESSION[ 'username' ] = $user[ 'username' ];
                    $_SESSION[ 'logged_in' ] = true;

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

    header( 'Location: ../join_us.php#form' );
    exit();

} else {
    header( 'Location: ../join_us.php' );
    exit();
}
?>