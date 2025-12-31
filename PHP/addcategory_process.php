<?php

include '../db_connection/connection.php';

// Only process POST requests
if ( $_SERVER[ 'REQUEST_METHOD' ] === 'POST' ) {
    $id = isset( $_POST[ 'id' ] ) && !empty( $_POST[ 'id' ] ) ? intval( $_POST[ 'id' ] ) : 0;
    $name = isset( $_POST[ 'name' ] ) ? trim( $_POST[ 'name' ] ) : '';
    $description = isset( $_POST[ 'description' ] ) ? trim( $_POST[ 'description' ] ) : '';

    // Validate required fields
    if ( empty( $name ) ) {
        $_SESSION[ 'error' ] = 'Category name is required!';
        header( 'Location: addcategoryform.php' );
        exit;
    }

    if ( $id > 0 ) {
        $stmt = $conn->prepare( 'UPDATE add_categories SET name = ?, description = ? WHERE id = ?' );
        if ( !$stmt ) {
            $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
            header( 'Location: addcategoryform.php' );
            exit;
        }
        $stmt->bind_param( 'ssi', $name, $description, $id );
        $action = 'updated';
    } else {
        $stmt = $conn->prepare( 'INSERT INTO add_categories (name, description, created_at) VALUES (?, ?, NOW())' );
        if ( !$stmt ) {
            $_SESSION[ 'error' ] = 'Database error: ' . $conn->error;
            header( 'Location: addcategoryform.php' );
            exit;
        }
        $stmt->bind_param( 'ss', $name, $description );
        $action = 'created';
    }

    // Execute query
    if ( $stmt->execute() ) {
        $_SESSION[ 'success' ] = 'Category ' . $action . ' successfully!';
        header( 'Location: categorytable.php' );
    } else {
        $_SESSION[ 'error' ] = 'Error: ' . $stmt->error;
        header( 'Location: addcategoryform.php' );
    }
    $stmt->close();
    exit;
}

header( 'Location: addcategoryform.php' );
exit;
?>