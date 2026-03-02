<?php
session_start();
include '../db_connection/connection.php';

$email = isset( $_POST[ 'email' ] ) ? trim( $_POST[ 'email' ] ) : '';
$password = isset( $_POST[ 'password' ] ) ? trim( $_POST[ 'password' ] ) : '';

if ( empty( $email ) || empty( $password ) ) {
    header( 'Location: index.php?error=empty_fields' );
    exit;
}

$sql = 'SELECT * FROM super_admin WHERE email = ?';
$stmt = $conn->prepare( $sql );

if ( !$stmt ) {
    header( 'Location: index.php?error=database_error' );
    exit;
}

$stmt->bind_param( 's', $email );
$stmt->execute();
$result = $stmt->get_result();

if ( $result->num_rows === 1 ) {
    $admin = $result->fetch_assoc();

    // Verify password
    if ( password_verify( $password, $admin[ 'password' ] ) ) {
        $_SESSION[ 'super_admin_id' ] = $admin[ 'id' ];
        $_SESSION[ 'super_admin_name' ] = $admin[ 'name' ];
        $_SESSION[ 'super_admin_email' ] = $admin[ 'email' ];
        $_SESSION[ 'logged_in' ] = true;

        header( 'Location: admindashboard.php' );
        exit;
    } else {
        header( 'Location: index.php?error=invalid_password' );
        exit;
    }
} else {
    header( 'Location: index.php?error=invalid_email' );
    exit;
}

$stmt->close();
$conn->close();
?>