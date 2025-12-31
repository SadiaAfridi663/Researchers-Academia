<?php

session_start();

if(!isset($_SESSION['super_admin_id'])){
    header('location:superadminlogin.php');
    exit;
}

include '../db_connection/connection.php';

$result = mysqli_query($conn, "SELECT * FROM add_categories ORDER BY id DESC");

$subResult = mysqli_query($conn, "SELECT s.id, s.name AS sub_name, s.main_category_id, c.name AS category_name FROM sub_categories s LEFT JOIN add_categories c ON s.main_category_id = c.id ORDER BY s.id DESC");

$counter = 1;   
mysqli_data_seek($result, 0);
while($row = mysqli_fetch_assoc($result));

if (!$result) {
    die('Database query failed: ' . mysqli_error($conn));


    
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Research Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }

    .card-shadow {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .table-row:hover {
        background-color: #f8fafc;
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

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <?php include '../include/dashboardsidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <!-- Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-tags text-primary mr-3"></i>Categories
                        </h1>
                        <p class="text-gray-600">Manage all research video categories</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="addcategoryform.php"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i> Add New Category
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div
                        class="bg-white rounded-2xl card-shadow p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Categories
                                </p>
                                <p class="text-3xl font-bold text-gray-900 mt-3">
                                    <?php echo mysqli_num_rows($result); ?>
                                </p>
                                <div class="flex items-center mt-4">
                                    <span class="text-primary text-sm font-medium">
                                        <i class="fas fa-database mr-1"></i> All Research Fields
                                    </span>
                                    <span class="text-gray-400 text-sm ml-3">System-wide</span>
                                </div>
                            </div>
                            <div class="w-14 h-14 rounded-xl bg-primary flex items-center justify-center">
                                <i class="fas fa-layer-group text-primary text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center text-gray-600 text-sm">
                                <i class="fas fa-chart-pie text-primary mr-2"></i>
                                Organized research classification
                            </div>
                        </div>
                    </div>

                    <!-- Latest Category Card -->
                    <div
                        class="bg-white rounded-2xl card-shadow p-6 border border-gray-100 hover:shadow-lg transition-shadow duration-300">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Latest Added</p>
                                <p class="text-lg font-semibold text-gray-900 mt-3 truncate">
                                    <?php 
                    $latestResult = mysqli_query($conn, "SELECT id, name, created_at FROM add_categories ORDER BY created_at DESC LIMIT 1");
                    $latestRow = mysqli_fetch_assoc($latestResult);
                    if ($latestRow):
                    ?>
                                    <span
                                        class="text-xl font-bold text-gray-900 block mb-1"><?= htmlspecialchars($latestRow['name']) ?></span>
                                    <span class="text-sm text-gray-500 font-normal">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <?php echo date('M d, Y', strtotime($latestRow['created_at'])); ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="text-gray-400 italic">No categories yet</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div
                                class="w-14 h-14 rounded-xl bg-primary  flex items-center justify-center ml-4 flex-shrink-0">
                                <i class="fas fa-plus-circle text-white text-2xl"></i>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div class="text-gray-600 text-sm flex items-center">
                                    <i class="fas fa-clock text-primary mr-2"></i>
                                    Most recently created
                                </div>
                                <?php if($latestRow): ?>
                                <a href="edit.php?id=<?= $latestRow['id'] ?>"
                                    class="text-primary text-sm font-medium hover:text-blue-700 transition-colors">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Categories</h3>
                            <p class="text-gray-500 text-sm">List of all research categories</p>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Search categories..."
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition w-full md:w-64"
                                    id="searchInput">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span>ID</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <span>Category Name</span>
                                    </div>
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Description
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php 
                            mysqli_data_seek($result, 0);
                            while($row = mysqli_fetch_assoc($result)): 
                            ?>
                            <tr class="table-row transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="text-sm bg-primary text-white rounded-md p-1">#<?php echo $counter++; ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">

                                        <div>
                                            <div class="font-medium text-gray-900">
                                                <?php echo htmlspecialchars($row['name']); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">Created:
                                                <?php echo date('M d, Y', strtotime($row['created_at'])); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 max-w-xs truncate">
                                        <?php echo htmlspecialchars($row['description']) ?: '<span class="text-gray-400 italic">No description</span>'; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="addcategoryform.php?id=<?php echo htmlspecialchars($row['id']); ?>"
                                            class="inline-flex items-center px-3 py-1.5 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                            <i class="fas fa-edit mr-1.5 text-sm"></i>
                                            Edit
                                        </a>
                                        <a href="update_delete_process.php?delete_id=<?php echo htmlspecialchars($row['id']); ?>"
                                            onclick="return confirmDelete()"
                                            class="inline-flex items-center px-3 py-1.5 text-white bg-red-500 rounded-lg hover:bg-red-600 transition duration-300">
                                            <i class="fas fa-trash-alt mr-1.5 text-sm"></i>
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Showing <span class="font-medium"><?= mysqli_num_rows($result) ?></span> categories
                        </div>
                        <div class="mt-2 md:mt-0">
                            <nav class="inline-flex rounded-md shadow-sm -space-x-px">
                                <a href="#"
                                    class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                    Previous
                                </a>
                                <a href="#" class="px-3 py-2 border border-gray-300 bg-primary text-white">
                                    1
                                </a>
                                <a href="#"
                                    class="px-3 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                    2
                                </a>
                                <a href="#"
                                    class="px-3 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                    3
                                </a>
                                <a href="#"
                                    class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-gray-500 hover:bg-gray-50">
                                    Next
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <?php if(mysqli_num_rows($result) === 0): ?>
            <div class="mt-8 text-center py-12">
                <div class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                    <i class="fas fa-tags text-gray-400 text-3xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No categories found</h3>
                <p class="text-gray-600 mb-6">Get started by creating your first category</p>
                <a href="addcategoryform.php"
                    class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Create First Category
                </a>
            </div>
            <?php endif; ?>

            <!-- Sub Categories Table -->
            <div class="mt-8 bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sub Categories</h3>
                            <p class="text-gray-500 text-sm">List of all sub categories (grouped by category)</p>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <div class="relative">
                                <input type="text" placeholder="Search sub categories..."
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition w-full md:w-64"
                                    id="searchSubInput">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Sub Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Parent Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="subTableBody">
                            <?php if($subResult && mysqli_num_rows($subResult) > 0):
                                $sCounter = 1;
                                while($srow = mysqli_fetch_assoc($subResult)): ?>
                            <tr class="table-row transition duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="text-sm bg-primary text-white rounded-md p-1">#<?php echo $sCounter++; ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                <?php echo htmlspecialchars($srow['sub_name']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700">
                                        <?php echo htmlspecialchars($srow['category_name']) ?: '<span class="text-gray-400 italic">Unassigned</span>'; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="addsubcategoryfrom.php?id=<?php echo htmlspecialchars($srow['id']); ?>"
                                            class="inline-flex items-center px-3 py-1.5 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-300">
                                            <i class="fas fa-edit mr-1.5 text-sm"></i> Edit
                                        </a>
                                        <a href="subcategory_delete.php?delete_id=<?php echo htmlspecialchars($srow['id']); ?>"
                                            onclick="return confirm('Delete this sub category?');"
                                            class="inline-flex items-center px-3 py-1.5 text-white bg-red-500 rounded-lg hover:bg-red-600 transition duration-300">
                                            <i class="fas fa-trash-alt mr-1.5 text-sm"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-500">No sub categories found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="text-sm text-gray-500">Showing <span
                            class="font-medium"><?= ($subResult ? mysqli_num_rows($subResult) : 0) ?></span> sub
                        categories</div>
                </div>
            </div>

        </main>
    </div>

    <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('table:first-of-type tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Subcategories search
    document.getElementById('searchSubInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#subTableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Delete confirmation
    function confirmDelete() {
        return confirm('Are you sure you want to delete this category? This action cannot be undone.');
    }
    </script>

</body>

</html>