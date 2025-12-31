<?php
include '../db_connection/connection.php';
session_start();

session_unset();

session_destroy();

header( 'location:superadminlogin.php' )

?>