<?php

header( 'Content-Type: application/json' );
include '../db_connection/connection.php';

$category_id = isset( $_GET[ 'category_id' ] ) ? intval( $_GET[ 'category_id' ] ) : 0;

// Validate category ID
if ( $category_id <= 0 ) {
    echo json_encode( [] );
    exit;
}

$query = 'SELECT id, name FROM sub_categories WHERE main_category_id = ? ORDER BY name ASC';
$stmt = $conn->prepare( $query );

if ( !$stmt ) {
    echo json_encode( [] );
    exit;
}

$stmt->bind_param( 'i', $category_id );
$stmt->execute();
$result = $stmt->get_result();

$subcategories = [];
while ( $row = $result->fetch_assoc() ) {
    $subcategories[] = $row;
}

$stmt->close();

echo json_encode( $subcategories );
?>