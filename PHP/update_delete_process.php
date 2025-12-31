<?php
// DB connection
include '../db_connection/connection.php';
session_start();

// Check delete request
if ( isset( $_GET[ 'delete_id' ] ) ) {

    $id = ( int ) $_GET[ 'delete_id' ];

    // ID validation
    if ( $id <= 0 ) {
        $_SESSION[ 'error' ] = 'Invalid category ID';
        header( 'Location: categorytable.php' );
        exit;
    }

    // Check category exists
    $check = mysqli_prepare( $conn, 'SELECT id FROM add_categories WHERE id = ?' );
    mysqli_stmt_bind_param( $check, 'i', $id );
    mysqli_stmt_execute( $check );
    mysqli_stmt_store_result( $check );

    if ( mysqli_stmt_num_rows( $check ) == 0 ) {
        $_SESSION[ 'error' ] = 'Category not found';
        header( 'Location: categorytable.php' );
        exit;
    }
    mysqli_stmt_close( $check );

    // Delete category
    $delete = mysqli_prepare( $conn, 'DELETE FROM add_categories WHERE id = ?' );
    mysqli_stmt_bind_param( $delete, 'i', $id );

    if ( mysqli_stmt_execute( $delete ) ) {
        $_SESSION[ 'success' ] = 'Category deleted successfully';
    } else {
        $_SESSION[ 'error' ] = 'Delete failed';
    }

    mysqli_stmt_close( $delete );
}

// Redirect back
header( 'Location: categorytable.php' );
exit;
?>