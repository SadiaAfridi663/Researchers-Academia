<?php
session_start();
include '../db_connection/connection.php';

$edit_mode = false;
$subcategory = [ 'id' => '', 'main_category_id' => '', 'name' => '' ];

// Load main categories for the select
$categories = mysqli_query( $conn, 'SELECT id, name FROM add_categories ORDER BY name ASC' );

// If editing, load existing sub category
if ( isset( $_GET[ 'id' ] ) ) {
    $sub_id = intval( $_GET[ 'id' ] );
    $stmt = $conn->prepare( 'SELECT id, main_category_id, name FROM sub_categories WHERE id = ?' );
    if ( $stmt ) {
        $stmt->bind_param( 'i', $sub_id );
        $stmt->execute();
        $res = $stmt->get_result();
        if ( $res && $res->num_rows > 0 ) {
            $subcategory = $res->fetch_assoc();
            $edit_mode = true;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang = 'en'>

<head>
<meta charset = 'UTF-8'>
<title><?php echo $edit_mode ? 'Edit' : 'Add';
?> Sub Category</title>
<script src = 'https://cdn.tailwindcss.com'></script>

<style>
:root {
    --primary: #103182;
}
</style>
</head>

<body class = 'bg-gray-100 min-h-screen'>

<div class = 'flex'>
<!-- Sidebar -->
<?php include 'dashboardsidebar.php';
?>

<!-- Main Content -->
<main class = 'flex-1 p-6 md:p-10'>

<div class = 'mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4'>
<div>
<h1 class = 'text-3xl font-bold text-gray-900'>
<?php echo $edit_mode ? 'Edit' : 'Add New';
?> Sub Category
</h1>
<p class = 'text-gray-600 text-sm'>
Manage sub categories under main categories
</p>
</div>
<div class="flex items-center gap-3">
    <?php include 'notification_bar.php'; ?>
</div>
</div>

<!-- Form Card -->
<div class = 'max-w-5xl bg-white rounded-2xl shadow-lg border border-gray-200'>

<div class = 'px-6 py-4 bg-[var(--primary)] rounded-t-2xl'>
<h2 class = 'text-xl font-semibold text-white'>
Sub Category Details
</h2>
</div>

<!-- Form -->
<form method = 'POST' action = 'subcategory_process.php' class = 'p-6 space-y-6'>

<input type = 'hidden' name = 'id' value = "<?php echo $subcategory['id']; ?>">

<div>
<label class = 'block font-semibold text-gray-700 mb-2'>
Main Category <span class = 'text-red-500'>*</span>
</label>
<select name = 'main_category_id' required

class = 'w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500'>
<option value = ''>Select Category</option>
<?php while( $cat = mysqli_fetch_assoc( $categories ) ) {
    ?>
    <option value = "<?php echo $cat['id']; ?>" <?php if ( $cat[ 'id' ] == $subcategory[ 'main_category_id' ] ) echo 'selected';
    ?>>
    <?php echo htmlspecialchars( $cat[ 'name' ] );
    ?>
    </option>
    <?php }
    ?>
    </select>
    </div>

    <!-- Sub Category Name -->
    <div>
    <label class = 'block font-semibold text-gray-700 mb-2'>
    Sub Category Name <span class = 'text-red-500'>*</span>
    </label>
    <input type = 'text' name = 'name' required
    value = "<?php echo htmlspecialchars($subcategory['name']); ?>" placeholder = 'e.g. Law & Legal'

    class = 'w-full px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500'>
    </div>

    <!-- Buttons -->
    <div class = 'flex justify-end gap-4 pt-4 border-t'>

    <button type = 'reset'

    class = 'px-6 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition'>
    Reset
    </button>

    <button type = 'submit'

    class = 'px-6 py-2 rounded-xl bg-[var(--primary)] text-white hover:bg-blue-800 transition'>
    <?php echo $edit_mode ? 'Update Sub Category' : 'Save Sub Category';
    ?>
    </button>

    </div>

    </form>
    </div>

    </main>
    </div>

    </body>

    </html>