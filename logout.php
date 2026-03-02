<?php
session_start();

// Clear all session data
$_SESSION = array();

// If there's a session cookie, remove it for complete teardown
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Determine redirect destination
if (isset($_GET['admin']) && $_GET['admin'] == '1') {
    // Redirect to Admin Login with status
    header('Location: Admin/index.php?logout=1');
} else {
    // Redirect to public homepage
    header('Location: index.php');
}
exit;
?>