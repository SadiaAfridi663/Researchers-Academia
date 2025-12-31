<?php
session_start();
include '../db_connection/connection.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {
    $email_or_username = trim( $_POST[ 'email' ] );
    $password = trim( $_POST[ 'password' ] );

    $stmt = $conn->prepare( 'SELECT * FROM users WHERE email = ? OR username = ?' );
    $stmt->bind_param( 'ss', $email_or_username, $email_or_username );
    $stmt->execute();
    $result = $stmt->get_result();

    if ( $result->num_rows === 1 ) {
        $user = $result->fetch_assoc();

        if ( password_verify( $password, $user[ 'password' ] ) ) {
            $_SESSION[ 'user_id' ] = $user[ 'id' ];
            $_SESSION[ 'user_name' ] = $user[ 'first_name' ] . ' ' . $user[ 'last_name' ];

            header( 'Location: ../index.php' );
            exit;
        } else {
            $error = 'Invalid password!';
        }
    } else {
        $error = 'User not found!';
    }

    exit;
}
?>