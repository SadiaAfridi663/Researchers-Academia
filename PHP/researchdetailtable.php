<?php
session_start();

// Check if user is logged in as admin
if(!isset($_SESSION['super_admin_id'])){
    header('location:superadminlogin.php');
    exit;
}

include '../db_connection/connection.php';

$query = "SELECT rd.*, c.name as category_name, sc.name as sub_category_name
          FROM research_detail rd
          LEFT JOIN add_categories c ON rd.category_id = c.id
          LEFT JOIN sub_categories sc ON rd.sub_category_id = sc.id
          ORDER BY rd.created_at DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Database error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Details | Research Academia</title>
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

    .truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Professional horizontal scroll styling */
    .table-scroll-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .table-scroll-wrapper::-webkit-scrollbar {
        height: 8px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .table-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .table-scroll-wrapper table {
        min-width: 100%;
    }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

    <div class="flex">
        <!-- Sidebar Navigation -->
        <?php include '../include/dashboardsidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <span class="text-green-800"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <span class="text-red-800"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            <i class="fas fa-file-alt text-primary mr-3"></i>Research Details
                        </h1>
                        <p class="text-gray-600">Manage all research detail documents</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="uploadresearchdetailform.php"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i> Add Research Detail
                        </a>
                    </div>
                </div>
                <!-- Detail Modal -->
                <div id="detailModal"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg w-full max-w-3xl mx-4 overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h3 id="dmTitle" class="text-xl font-bold text-primary"></h3>
                                <button id="dmClose" class="text-gray-500 hover:text-gray-800">&times;</button>
                            </div>
                            <p id="dmMeta" class="text-sm text-gray-600 mt-2"></p>
                            <div id="dmBody" class="mt-4 text-gray-700"></div>
                            <div class="mt-6 flex gap-3">
                                <a id="dmFullLink" href="#" class="bg-primary text-white px-4 py-2 rounded-md">Open Full
                                    View</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Records Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Details</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    $totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM research_detail");
                                    $totalData = mysqli_fetch_assoc($totalQuery);
                                    echo $totalData['total'];
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-file-alt text-primary text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- This Month Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">This Month</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    $monthQuery = mysqli_query($conn, "SELECT COUNT(*) as month_count FROM research_detail WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
                                    $monthData = mysqli_fetch_assoc($monthQuery);
                                    echo $monthData['month_count'];
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Downloads Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Downloads</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    $dlQuery = mysqli_query($conn, "SELECT SUM(downloads) as total_downloads FROM research_detail");
                                    $dlData = mysqli_fetch_assoc($dlQuery);
                                    echo $dlData['total_downloads'] ?? 0;
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center">
                                <i class="fas fa-download text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Categories</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    $catQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT category_id) as cat_count FROM research_detail WHERE category_id IS NOT NULL");
                                    $catData = mysqli_fetch_assoc($catQuery);
                                    echo $catData['cat_count'];
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center">
                                <i class="fas fa-tags text-amber-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Research Details Table Section -->
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden max-w-[945px] w-full">
                <!-- Table Header with Search -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Research Details</h3>
                            <p class="text-gray-500 text-sm">List of all research detail documents</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="flex space-x-3">
                                <!-- Search Box -->
                                <div class="relative">
                                    <input type="text" placeholder="Search by title..."
                                        class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition w-full md:w-64"
                                        id="searchInput">
                                    <i
                                        class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <!-- Category Filter -->
                                <select id="categoryFilter"
                                    class="border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                                    <option value="">All Categories</option>
                                    <?php
                                    // Get all categories for filter dropdown
                                    $catListQuery = mysqli_query($conn, "SELECT DISTINCT id, name FROM add_categories WHERE id IN (SELECT category_id FROM research_detail) ORDER BY name ASC");
                                    while($category = mysqli_fetch_assoc($catListQuery)) {
                                        echo '<option value="' . htmlspecialchars($category['id']) . '">' . htmlspecialchars($category['name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-scroll-wrapper overflow-x-auto max-w-full">
                    <table class="w-full">
                        <!-- Table Head -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    ID</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Sub Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Published Date</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Pages</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Downloads</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Created Date</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-200" id="detailTableBody">
                            <?php 
                            $counter = 1;

                            if(mysqli_num_rows($result) > 0):
                                while($detail = mysqli_fetch_assoc($result)): 
                            ?>

                            <tr class="table-row transition duration-150 ease-in-out hover:bg-gray-50 cursor-pointer"
                                data-category="<?php echo $detail['category_id']; ?>">
                                <!-- ID -->
                                <td class="px-6 py-4">
                                    <div class="bg-primary p-2 rounded-lg w-fit">
                                        <p class="font-semibold text-white">
                                            #<?php echo $counter++; ?>
                                        </p>
                                    </div>
                                </td>

                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-gray-900 max-w-xs truncate">
                                            <?php echo htmlspecialchars($detail['title']); ?>
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1 truncate-2">
                                            <?php echo htmlspecialchars(substr($detail['abstract'] ?? '', 0, 100)); ?>
                                        </p>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-secondary text-white border truncate max-w-[150px]">
                                        <?php echo htmlspecialchars($detail['category_name'] ?? 'Uncategorized'); ?>
                                    </span>
                                </td>

                                <!-- Sub Category -->
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium bg-secondary text-white border truncate max-w-[150px]">
                                        <?php echo htmlspecialchars($detail['sub_category_name'] ?? 'Not assigned'); ?>
                                    </span>
                                </td>

                                <!-- Published Date -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-800">
                                        <?php 
                                        echo $detail['published_date'] ? date('M d, Y', strtotime($detail['published_date'])) : '—';
                                        ?>
                                    </p>
                                </td>

                                <!-- Pages -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-800">
                                        <?php echo $detail['pages'] ?? '—'; ?>
                                    </p>
                                </td>

                                <!-- Downloads -->
                                <td class="px-6 py-4">
                                    <p class="text-sm font-semibold text-primary">
                                        <?php echo $detail['downloads']; ?>
                                    </p>
                                </td>

                                <!-- Created Date -->
                                <td class="px-6 py-4">
                                    <p class="text-xs text-gray-700">
                                        <?php echo date('M d, Y', strtotime($detail['created_at'])); ?>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php echo date('h:i A', strtotime($detail['created_at'])); ?>
                                    </p>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <!-- View Button (opens modal) -->
                                        <button data-id="<?php echo $detail['id']; ?>"
                                            class="detail-view-btn inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-200"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <!-- Edit Button -->
                                        <a href="researchdetailedit.php?id=<?php echo $detail['id']; ?>"
                                            class="inline-flex items-center px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-200"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete(<?php echo $detail['id']; ?>)"
                                            class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endwhile;
                            else: 
                            ?>
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div
                                        class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                        <i class="fas fa-file-alt text-gray-400 text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No research details found</h3>
                                    <p class="text-gray-600 mb-6">Start by adding your first research detail</p>
                                    <a href="uploadresearchdetailform.php"
                                        class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-plus mr-2"></i> Add First Research Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold"><?php echo mysqli_num_rows($result); ?></span> research
                            details
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#detailTableBody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Category filter functionality
    document.getElementById('categoryFilter').addEventListener('change', function() {
        const categoryId = this.value;
        const rows = document.querySelectorAll('#detailTableBody tr');

        rows.forEach(row => {
            const rowCategory = row.getAttribute('data-category');

            if (!categoryId || rowCategory === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Delete confirmation
    function confirmDelete(detailId) {
        if (confirm('Are you sure you want to delete this research detail? This action cannot be undone.')) {
            window.location.href = 'researchdetaildelete_process.php?delete_id=' + detailId;
        }
        return false;
    }

    // Modal view for details
    const detailModal = document.getElementById('detailModal');
    const dmClose = document.getElementById('dmClose');
    const dmTitle = document.getElementById('dmTitle');
    const dmMeta = document.getElementById('dmMeta');
    const dmBody = document.getElementById('dmBody');
    const dmFullLink = document.getElementById('dmFullLink');

    document.addEventListener('click', function(e) {
        if (e.target.closest('.detail-view-btn')) {
            const btn = e.target.closest('.detail-view-btn');
            const id = btn.getAttribute('data-id');
            fetch('get_research_detail.php?id=' + id)
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        alert('Could not load detail');
                        return;
                    }
                    const d = data.data;
                    dmTitle.textContent = d.title;
                    dmMeta.textContent =
                        `${d.category_name || 'Uncategorized'} • ${d.sub_category_name || ''} • Pages: ${d.pages || '—'}`;
                    dmBody.innerHTML = '';
                    if (d.abstract) dmBody.innerHTML +=
                        `<h4 class="font-semibold mt-2">Abstract</h4><div class="mt-1">${d.abstract}</div>`;
                    if (d.introduction) dmBody.innerHTML +=
                        `<h4 class="font-semibold mt-4">Introduction</h4><div class="mt-1">${d.introduction}</div>`;
                    if (d.methodology) dmBody.innerHTML +=
                        `<h4 class="font-semibold mt-4">Methodology</h4><div class="mt-1">${d.methodology}</div>`;
                    if (d.conclusion) dmBody.innerHTML +=
                        `<h4 class="font-semibold mt-4">Conclusion</h4><div class="mt-1">${d.conclusion}</div>`;
                    dmFullLink.href = 'researchDetailView.php?id=' + id;
                    detailModal.classList.remove('hidden');
                    detailModal.classList.add('flex');
                })
                .catch(err => {
                    console.error(err);
                    alert('Error loading detail');
                });
        }
    });

    dmClose.addEventListener('click', function() {
        detailModal.classList.remove('flex');
        detailModal.classList.add('hidden');
    });
    </script>

</body>

</html>