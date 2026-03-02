<?php

session_start();

if ( !isset( $_SESSION[ 'super_admin_id' ] ) ) {
    header( 'location:index.php' );
    exit;
}

include '../db_connection/connection.php';

$edit_mode = false;
$category = [ 'id' => '', 'name' => '', 'description' => '' ];

// Check if editing an existing category
if ( isset( $_GET[ 'id' ] ) ) {
    $category_id = intval( $_GET[ 'id' ] );

    $stmt = $conn->prepare( 'SELECT id, name, description FROM add_categories WHERE id = ?' );
    if ( $stmt ) {
        $stmt->bind_param( 'i', $category_id );
        $stmt->execute();
        $result = $stmt->get_result();

        if ( $result->num_rows > 0 ) {
            $category = $result->fetch_assoc();
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
<meta name = 'viewport' content = 'width=device-width, initial-scale=1.0'>
<title><?php echo $edit_mode ? 'Edit' : 'Add';
?> Category | Research Academia</title>
<script src = 'https://cdn.tailwindcss.com'></script>
<link rel = 'stylesheet' href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
<style>
:root {
    --primary: #103182;
    --secondary: #4fc5c1;
}

.form-input {
    transition: all 0.3s ease;
}

.card-shadow {
    box-shadow: 0 10px 30px rgba( 0, 0, 0, 0.08 );
}

.alert {
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.alert-error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}
</style>
</head>

<body class = 'bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen'>

<div class = 'flex'>
<?php include 'dashboardsidebar.php';
?>

<main class = 'flex-1 p-6 md:p-8'>
<!-- Header -->
<div class = 'mb-8'>
<div class = 'flex items-center justify-between'>
<div>
<h1 class = 'text-3xl font-bold text-gray-900 mb-2'>
<i class = 'fas fa-tags text-primary mr-3'></i><?php echo $edit_mode ? 'Edit Category' : 'Add New Category';
?>
</h1>
<p class = 'text-gray-600'>Create and manage research video categories</p>
</div>

                <div class = 'flex items-center space-x-3'>
                    <?php include 'notification_bar.php'; ?>
                    <a href = 'addsubcategoryfrom.php'
                        class = 'flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition duration-300'>
                        <i class = 'fas fa-plus mr-2'></i>Add sub Category
                    </a>
                    <a href = 'categorytable.php'
                        class = 'flex items-center px-4 py-2.5 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition duration-300'>
                        <i class = 'fas fa-list mr-2'></i>View Categories
                    </a>
                </div>
</div>
</div>

<!-- Messages -->
<?php if ( isset( $_SESSION[ 'success' ] ) ): ?>
<div class = 'alert alert-success'>
<i class = 'fas fa-check-circle'></i>
<span><?php echo htmlspecialchars( $_SESSION[ 'success' ] );
?></span>
</div>
<?php unset( $_SESSION[ 'success' ] );
endif;
?>

<?php if ( isset( $_SESSION[ 'error' ] ) ): ?>
<div class = 'alert alert-error'>
<i class = 'fas fa-exclamation-circle'></i>
<span><?php echo htmlspecialchars( $_SESSION[ 'error' ] );
?></span>
</div>
<?php unset( $_SESSION[ 'error' ] );
endif;
?>

<!-- Main Form Card -->
<div class = 'max-w-5xl mx-auto'>
<div class = 'bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden'>
<!-- Card Header -->
<div class = 'bg-primary p-6 md:p-8'>
<div class = 'flex items-center'>
<div class = 'w-12 h-12 rounded-lg bg-white flex items-center justify-center mr-4'>
<i class = "fas fa-<?php echo $edit_mode ? 'edit' : 'plus'; ?> text-primary text-xl"></i>
</div>
<div>
<h2 class = 'text-2xl font-bold text-white'>Category Details</h2>
<p class = 'text-white mt-1'>Fill in the category information below</p>
</div>
</div>
</div>

<!-- Form -->
<form method = 'POST' action = 'addcategory_process.php' class = 'p-6 md:p-8 space-y-8'>
<input type = 'hidden' name = 'id' value = "<?php echo htmlspecialchars($category['id']); ?>">

<!-- Category Name -->
<div class = 'space-y-3'>
<label class = 'block text-gray-800 font-semibold text-lg'>
<i class = 'fas fa-heading text-primary mr-2'></i>Category Name <span

class = 'text-red-500'>*</span>
</label>
<div class = 'relative'>
<input type = 'text' name = 'name' required

class = 'w-full px-5 py-4 border-2 border-gray-200 rounded-xl form-input focus:border-primary focus:ring-0 outline-none text-lg placeholder-gray-400'
placeholder = "Enter category name (e.g., 'Scientific Research')"
value = "<?php echo htmlspecialchars($category['name']); ?>">
<div class = 'absolute right-4 top-1/2 transform -translate-y-1/2'>
<i class = 'fas fa-tag text-gray-400'></i>
</div>
</div>
</div>

<div class = 'space-y-3'>
<label class = 'block text-gray-800 font-semibold text-lg'>
<i class = 'fas fa-align-left text-primary mr-2'></i>Description
</label>
<div class = 'relative'>
<textarea name = 'description' rows = '5'

class = 'w-full px-5 py-4 border-2 border-gray-200 rounded-xl form-input focus:border-primary focus:ring-0 outline-none resize-none placeholder-gray-400'
placeholder = "Describe this category's purpose and scope..."><?php echo htmlspecialchars( $category[ 'description' ] );
?></textarea>
<div class = 'absolute right-4 top-5'>
<i class = 'fas fa-file-alt text-gray-400'></i>
</div>
</div>
</div>

<div

class = 'pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0'>
<div class = 'text-gray-600 text-sm'>
<i class = 'fas fa-asterisk text-red-400 mr-2'></i>
Required fields are marked with <span class = 'text-red-500'>*</span>
</div>

<div class = 'flex space-x-4'>
<button type = 'reset'

class = 'px-8 py-3.5 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300 flex items-center'>
<i class = 'fas fa-redo mr-2'></i>
Reset
</button>
<button type = 'submit'

class = 'px-8 py-3.5 bg-primary text-white font-semibold rounded-xl  transition-all duration-300 shadow-md hover:shadow-lg flex items-center'>
<i class = "fas fa-<?php echo $edit_mode ? 'save' : 'save'; ?> mr-2"></i>
<?php echo $edit_mode ? 'Update Category' : 'Save Category';
?>
</button>
</div>
</div>
</form>
</div>
</div>
</main>
</div>

</body>

</html>