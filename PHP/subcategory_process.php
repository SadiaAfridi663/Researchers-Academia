<?php
include '../db_connection/connection.php';

if ( $_SERVER[ 'REQUEST_METHOD' ] == 'POST' ) {

    $main_category_id = $_POST[ 'main_category_id' ];
    $name             = $_POST[ 'name' ];

    if ( $main_category_id == '' || $name == '' ) {
        echo 'All fields are required';
        exit;
    }

    $sql = "INSERT INTO sub_categories (main_category_id, name)
            VALUES ('$main_category_id', '$name')";

    if ( mysqli_query( $conn, $sql ) ) {
        echo 'Sub Category Saved Successfully';
    } else {
        echo 'Error: ' . mysqli_error( $conn );
    }
    header( 'location:categorytable.php' );
}
?>