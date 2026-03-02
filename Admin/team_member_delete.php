<?php
session_start();

// Security check
if (!isset($_SESSION['super_admin_id'])) {
    header('location: index.php');
    exit;
}

// Must have a valid ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = 'Invalid request.';
    header('location: team_members_table.php');
    exit;
}

include '../db_connection/connection.php';

$id = (int)$_GET['id'];

// Get member record to find the image path
$memberQuery = mysqli_query($conn, "SELECT * FROM team_members WHERE id = $id");

if (!$memberQuery || mysqli_num_rows($memberQuery) === 0) {
    $_SESSION['error'] = 'Team member not found.';
    header('location: team_members_table.php');
    exit;
}

$member = mysqli_fetch_assoc($memberQuery);
$imagePath = '../' . $member['image']; // Convert DB path to server path

// Delete from database
$deleteQuery = "DELETE FROM team_members WHERE id = $id";

if (mysqli_query($conn, $deleteQuery)) {
    // Also delete the image file from server if it exists
    if (!empty($member['image']) && file_exists($imagePath)) {
        unlink($imagePath);
    }
    $_SESSION['success'] = 'Team member "' . htmlspecialchars($member['name']) . '" deleted successfully.';
} else {
    $_SESSION['error'] = 'Failed to delete team member: ' . mysqli_error($conn);
}

header('location: team_members_table.php');
exit;
?>
