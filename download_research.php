<?php
include 'db_connection/connection.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo "<script>alert('Invalid Request'); window.history.back();</script>";
    exit;
}

/* ================================
   STEP 1: Get Research PDF File
================================ */

$sql = "SELECT pdf_file FROM research_detail WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$detail = mysqli_fetch_assoc($result);

$file_name = "";
if ($detail) {
    // Increase download count
    $update = "UPDATE research_detail 
               SET downloads = IFNULL(downloads,0) + 1 
               WHERE id = ?";
    $u_stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($u_stmt, "i", $id);
    mysqli_stmt_execute($u_stmt);

    $file_name = $detail['pdf_file'];
}

/* ================================
   STEP 2: Get Research Information
================================ */

$info_sql = "SELECT v.title, v.description, v.research_leader, 
                    v.co_leader, v.created_at,
                    c.name as category_name,
                    rd.abstract, rd.introduction, 
                    rd.methodology, rd.conclusion
             FROM research_videos v
             LEFT JOIN add_categories c ON v.category_id = c.id
             LEFT JOIN research_detail rd ON v.id = rd.id
             WHERE v.id = ?";

$info_stmt = mysqli_prepare($conn, $info_sql);
mysqli_stmt_bind_param($info_stmt, "i", $id);
mysqli_stmt_execute($info_stmt);
$info_res = mysqli_stmt_get_result($info_stmt);
$data = mysqli_fetch_assoc($info_res);

/* ================================
   STEP 3: If PDF Exists → Download It
================================ */

if (!empty($file_name)) {

    $file_path = __DIR__ . "/" . ltrim($file_name, "../");

    if (!file_exists($file_path)) {
        $file_path = __DIR__ . "/pdfs/" . basename($file_name);
    }

    if (file_exists($file_path)) {

        $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        $content_type = "application/octet-stream";
        if ($ext == "pdf") {
            $content_type = "application/pdf";
        } elseif ($ext == "doc") {
            $content_type = "application/msword";
        } elseif ($ext == "docx") {
            $content_type = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
        }

        header("Content-Type: $content_type");
        header("Content-Disposition: attachment; filename=\"" . basename($file_path) . "\"");
        header("Content-Length: " . filesize($file_path));

        readfile($file_path);
        exit;
    }
}

/* ================================
   STEP 4: If No PDF → Generate DOC File
================================ */

$title = !empty($data['title']) ? $data['title'] : "Research Document";

$filename = "Research_" . preg_replace("/[^a-zA-Z0-9]/", "_", $title) . ".doc";

$abstract = !empty($data['abstract']) 
            ? $data['abstract'] 
            : (!empty($data['description']) ? $data['description'] : "N/A");

$introduction = !empty($data['introduction']) 
                ? $data['introduction'] 
                : "No introduction provided.";

$methodology = !empty($data['methodology']) 
               ? $data['methodology'] 
               : "No methodology provided.";

$conclusion = !empty($data['conclusion']) 
              ? $data['conclusion'] 
              : "No conclusion provided.";

$content = "
<html>
<head><meta charset='utf-8'></head>
<body style='font-family: Arial;'>

<h1 style='text-align:center;'>RESEARCH ACADEMIA</h1>
<hr>

<h2 style='text-align:center;'>$title</h2>

<h3>Research Team</h3>
<p><b>Research Leader:</b> " . htmlspecialchars($data['research_leader']) . "</p>
<p><b>Co-Leader:</b> " . htmlspecialchars($data['co_leader']) . "</p>

<p><b>Category:</b> " . htmlspecialchars($data['category_name']) . "</p>
<p><b>Published:</b> " . date('F j, Y', strtotime($data['created_at'])) . "</p>

<h3>Abstract</h3>
<p>" . nl2br(htmlspecialchars($abstract)) . "</p>

<h3>Introduction</h3>
<p>" . nl2br(htmlspecialchars($introduction)) . "</p>

<h3>Methodology</h3>
<p>" . nl2br(htmlspecialchars($methodology)) . "</p>

<h3>Conclusion</h3>
<p>" . nl2br(htmlspecialchars($conclusion)) . "</p>

<hr>
<p style='text-align:center;'>
Downloaded from Research Academia • " . date("Y-m-d H:i:s") . "
</p>

</body>
</html>
";

header("Content-Type: application/msword");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Length: " . strlen($content));

echo $content;
exit;
?>