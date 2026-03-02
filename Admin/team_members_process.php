<?php
session_start();

// Only run if form was submitted
if (!isset($_POST['submit'])) {
    header('location: Add_team_members.php');
    exit;
}

// Security: Only logged-in admins can access
if (!isset($_SESSION['super_admin_id'])) {
    header('location: index.php');
    exit;
}

include '../db_connection/connection.php';
include '../db_connection/team_config.php';

// ─── 1. Collect & Sanitize Text Fields ──────────────────────────────────────
$name        = trim(mysqli_real_escape_string($conn, $_POST['name'] ?? ''));
$description = trim(mysqli_real_escape_string($conn, $_POST['description'] ?? ''));
$quote       = trim(mysqli_real_escape_string($conn, $_POST['quote'] ?? ''));
$skill_1     = trim(mysqli_real_escape_string($conn, $_POST['skill_1'] ?? ''));
$skill_2     = trim(mysqli_real_escape_string($conn, $_POST['skill_2'] ?? ''));
$skill_3     = trim(mysqli_real_escape_string($conn, $_POST['skill_3'] ?? ''));
$twitter     = trim(mysqli_real_escape_string($conn, $_POST['twitter'] ?? ''));
$linkedin    = trim(mysqli_real_escape_string($conn, $_POST['linkedin'] ?? ''));
$github      = trim(mysqli_real_escape_string($conn, $_POST['github'] ?? ''));
$status      = isset($_POST['status']) ? (int)$_POST['status'] : 1;

// Whitelist allowed type values
$allowedTypes = ['leader', 'co_leader', 'team_member', 'advisor'];
$type = in_array($_POST['type'] ?? '', $allowedTypes) ? $_POST['type'] : 'team_member';

// Whitelist allowed sub_type values from config
$allowedSubTypes = array_keys($subTypeLabels);
$sub_type = in_array($_POST['sub_type'] ?? '', $allowedSubTypes) ? $_POST['sub_type'] : '';

// ─── 2. Basic Required Field Validation ─────────────────────────────────────
if (empty($name)) {
    $_SESSION['error'] = 'Name is a required field.';
    header('location: Add_team_members.php');
    exit;
}

if (empty($type)) {
    $_SESSION['error'] = 'Please select a Member Type.';
    header('location: Add_team_members.php');
    exit;
}

// ─── 3. Handle Image Upload ──────────────────────────────────────────────────
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $_SESSION['error'] = 'Please upload a valid profile image.';
    header('location: Add_team_members.php');
    exit;
}

$file      = $_FILES['image'];
$fileName  = $file['name'];
$fileTmp   = $file['tmp_name'];
$fileSize  = $file['size'];
$fileExt   = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Allowed types
$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
if (!in_array($fileExt, $allowedExtensions)) {
    $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, WEBP, and GIF are allowed.';
    header('location: Add_team_members.php');
    exit;
}

// Max file size: 2MB
if ($fileSize > 2 * 1024 * 1024) {
    $_SESSION['error'] = 'Image size must be less than 2MB.';
    header('location: Add_team_members.php');
    exit;
}

// Create uploads folder if it doesn't exist
$uploadDir = '../images/team_members/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Generate unique filename to avoid collisions
$newFileName = 'member_' . time() . '_' . mt_rand(1000, 9999) . '.' . $fileExt;
$uploadPath  = $uploadDir . $newFileName;

if (!move_uploaded_file($fileTmp, $uploadPath)) {
    $_SESSION['error'] = 'Failed to upload image. Please try again.';
    header('location: Add_team_members.php');
    exit;
}

// Store relative path for DB (used in <img src="...">)
$imagePath = 'images/team_members/' . $newFileName;

// ─── 4. Insert Into Database ─────────────────────────────────────────────────
$sql = "INSERT INTO team_members 
        (name, type, sub_type, image, description, quote, skill_1, skill_2, skill_3, twitter, linkedin, github, status, created_at)
        VALUES 
        ('$name', '$type', '$sub_type', '$imagePath', '$description', '$quote', '$skill_1', '$skill_2', '$skill_3', '$twitter', '$linkedin', '$github', '$status', NOW())";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Team member \"$name\" added successfully!";
    header('location: team_members_table.php');
    exit;
} else {
    // Clean up uploaded file on DB failure
    if (file_exists($uploadPath)) {
        unlink($uploadPath);
    }
    $_SESSION['error'] = 'Database error: ' . mysqli_error($conn);
    header('location: Add_team_members.php');
    exit;
}
?>
