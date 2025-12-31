<?php
header( 'Content-Type: application/json' );
include __DIR__ . '/../db_connection/connection.php';

$id = isset( $_GET[ 'id' ] ) ? intval( $_GET[ 'id' ] ) : 0;
if ( $id <= 0 ) {
    echo json_encode( [ 'success' => false, 'message' => 'Invalid id' ] );
    exit;
}

$sql = "SELECT rd.*, c.name as category_name, sc.name as sub_category_name
        FROM research_detail rd
        LEFT JOIN add_categories c ON rd.category_id = c.id
        LEFT JOIN sub_categories sc ON rd.sub_category_id = sc.id
        WHERE rd.id = ? LIMIT 1";

$stmt = mysqli_prepare( $conn, $sql );
if ( !$stmt ) {
    echo json_encode( [ 'success' => false, 'message' => 'DB prepare failed' ] );
    exit;
}
mysqli_stmt_bind_param( $stmt, 'i', $id );
mysqli_stmt_execute( $stmt );
$res = mysqli_stmt_get_result( $stmt );
$detail = mysqli_fetch_assoc( $res );

if ( !$detail ) {
    echo json_encode( [ 'success' => false, 'message' => 'Not found' ] );
    exit;
}

// sanitize
$detail[ 'title' ] = htmlspecialchars( $detail[ 'title' ] );
$detail[ 'abstract' ] = nl2br( htmlspecialchars( $detail[ 'abstract' ] ) );
$detail[ 'introduction' ] = nl2br( htmlspecialchars( $detail[ 'introduction' ] ) );
$detail[ 'methodology' ] = nl2br( htmlspecialchars( $detail[ 'methodology' ] ) );
$detail[ 'conclusion' ] = nl2br( htmlspecialchars( $detail[ 'conclusion' ] ) );
$detail[ 'category_name' ] = htmlspecialchars( $detail[ 'category_name' ] );
$detail[ 'sub_category_name' ] = htmlspecialchars( $detail[ 'sub_category_name' ] );

echo json_encode( [ 'success' => true, 'data' => $detail ] );
exit;
