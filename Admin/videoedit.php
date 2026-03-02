<?php
include '../db_connection/connection.php';
session_start();

$video = null;
$edit_mode = false;

// Check if editing
if (isset($_GET['id'])) {
    $video_id = intval($_GET['id']);
    
    $query = "SELECT * FROM research_videos WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if ($stmt) {
        $stmt->bind_param('i', $video_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $video = $result->fetch_assoc();
            $edit_mode = true;
        } else {
            $_SESSION['error'] = 'Video not found!';
            header('Location: videostable.php');
            exit;
        }
        $stmt->close();
    }
}

if (!$edit_mode) {
    $_SESSION['error'] = 'No video selected for editing!';
    header('Location: videostable.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Research Video | Research Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar -->
    <?php include 'dashboardsidebar.php' ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-8">

        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-2">
                    <i class="fas fa-video text-primary mr-2"></i> Edit Research Video
                </h1>
                <p class="text-gray-600">Update video details and information</p>
            </div>
            <div class="flex items-center gap-3">
                <?php include 'notification_bar.php'; ?>
            </div>
        </div>

        <!-- Video Edit Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-gradient-to-r from-primary to-blue-700 p-6 md:p-8">
                <h2 class="text-2xl font-bold text-white">Update Video Details</h2>
                <p class="text-blue-200 mt-2">Modify the research video information</p>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="m-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                <span class="text-green-800"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="m-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <span class="text-red-800"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <!-- Form Content -->
            <form id="editForm" class="p-6 md:p-8 space-y-8" method="POST" action="videoupdate_process.php" enctype="multipart/form-data">

                <input type="hidden" name="video_id" value="<?php echo $video['id']; ?>">

                <!-- Video Title -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-heading text-primary mr-2"></i> Video Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required value="<?php echo htmlspecialchars($video['title']); ?>"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition text-lg placeholder-gray-400"
                        placeholder="Enter a compelling title for your research video">
                </div>

                <!-- Video Description -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-align-left text-primary mr-2"></i> Description <span
                            class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="4" required
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition resize-none placeholder-gray-400"
                        placeholder="Describe your research methodology, findings, and significance..."><?php echo htmlspecialchars($video['description']); ?></textarea>
                </div>

                <!-- Video URL -->
                <div class="space-y-4">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-link text-primary mr-2"></i> Video URL <span class="text-red-500">*</span>
                    </label>

                    <div class="space-y-3">
                        <input type="url" name="videoUrl" required value="<?php echo htmlspecialchars($video['video_url']); ?>"
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition placeholder-gray-400"
                            placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
                        <p class="text-gray-500 text-sm flex items-center">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Supported platforms: YouTube, Vimeo, Dailymotion, or direct video URL
                        </p>
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-tags text-primary mr-2"></i> Research Category <span
                            class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="categorySelect" name="category" required
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition appearance-none bg-white text-gray-800 text-lg cursor-pointer">
                            <option value="" disabled>Select a category</option>
                            <?php
                            $catQuery = "SELECT * FROM add_categories ORDER BY name ASC";
                            $catResult = mysqli_query($conn, $catQuery);
                            while($cat = mysqli_fetch_assoc($catResult)){
                                $selected = ($cat['id'] == $video['category_id']) ? 'selected' : '';
                                echo '<option value="'.htmlspecialchars($cat['id']).'" '.$selected.'>'.htmlspecialchars($cat['name']).'</option>';
                            }
                            ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Sub Category Dropdown -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-layer-group text-primary mr-2"></i> Research Sub Category <span
                            class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="subCategorySelect" name="sub_category" required
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition appearance-none bg-white text-gray-800 text-lg cursor-pointer">
                            <option value="">Select a sub category</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Research Leader -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-user-tie text-primary mr-2"></i> Research Leader
                    </label>
                    <input type="text" name="research_leader" maxlength="255" value="<?php echo htmlspecialchars($video['research_leader'] ?? ''); ?>"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition text-lg placeholder-gray-400"
                        placeholder="Lead researcher (optional)">
                </div>

                <!-- Co Leader -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-user-friends text-primary mr-2"></i> Co-Leader
                    </label>
                    <input type="text" name="co_leader" maxlength="255" value="<?php echo htmlspecialchars($video['co_leader'] ?? ''); ?>"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition text-lg placeholder-gray-400"
                        placeholder="Co-leader (optional)">
                </div>

                <!-- Current Thumbnail -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-image text-primary mr-2"></i> Current Thumbnail
                    </label>
                    <div>
                        <?php if (!empty($video['thumbnail'])): ?>
                            <img src="<?php echo '../images/thumbnails/' . htmlspecialchars($video['thumbnail']); ?>" alt="Thumbnail" class="w-36 h-20 object-cover rounded-md border">
                        <?php else: ?>
                            <div class="w-36 h-20 bg-gray-100 rounded-md flex items-center justify-center text-gray-400">No image</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Replace Thumbnail -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-upload text-primary mr-2"></i> Replace Thumbnail
                    </label>
                    <input type="file" name="thumbnail" accept="image/*"
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-primary file:text-white hover:file:cursor-pointer" />
                    <p class="text-gray-500 text-sm">Leave empty to keep current thumbnail. Allowed: jpg, png, webp, gif. Max 2MB.</p>
                </div>

                <!-- Form Actions -->
                <div class="pt-8 border-t border-gray-200 flex justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        All fields marked with <span class="text-red-500">*</span> are required
                    </div>

                    <div class="flex space-x-4">
                        <a href="videostable.php"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back
                        </a>
                        <button type="submit" name="submit" value="1"
                            class="px-8 py-3.5 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-save mr-2"></i> Update Video
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </main>

    <script>
    // Get subcategories when category changes
    const categorySelect = document.getElementById('categorySelect');
    const subCategorySelect = document.getElementById('subCategorySelect');
    const currentSubCategoryId = <?php echo $video['sub_category_id'] ?? 0; ?>;

    // Function to load subcategories
    function loadSubCategories(categoryId, selectSubCategoryId = null) {
        if (!categoryId) {
            subCategorySelect.innerHTML = '<option value="">Select a sub category</option>';
            subCategorySelect.disabled = true;
            return;
        }

        // Fetch subcategories
        fetch('get_subcategories.php?category_id=' + categoryId)
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML = '<option value="">Select a sub category</option>';
                
                if (data.length > 0) {
                    data.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
                        
                        // Select the current subcategory
                        if (selectSubCategoryId && subcat.id == selectSubCategoryId) {
                            option.selected = true;
                        }
                        
                        subCategorySelect.appendChild(option);
                    });
                    subCategorySelect.disabled = false;
                } else {
                    subCategorySelect.innerHTML = '<option value="">No sub categories available</option>';
                    subCategorySelect.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                subCategorySelect.innerHTML = '<option value="">Error loading sub categories</option>';
                subCategorySelect.disabled = true;
            });
    }

    // Load subcategories on page load and on category change
    categorySelect.addEventListener('change', function() {
        loadSubCategories(this.value);
    });

    // Load current subcategories on page load
    window.addEventListener('load', function() {
        loadSubCategories(categorySelect.value, currentSubCategoryId);
    });
    </script>

</body>

</html>
