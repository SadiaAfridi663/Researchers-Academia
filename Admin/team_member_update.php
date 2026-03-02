<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header('location: index.php');
    exit;
}

if (!isset($_POST['update'])) {
    header('location: team_members_table.php');
    exit;
}

include '../db_connection/connection.php';
include '../db_connection/team_config.php';

$id          = (int)$_POST['id'];
$name        = trim(mysqli_real_escape_string($conn, $_POST['name']));
$type        = trim(mysqli_real_escape_string($conn, $_POST['type']));
$description = trim(mysqli_real_escape_string($conn, $_POST['description']));
$quote       = trim(mysqli_real_escape_string($conn, $_POST['quote']));
$skill_1     = trim(mysqli_real_escape_string($conn, $_POST['skill_1']));
$skill_2     = trim(mysqli_real_escape_string($conn, $_POST['skill_2']));
$skill_3     = trim(mysqli_real_escape_string($conn, $_POST['skill_3']));
$twitter     = trim(mysqli_real_escape_string($conn, $_POST['twitter']));
$linkedin    = trim(mysqli_real_escape_string($conn, $_POST['linkedin']));
$github      = trim(mysqli_real_escape_string($conn, $_POST['github']));

// Whitelist sub_type values from config
$allowedSubTypes = array_keys($subTypeLabels);
$sub_type = in_array($_POST['sub_type'] ?? '', $allowedSubTypes) ? $_POST['sub_type'] : '';

if (empty($name)) {
    $_SESSION['error'] = 'Name is required.';
    header("location: team_member_edit.php?id=$id");
    exit;
}

// Get existing data to handle image
$query = mysqli_query($conn, "SELECT image FROM team_members WHERE id = $id");
$oldData = mysqli_fetch_assoc($query);
$imagePath = $oldData['image'];

// Handle new image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['image'];
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExt, $allowed) && $file['size'] < 2 * 1024 * 1024) {
        $newFileName = 'member_' . time() . '_' . mt_rand(1000, 9999) . '.' . $fileExt;
        $uploadDir = '../images/team_members/';
        
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        if (move_uploaded_file($file['tmp_name'], $uploadDir . $newFileName)) {
            // Delete old image if it exists
            if (file_exists('../' . $imagePath)) unlink('../' . $imagePath);
            $imagePath = 'images/team_members/' . $newFileName;
        }
    }
}

$sql = "UPDATE team_members SET 
        name = '$name', 
        type = '$type', 
        sub_type = '$sub_type', 
        image = '$imagePath', 
        description = '$description', 
        quote = '$quote', 
        skill_1 = '$skill_1', 
        skill_2 = '$skill_2', 
        skill_3 = '$skill_3', 
        twitter = '$twitter', 
        linkedin = '$linkedin', 
        github = '$github' 
        WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    $_SESSION['success'] = "Member updated successfully!";
    header('location: team_members_table.php');
} else {
    $_SESSION['error'] = "Error updating member: " . mysqli_error($conn);
    header("location: team_member_edit.php?id=$id");
}
?>
