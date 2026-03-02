<?php

session_start();
include '../db_connection/connection.php';

// Only process POST requests
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'submit' ] ) ) {

    // Get and sanitize input data
    $title = isset( $_POST[ 'title' ] ) ? trim( $_POST[ 'title' ] ) : '';
    $description = isset( $_POST[ 'description' ] ) ? trim( $_POST[ 'description' ] ) : '';
    $videoUrl = isset( $_POST[ 'videoUrl' ] ) ? trim( $_POST[ 'videoUrl' ] ) : '';
    $category_id = isset( $_POST[ 'category' ] ) ? intval( $_POST[ 'category' ] ) : 0;
    $sub_category_id = isset( $_POST[ 'sub_category' ] ) ? intval( $_POST[ 'sub_category' ] ) : 0;
    $research_leader = isset( $_POST[ 'research_leader' ] ) ? trim( $_POST[ 'research_leader' ] ) : null;
    $co_leader = isset( $_POST[ 'co_leader' ] ) ? trim( $_POST[ 'co_leader' ] ) : null;
    // Handle optional thumbnail upload ( only process if a file was provided )
    $thumbnail = '';
    if ( isset( $_FILES[ 'thumbnail' ] ) && $_FILES[ 'thumbnail' ][ 'error' ] === UPLOAD_ERR_OK ) {
        $file = $_FILES[ 'thumbnail' ];
        // Basic validation
        $allowed = [ 'image/jpeg', 'image/png', 'image/webp', 'image/gif' ];
        if ( $file[ 'size' ] > 2 * 1024 * 1024 ) {
            $_SESSION[ 'error' ] = 'Thumbnail must be less than 2MB.';
            header( 'Location: uploadvideoform.php' );
            exit;
        }

        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mime = finfo_file( $finfo, $file[ 'tmp_name' ] );
        finfo_close( $finfo );

        if ( !in_array( $mime, $allowed ) ) {
            $_SESSION[ 'error' ] = 'Invalid thumbnail format. Allowed: jpg, png, webp, gif.';
            header( 'Location: uploadvideoform.php' );
            exit;
        }

        // Create upload dir if not exists
        $uploadDir = __DIR__ . '/../images/thumbnails/';
        if ( !is_dir( $uploadDir ) ) {
            mkdir( $uploadDir, 0755, true );
        }

        $ext = pathinfo( $file[ 'name' ], PATHINFO_EXTENSION );
        $safeName = time() . '_' . bin2hex( random_bytes( 6 ) ) . '.' . $ext;
        $targetPath = $uploadDir . $safeName;

        if ( !move_uploaded_file( $file[ 'tmp_name' ], $targetPath ) ) {
            $_SESSION[ 'error' ] = 'Failed to save thumbnail image.';
            header( 'Location: uploadvideoform.php' );
            exit;
        }

        $thumbnail = $safeName;
    }

    // Validate required fields
    if ( empty( $title ) ) {
        $_SESSION[ 'error' ] = 'Video title is required!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    if ( empty( $description ) ) {
        $_SESSION[ 'error' ] = 'Video description is required!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    if ( empty( $videoUrl ) ) {
        $_SESSION[ 'error' ] = 'Video URL is required!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    if ( $category_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Please select a valid category!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    if ( $sub_category_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Please select a valid sub category!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    // Validate URL format
    if ( !filter_var( $videoUrl, FILTER_VALIDATE_URL ) ) {
        $_SESSION[ 'error' ] = 'Please enter a valid video URL!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    // Check if category exists
    $check_stmt = $conn->prepare( 'SELECT id FROM add_categories WHERE id = ?' );
    if ( !$check_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: uploadvideoform.php' );
        exit;
    }
    $check_stmt->bind_param( 'i', $category_id );
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ( $check_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Selected category does not exist!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }
    $check_stmt->close();

    // Check if sub category exists and belongs to the selected category
    $check_sub_stmt = $conn->prepare( 'SELECT id FROM sub_categories WHERE id = ? AND main_category_id = ?' );
    if ( !$check_sub_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: uploadvideoform.php' );
        exit;
    }
    $check_sub_stmt->bind_param( 'ii', $sub_category_id, $category_id );
    $check_sub_stmt->execute();
    $check_sub_result = $check_sub_stmt->get_result();

    if ( $check_sub_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Selected sub category does not exist or does not belong to the selected category!';
        header( 'Location: uploadvideoform.php' );
        exit;
    }
    $check_sub_stmt->close();

    // Prepare and execute insert query with prepared statement ( prevents SQL injection )
    $stmt = $conn->prepare( 'INSERT INTO research_videos (title, description, video_url, category_id, research_leader, co_leader, sub_category_id, thumbnail, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())' );

    if ( !$stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: uploadvideoform.php' );
        exit;
    }

    // Bind parameters ( s = string, i = integer )
    $stmt->bind_param( 'sssissis', $title, $description, $videoUrl, $category_id, $research_leader, $co_leader, $sub_category_id, $thumbnail );

    // Execute the query
    if ( $stmt->execute() ) {
        $_SESSION[ 'success' ] = 'Video uploaded successfully!';
        header( 'Location: uploadvideoform.php' );
    } else {
        $_SESSION[ 'error' ] = 'Error uploading video: ' . $stmt->error;
        header( 'Location: uploadvideoform.php' );
    }

    $stmt->close();
    exit;
}

// If not a POST request, redirect to form
header( 'Location: uploadvideoform.php' );
exit;
?>