<?php
/**
* Video Delete Process Handler
* Handles deletion of research videos with validation
*/
session_start();
include '../db_connection/connection.php';

// Check delete request
if ( isset( $_GET[ 'delete_id' ] ) ) {
    $video_id = intval( $_GET[ 'delete_id' ] );

    // ID validation
    if ( $video_id <= 0 ) {
        $_SESSION[ 'error' ] = 'Invalid video ID';
        header( 'Location: videostable.php' );
        exit;
    }

    // Check video exists
    $check_stmt = $conn->prepare( 'SELECT id, thumbnail FROM research_videos WHERE id = ?' );
    if ( !$check_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videostable.php' );
        exit;
    }

    $check_stmt->bind_param( 'i', $video_id );
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ( $check_result->num_rows === 0 ) {
        $_SESSION[ 'error' ] = 'Video not found';
        header( 'Location: videostable.php' );
        exit;
    }
    $row = $check_result->fetch_assoc();
    $current_thumb = $row[ 'thumbnail' ] ?? '';
    $check_stmt->close();

    // Delete the video
    $delete_stmt = $conn->prepare( 'DELETE FROM research_videos WHERE id = ?' );
    if ( !$delete_stmt ) {
        $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
        header( 'Location: videostable.php' );
        exit;
    }

    $delete_stmt->bind_param( 'i', $video_id );

    if ( $delete_stmt->execute() ) {
        // Remove thumbnail file if exists
        if ( !empty( $current_thumb ) ) {
            $uploadDir = __DIR__ . '/../images/thumbnails/';
            $filePath = $uploadDir . $current_thumb;
            if ( file_exists( $filePath ) ) @unlink( $filePath );
        }
        $_SESSION[ 'success' ] = 'Video deleted successfully!';
    } else {
        $_SESSION[ 'error' ] = 'Error deleting video: ' . $delete_stmt->error;
    }

    $delete_stmt->close();
} else {
    $_SESSION[ 'error' ] = 'No video selected for deletion';
}

// Redirect back to video table
header( 'Location: videostable.php' );
exit;
?>
