<?php
session_start();

include '../db_connection/connection.php';

$detail_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($detail_id <= 0) {
    header('Location: researchdetailtable.php');
    exit();
}

// Fetch the research detail
$query = "SELECT * FROM research_detail WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $detail_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$detail = mysqli_fetch_assoc($result);

if (!$detail) {
    $_SESSION['error'] = 'Research detail not found!';
    header('Location: researchdetailtable.php');
    exit();
}

$categoriesQuery = "SELECT id, name FROM add_categories ORDER BY name ASC";
$categoriesResult = mysqli_query($conn, $categoriesQuery);

$subCategoriesQuery = "SELECT id, name FROM sub_categories WHERE category_id = ? ORDER BY name ASC";
$subStmt = mysqli_prepare($conn, $subCategoriesQuery);
mysqli_stmt_bind_param($subStmt, 'i', $detail['category_id']);
mysqli_stmt_execute($subStmt);
$subCategoriesResult = mysqli_stmt_get_result($subStmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Research Detail | Research Academia</title>
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

    .form-section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary);
        margin-top: 2rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--secondary);
        display: flex;
        align-items: center;
    }

    .form-section-title i {
        margin-right: 0.75rem;
    }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">

    <div class="flex">
        <?php include '../include/dashboardsidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-edit text-primary mr-3"></i>Edit Research Detail
                </h1>
                <p class="text-gray-600">Update the research detail information</p>
            </div>

            <!-- Error/Success Messages -->
            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center">
                <i class="fas fa-exclamation-circle text-red-600 mr-3"></i>
                <span class="text-red-800"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Form Container -->
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden max-w-4xl">

                <div class="bg-gradient-to-r from-primary to-blue-700 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white">
                        <?php echo htmlspecialchars($detail['title']); ?>
                    </h2>
                    <p class="text-blue-100 mt-2">Last updated:
                        <?php echo date('M d, Y \a\t h:i A', strtotime($detail['updated_at'])); ?></p>
                </div>

                <form action="researchdetailedit_process.php" method="POST" enctype="multipart/form-data" class="p-8">

                    <input type="hidden" name="detail_id" value="<?php echo $detail['id']; ?>">

                    <div class="form-section-title">
                        <i class="fas fa-folder-open"></i>Category & Sub-Category
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-bookmark text-secondary mr-2"></i>Category <span
                                    class="text-red-500">*</span>
                            </label>
                            <select id="categorySelect" name="category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                required>
                                <option value="">Select a category</option>
                                <?php 
                                while ($category = mysqli_fetch_assoc($categoriesResult)) {
                                    $selected = ($category['id'] == $detail['category_id']) ? 'selected' : '';
                                    echo '<option value="' . $category['id'] . '" ' . $selected . '>' . htmlspecialchars($category['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-tags text-secondary mr-2"></i>Sub-Category <span
                                    class="text-red-500">*</span>
                            </label>
                            <select id="subCategorySelect" name="sub_category_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                required>
                                <option value="">Select a sub-category</option>
                                <?php 
                                while ($subCategory = mysqli_fetch_assoc($subCategoriesResult)) {
                                    $selected = ($subCategory['id'] == $detail['sub_category_id']) ? 'selected' : '';
                                    echo '<option value="' . $subCategory['id'] . '" ' . $selected . '>' . htmlspecialchars($subCategory['name']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Section 2: Basic Information -->
                    <div class="form-section-title">
                        <i class="fas fa-pen-fancy"></i>Basic Information
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-heading text-secondary mr-2"></i>Research Title <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" placeholder="Enter research title"
                                value="<?php echo htmlspecialchars($detail['title']); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-calendar-alt text-secondary mr-2"></i>Published Date
                            </label>
                            <input type="date" name="published_date" value="<?php echo $detail['published_date']; ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition">
                        </div>

                        <!-- Pages -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-file-lines text-secondary mr-2"></i>Number of Pages
                            </label>
                            <input type="number" name="pages" placeholder="Enter number of pages"
                                value="<?php echo $detail['pages']; ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition"
                                min="1">
                        </div>
                    </div>

                    <div class="form-section-title">
                        <i class="fas fa-book"></i>Content Sections
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-lightbulb text-secondary mr-2"></i>Abstract
                        </label>
                        <textarea name="abstract" placeholder="Enter abstract" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition resize-none"><?php echo htmlspecialchars($detail['abstract']); ?></textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-lightbulb mr-1"></i>A brief summary of the research
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-arrow-right text-secondary mr-2"></i>Introduction
                        </label>
                        <textarea name="introduction" placeholder="Enter introduction" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition resize-none"><?php echo htmlspecialchars($detail['introduction']); ?></textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>Background and context
                        </p>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-flask text-secondary mr-2"></i>Methodology
                        </label>
                        <textarea name="methodology" placeholder="Enter methodology" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition resize-none"><?php echo htmlspecialchars($detail['methodology']); ?></textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-flask mr-1"></i>Research methods and approach
                        </p>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-check-circle text-secondary mr-2"></i>Conclusion
                        </label>
                        <textarea name="conclusion" placeholder="Enter conclusion" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition resize-none"><?php echo htmlspecialchars($detail['conclusion']); ?></textarea>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-check-circle mr-1"></i>Results and findings
                        </p>
                    </div>

                    <div class="form-section-title">
                        <i class="fas fa-file-pdf"></i>PDF Document
                    </div>

                    <div class="mb-8">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-cloud-upload-alt text-secondary mr-2"></i>Upload PDF (Optional)
                        </label>
                        <p class="text-xs text-gray-600 mb-4">
                            Current file: <span
                                class="font-semibold text-primary"><?php echo basename($detail['pdf_file']); ?></span>
                        </p>

                        <div id="dropZone"
                            class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center cursor-pointer hover:border-primary hover:bg-blue-50 transition duration-300"
                            ondrop="handleDrop(event)" ondragover="handleDragOver(event)"
                            ondragleave="handleDragLeave(event)">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4 block"></i>
                            <p class="text-gray-700 font-semibold">Drag and drop your PDF here</p>
                            <p class="text-gray-500 text-sm">or</p>
                            <button type="button" onclick="document.getElementById('pdfInput').click()"
                                class="text-primary font-semibold hover:underline mt-2">browse your files</button>
                            <p class="text-xs text-gray-500 mt-4">
                                <i class="fas fa-info-circle mr-1"></i>Maximum file size: 50MB | PDF only
                            </p>
                        </div>

                        <input type="file" id="pdfInput" name="pdf_file" accept=".pdf" style="display: none;">

                        <div id="filePreview" class="mt-4 hidden">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                                <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                <div>
                                    <p class="font-semibold text-green-900">New PDF selected</p>
                                    <p class="text-sm text-green-700 mt-1" id="fileName"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col md:flex-row gap-4 pt-8 border-t border-gray-200">
                        <button type="submit"
                            class="flex-1 py-3 px-6 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>Update Research Detail
                        </button>
                        <a href="researchdetailtable.php"
                            class="flex-1 py-3 px-6 bg-gray-100 text-gray-900 font-semibold rounded-lg hover:bg-gray-200 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>

                </form>
            </div>
        </main>
    </div>

    <script>
    // Category change handler
    document.getElementById('categorySelect').addEventListener('change', function() {
        const categoryId = this.value;

        if (!categoryId) {
            document.getElementById('subCategorySelect').innerHTML =
                '<option value="">Select a sub-category</option>';
            return;
        }

        fetch('../PHP/get_subcategories.php?category_id=' + categoryId)
            .then(response => response.json())
            .then(data => {
                let options = '<option value="">Select a sub-category</option>';

                data.forEach(sub => {
                    options +=
                        `<option value="${sub.id}">${sub.name}</option>`;
                });

                document.getElementById('subCategorySelect').innerHTML =
                    options;
            })
            .catch(error => console.error('Error:', error));
    });

    const dropZone = document.getElementById('dropZone');
    const pdfInput = document.getElementById('pdfInput');

    function handleDragOver(e) {
        e.preventDefault();
        dropZone.classList.add('border-primary', 'bg-blue-50');
    }

    function handleDragLeave(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-blue-50');
    }

    function handleDrop(e) {
        e.preventDefault();
        dropZone.classList.remove('border-primary', 'bg-blue-50');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            pdfInput.files = files;
            validateAndDisplayFile();
        }
    }

    // File input change handler
    pdfInput.addEventListener('change', validateAndDisplayFile);

    function validateAndDisplayFile() {
        const file = pdfInput.files[0];
        const filePreview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');

        if (!file) {
            filePreview.classList.add('hidden');
            return;
        }

        if (file.type !== 'application/pdf') {
            alert('Please upload a PDF file only');
            pdfInput.value = '';
            filePreview.classList.add('hidden');
            return;
        }

        if (file.size > 50 * 1024 * 1024) {
            alert('File size must not exceed 50MB');
            pdfInput.value = '';
            filePreview.classList.add('hidden');
            return;
        }

        fileName.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)`;
        filePreview.classList.remove('hidden');
    }
    </script>

</body>

</html>