<?php
// Start session for messages
session_start();

// Check if user is logged in as admin
if(!isset($_SESSION['super_admin_id'])){
    header('location:superadminlogin.php');
    exit;
}

// Include database connection
include '../db_connection/connection.php';

// Get all videos from database with their category and sub category names
// LEFT JOIN means: show videos even if they don't have a category
$query = "SELECT v.*, c.name as category_name, sc.name as sub_category_name
          FROM research_videos v 
          LEFT JOIN add_categories c ON v.category_id = c.id
          LEFT JOIN sub_categories sc ON v.sub_category_id = sc.id
          ORDER BY v.created_at DESC";




$result = mysqli_query($conn, $query);

// Check if query was successful
if (!$result) {
    die('Database error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Videos | Research Academia</title>
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

    .video-thumbnail {
        width: 120px;
        height: 68px;
        object-fit: cover;
        border-radius: 6px;
    }

    .truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
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
                            <i class="fas fa-video text-primary mr-3"></i>Research Videos
                        </h1>
                        <p class="text-gray-600">Manage all research video content</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="uploadvideoform.php"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-plus mr-2"></i> Add New Video
                        </a>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Videos Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Total Videos</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    // Count total number of videos
                                    $totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM research_videos");
                                    $totalData = mysqli_fetch_assoc($totalQuery);
                                    echo $totalData['total'];
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                                <i class="fas fa-video text-primary text-xl"></i>
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
                                    // Count videos added this month
                                    $monthQuery = mysqli_query($conn, "SELECT COUNT(*) as month_count FROM research_videos WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
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

                    <!-- Categories Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm font-medium">Categories</p>
                                <p class="text-2xl font-bold text-gray-900 mt-2">
                                    <?php 
                                    // Count unique categories used
                                    $catQuery = mysqli_query($conn, "SELECT COUNT(DISTINCT category_id) as cat_count FROM research_videos WHERE category_id IS NOT NULL");
                                    $catData = mysqli_fetch_assoc($catQuery);
                                    echo $catData['cat_count'];
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center">
                                <i class="fas fa-tags text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Latest Video Card -->
                    <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <p class="text-gray-500 text-sm font-medium">Latest Added</p>
                                <p class="text-sm font-semibold text-gray-900 mt-2 truncate">
                                    <?php 
                                    // Get the latest video title
                                    $latestQuery = mysqli_query($conn, "SELECT title FROM research_videos ORDER BY created_at DESC LIMIT 1");
                                    $latestData = mysqli_fetch_assoc($latestQuery);
                                    // Show the title or "No videos yet"
                                    echo $latestData ? htmlspecialchars($latestData['title']) : 'No videos yet';
                                    ?>
                                </p>
                            </div>
                            <div class="w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center ml-3">
                                <i class="fas fa-clock text-amber-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Videos Table Section -->
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden max-w-[945px] w-full">
                <!-- Table Header with Search -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">All Research Videos</h3>
                            <p class="text-gray-500 text-sm">List of all uploaded research videos</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <div class="flex space-x-3">
                                <!-- Search Box -->
                                <div class="relative">
                                    <input type="text" placeholder="Search by title or description..."
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
                                    $catListQuery = mysqli_query($conn, "SELECT id, name FROM add_categories ORDER BY name ASC");
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
                <div class="overflow-x-auto max-w-full">
                    <table class="w-full">
                        <!-- Table Head -->
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-3 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    ID</th>

                                <th
                                    class="px-3 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Thumbnail</th>

                                <th
                                    class="px-3 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Title</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Sub Category</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Research Leader</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Co-Leader</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Date Added</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    URL</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-200" id="videoTableBody">
                            <?php 
                            $counter = 1; // 🔥 counter start

                                if(mysqli_num_rows($result) > 0):
                                while($video = mysqli_fetch_assoc($result)): 
                                ?>

                            <tr class="table-row transition duration-150 ease-in-out hover:bg-gray-50 cursor-pointer"
                                data-category="<?php echo $video['category_id']; ?>">
                                <!-- Title Column -->
                                <td class="px-3 py-2">
                                    <div class="bg-primary p-1 rounded-lg ">
                                        <p class="font-semibold text-white max-w-xs truncate">
                                            #<?php echo $counter++; ?>
                                        </p>
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <?php if (!empty($video['thumbnail'])): ?>
                                    <img src="<?php echo '../images/thumbnails/' . htmlspecialchars($video['thumbnail']); ?>"
                                        alt="Thumb" class="video-thumbnail">
                                    <?php else: ?>
                                    <div
                                        class="w-28 h-16 bg-gray-100 flex items-center justify-center text-gray-300 rounded">
                                        No image</div>
                                    <?php endif; ?>
                                </td>

                                <td class="px-3 py-2">
                                    <div>
                                        <p class="font-semibold text-gray-900 max-w-xs truncate">
                                            <?php echo htmlspecialchars($video['title']); ?>
                                        </p>
                                        <p class="text-xs text-gray-600 mt-1  line-clamp-2">
                                            <?php echo htmlspecialchars($video['description']); ?>
                                        </p>
                                    </div>
                                </td>


                                <!-- Category Column -->
                                <td class="px-3 py-2">
                                    <span
                                        class="inline-flex items-center px-2 py-1.5 rounded-full text-[10px] font-medium bg-secondary text-white border truncate max-w-[150px]">
                                        <?php 
                             // Show category name or "Uncategorized"
                             echo htmlspecialchars($video['category_name'] ?? 'Uncategorized');
                                 ?>
                                    </span>
                                </td>

                                <!-- Sub Category Column -->
                                <td class="px-3 py-2">
                                    <span
                                        class="inline-flex items-center px-2 py-1.5 rounded-full text-[10px] font-medium bg-secondary text-white border truncate max-w-[150px]">
                                        <?php 
                            // Show sub category name or "Not assigned"
                             echo htmlspecialchars($video['sub_category_name'] ?? 'Not assigned');
                                 ?>
                                    </span>
                                </td>


                                <!-- Research Leader Column -->
                                <td class="px-3 py-2">
                                    <p class="text-sm text-gray-800 truncate max-w-[150px]">
                                        <?php echo htmlspecialchars($video['research_leader'] ?? '—'); ?>
                                    </p>
                                </td>

                                <!-- Co-Leader Column -->
                                <td class="px-3 py-2">
                                    <p class="text-sm text-gray-800 truncate max-w-[150px]">
                                        <?php echo htmlspecialchars($video['co_leader'] ?? '—'); ?>
                                    </p>
                                </td>

                                <!-- Date Added Column -->
                                <td class="px-3 py-2">
                                    <p class="text-xs text-gray-700">
                                        <?php 
                                        // Format date nicely (e.g., "Dec 26, 2025")
                                        echo date('M d, Y', strtotime($video['created_at']));
                                        ?>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        <?php 
                                        // Show time (e.g., "02:30 PM")
                                        echo date('h:i A', strtotime($video['created_at']));
                                        ?>
                                    </p>
                                </td>

                                <!-- URL Column -->
                                <td class="px-3 py-2">
                                    <p class="text-sm text-primary truncate max-w-[150px] truncate">
                                        <?php echo htmlspecialchars($video['video_url']); ?>
                                    </p>
                                </td>

                                <!-- Actions Column -->
                                <td class="px-5 py-2 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <!-- View Button -->
                                        <a href="<?php echo htmlspecialchars($video['video_url']); ?>" target="_blank"
                                            class="inline-flex items-center px-3 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition duration-200"
                                            title="View Video">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <!-- Edit Button -->
                                        <a href="videoedit.php?id=<?php echo $video['id']; ?>"
                                            class="inline-flex items-center px-3 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition duration-200"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete(<?php echo $video['id']; ?>)"
                                            class="inline-flex items-center px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200"
                                            title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                                endwhile; // End of while loop for videos
                            // If no videos found
                            else: 
                            ?>
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div
                                        class="mx-auto w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-6">
                                        <i class="fas fa-video text-gray-400 text-3xl"></i>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No videos found</h3>
                                    <p class="text-gray-600 mb-6">Start by uploading your first research video</p>
                                    <a href="uploadvideoform.php"
                                        class="inline-flex items-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                        <i class="fas fa-plus mr-2"></i> Upload First Video
                                    </a>
                                </td>
                            </tr>
                            <?php endif; // End of if statement ?>
                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">
                            Showing <span class="font-semibold"><?php echo mysqli_num_rows($result); ?></span> videos
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Search functionality - filters videos based on search input
    document.getElementById('searchInput').addEventListener('keyup', function() {
        // Get the search value and convert to lowercase for comparison
        const searchValue = this.value.toLowerCase();
        // Get all table rows
        const rows = document.querySelectorAll('#videoTableBody tr');

        // Loop through each row
        rows.forEach(row => {
            // Get all text content from the row and convert to lowercase
            const text = row.textContent.toLowerCase();
            // Show row if text matches search, hide if not
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });

    // Category filter functionality
    document.getElementById('categoryFilter').addEventListener('change', function() {
        // Get selected category ID
        const categoryId = this.value;
        // Get all table rows
        const rows = document.querySelectorAll('#videoTableBody tr');

        // Loop through each row
        rows.forEach(row => {
            // Get the category ID from the row's data attribute
            const rowCategory = row.getAttribute('data-category');

            // Show row if no filter selected or category matches
            if (!categoryId || rowCategory === categoryId) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Delete video confirmation
    function confirmDelete(videoId) {
        // Ask user to confirm deletion
        if (confirm('Are you sure you want to delete this video? This action cannot be undone.')) {
            // If confirmed, redirect to delete process
            window.location.href = 'videodelete_process.php?delete_id=' + videoId;
        }
        // If not confirmed, do nothing
        return false;
    }
    </script>

</body>

</html>