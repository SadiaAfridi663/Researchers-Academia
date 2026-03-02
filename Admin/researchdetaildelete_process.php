<?php
session_start();

include '../db_connection/connection.php';

$delete_id = isset( $_GET[ 'delete_id' ] ) ? intval( $_GET[ 'delete_id' ] ) : 0;

if ( $delete_id <= 0 ) {
    $_SESSION[ 'error' ] = 'Invalid research detail ID!';
    header( 'Location: researchdetailtable.php' );
    exit();
}

$query = 'SELECT pdf_file FROM research_detail WHERE id = ?';
$stmt = mysqli_prepare( $conn, $query );
mysqli_stmt_bind_param( $stmt, 'i', $delete_id );
mysqli_stmt_execute( $stmt );
$result = mysqli_stmt_get_result( $stmt );
$detail = mysqli_fetch_assoc( $result );

if ( !$detail ) {
    $_SESSION[ 'error' ] = 'Research detail not found!';
    header( 'Location: researchdetailtable.php' );
    exit();
}

if ( !empty( $detail[ 'pdf_file' ] ) && file_exists( '../' . $detail[ 'pdf_file' ] ) ) {
    unlink( '../' . $detail[ 'pdf_file' ] );
}

$deleteQuery = 'DELETE FROM research_detail WHERE id = ?';
$deleteStmt = mysqli_prepare( $conn, $deleteQuery );
mysqli_stmt_bind_param( $deleteStmt, 'i', $delete_id );

if ( mysqli_stmt_execute( $deleteStmt ) ) {
    $_SESSION[ 'success' ] = 'Research detail deleted successfully!';
    header( 'Location: researchdetailtable.php' );
    exit();
} else {
    $_SESSION[ 'error' ] = 'Database error: ' . mysqli_error( $conn );
    header( 'Location: researchdetailtable.php' );
    exit();
}

mysqli_close( $conn );
?>