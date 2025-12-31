<?php
include '../db_connection/connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Research Video | Research Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <?php session_start(); ?>
    <!-- Sidebar -->
    <?php include '../include/dashboardsidebar.php' ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-8">

        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-2">
                    <i class="fas fa-video text-primary mr-2"></i> Upload Research Video
                </h1>
                <p class="text-gray-600">Share your research findings through video content</p>
            </div>


        </div>

        <!-- Video Upload Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-gradient-to-r from-primary to-blue-700 p-6 md:p-8">
                <h2 class="text-2xl font-bold text-white">Video Details</h2>
                <p class="text-blue-200 mt-2">Enter your research video URL and details</p>
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
            <form id="uploadForm" class="p-6 md:p-8 space-y-8" method="POST" action="uploadvideo_process.php" enctype="multipart/form-data">

                <!-- Video Title -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-heading text-primary mr-2"></i> Video Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" required
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
                        placeholder="Describe your research methodology, findings, and significance..."></textarea>
                </div>

                <!-- Video URL -->
                <div class="space-y-4">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-link text-primary mr-2"></i> Video URL <span class="text-red-500">*</span>
                    </label>

                    <div class="space-y-3">
                        <input type="url" name="videoUrl" required
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition placeholder-gray-400"
                            placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
                        <p class="text-gray-500 text-sm flex items-center">
                            <i class="fas fa-info-circle text-primary mr-2"></i>
                            Supported platforms: YouTube, Vimeo, Dailymotion, or direct video URL
                        </p>
                    </div>

                    <!-- URL Preview (Optional) -->
                    <div id="urlPreview" class="hidden">
                        <div class="mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <h4 class="font-semibold text-gray-700 mb-2">
                                <i class="fas fa-eye mr-2"></i> URL Preview
                            </h4>
                            <p id="previewText" class="text-gray-600 text-sm"></p>
                        </div>
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
                            <option value="" disabled selected>Select a category</option>
                            <?php
                            $catQuery = "SELECT * FROM add_categories ORDER BY name ASC";
                            $catResult = mysqli_query($conn, $catQuery);
                            while($cat = mysqli_fetch_assoc($catResult)){
                                echo '<option value="'.htmlspecialchars($cat['id']).'">'.htmlspecialchars($cat['name']).'</option>';
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
                        <select id="subCategorySelect" name="sub_category" required disabled
                            class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition appearance-none bg-white text-gray-800 text-lg cursor-pointer disabled:bg-gray-100 disabled:text-gray-500">
                            <option value="" disabled selected>First select a category</option>
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
                    <input type="text" name="research_leader" maxlength="255"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition text-lg placeholder-gray-400"
                        placeholder="Lead researcher (optional)">
                </div>

                <!-- Co Leader -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-user-friends text-primary mr-2"></i> Co-Leader
                    </label>
                    <input type="text" name="co_leader" maxlength="255"
                        class="w-full px-5 py-4 border-2 border-gray-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary outline-none transition text-lg placeholder-gray-400"
                        placeholder="Co-leader (optional)">
                </div>

                <!-- Thumbnail -->
                <div class="space-y-3">
                    <label class="block text-gray-800 font-semibold text-lg">
                        <i class="fas fa-image text-primary mr-2"></i> Thumbnail <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="thumbnail" accept="image/*" required
                        class="w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:bg-primary file:text-white hover:file:cursor-pointer" />
                    <p class="text-gray-500 text-sm">Upload a small thumbnail image (jpg, png, webp, max 2MB)</p>
                </div>



                <!-- Form Actions -->
                <div class="pt-8 border-t border-gray-200 flex justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        <i class="fas fa-info-circle text-primary mr-2"></i>
                        All fields marked with <span class="text-red-500">*</span> are required
                    </div>

                    <div class="flex space-x-4">
                        <button type="reset"
                            class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition">
                            <i class="fas fa-redo mr-2"></i> Reset
                        </button>
                        <button type="submit" name="submit" value="1"
                            class="px-8 py-3.5 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg flex items-center">
                            <i class="fas fa-upload mr-2"></i> Upload Video
                        </button>
                    </div>
                </div>

            </form>
        </div>

        <!-- Help Card -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-question-circle text-primary mr-3"></i>
                How to Add Videos
            </h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div
                        class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                        <span class="text-primary font-bold">1</span>
                    </div>
                    <p class="text-gray-700">Copy the video URL from YouTube, Vimeo, or any video hosting platform</p>
                </div>
                <div class="flex items-start">
                    <div
                        class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                        <span class="text-primary font-bold">2</span>
                    </div>
                    <p class="text-gray-700">Paste the URL in the field above and fill in the video details</p>
                </div>
                <div class="flex items-start">
                    <div
                        class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center mr-3 mt-1 flex-shrink-0">
                        <span class="text-primary font-bold">3</span>
                    </div>
                    <p class="text-gray-700">Select the most relevant category for better organization and discovery</p>
                </div>
            </div>
        </div>

    </main>

    <script>
    // Get subcategories when category changes
    const categorySelect = document.getElementById('categorySelect');
    const subCategorySelect = document.getElementById('subCategorySelect');

    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;

        if (!categoryId) {
            subCategorySelect.disabled = true;
            subCategorySelect.innerHTML = '<option value="" disabled selected>First select a category</option>';
            return;
        }

        // Fetch subcategories for the selected category
        fetch('get_subcategories.php?category_id=' + categoryId)
            .then(response => response.json())
            .then(data => {
                subCategorySelect.innerHTML =
                    '<option value="" disabled selected>Select a sub category</option>';

                if (data.length > 0) {
                    data.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
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
    });

    // URL validation and preview
    const videoUrlInput = document.querySelector('input[name="videoUrl"]');
    const urlPreview = document.getElementById('urlPreview');
    const previewText = document.getElementById('previewText');

    videoUrlInput.addEventListener('blur', function() {
        const url = this.value.trim();

        if (!url) {
            urlPreview.classList.add('hidden');
            return;
        }

        // Show preview with URL type detection
        let platform = 'Unknown Platform';
        let color = 'text-gray-600';

        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            platform = 'YouTube';
            color = 'text-red-600';
        } else if (url.includes('vimeo.com')) {
            platform = 'Vimeo';
            color = 'text-blue-600';
        } else if (url.includes('dailymotion.com')) {
            platform = 'Dailymotion';
            color = 'text-blue-500';
        } else if (url.match(/\.(mp4|mov|avi|wmv|webm)$/i)) {
            platform = 'Direct Video File';
            color = 'text-green-600';
        }

        previewText.innerHTML =
            `<span class="font-medium ${color}">${platform}</span> URL detected: <span class="font-mono text-sm bg-gray-100 px-2 py-1 rounded">${url}</span>`;
        urlPreview.classList.remove('hidden');
    });

    // Quick Add Button
    document.getElementById('quickAddBtn').addEventListener('click', function() {
        // Fill with sample data for quick testing
        document.querySelector('input[name="title"]').value = 'Research Video: ' + new Date()
            .toLocaleDateString();
        document.querySelector('textarea[name="description"]').value =
            'This video presents our latest research findings...';
        document.querySelector('input[name="videoUrl"]').value = 'https://youtube.com/watch?v=example';
        document.querySelector('input[name="author"]').value = 'Dr. Research Scientist';
        document.querySelector('input[name="institution"]').value = 'University of Research';
        document.querySelector('select[name="publication_year"]').value = new Date().getFullYear();
        document.querySelector('input[name="duration"]').value = '15';

        // Trigger URL preview
        videoUrlInput.dispatchEvent(new Event('blur'));

        // Show success message
        alert('Sample data added! Please review and submit.');
    });

    // Form validation
    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        const url = videoUrlInput.value.trim();

        // Basic URL validation
        if (!isValidUrl(url)) {
            e.preventDefault();
            alert('Please enter a valid URL (e.g., https://youtube.com/watch?v=...)');
            videoUrlInput.focus();
            return;
        }

        // Check if URL is from supported platforms
        if (!url.includes('youtube.com') && !url.includes('youtu.be') &&
            !url.includes('vimeo.com') && !url.includes('dailymotion.com') &&
            !url.match(/\.(mp4|mov|avi|wmv|webm)$/i)) {
            if (!confirm('This URL might not be from a supported platform. Continue anyway?')) {
                e.preventDefault();
                return;
            }
        }
    });

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    </script>

</body>

</html>