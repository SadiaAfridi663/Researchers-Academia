<?php
session_start();

include '../db_connection/connection.php';

// Get the detail ID
$detail_id = isset( $_POST[ 'detail_id' ] ) ? intval( $_POST[ 'detail_id' ] ) : 0;

if ( $detail_id <= 0 ) {
    $_SESSION[ 'error' ] = 'Invalid research detail ID!';
    header( 'Location: researchdetailtable.php' );
    exit();
}

if ( empty( $_POST[ 'title' ] ) || empty( $_POST[ 'category_id' ] ) || empty( $_POST[ 'sub_category_id' ] ) ) {
    $_SESSION[ 'error' ] = 'Please fill in all required fields!';
    header( 'Location: researchdetailedit.php?id=' . $detail_id );
    exit();
}

$getQuery = 'SELECT pdf_file FROM research_detail WHERE id = ?';
$getStmt = mysqli_prepare( $conn, $getQuery );
mysqli_stmt_bind_param( $getStmt, 'i', $detail_id );
mysqli_stmt_execute( $getStmt );
$result = mysqli_stmt_get_result( $getStmt );
$existing = mysqli_fetch_assoc( $result );

if ( !$existing ) {
    $_SESSION[ 'error' ] = 'Research detail not found!';
    header( 'Location: researchdetailtable.php' );
    exit();
}

$pdf_file = isset( $existing[ 'pdf_file' ] ) ? $existing[ 'pdf_file' ] : '';

if ( !empty( $_FILES[ 'pdf_file' ][ 'name' ] ) ) {
    $file_type = strtolower( pathinfo( $_FILES[ 'pdf_file' ][ 'name' ], PATHINFO_EXTENSION ) );
    if ( $file_type !== 'pdf' ) {
        $_SESSION[ 'error' ] = 'Only PDF files are allowed!';
        header( 'Location: researchdetailedit.php?id=' . $detail_id );
        exit();
    }

    if ( $_FILES[ 'pdf_file' ][ 'size' ] > 50 * 1024 * 1024 ) {
        $_SESSION[ 'error' ] = 'File size must not exceed 50MB!';
        header( 'Location: researchdetailedit.php?id=' . $detail_id );
        exit();
    }

    if ( !is_dir( '../pdfs' ) ) {
        mkdir( '../pdfs', 0755, true );
    }

    $file_name = time() . '_' . basename( $_FILES[ 'pdf_file' ][ 'name' ] );
    $pdf_file = 'pdfs/' . $file_name;

    if ( move_uploaded_file( $_FILES[ 'pdf_file' ][ 'tmp_name' ], '../' . $pdf_file ) ) {
        if ( !empty( $existing[ 'pdf_file' ] ) && file_exists( '../' . $existing[ 'pdf_file' ] ) ) {
            unlink( '../' . $existing[ 'pdf_file' ] );
        }
    } else {
        $_SESSION[ 'error' ] = 'Failed to upload PDF file!';
        header( 'Location: researchdetailedit.php?id = ' . $detail_id );
        exit();
    }
}

// Prepare update query
$updateQuery = "UPDATE research_detail SET 
                title = ?, 
                category_id = ?, 
                sub_category_id = ?, 
                published_date = ?, 
                pages = ?, 
                abstract = ?, 
                introduction = ?, 
                methodology = ?, 
                conclusion = ?, 
                pdf_file = ?,
                updated_at = NOW()
                WHERE id = ?";

$updateStmt = mysqli_prepare( $conn, $updateQuery );

// Prepare variables and bind parameters
$title = isset( $_POST[ 'title' ] ) ? trim( $_POST[ 'title' ] ) : '';
$category_id = isset( $_POST[ 'category_id' ] ) ? intval( $_POST[ 'category_id' ] ) : 0;
$sub_category_id = isset( $_POST[ 'sub_category_id' ] ) ? intval( $_POST[ 'sub_category_id' ] ) : 0;
$published_date = !empty( $_POST[ 'published_date' ] ) ? $_POST[ 'published_date' ] : null;
$pages = !empty( $_POST[ 'pages' ] ) ? intval( $_POST[ 'pages' ] ) : null;
$abstract = isset( $_POST[ 'abstract' ] ) ? $_POST[ 'abstract' ] : '';
$introduction = isset( $_POST[ 'introduction' ] ) ? $_POST[ 'introduction' ] : '';
$methodology = isset( $_POST[ 'methodology' ] ) ? $_POST[ 'methodology' ] : '';
$conclusion = isset( $_POST[ 'conclusion' ] ) ? $_POST[ 'conclusion' ] : '';

mysqli_stmt_bind_param(
    $updateStmt,
    'siisisssssi',
    $title,
    $category_id,
    $sub_category_id,
    $published_date,
    $pages,
    $abstract,
    $introduction,
    $methodology,
    $conclusion,
    $pdf_file,
    $detail_id
);

// Execute query
if ( mysqli_stmt_execute( $updateStmt ) ) {
    $_SESSION[ 'success' ] = 'Research detail updated successfully!';
    header( 'Location: researchDetailView.php?id = ' . $detail_id );
    exit();
} else {
    $_SESSION[ 'error' ] = 'Database error: ' . mysqli_error( $conn );
    header( 'Location: researchdetailedit.php?id = ' . $detail_id );
    exit();
}

mysqli_close( $conn );
?>