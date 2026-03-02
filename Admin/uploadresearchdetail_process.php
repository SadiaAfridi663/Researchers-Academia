<?php
// Start session
session_start();

// Include database connection
include '../db_connection/connection.php';

// Check if form was submitted
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {

    // Get form data
    $category_id = isset( $_POST[ 'category_id' ] ) ? intval( $_POST[ 'category_id' ] ) : 0;
    $sub_category_id = isset( $_POST[ 'sub_category_id' ] ) ? intval( $_POST[ 'sub_category_id' ] ) : 0;
    $title = isset( $_POST[ 'title' ] ) ? trim( $_POST[ 'title' ] ) : '';
    $abstract = isset( $_POST[ 'abstract' ] ) ? trim( $_POST[ 'abstract' ] ) : '';
    $introduction = isset( $_POST[ 'introduction' ] ) ? trim( $_POST[ 'introduction' ] ) : '';
    $methodology = isset( $_POST[ 'methodology' ] ) ? trim( $_POST[ 'methodology' ] ) : '';
    $conclusion = isset( $_POST[ 'conclusion' ] ) ? trim( $_POST[ 'conclusion' ] ) : '';
    $published_date = isset( $_POST[ 'published_date' ] ) ? $_POST[ 'published_date' ] : null;
    $pages = isset( $_POST[ 'pages' ] ) ? intval( $_POST[ 'pages' ] ) : null;

    // Validation
    if ( empty( $title ) || $category_id <= 0 || $sub_category_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Please fill in all required fields (Title, Category, Sub Category)';
        header( 'Location: uploadresearchdetailform.php' );
        exit();
    }

    // Handle PDF upload
    $pdf_file = '';
    if ( isset( $_FILES[ 'pdf_file' ] ) && $_FILES[ 'pdf_file' ][ 'size' ] > 0 ) {
        $pdf_file_tmp = $_FILES[ 'pdf_file' ][ 'tmp_name' ];
        $pdf_file_name = $_FILES[ 'pdf_file' ][ 'name' ];
        $pdf_file_size = $_FILES[ 'pdf_file' ][ 'size' ];
        $pdf_file_type = $_FILES[ 'pdf_file' ][ 'type' ];

        // Validate PDF file
        if ( $pdf_file_type === 'application/pdf' && $pdf_file_size <= 50 * 1024 * 1024 ) {
            // Create unique filename
            $pdf_file = 'research_detail_' . time() . '_' . basename( $pdf_file_name );
            $pdf_path = '../pdfs/' . $pdf_file;

            // Create pdfs folder if it doesn't exist
            if (!is_dir('../pdfs')) {
                mkdir('../pdfs', 0755, true);
            }

            // Move uploaded file
            if (move_uploaded_file($pdf_file_tmp, $pdf_path)) {
                // PDF uploaded successfully
            } else {
                $_SESSION['error'] = 'Failed to upload PDF file';
                header('Location: uploadresearchdetailform.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Please upload a valid PDF file ( max 50MB )';
            header('Location: uploadresearchdetailform.php');
            exit();
        }
    }

    // Verify that sub_category belongs to the selected category
    $verify_query = "SELECT id FROM sub_categories WHERE id = ? AND main_category_id = ?";
    $verify_stmt = $conn->prepare($verify_query);
    $verify_stmt->bind_param('ii', $sub_category_id, $category_id);
    $verify_stmt->execute();
    $verify_result = $verify_stmt->get_result();

    if ($verify_result->num_rows === 0) {
        $_SESSION['error'] = 'Invalid sub category for selected category';
        header('Location: uploadresearchdetailform.php');
        exit();
    }
    $verify_stmt->close();

    // Insert into database using prepared statement (place title after sub_category_id)
    $query = "INSERT INTO research_detail (category_id, sub_category_id, title, abstract, introduction, methodology, conclusion, published_date, pages, pdf_file) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['error'] = 'Database error: ' . $conn->error;
        header('Location: uploadresearchdetailform.php');
        exit();
    }

    // Prepare variables and bind parameters
    $title_db = $title;
    // Ensure pdf_file stores relative path like 'pdfs/filename' (or null)
    if (!empty($pdf_file)) {
        // $pdf_file currently contains filename like 'research_detail_...'
        $pdf_file = 'pdfs/' . $pdf_file;
    }

    // Normalize published_date and pages for binding
    $published_date_db = !empty($published_date) ? $published_date : '';
    $pages_db = !empty($pages) ? intval($pages) : 0;

    // Bind in the order: category_id, sub_category_id, title, abstract, introduction, methodology, conclusion, published_date, pages, pdf_file
    $stmt->bind_param(
        'iissssssis',
        $category_id,
        $sub_category_id,
        $title_db,
        $abstract,
        $introduction,
        $methodology,
        $conclusion,
        $published_date_db,
        $pages_db,
        $pdf_file
    );

    // Execute query
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Research detail added successfully!';
        header('Location: researchdetailtable.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error adding research detail: ' . $stmt->error;
        header('Location: uploadresearchdetailform.php');
        exit();
    }

    $stmt->close();
} else {
    // If not POST request, redirect back
    header('Location: uploadresearchdetailform.php' );
            exit();
        }
        ?>