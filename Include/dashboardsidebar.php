<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#103182',
                    secondary: '#4fc5c1',
                }
            }
        }
    }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <title>Document</title>
</head>

<body>
    <aside class="flex flex-col h-screen w-64 bg-white border-r border-gray-200 sticky top-0">
        <!-- Main sidebar container with scroll -->
        <div class="flex flex-col h-full p-6
            overflow-y-auto
            [scrollbar-width:none]
            [-ms-overflow-style:none]
            [&::-webkit-scrollbar]:hidden">

            <!-- Logo -->
            <div class="mb-10">
                <h1 class="text-xl font-bold text-primary mt-4">Research Academia</h1>
                <p class="text-gray-500 text-sm">Professional Research Dashboard</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-2 mb-6" id="sidebarNav">
                <!-- Active tab will have "bg-primary text-white" classes -->

                <a href="../PHP/admindashboard.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="dashboard">
                    <i class="fas fa-home mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <a href="../PHP/uploadvideoform.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="upload-videos">
                    <i class="fas fa-upload mr-3"></i>
                    <span>Upload Videos</span>
                </a>

                <a href="../PHP/videostable.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="research-videos">
                    <i class="fas fa-play-circle mr-3 "></i>
                    <span>Research Videos</span>
                </a>

                <a href="../PHP/addcategoryform.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="add-category">
                    <i class="fas fa-tags mr-3"></i>
                    <span>Add Category</span>
                </a>

                <a href="../PHP/categorytable.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="categories">
                    <i class="fas fa-list-alt mr-3"></i>
                    <span>Categories</span>
                </a>

                <!-- <a href="../PHP/uploadresearchdetailform.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="upload-research-detail">
                    <i class="fas fa-file-upload mr-3"></i>
                    <span>Add Research Detail</span>
                </a>

                <a href="../PHP/researchdetailtable.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="research-detail">
                    <i class="fas fa-clipboard-list mr-3"></i>
                    <span>Research Detail</span>
                </a> -->

                <a href="../analytics.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="analytics">
                    <i class="fas fa-chart-bar mr-3"></i>
                    <span>Analytics</span>
                </a>

                <a href="../research-teams.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="research-teams">
                    <i class="fas fa-users mr-3"></i>
                    <span>Research Teams</span>
                </a>

                <a href="../settings.php"
                    class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-200 hover:translate-x-1"
                    data-tab="settings">
                    <i class="fas fa-cog mr-3"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex items-center p-3">
                    <div
                        class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-bold">
                        AJ
                    </div>
                    <div class="ml-3">
                        <p class="font-medium">Admin User</p>
                        <p class="text-gray-500 text-sm">Research Director</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <script>
    // Active tab management with localStorage persistence
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarNav = document.getElementById('sidebarNav');
        const allTabs = sidebarNav.querySelectorAll('a');

        // Function to set active tab
        function setActiveTab(tabElement) {
            // Remove active classes from all tabs
            allTabs.forEach(tab => {
                tab.classList.remove('bg-primary', 'text-white', 'shadow-md');
                tab.classList.add('text-gray-700', 'hover:bg-gray-100');


            });

            // Add active classes to clicked tab
            tabElement.classList.remove('text-gray-700', 'hover:bg-gray-100');
            tabElement.classList.add('bg-primary', 'text-white', 'shadow-md');

            // Make icon white in active tab
            const activeIcon = tabElement.querySelector('i');
            if (activeIcon) {
                activeIcon.classList.remove('text-secondary');
                activeIcon.classList.add('text-white');
            }

            // Store active tab in localStorage
            const activeTab = tabElement.getAttribute('data-tab');
            localStorage.setItem('activeSidebarTab', activeTab);
        }

        // Get current page path
        const currentPath = window.location.pathname;

        // Define page-to-tab mapping
        const pageToTabMap = {
            'admindashboard.php': 'dashboard',
            'videostable.php': 'research-videos',
            'addcategoryform.php': 'add-category',
            'categorytable.php': 'categories', // ✅ Fixed: separate mapping for categories
            'uploadvideoform.php': 'upload-videos',
            'uploadresearchdetailform.php': 'upload-research-detail',
            'researchdetailtable.php': 'research-detail',
            'analytics.php': 'analytics',
            'research-teams.php': 'research-teams',
            'settings.php': 'settings'
        };

        // Get current page filename
        const currentPage = currentPath.split('/').pop();

        let activeTabValue;

        // First priority: current page mapping
        if (pageToTabMap[currentPage]) {
            activeTabValue = pageToTabMap[currentPage];
        }
        // Second priority: localStorage (if user clicked a tab)
        else if (localStorage.getItem('activeSidebarTab')) {
            activeTabValue = localStorage.getItem('activeSidebarTab');
        }
        // Default: dashboard
        else {
            activeTabValue = 'dashboard';
        }

        // Set active tab based on determined value
        const activeTabElement = document.querySelector(`[data-tab="${activeTabValue}"]`);
        if (activeTabElement) {
            setActiveTab(activeTabElement);
        }

        // Add click event listeners to all tabs
        allTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                // Update active state immediately
                setActiveTab(this);
            });
        });

        // Handle tab navigation with Enter key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && document.activeElement.closest('#sidebarNav a')) {
                const focusedTab = document.activeElement;
                setActiveTab(focusedTab);
            }
        });
    });

    // Optional: Clear active tab when user navigates away from admin section
    window.addEventListener('beforeunload', function() {
        const currentPath = window.location.pathname;
        // If user is leaving admin section, clear the active tab
        if (!currentPath.includes('PHP/') && !currentPath.includes('admin')) {
            localStorage.removeItem('activeSidebarTab');
        }
    });
    </script>
</body>

</html>