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

    <title>Dashboard Sidebar</title>
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body>
    <aside class="flex flex-col h-screen w-64 bg-white border-r border-gray-200 sticky top-0 overflow-hidden">
        
        <!-- Fixed Header: Logo -->
        <div class="p-6 border-b border-gray-50 bg-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 flex-shrink-0">
                    <i class="fas fa-microscope text-white text-lg"></i>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-xl font-bold text-primary truncate">Research</h1>
                    <p class="text-[10px] font-bold text-secondary tracking-widest uppercase">Academia</p>
                </div>
            </div>
        </div>

        <!-- Scrollable Navigation Area -->
        <div class="flex-1 overflow-y-auto px-4 py-6 no-scrollbar">
            
            <nav class="space-y-1.5" id="sidebarNav">
                <!-- Links mapping -->
                <a href="admindashboard.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="dashboard">
                    <i class="fas fa-home w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>

            

                <a href="addcategoryform.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="add-category">
                    <i class="fas fa-folder-plus w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Add Category</span>
                </a>

                <a href="categorytable.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="categories">
                    <i class="fas fa-th-list w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Categories</span>
                </a>

              

                <a href="uploadvideoform.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="upload-videos">
                    <i class="fas fa-video w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Upload Videos</span>
                </a>

                <a href="videostable.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="research-videos">
                    <i class="fas fa-play-circle w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Research Videos</span>
                </a>


                <a href="Add_team_members.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="add-team-member">
                    <i class="fas fa-user-plus w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Add Member</span>
                </a>

                <a href="team_members_table.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="team-members">
                    <i class="fas fa-users w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Team Members</span>
                </a>

                <a href="contact_messages.php"
                    class="flex items-center p-3 rounded-xl text-gray-700 hover:bg-gray-100 transition-all duration-200"
                    data-tab="contact-messages">
                    <i class="fas fa-envelope w-5 text-center mr-3"></i>
                    <span class="text-sm font-medium">Contact Messages</span>
                    <?php
                    // Show unread badge if there are unread messages
                    if (!isset($conn)) {
                        $conn_path = dirname(__DIR__) . '/db_connection/connection.php';
                        if (file_exists($conn_path)) include_once $conn_path;
                    }
                    if (isset($conn)) {
                        $unread_q = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM contact_messages WHERE status = 'unread'");
                        if ($unread_q) {
                            $unread_d = mysqli_fetch_assoc($unread_q);
                            if ($unread_d['cnt'] > 0) {
                                echo '<span class="ml-auto bg-red-500 text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">' . $unread_d['cnt'] . '</span>';
                            }
                        }
                    }
                    ?>
                </a>
            </nav>
        </div>

        <!-- Fixed Footer: User Profile -->
        <div class="p-4 mt-auto">
            <div class="relative group">
                <button type="button" id="adminBtn"
                    class="w-full flex items-center gap-3 p-3 bg-gray-50/50 border border-transparent rounded-2xl hover:bg-white hover:border-primary/10 hover:shadow-xl hover:shadow-primary/5 transition-all duration-300">
                    
                    <!-- Avatar with online indicator -->
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white shadow-lg shadow-primary/20">
                            <i class="fas fa-user-shield text-sm"></i>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>

                    <div class="text-left flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate leading-none mb-1">Super Admin</p>
                        <p class="text-[10px] font-medium text-gray-500 truncate uppercase tracking-wider">Research Academia</p>
                    </div>

                    <div class="w-7 h-7 flex items-center justify-center rounded-lg bg-white shadow-sm border border-gray-100 group-hover:border-primary/20 transition-colors">
                        <i class="fas fa-chevron-up text-[10px] text-gray-400 group-hover:text-primary transition-colors"></i>
                    </div>
                </button>

                <!-- Admin Dropdown -->
                <div id="adminMenu"
                    class="hidden absolute bottom-full left-0 right-0 mb-3 bg-white/95 backdrop-blur-md border border-gray-200/50 rounded-2xl shadow-2xl z-[999] overflow-hidden">
                    <div class="p-2">
                        <div class="px-4 py-2 mb-1 border-b border-gray-50">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Account</p>
                        </div>
                        <a href="../logout.php?admin=1"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200 group/item">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center group-hover/item:bg-red-100 transition-colors">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <span class="font-bold">Sign Out</span>
                        </a>
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
            'categorytable.php': 'categories',
            'uploadvideoform.php': 'upload-videos',
            'uploadresearchdetailform.php': 'upload-research-detail',
            'researchdetailtable.php': 'research-detail',
            'analytics.php': 'analytics',
            'research-teams.php': 'research-teams',
            'settings.php': 'settings',
            'Add_team_members.php': 'add-team-member',
            'team_members_table.php': 'team-members',
            'contact_messages.php': 'contact-messages'
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
        if (!currentPath.includes('') && !currentPath.includes('admin')) {
            localStorage.removeItem('activeSidebarTab');
        }
    });

    // Admin button dropdown functionality
    document.addEventListener("DOMContentLoaded", function() {
        const adminBtn = document.getElementById("adminBtn");
        const adminMenu = document.getElementById("adminMenu");

        if (adminBtn && adminMenu) {
            adminBtn.addEventListener("click", function(e) {
                e.stopPropagation();
                adminMenu.classList.toggle("hidden");
            });

            document.addEventListener("click", function() {
                adminMenu.classList.add("hidden");
            });
        }
    });
    </script>
</body>

</html>