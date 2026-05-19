<?php

session_start();

if(!isset($_SESSION['super_admin_id'])){
    
    header('location:index.php');
    exit;
}

?>

<?php
include '../db_connection/connection.php';

/* TOTAL VIDEOS */
$videoQuery = "SELECT COUNT(id) AS total_videos FROM research_videos";
$videoResult = mysqli_query($conn, $videoQuery);
$totalVideos = mysqli_fetch_assoc($videoResult)['total_videos'];

/* TOTAL CATEGORIES */
$catQuery = "SELECT COUNT(id) AS total_categories FROM add_categories";
$catResult = mysqli_query($conn, $catQuery);
$totalCategories = mysqli_fetch_assoc($catResult)['total_categories'];

/* TOTAL SUB CATEGORIES */
$subCatQuery = "SELECT COUNT(id) AS total_sub_categories FROM sub_categories";
$subCatResult = mysqli_query($conn, $subCatQuery);
$totalSubCategories = mysqli_fetch_assoc($subCatResult)['total_sub_categories'];

/* TOTAL VIEWS */
// $viewsQuery = "SELECT SUM(views) AS total_views FROM videos";
// $viewsResult = mysqli_query($conn, $viewsQuery);
// $totalViews = mysqli_fetch_assoc($viewsResult)['total_views'] ?? 0;

/* THIS MONTH PUBLISHED */
$monthQuery = "SELECT COUNT(id) AS month_videos 
               FROM research_videos 
               WHERE MONTH(created_at) = MONTH(CURRENT_DATE())
               AND YEAR(created_at) = YEAR(CURRENT_DATE())";
$monthResult = mysqli_query($conn, $monthQuery);
$thisMonthVideos = mysqli_fetch_assoc($monthResult)['month_videos'];

/* UNREAD MESSAGES */
$unreadQuery = "SELECT COUNT(id) AS unread FROM contact_messages WHERE status = 'unread'";
$unreadResult = mysqli_query($conn, $unreadQuery);
$unreadCount = mysqli_fetch_assoc($unreadResult)['unread'] ?? 0;
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Research Academia Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }
    }

    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .video-card {
        transition: all 0.3s ease;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--primary) 0%, #1a4ab3 100%);
    }

    .stat-card-secondary {
        background: linear-gradient(135deg, var(--secondary) 0%, #6bd9d6 100%);
    }

    .btn-primary {
        background-color: var(--primary);
    }

    .btn-primary:hover {
        background-color: #0c2769;
    }

    .btn-secondary {
        background-color: var(--secondary);
    }

    .btn-secondary:hover {
        background-color: #3db3af;
    }

    .text-primary {
        color: var(--primary);
    }

    .text-secondary {
        color: var(--secondary);
    }

    .border-primary {
        border-color: var(--primary);
    }

    .border-secondary {
        border-color: var(--secondary);
    }

    .bg-primary {
        background-color: var(--primary);
    }

    .bg-secondary {
        background-color: var(--secondary);
    }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Mobile Menu Button -->
    <div class="md:hidden fixed top-4 left-4 z-50">
        <button id="menuToggle" class="p-2 rounded-md bg-primary text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex min-h-screen">


        <?php include('dashboardsidebar.php'); ?>



        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Research Dashboard</h1>
                        <p class="text-gray-600">Manage and monitor all research video content</p>
                    </div>

                    <!-- Notification Area -->
                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm text-gray-500 shadow-sm">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            <span><?php echo date('d M Y'); ?></span>
                        </div>
                        <?php include 'notification_bar.php'; ?>
                    </div>
                </div>
            </header>



            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

                <div class="stat-card text-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90">Total Videos</p>
                            <p class="text-3xl font-bold mt-2"><?php echo $totalVideos; ?></p>
                        </div>
                        <i class="fas fa-play-circle text-3xl opacity-80"></i>
                    </div>
                </div>

                <div class="stat-card-secondary text-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90">Categories</p>
                            <p class="text-3xl font-bold mt-2"><?php echo $totalCategories; ?></p>
                        </div>
                        <i class="fas fa-tags text-3xl opacity-80"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Sub Categories</p>
                            <p class="text-2xl font-bold mt-2 text-primary"><?php echo $totalSubCategories; ?></p>
                        </div>
                        <i class="fas fa-layer-group text-2xl text-secondary"></i>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">This Month</p>
                            <p class="text-2xl font-bold mt-2 text-primary"><?php echo $thisMonthVideos; ?></p>
                        </div>
                        <i class="fas fa-calendar-check text-2xl text-secondary"></i>
                    </div>
                </div>

                <!-- Unread Messages Card -->
                <div class="bg-white rounded-xl p-6 shadow-lg border-2 border-red-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-red-500 text-sm font-bold">Unread Messages</p>
                            <p class="text-3xl font-bold mt-2 text-red-600"><?php echo $unreadCount; ?></p>
                        </div>
                        <i class="fas fa-envelope-open-text text-3xl text-red-500 animate-pulse"></i>
                    </div>
                </div>

            </div>




        </main>
    </div>

    <script>
    // Mobile menu toggle
    document.getElementById('menuToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.querySelector('.sidebar');
        const menuToggle = document.getElementById('menuToggle');

        if (window.innerWidth <= 768 &&
            !sidebar.contains(event.target) &&
            !menuToggle.contains(event.target) &&
            sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });

    // Add active state to video category buttons
    const categoryButtons = document.querySelectorAll('.bg-gray-100.text-gray-700');
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            categoryButtons.forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-gray-100', 'text-gray-700');
            });
            this.classList.remove('bg-gray-100', 'text-gray-700');
            this.classList.add('bg-primary', 'text-white');
        });
    });
    </script>
</body>

</html>