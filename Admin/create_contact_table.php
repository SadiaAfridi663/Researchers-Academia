<?php
// Run this file ONCE to create the contact_messages table
// Visit: http://localhost/Researchers-Academia/Admin/create_contact_table.php
// After it runs, you can delete this file.

include '../db_connection/connection.php';

$sql = "CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id`           INT(11) NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(150) NOT NULL,
  `email`        VARCHAR(200) NOT NULL,
  `phone`        VARCHAR(30) DEFAULT NULL,
  `department`   VARCHAR(100) DEFAULT NULL,
  `subject`      VARCHAR(255) NOT NULL,
  `message`      TEXT NOT NULL,
  `status`       ENUM('unread','read') NOT NULL DEFAULT 'unread',
  `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo '<div style="font-family:Arial;max-width:500px;margin:80px auto;text-align:center;padding:40px;border:2px solid #4fc5c1;border-radius:16px;">';
    echo '<h2 style="color:#103182;">&#10003; Table Created Successfully!</h2>';
    echo '<p style="color:#555;">The <strong>contact_messages</strong> table has been created in your database.</p>';
    echo '<p style="color:#888;font-size:13px;">You can now delete <strong>create_contact_table.php</strong> for security.</p>';
    echo '<br><a href="../contact_us.php" style="background:#103182;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;">Go to Contact Page</a>';
    echo '&nbsp;&nbsp;';
    echo '<a href="contact_messages.php" style="background:#4fc5c1;color:#fff;padding:12px 28px;border-radius:8px;text-decoration:none;font-weight:bold;">View Messages</a>';
    echo '</div>';
} else {
    echo '<div style="font-family:Arial;max-width:500px;margin:80px auto;text-align:center;padding:40px;border:2px solid red;border-radius:16px;">';
    echo '<h2 style="color:red;">&#10007; Error</h2>';
    echo '<p>' . mysqli_error($conn) . '</p>';
    echo '</div>';
}
?>
