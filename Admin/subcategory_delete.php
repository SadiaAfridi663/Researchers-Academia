<?php
include '../db_connection/connection.php';
session_start();

if ( isset( $_GET[ 'delete_id' ] ) ) {
    $id = ( int ) $_GET[ 'delete_id' ];
    if ( $id <= 0 ) {
        $_SESSION[ 'error' ] = 'Invalid sub category ID';
        header( 'Location: categorytable.php' );
        exit;
    }

    $check = mysqli_prepare( $conn, 'SELECT id FROM sub_categories WHERE id = ?' );
    mysqli_stmt_bind_param( $check, 'i', $id );
    mysqli_stmt_execute( $check );
    mysqli_stmt_store_result( $check );

    if ( mysqli_stmt_num_rows( $check ) == 0 ) {
        $_SESSION[ 'error' ] = 'Sub category not found';
        header( 'Location: categorytable.php' );
        exit;
    }
    mysqli_stmt_close( $check );

    $delete = mysqli_prepare( $conn, 'DELETE FROM sub_categories WHERE id = ?' );
    mysqli_stmt_bind_param( $delete, 'i', $id );

    if ( mysqli_stmt_execute( $delete ) ) {
        $_SESSION[ 'success' ] = 'Sub category deleted successfully';
    } else {
        $_SESSION[ 'error' ] = 'Delete failed';
    }
    mysqli_stmt_close( $delete );
}

header( 'Location: categorytable.php' );
exit;

?>