<?php

session_start();

if(!isset($_SESSION['super_admin_id'])){
    
    header('location:superadminlogin.php');
    exit;
}

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


        <?php include '../include/dashboardsidebar.php'; ?>



        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-primary">Research Dashboard</h1>
                        <p class="text-gray-600">Manage and monitor all research video content</p>
                    </div>

                    <!-- Admin Dropdown -->
                    <div class="relative mt-4 md:mt-0">
                        <button type="button" id="adminBtn"
                            class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-medium">
                            <i class="fas fa-user-shield"></i>
                            Admin
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>

                        <!-- Dropdown -->
                        <div id="adminMenu"
                            class="hidden absolute right-0 mt-2 w-42 bg-white border rounded-lg shadow-lg z-[999]">
                            <hr>
                            <a href="superadminlogout_process.php" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </header>



            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card text-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90">Total Videos</p>
                            <p class="text-3xl font-bold mt-2">147</p>
                        </div>
                        <i class="fas fa-play-circle text-3xl opacity-80"></i>
                    </div>
                    <p class="text-sm mt-4 opacity-90"><i class="fas fa-arrow-up mr-1"></i> 12% from last month</p>
                </div>

                <div class="stat-card-secondary text-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm opacity-90">Research Categories</p>
                            <p class="text-3xl font-bold mt-2">8</p>
                        </div>
                        <i class="fas fa-tags text-3xl opacity-80"></i>
                    </div>
                    <p class="text-sm mt-4 opacity-90">All research fields covered</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Total Views</p>
                            <p class="text-3xl font-bold mt-2 text-primary">24.5K</p>
                        </div>
                        <i class="fas fa-eye text-3xl text-secondary"></i>
                    </div>
                    <p class="text-sm mt-4 text-gray-500"><i class="fas fa-arrow-up mr-1 text-green-500"></i> 23% from
                        last month</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500 text-sm">Published This Month</p>
                            <p class="text-3xl font-bold mt-2 text-primary">18</p>
                        </div>
                        <i class="fas fa-calendar-alt text-3xl text-secondary"></i>
                    </div>
                    <p class="text-sm mt-4 text-gray-500">On track for monthly target</p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 gap-8">
                <!-- Video List Section -->
                <div class="space-y-8">
                    <!-- Research Performance Metrics -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-primary">Research Performance</h2>
                            <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 bg-white">
                                <option>Last 30 days</option>
                                <option>Last Quarter</option>
                                <option>Year to Date</option>
                            </select>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Video Completion Rate</span>
                                    <span class="text-sm font-bold text-primary">78%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-secondary h-2 rounded-full" style="width: 78%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">↑ 12% from previous period</p>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Research Impact Score</span>
                                    <span class="text-sm font-bold text-primary">8.7/10</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: 87%"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Based on citations & engagement</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4 pt-4 border-t">
                                <div class="text-center p-3 bg-blue-50 rounded-lg">
                                    <p class="text-2xl font-bold text-primary">92%</p>
                                    <p class="text-xs text-gray-600 mt-1">Positive Feedback</p>
                                </div>
                                <div class="text-center p-3 bg-secondary bg-opacity-10 rounded-lg">
                                    <p class="text-2xl font-bold text-secondary">4.2K</p>
                                    <p class="text-xs text-gray-600 mt-1">New Followers</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Research Teams -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h2 class="text-xl font-bold text-primary mb-6">Top Research Teams</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white font-bold">
                                            QC
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Quantum Computing</p>
                                            <p class="text-xs text-gray-500">Dr. Alan Smith</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">24</p>
                                        <p class="text-xs text-gray-500">videos</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center text-white font-bold">
                                            GT
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Gene Therapy</p>
                                            <p class="text-xs text-gray-500">Dr. Maria Chen</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">18</p>
                                        <p class="text-xs text-gray-500">videos</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center text-white font-bold">
                                            AI
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Sustainable AI</p>
                                            <p class="text-xs text-gray-500">Dr. Robert Kim</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">15</p>
                                        <p class="text-xs text-gray-500">videos</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-purple-500 flex items-center justify-center text-white font-bold">
                                            CC
                                        </div>
                                        <div class="ml-3">
                                            <p class="font-medium">Climate Change</p>
                                            <p class="text-xs text-gray-500">Dr. Lisa Park</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">12</p>
                                        <p class="text-xs text-gray-500">videos</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Research Events -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-bold text-primary">Upcoming Events</h2>
                                <button class="text-sm text-primary font-medium">View All</button>
                            </div>

                            <div class="space-y-4">
                                <div class="border-l-4 border-secondary pl-4 py-2">
                                    <p class="font-medium">Research Symposium</p>
                                    <p class="text-sm text-gray-600">Annual Quantum Computing Conference</p>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="far fa-calendar mr-2"></i> Nov 15, 2023 • 9:00 AM
                                    </p>
                                </div>

                                <div class="border-l-4 border-primary pl-4 py-2">
                                    <p class="font-medium">Paper Submission Deadline</p>
                                    <p class="text-sm text-gray-600">Nature: Medical Research Special</p>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="far fa-clock mr-2"></i> Nov 20, 2023 • 11:59 PM
                                    </p>
                                </div>

                                <div class="border-l-4 border-green-500 pl-4 py-2">
                                    <p class="font-medium">Live Research Webinar</p>
                                    <p class="text-sm text-gray-600">AI Ethics in Modern Research</p>
                                    <p class="text-xs text-gray-500 mt-1 flex items-center">
                                        <i class="fas fa-video mr-2"></i> Nov 22, 2023 • 2:00 PM
                                    </p>
                                </div>
                            </div>
                        </div>
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


    // / Admin dashboard admin login  logout button 
    document.addEventListener("DOMContentLoaded", function() {
        const adminBtn = document.getElementById("adminBtn");
        const adminMenu = document.getElementById("adminMenu");

        adminBtn.addEventListener("click", function(e) {
            e.stopPropagation();
            adminMenu.classList.toggle("hidden");
        });

        document.addEventListener("click", function() {
            adminMenu.classList.add("hidden");
        });
    });
    </script>
</body>

</html>