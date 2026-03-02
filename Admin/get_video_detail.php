<?php
header( 'Content-Type: application/json' );

include __DIR__ . '/../db_connection/connection.php';

$id = isset( $_GET[ 'id' ] ) ? intval( $_GET[ 'id' ] ) : 0;
if ( $id <= 0 ) {
    echo json_encode( [ 'success' => false, 'message' => 'Invalid id' ] );
    exit;
}

$sql = "SELECT v.*, c.name as category_name, s.name as sub_category_name
        FROM research_videos v
        LEFT JOIN add_categories c ON v.category_id = c.id
        LEFT JOIN sub_categories s ON v.sub_category_id = s.id
        WHERE v.id = ? LIMIT 1";

$stmt = mysqli_prepare( $conn, $sql );
if ( !$stmt ) {
    echo json_encode( [ 'success' => false, 'message' => 'DB prepare failed' ] );
    exit;
}
mysqli_stmt_bind_param( $stmt, 'i', $id );
mysqli_stmt_execute( $stmt );
$res = mysqli_stmt_get_result( $stmt );
$video = mysqli_fetch_assoc( $res );

if ( !$video ) {
    echo json_encode( [ 'success' => false, 'message' => 'Not found' ] );
    exit;
}

// sanitize and return
$video[ 'title' ] = htmlspecialchars( $video[ 'title' ] );
$video[ 'description' ] = nl2br( htmlspecialchars( $video[ 'description' ] ) );
$video[ 'research_leader' ] = htmlspecialchars( $video[ 'research_leader' ] );
$video[ 'co_leader' ] = htmlspecialchars( $video[ 'co_leader' ] );
$video[ 'category_name' ] = htmlspecialchars( $video[ 'category_name' ] );
$video[ 'sub_category_name' ] = htmlspecialchars( $video[ 'sub_category_name' ] );

echo json_encode( [ 'success' => true, 'data' => $video ] );
exit;
