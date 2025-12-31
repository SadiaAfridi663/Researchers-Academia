<?php
// Start session
session_start();

// Include database connection
include '../db_connection/connection.php';

// Get all categories for the dropdown
$categoriesQuery = "SELECT id, name FROM add_categories ORDER BY name ASC";
$categoriesResult = mysqli_query($conn, $categoriesQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Research Detail | Research Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    :root {
        --primary: #103182;
        --secondary: #4fc5c1;
    }

    body {
        font-family: 'Outfit', sans-serif;
    }

    .card-shadow {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

    <div class="flex">
        <!-- Sidebar Navigation -->
        <?php include '../include/dashboardsidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Page Header -->
            <div class="mb-8">
                <a href="admindashboard.php" class="text-primary hover:text-blue-700 mb-4 inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-file-alt text-primary mr-3"></i>Add Research Detail
                </h1>
                <p class="text-gray-600">Create a new research detail document</p>
            </div>

            <!-- Form Container -->
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-2xl card-shadow border border-gray-100 p-8">
                    <!-- Form -->
                    <form method="POST" action="uploadresearchdetail_process.php" enctype="multipart/form-data"
                        class="space-y-8">

                        <!-- Section 1: Category & Sub Category -->
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                                <i class="fas fa-sitemap text-primary mr-2"></i>Category Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Category Dropdown -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="category_id" id="categorySelect"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                        required>
                                        <option value="">-- Select Category --</option>
                                        <?php
                                        while ($category = mysqli_fetch_assoc($categoriesResult)) {
                                            echo '<option value="' . htmlspecialchars($category['id']) . '">' . htmlspecialchars($category['name']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Sub Category Dropdown -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Sub Category <span class="text-red-500">*</span>
                                    </label>
                                    <select name="sub_category_id" id="subCategorySelect"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition disabled:bg-gray-100 disabled:cursor-not-allowed"
                                        required disabled>
                                        <option value="">-- Select Sub Category --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Basic Information -->
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                                <i class="fas fa-info-circle text-primary mr-2"></i>Basic Information
                            </h2>

                            <!-- Title -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" placeholder="Enter research detail title"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                    required>
                            </div>

                            <!-- Published Date & Pages -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Published Date
                                    </label>
                                    <input type="date" name="published_date"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                                        Pages
                                    </label>
                                    <input type="number" name="pages" placeholder="Total pages"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Content -->
                        <div class="border-b border-gray-200 pb-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                                <i class="fas fa-pen-fancy text-primary mr-2"></i>Content
                            </h2>

                            <!-- Abstract -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Abstract
                                </label>
                                <textarea name="abstract" rows="4" placeholder="Enter research abstract..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                            </div>

                            <!-- Introduction -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Introduction
                                </label>
                                <textarea name="introduction" rows="4" placeholder="Enter introduction..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                            </div>

                            <!-- Methodology -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Methodology
                                </label>
                                <textarea name="methodology" rows="4" placeholder="Enter methodology..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                            </div>

                            <!-- Conclusion -->
                            <div class="mb-6">
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Conclusion
                                </label>
                                <textarea name="conclusion" rows="4" placeholder="Enter conclusion..."
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"></textarea>
                            </div>
                        </div>

                        <!-- Section 4: PDF Upload -->
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 mb-6">
                                <i class="fas fa-file-pdf text-primary mr-2"></i>PDF File
                            </h2>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">
                                    Upload PDF File
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary transition cursor-pointer"
                                    id="dropZone">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-gray-600 font-medium">Drag and drop PDF here</p>
                                    <p class="text-gray-500 text-sm">or</p>
                                    <input type="file" name="pdf_file" id="pdfInput" accept=".pdf" class="hidden">
                                    <button type="button"
                                        class="mt-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-700 transition"
                                        onclick="document.getElementById('pdfInput').click()">
                                        Select PDF
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2" id="fileName"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 px-6 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-md hover:shadow-lg">
                                <i class="fas fa-save mr-2"></i> Save Research Detail
                            </button>
                            <a href="admindashboard.php"
                                class="flex-1 px-6 py-3 bg-gray-200 text-gray-800 font-semibold rounded-lg hover:bg-gray-300 transition-all duration-300 text-center">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Load subcategories when category changes
    document.getElementById('categorySelect').addEventListener('change', function() {
        const categoryId = this.value;
        const subCategorySelect = document.getElementById('subCategorySelect');

        if (categoryId) {
            // Fetch subcategories via AJAX
            fetch(`../PHP/get_subcategories.php?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
                    data.forEach(subcat => {
                        const option = document.createElement('option');
                        option.value = subcat.id;
                        option.textContent = subcat.name;
                        subCategorySelect.appendChild(option);
                    });
                    subCategorySelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    subCategorySelect.disabled = true;
                });
        } else {
            subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            subCategorySelect.disabled = true;
        }
    });

    // PDF file handling
    const dropZone = document.getElementById('dropZone');
    const pdfInput = document.getElementById('pdfInput');
    const fileName = document.getElementById('fileName');

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-primary', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-blue-50');
        pdfInput.files = e.dataTransfer.files;
        updateFileName();
    });

    pdfInput.addEventListener('change', updateFileName);

    function updateFileName() {
        if (pdfInput.files.length > 0) {
            const file = pdfInput.files[0];
            if (file.type === 'application/pdf') {
                fileName.textContent = '✓ ' + file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
                fileName.classList.add('text-green-600');
            } else {
                fileName.textContent = '✗ Please select a PDF file';
                fileName.classList.add('text-red-600');
                pdfInput.value = '';
            }
        }
    }
    </script>

</body>

</html>