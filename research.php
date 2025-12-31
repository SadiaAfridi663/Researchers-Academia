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
                        <!-- Thumbnail with Play Button & Dark Overlay -->
                        <div
                            class="relative h-48 w-full flex items-center justify-center bg-gray-500 overflow-hidden rounded-t-xl shadow-sm hover:shadow-lg transition-shadow duration-300">
                            <?php
    $thumbUrl = '';
    if (!empty($video['thumbnail'])) {
        $thumbFile = __DIR__ . '/images/thumbnails/' . $video['thumbnail'];
        if (file_exists($thumbFile)) {
            $thumbUrl = 'images/thumbnails/' . $video['thumbnail'];
        }
    }
    ?>

                            <?php if ($thumbUrl): ?>
                            <a href="<?php echo htmlspecialchars($video['video_url']); ?>" target="_blank"
                                class="relative w-full h-full block group">
                                <img src="<?php echo htmlspecialchars($thumbUrl); ?>"
                                    alt="<?php echo htmlspecialchars($video['title']); ?>"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />

                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent opacity-70 group-hover:opacity-80 transition-opacity duration-300">
                                </div>

                                <!-- Professional Play Button -->
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="relative group-hover:scale-110 transition-transform duration-300">
                                        <div
                                            class="absolute inset-0 bg-white/20 rounded-full blur-md group-hover:blur-lg transition-all duration-300">
                                        </div>
                                        <div
                                            class="relative w-16 h-16 bg-white rounded-full shadow-2xl flex items-center justify-center transform group-hover:shadow-3xl transition-all duration-300">
                                            <div
                                                class="absolute inset-0 rounded-full bg-gradient-to-br from-white to-gray-100">
                                            </div>
                                            <div class="relative flex items-center justify-center ml-1">
                                                <i class="fa-solid fa-play text-2xl" style="color: #f52e2e;"></i>
                                            </div>
                                            <div
                                                class="absolute inset-0 rounded-full border-2 border-white/30 animate-ping opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <?php else: ?>
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                <div class="text-center">
                                    <i class="fas fa-video text-gray-400 text-3xl mb-2"></i>
                                    <span class="text-gray-500 font-medium block">No Thumbnail</span>
                                </div>
                            </div>
                            <?php endif; ?>
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

                            <!-- Leaders -->
                            <p class="text-gray-600 mb-4 text-sm">
                                <?php echo htmlspecialchars($video['research_leader']); ?>
                                <?php if(!empty($video['co_leader'])): ?>
                                , <?php echo htmlspecialchars($video['co_leader']); ?>
                                <?php endif; ?>
                            </p>

                            <!-- Description -->
                            <p class="text-gray-700 mb-5 text-sm line-clamp-3">
                                <?php echo htmlspecialchars($video['description']); ?>
                            </p>

                            <!-- Footer -->
                            <div class="flex justify-between items-center">
                                <div class="flex items-center space-x-3">
                                    <!-- <a href="researchDetail.php?id=<?php echo $video['id']; ?>"
                                        class="text-primary font-medium flex items-center text-sm hover:text-blue-800 transition">
                                        Read Abstract
                                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                                    </a> -->
                                </div>
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
                class="hidden fixed inset-y-0 right-0 w-80 bg-white transition-all  duration-300 ease-in-out lg:relative lg:w-1/3 z-50 lg:z-20 lg:z-0 overflow-y-auto">
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
                                    value="0" />
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
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter"
                                    value="0" />
                                <span class="ml-2 text-gray-600">Select a category first</span>
                            </label>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterToggle = document.getElementById("filterToggle");
        const closeFilter = document.getElementById("closeFilter");
        const filterSidebar = document.getElementById("filterSidebar");
        const researchGrid = document.getElementById("researchGrid");
        const researchCards = document.getElementById("researchCards");
        const overlay = document.getElementById("overlay");
        const applyFiltersBtn = document.getElementById("applyFiltersBtn");
        const clearFiltersBtn = document.getElementById("clearFiltersBtn");

        // Start hidden at right side
        filterSidebar.classList.add("translate-x-full");

        // Open filter
        filterToggle.addEventListener("click", function() {
            filterSidebar.classList.remove("hidden");
            overlay.classList.remove("hidden"); // show overlay
            setTimeout(() => {
                filterSidebar.classList.remove("translate-x-full");
                filterSidebar.classList.add("translate-x-0");
            }, 10);

            if (window.innerWidth >= 1024) {
                researchGrid.classList.remove("w-full");
                researchGrid.classList.add("lg:w-2/3");
                researchCards.classList.remove("lg:grid-cols-3");
                researchCards.classList.add("lg:grid-cols-2");
            } else {
                // Disable scroll on mobile/tablet
                document.body.style.overflow = "hidden";
            }
        });

        // Close filter
        function closeSidebar() {
            filterSidebar.classList.remove("translate-x-0");
            filterSidebar.classList.add("translate-x-full");
            overlay.classList.add("hidden"); // hide overlay

            setTimeout(() => {
                filterSidebar.classList.add("hidden");
            }, 300);

            if (window.innerWidth >= 1024) {
                researchGrid.classList.remove("lg:w-2/3");
                researchGrid.classList.add("w-full");
                researchCards.classList.remove("lg:grid-cols-2");
                researchCards.classList.add("lg:grid-cols-3");
            } else {
                // Re-enable scroll on mobile/tablet
                document.body.style.overflow = "auto";
            }
        }

        closeFilter.addEventListener("click", closeSidebar);
        overlay.addEventListener("click", closeSidebar); // close when clicking outside

        // ===== DYNAMIC FILTER FUNCTIONALITY =====

        // Handle category selection
        const categoryFilters = document.querySelectorAll('.category-filter');
        categoryFilters.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const selectedCategoryId = this.value;

                // Uncheck other categories (single selection)
                categoryFilters.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                    }
                });

                // Load subcategories for selected category
                loadSubcategories(selectedCategoryId);
            });
        });

        // Function to load subcategories dynamically
        function loadSubcategories(categoryId) {
            const subCategoryList = document.getElementById('subCategoryList');

            if (categoryId === '0' || categoryId === 0) {
                // Show "select a category first" message
                subCategoryList.innerHTML = `
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="0" disabled />
                        <span class="ml-2 text-gray-600">Select a category first</span>
                    </label>
                `;
                return;
            }

            // Fetch subcategories from server
            fetch(`PHP/get_filter_subcategories.php?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        let html = `
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="0" />
                                <span class="ml-2">All Sub Categories</span>
                            </label>
                        `;

                        data.data.forEach(subcat => {
                            html += `
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="${subcat.id}" />
                                    <span class="ml-2">${subcat.name}</span>
                                </label>
                            `;
                        });

                        subCategoryList.innerHTML = html;

                        // Attach event listeners to new subcategory checkboxes
                        attachSubcategoryListeners();
                    } else {
                        subCategoryList.innerHTML = `
                            <label class="flex items-center">
                                <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="0" disabled />
                                <span class="ml-2 text-gray-600">No sub categories available</span>
                            </label>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading subcategories:', error);
                    subCategoryList.innerHTML = `
                        <label class="flex items-center">
                            <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="0" disabled />
                            <span class="ml-2 text-gray-600">Error loading sub categories</span>
                        </label>
                    `;
                });
        }



        // Function to attach listeners to subcategory filters
        function attachSubcategoryListeners() {
            const subcategoryFilters = document.querySelectorAll('.subcategory-filter');
            subcategoryFilters.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.value === '0') {
                        // "All Sub Categories" option
                        subcategoryFilters.forEach(cb => {
                            if (cb !== this) {
                                cb.checked = false;
                            }
                        });
                    } else {
                        // Uncheck "All Sub Categories" if a specific one is selected
                        const allSubcatCheckbox = document.querySelector(
                            '.subcategory-filter[value="0"]');
                        if (allSubcatCheckbox) {
                            allSubcatCheckbox.checked = false;
                        }
                    }
                });
            });
        }

        // Apply filters button
        applyFiltersBtn.addEventListener('click', function() {
            const selectedCategory = document.querySelector('.category-filter:checked');
            const selectedSubcategory = document.querySelector('.subcategory-filter:checked');

            let url = 'research.php';
            const params = new URLSearchParams();

            if (selectedCategory && selectedCategory.value !== '0') {
                params.append('category_id', selectedCategory.value);
            }

            if (selectedSubcategory && selectedSubcategory.value !== '0') {
                params.append('sub_category_id', selectedSubcategory.value);
            }

            // Build URL with parameters
            if (params.toString()) {
                url += '?' + params.toString();
            }

            // Navigate to filtered page
            window.location.href = url;
        });

        // Clear filters button
        clearFiltersBtn.addEventListener('click', function() {
            // Uncheck all filters
            document.querySelectorAll('.category-filter').forEach(cb => cb.checked = false);
            document.querySelectorAll('.subcategory-filter').forEach(cb => cb.checked = false);

            // Reset subcategories list
            document.getElementById('subCategoryList').innerHTML = `
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox text-primary rounded subcategory-filter" value="0" disabled />
                    <span class="ml-2 text-gray-600">Select a category first</span>
                </label>
            `;

            // Navigate to research page without filters
            window.location.href = 'research.php';
        });

        // Load subcategories on page load if category is already selected
        const urlParams = new URLSearchParams(window.location.search);
        const categoryIdFromUrl = urlParams.get('category_id');
        if (categoryIdFromUrl) {
            loadSubcategories(categoryIdFromUrl);
        }
    });
    </script>
</body>

</html>