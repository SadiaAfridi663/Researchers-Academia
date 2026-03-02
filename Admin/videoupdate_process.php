<?php
/**
* Video Update Process Handler
* Handles updating of research videos with validation and security
*/
session_start();
include '../db_connection/connection.php';

// Only process POST requests
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' && isset( $_POST[ 'submit' ] ) ) {

    // Get and sanitize input data
    $video_id = isset( $_POST[ 'video_id' ] ) ? intval( $_POST[ 'video_id' ] ) : 0;
    $title = isset( $_POST[ 'title' ] ) ? trim( $_POST[ 'title' ] ) : '';
    $description = isset( $_POST[ 'description' ] ) ? trim( $_POST[ 'description' ] ) : '';
    $videoUrl = isset( $_POST[ 'videoUrl' ] ) ? trim( $_POST[ 'videoUrl' ] ) : '';
    $category_id = isset( $_POST[ 'category' ] ) ? intval( $_POST[ 'category' ] ) : 0;
    $sub_category_id = isset( $_POST[ 'sub_category' ] ) ? intval( $_POST[ 'sub_category' ] ) : 0;
    $research_leader = isset( $_POST[ 'research_leader' ] ) ? trim( $_POST[ 'research_leader' ] ) : null;
    $co_leader = isset( $_POST[ 'co_leader' ] ) ? trim( $_POST[ 'co_leader' ] ) : null;

    // Fetch current thumbnail so we can remove it if replaced
    $current_thumb = '';
    $thumb_stmt = $conn->prepare( 'SELECT thumbnail FROM research_videos WHERE id = ?' );
    if ( $thumb_stmt ) {
        $thumb_stmt->bind_param( 'i', $video_id );
        $thumb_stmt->execute();
        $thumb_res = $thumb_stmt->get_result();
        if ( $thumb_row = $thumb_res->fetch_assoc() ) {
            $current_thumb = $thumb_row[ 'thumbnail' ];
        }
        $thumb_stmt->close();
    }

    // Handle optional thumbnail replacement
    $thumbnail = $current_thumb;
    if ( isset( $_FILES[ 'thumbnail' ] ) && $_FILES[ 'thumbnail' ][ 'error' ] === UPLOAD_ERR_OK ) {
        $file = $_FILES[ 'thumbnail' ];
        $allowed = [ 'image/jpeg', 'image/png', 'image/webp', 'image/gif' ];
        if ( $file[ 'size' ] > 2 * 1024 * 1024 ) {
            $_SESSION[ 'error' ] = 'Thumbnail must be less than 2MB.';
            header( 'Location: videoedit.php?id=' . $video_id );
            exit;
        }
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mime = finfo_file( $finfo, $file[ 'tmp_name' ] );
        finfo_close( $finfo );
        if ( !in_array( $mime, $allowed ) ) {
            $_SESSION[ 'error' ] = 'Invalid thumbnail format. Allowed: jpg, png, webp, gif.';
            header( 'Location: videoedit.php?id=' . $video_id );
            exit;
        }

        $uploadDir = __DIR__ . '/../images/thumbnails/';
        if ( !is_dir( $uploadDir ) ) mkdir( $uploadDir, 0755, true );
        $ext = pathinfo( $file[ 'name' ], PATHINFO_EXTENSION );
        $safeName = time() . '_' . bin2hex( random_bytes( 6 ) ) . '.' . $ext;
        $targetPath = $uploadDir . $safeName;
        if ( !move_uploaded_file( $file[ 'tmp_name' ], $targetPath ) ) {
            $_SESSION[ 'error' ] = 'Failed to save thumbnail image.';
            header( 'Location: videoedit.php?id=' . $video_id );
            exit;
        }

        // Delete old thumbnail file if exists and different
        if ( !empty( $current_thumb ) && file_exists( $uploadDir . $current_thumb ) ) {
            @unlink( $uploadDir . $current_thumb );
        }

        $thumbnail = $safeName;
    }

    // Validate video ID
    if ( $video_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Invalid video ID!';
        header( 'Location: videostable.php' );
        exit;
    }

    // Validate required fields
    if ( empty( $title ) ) {
        $_SESSION[ 'error' ] = 'Video title is required!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    if ( empty( $description ) ) {
        $_SESSION[ 'error' ] = 'Video description is required!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    if ( empty( $videoUrl ) ) {
        $_SESSION[ 'error' ] = 'Video URL is required!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    if ( $category_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Please select a valid category!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    if ( $sub_category_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Please select a valid sub category!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    // Validate URL format
    if ( !filter_var( $videoUrl, FILTER_VALIDATE_URL ) ) {
        $_SESSION[ 'error' ] = 'Please enter a valid video URL!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    // Check if video exists
    $check_video_stmt = $conn->prepare( 'SELECT id FROM research_videos WHERE id = ?' );
    if ( !$check_video_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videostable.php' );
        exit;
    }
    $check_video_stmt->bind_param( 'i', $video_id );
    $check_video_stmt->execute();
    $check_video_result = $check_video_stmt->get_result();

    if ( $check_video_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Video not found!';
        header( 'Location: videostable.php' );
        exit;
    }
    $check_video_stmt->close();

    // Check if category exists
    $check_cat_stmt = $conn->prepare( 'SELECT id FROM add_categories WHERE id = ?' );
    if ( !$check_cat_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }
    $check_cat_stmt->bind_param( 'i', $category_id );
    $check_cat_stmt->execute();
    $check_cat_result = $check_cat_stmt->get_result();

    if ( $check_cat_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Selected category does not exist!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }
    $check_cat_stmt->close();

    // Check if sub category exists and belongs to the selected category
    $check_subcat_stmt = $conn->prepare( 'SELECT id FROM sub_categories WHERE id = ? AND main_category_id = ?' );
    if ( !$check_subcat_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }
    $check_subcat_stmt->bind_param( 'ii', $sub_category_id, $category_id );
    $check_subcat_stmt->execute();
    $check_subcat_result = $check_subcat_stmt->get_result();

    if ( $check_subcat_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Selected sub category does not exist or does not belong to the selected category!';
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }
    $check_subcat_stmt->close();

    // Prepare and execute update query ( include leader fields )
    $update_stmt = $conn->prepare( 'UPDATE research_videos SET title = ?, description = ?, video_url = ?, category_id = ?, research_leader = ?, co_leader = ?, sub_category_id = ?, thumbnail = ? WHERE id = ?' );

    if ( !$update_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videoedit.php?id=' . $video_id );
        exit;
    }

    // Bind parameters ( s = string, i = integer )
    $update_stmt->bind_param( 'sssissisi', $title, $description, $videoUrl, $category_id, $research_leader, $co_leader, $sub_category_id, $thumbnail, $video_id );

    // Execute the query
    if ( $update_stmt->execute() ) {
        $_SESSION[ 'success' ] = 'Video updated successfully!';
        header( 'Location: videostable.php' );
    } else {
        $_SESSION[ 'error' ] = 'Error updating video: ' . $update_stmt->error;
        header( 'Location: videoedit.php?id=' . $video_id );
    }

    $update_stmt->close();
    exit;
}

// If not a POST request, redirect to table
header( 'Location: videostable.php' );
exit;
?>
