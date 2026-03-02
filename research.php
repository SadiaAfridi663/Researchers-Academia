<?php
include 'db_connection/connection.php';

// Get selected main category ID from URL
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$sub_category_id = isset($_GET['sub_category_id']) ? intval($_GET['sub_category_id']) : 0;

$query = "SELECT v.*, c.name AS main_category_name, s.name AS sub_category_name
          FROM research_videos v
          LEFT JOIN add_categories c ON v.category_id = c.id
          LEFT JOIN sub_categories s ON v.sub_category_id = s.id";

// Build WHERE clause based on filters
$where_conditions = [];

if($category_id > 0){
    $where_conditions[] = "v.category_id = $category_id";
}

if($sub_category_id > 0){
    $where_conditions[] = "v.sub_category_id = $sub_category_id";
}

// Add WHERE clause if conditions exist
if(!empty($where_conditions)){
    $query .= " WHERE " . implode(" AND ", $where_conditions);
}

$query .= " ORDER BY v.created_at DESC";

$result = mysqli_query($conn, $query);

// Get all categories for sidebar
$categories_query = "SELECT id, name FROM add_categories ORDER BY name ASC";
$categories_result = mysqli_query($conn, $categories_query);
$categories = [];
while($cat = mysqli_fetch_assoc($categories_result)){
    $categories[] = $cat;
}

// Get subcategories for selected category if category_id is set
$subcategories = [];
if($category_id > 0){
    $subcategories_query = "SELECT id, name FROM sub_categories WHERE main_category_id = $category_id ORDER BY name ASC";
    $subcategories_result = mysqli_query($conn, $subcategories_query);
    while($subcat = mysqli_fetch_assoc($subcategories_result)){
        $subcategories[] = $subcat;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Google Fonts: Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <title>Research</title>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: "#103182",
                    secondary: "#4fc5c1",
                },
            },
        },
    };
    </script>

    <style>
    /* Apply Outfit as the default font */

    body {
        font-family: "Outfit", sans-serif;

    }

    /* Default lines */
    #menu-btn span {
        background-color: #333;
        /* dark for white bg */
    }

    /* Open (Cross) state */
    #menu-btn.open #line1 {
        transform: rotate(45deg) translate(5px, 5px);
    }

    #menu-btn.open #line2 {
        opacity: 0;
    }

    #menu-btn.open #line3 {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    /* Video container responsive */
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
    }

    .video-container iframe,
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    /* Smooth transition for filter sidebar */
    .filter-sidebar-transition {
        transition: all 0.3s ease-in-out;
    }
    </style>
</head>

<body>
    <!-- Header -->
    <!-- header -->
    <?php include 'include/navbar.php'; ?>

    <!-- header end -->



    <!-- Hero section -->
    <section style="
        background-image: linear-gradient(
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.4)
          ),
          url('./images/research-page-hero-image.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
      " class="text-white py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Research Library</h1>
            <p class="text-xl max-w-3xl mx-auto">
                Explore our comprehensive collection of research papers, case studies,
                and publications across multiple disciplines
            </p>

            <!-- Search Bar -->
            <div class="max-w-xl mx-auto mt-10">
                <div class="relative">
                    <input type="text" placeholder="Search research papers, topics, or authors..."
                        class="w-full py-4 px-6 rounded-lg text-gray-800 focus:outline-none focus:ring focus:ring-primary" />
                    <button
                        class="absolute right-2 top-2 bg-blue-800 text-white p-2 rounded-md hover:bg-blue-700 transition">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-12 py-8">
        <!-- Filter Toggle Button -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-primary">Latest Research Papers</h2>
            <button id="filterToggle" class="bg-primary text-white px-4 py-2 rounded-md flex items-center">
                <i class="fas fa-sliders-h mr-2"></i> Filters
            </button>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <div id="researchGrid" class="w-full transition-all duration-300 ease-in-out">
                <div id="researchCards"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 transition-all duration-300 ease-in-out">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                    <?php while($video = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                        <!-- Video Container -->
                        <div
                            class="video-container rounded-t-xl shadow-sm hover:shadow-lg transition-shadow duration-300">
                            <?php
                            $video_url = htmlspecialchars($video['video_url']);
                            
                            // Check if it's a YouTube URL
                            if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false) {
                                // Extract YouTube video ID
                                $video_id = '';
                                if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                }
                                
                                if ($video_id) {
                                    echo '<iframe src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                                } else {
                                    echo '<div class="w-full h-full flex items-center justify-center bg-gray-800">
                                            <div class="text-center">
                                                <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                                                <span class="text-gray-300 font-medium block">Invalid Video URL</span>
                                            </div>
                                        </div>';
                                }
                            } 
                            // Check if it's a Vimeo URL
                            elseif (strpos($video_url, 'vimeo.com') !== false) {
                                // Extract Vimeo video ID
                                $video_id = '';
                                if (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                                    $video_id = $matches[1];
                                }
                                
                                if ($video_id) {
                                    echo '<iframe src="https://player.vimeo.com/video/' . $video_id . '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
                                } else {
                                    echo '<div class="w-full h-full flex items-center justify-center bg-gray-800">
                                            <div class="text-center">
                                                <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                                                <span class="text-gray-300 font-medium block">Invalid Video URL</span>
                                            </div>
                                        </div>';
                                }
                            }
                            // Check if it's a direct video file
                            elseif (preg_match('/\.(mp4|webm|ogg|mov|avi)$/i', $video_url)) {
                                echo '<video controls class="w-full h-full">
                                        <source src="' . $video_url . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                      </video>';
                            }
                            // Default fallback
                            else {
                                echo '<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                        <div class="text-center">
                                            <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                                            <span class="text-gray-500 font-medium block">Video Not Available</span>
                                        </div>
                                    </div>';
                            }
                            ?>
                        </div>

                        <div class="p-6 mt-3">
                            <!-- Category Badge -->
                            <div class="flex space-x-2 mb-3">
                                <span class="bg-primary/20 text-primary text-xs px-3 py-1 rounded-full">
                                    <?php echo htmlspecialchars($video['main_category_name']); ?>
                                </span>
                                <?php if(!empty($video['sub_category_name'])): ?>
                                <a href="research.php?category_id=<?php echo intval($video['category_id']); ?>&sub_category_id=<?php echo intval($video['sub_category_id']); ?>"
                                    class="bg-gray-200 text-gray-800 text-xs px-3 py-1 rounded-full inline-block hover:bg-gray-300 transition">
                                    <?php echo htmlspecialchars($video['sub_category_name']); ?>
                                </a>
                                <?php endif; ?>
                            </div>

                            <!-- Video Title -->
                            <h3 class="text-xl font-semibold mb-2">
                                <?php echo htmlspecialchars($video['title']); ?>
                            </h3>

                            <!-- Description -->
                            <p class="text-gray-700 mb-5 text-sm line-clamp-3">
                                <?php echo htmlspecialchars($video['description']); ?>
                            </p>

                            <!-- Footer -->
                            <div class="flex justify-between items-center">
                                <a href="researchDetail.php?id=<?php echo $video['id']; ?>"
                                    class="text-primary font-medium flex items-center text-sm hover:text-blue-800 transition">
                                    Read Abstract
                                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                </a>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    <?php echo date('M Y', strtotime($video['created_at'])); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <p class="col-span-3 text-center text-gray-500">No videos found.</p>
                    <?php endif; ?>
                </div>

                <!-- Load More Button -->
                <div class="text-center mt-12">
                    <button
                        class="bg-white text-primary border border-primary px-8 py-3 rounded-md font-semibold hover:bg-primary hover:text-white transition">
                        Load More Research
                    </button>
                </div>
            </div>


            <!-- Sidebar Filters - Hidden by default -->
            <aside id="filterSidebar"
                class="hidden fixed inset-y-0 right-0 w-80 bg-white transition-all duration-300 ease-in-out lg:relative lg:w-1/3 z-50 lg:z-20 lg:z-0 overflow-y-auto">
                <div class="bg-white p-6 lg:py-0 lg:px-6 rounded-lg h-full lg:sticky lg:top-24">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-primary">Filter Research</h2>
                        <button id="closeFilter" class="text-gray-500 hover:text-primary">
                            <i class="fas fa-angle-right text-primary text-xl"></i>
                        </button>
                    </div>

                    <!-- Main Categories -->
                    <div class="mb-6">
                        <h3 class="font-semibold mb-3 text-primary">Categories</h3>
                        <div class="space-y-2 flex flex-col">
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded category-filter"
                                    value="0" <?php echo ($category_id == 0) ? 'checked' : ''; ?> />
                                <span class="ml-2">All Categories</span>
                            </label>
                            <?php foreach($categories as $cat): ?>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded category-filter"
                                    value="<?php echo htmlspecialchars($cat['id']); ?>"
                                    <?php echo ($category_id == $cat['id']) ? 'checked' : ''; ?> />
                                <span class="ml-2"><?php echo htmlspecialchars($cat['name']); ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Sub Categories -->
                    <div class="mb-6" id="subCategoryFilterSection">
                        <h3 class="font-semibold mb-3 text-primary">Sub Categories</h3>
                        <div class="space-y-2 flex flex-col" id="subCategoryList">
                            <?php if($category_id > 0 && !empty($subcategories)): ?>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter"
                                    value="0" <?php echo ($sub_category_id == 0) ? 'checked' : ''; ?> />
                                <span class="ml-2">All Sub Categories</span>
                            </label>
                            <?php foreach($subcategories as $subcat): ?>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter"
                                    value="<?php echo htmlspecialchars($subcat['id']); ?>"
                                    <?php echo ($sub_category_id == $subcat['id']) ? 'checked' : ''; ?> />
                                <span class="ml-2"><?php echo htmlspecialchars($subcat['name']); ?></span>
                            </label>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter"
                                    value="0" disabled />
                                <span class="ml-2 text-gray-600">Select a category first</span>
                            </label>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <button class="w-full bg-primary mb-6 text-white py-2 rounded-md hover:bg-[#0d2a6d] transition"
                        id="applyFiltersBtn">
                        Apply Filters
                    </button>

                    <!-- Clear Filters Button -->
                    <button
                        class="w-full border border-primary text-primary py-2 rounded-md hover:bg-primary hover:text-white transition"
                        id="clearFiltersBtn">
                        Clear All Filters
                    </button>
                </div>
            </aside>

            <!-- Overlay -->
            <div id="overlay" class="hidden fixed inset-0 bg-black bg-opacity-70 z-40 lg:z-20 lg:hidden"></div>
        </div>
    </main>

    <!-- Newsletter Section -->
    <section style="
        background-image: linear-gradient(
            rgba(0, 0, 0, 0.5),
            rgba(0, 0, 0, 0.4)
          ),
          url('./images/research-page-hero-image.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
      " class="py-16 text-white">
        <div class="max-w-5xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Stay Updated with Latest Research
            </h2>
            <p class="text-xl mb-8">
                Subscribe to our newsletter for weekly research highlights and updates
            </p>

            <div class="max-w-md mx-auto flex flex-col sm:flex-row gap-4">
                <input type="email" placeholder="Your email address"
                    class="flex-grow py-3 px-4 rounded-lg text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button class="bg-white text-blue-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Subscribe
                </button>
            </div>

            <p class="text-sm text-blue-200 mt-4">
                We respect your privacy. Unsubscribe at any time.
            </p>
        </div>
    </section>



    <!-- Footer -->
    <?php include 'include/footer.php';?>



    <script src="./script.js"></script>



    <!-- filter -->
    <<script>
        document.addEventListener("DOMContentLoaded", function() {
        const filterToggle = document.getElementById("filterToggle");
        const closeFilter = document.getElementById("closeFilter");
        const filterSidebar = document.getElementById("filterSidebar");
        const researchGrid = document.getElementById("researchGrid");
        const researchCards = document.getElementById("researchCards");
        const overlay = document.getElementById("overlay");
        const applyFiltersBtn = document.getElementById("applyFiltersBtn");
        const clearFiltersBtn = document.getElementById("clearFiltersBtn");

        filterSidebar.classList.add("translate-x-full");

        filterToggle.addEventListener("click", function() {
        filterSidebar.classList.remove("hidden");
        overlay.classList.remove("hidden");
        setTimeout(() => {
        filterSidebar.classList.remove("translate-x-full");
        }, 10);
        });

        function closeSidebar() {
        filterSidebar.classList.add("translate-x-full");
        overlay.classList.add("hidden");
        setTimeout(() => {
        filterSidebar.classList.add("hidden");
        }, 300);
        }

        closeFilter.addEventListener("click", closeSidebar);
        overlay.addEventListener("click", closeSidebar);

        const categoryFilters = document.querySelectorAll('.category-filter');

        categoryFilters.forEach(cb => {
        cb.addEventListener('change', function () {
        categoryFilters.forEach(x => x.checked = false);
        this.checked = true;
        loadSubcategories(this.value);
        });
        });

        function loadSubcategories(categoryId) {
        const subCategoryList = document.getElementById('subCategoryList');

        if (categoryId === '0') {
        subCategoryList.innerHTML = `
        <label class="flex items-center">
            <input type="checkbox" disabled />
            <span class="ml-2 text-gray-600">Select a category first</span>
        </label>`;
        return;
        }

        fetch(`get_filter_subcategories.php?category_id=${categoryId}`)
        .then(res => res.json())
        .then(data => {
        let html = `
        <label class="flex items-center">
            <input type="checkbox" class="subcategory-filter" value="0" />
            <span class="ml-2">All Sub Categories</span>
        </label>`;
        data.data.forEach(sub => {
        html += `
        <label class="flex items-center">
            <input type="checkbox" class="subcategory-filter" value="${sub.id}" />
            <span class="ml-2">${sub.name}</span>
        </label>`;
        });
        subCategoryList.innerHTML = html;
        attachSubcategoryListeners();
        });
        }

        function attachSubcategoryListeners() {
        document.querySelectorAll('.subcategory-filter').forEach(cb => {
        cb.addEventListener('change', function () {
        document.querySelectorAll('.subcategory-filter').forEach(x => {
        if (x !== this) x.checked = false;
        });
        });
        });
        }

        applyFiltersBtn.addEventListener('click', function() {
        const c = document.querySelector('.category-filter:checked');
        const s = document.querySelector('.subcategory-filter:checked');
        let url = 'research.php';
        const p = new URLSearchParams();
        if (c && c.value !== '0') p.append('category_id', c.value);
        if (s && s.value !== '0') p.append('sub_category_id', s.value);
        if (p.toString()) url += '?' + p.toString();
        window.location.href = url;
        });

        clearFiltersBtn.addEventListener('click', function() {
        window.location.href = 'research.php';
        });

        /* 🔥 THIS WAS MISSING — FIX */
        attachSubcategoryListeners();

        });
        </script>

</body>

</html>