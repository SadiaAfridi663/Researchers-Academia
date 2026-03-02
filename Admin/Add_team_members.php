<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header('location:index.php');
    exit;
}

include '../db_connection/connection.php';
include '../db_connection/team_config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team Member | Research Academia</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }

        .image-preview-box {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #103182;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: 'Outfit', sans-serif;
            font-size: 0.95rem;
        }

        .form-input:focus {
            border-color: #103182;
            box-shadow: 0 0 0 3px rgba(16, 49, 130, 0.12);
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .section-divider {
            border: none;
            border-top: 2px dashed #e5e7eb;
            margin: 1.5rem 0;
        }

        .upload-zone {
            border: 2px dashed #103182;
            border-radius: 1rem;
            padding: 1.5rem;
            text-align: center;
            background: #f8faff;
            transition: background 0.2s;
            cursor: pointer;
        }

        .upload-zone:hover {
            background: #eef2ff;
        }

        /* Sub-type animated reveal */
        .sub-type-wrapper {
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-8px);
            transition: max-height 0.35s ease, opacity 0.3s ease, transform 0.3s ease;
        }
        .sub-type-wrapper.visible {
            max-height: 200px;
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen flex" style="font-family: 'Outfit', sans-serif;">

    <!-- Sidebar -->
    <?php include 'dashboardsidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-8">

        <!-- Page Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-1">
                    <i class="fas fa-user-plus mr-2"></i> Add Team Member
                </h1>
                <p class="text-gray-500 text-sm">Fill in the details to add a new member to your research team</p>
            </div>
            <div class="flex items-center gap-3">
                <?php include 'notification_bar.php'; ?>
                <a href="team_members_table.php"
                    class="inline-flex items-center px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition">
                    <i class="fas fa-list mr-2"></i> View All Members
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (isset($_SESSION['success'])): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-lg"></i>
            <span class="text-green-800 font-medium"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
        </div>
        <?php unset($_SESSION['success']); endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-lg"></i>
            <span class="text-red-800 font-medium"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
        </div>
        <?php unset($_SESSION['error']); endif; ?>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

            <!-- Card Header -->
            <div class="bg-gradient-to-r from-primary to-blue-700 p-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-id-card"></i> Member Information
                </h2>
                <p class="text-blue-200 text-sm mt-1">All fields marked with <span class="text-yellow-300 font-bold">*</span> are required</p>
            </div>

            <!-- Form -->
            <form id="addMemberForm" method="POST" action="team_members_process.php" enctype="multipart/form-data"
                class="p-6 md:p-8 space-y-8">

                <!-- === SECTION 1: Basic Info === -->
                <div>
                    <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Basic Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="form-label">
                                <i class="fas fa-user text-primary mr-1"></i> Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" required maxlength="150"
                                class="form-input" placeholder="e.g. Dr. Ahmed Khan">
                        </div>

                        <!-- Member Type -->
                        <div>
                            <label class="form-label">
                                <i class="fas fa-id-badge text-primary mr-1"></i> Member Type <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="type" id="memberType" required class="form-input appearance-none pr-10 bg-white cursor-pointer" onchange="handleTypeChange(this.value)">
                                    <option value="" disabled selected>-- Select Role --</option>
                                    <option value="leader">&#128081; Leader</option>
                                    <option value="team_member">&#128100; Team Member</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i>This determines how the member appears on the Team page.</p>
                        </div>

                        <!-- Sub-Type (dynamic) -->
                        <div>
                            <div class="sub-type-wrapper" id="subTypeWrapper">
                                <label class="form-label" id="subTypeLabel">
                                    <i class="fas fa-layer-group text-primary mr-1"></i> Role Category <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="sub_type" id="subTypeSelect" class="form-input appearance-none pr-10 bg-white cursor-pointer">
                                        <option value="" disabled selected>-- Select Category --</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                        <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-1" id="subTypeHint"></p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="form-label">
                                <i class="fas fa-align-left text-primary mr-1"></i> Short Description
                            </label>
                            <textarea name="description" rows="3"
                                class="form-input resize-none"
                                placeholder="Brief description about the team member..."></textarea>
                        </div>

                        <!-- Quote -->
                        <div class="md:col-span-2">
                            <label class="form-label">
                                <i class="fas fa-quote-left text-primary mr-1"></i> Inspiring Quote
                            </label>
                            <input type="text" name="quote" maxlength="500"
                                class="form-input" placeholder="e.g. Research is seeing what everybody else has seen...">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- === SECTION 2: Profile Image === -->
                <div>
                    <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-camera"></i> Profile Photo
                    </h3>
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-6">

                        <!-- Preview -->
                        <div class="flex-shrink-0 text-center">
                            <img id="imagePreview"
                                src="https://ui-avatars.com/api/?name=Team+Member&background=103182&color=fff&size=120"
                                alt="Preview" class="image-preview-box mx-auto">
                            <p class="text-xs text-gray-400 mt-2">Preview</p>
                        </div>

                        <!-- Upload Zone -->
                        <div class="flex-1 w-full">
                            <label class="form-label">
                                Profile Image <span class="text-red-500">*</span>
                            </label>
                            <div class="upload-zone" onclick="document.getElementById('imageInput').click()">
                                <i class="fas fa-cloud-upload-alt text-primary text-3xl mb-2"></i>
                                <p class="text-gray-600 font-medium">Click to upload image</p>
                                <p class="text-gray-400 text-xs mt-1">JPG, PNG, WEBP — Max 2MB</p>
                                <input type="file" id="imageInput" name="image" accept="image/*" required
                                    class="hidden" onchange="previewImage(this)">
                            </div>
                            <p class="text-xs text-gray-400 mt-2" id="fileName">No file selected</p>
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- === SECTION 3: Skills === -->
                <div>
                    <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-star"></i> Top Skills <span class="text-gray-400 text-xs font-normal ml-1">(optional)</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label">Skill 1</label>
                            <input type="text" name="skill_1" maxlength="100"
                                class="form-input" placeholder="e.g. Machine Learning">
                        </div>
                        <div>
                            <label class="form-label">Skill 2</label>
                            <input type="text" name="skill_2" maxlength="100"
                                class="form-input" placeholder="e.g. Data Analysis">
                        </div>
                        <div>
                            <label class="form-label">Skill 3</label>
                            <input type="text" name="skill_3" maxlength="100"
                                class="form-input" placeholder="e.g. Research Writing">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- === SECTION 4: Social Links === -->
                <div>
                    <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-share-alt"></i> Social Links <span class="text-gray-400 text-xs font-normal ml-1">(optional)</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        <!-- Twitter -->
                        <div>
                            <label class="form-label">
                                <i class="fab fa-twitter text-sky-500 mr-1"></i> Twitter / X URL
                            </label>
                            <input type="url" name="twitter"
                                class="form-input" placeholder="https://twitter.com/username">
                        </div>

                        <!-- LinkedIn -->
                        <div>
                            <label class="form-label">
                                <i class="fab fa-linkedin text-blue-700 mr-1"></i> LinkedIn URL
                            </label>
                            <input type="url" name="linkedin"
                                class="form-input" placeholder="https://linkedin.com/in/username">
                        </div>

                        <!-- GitHub -->
                        <div>
                            <label class="form-label">
                                <i class="fab fa-github text-gray-800 mr-1"></i> GitHub URL
                            </label>
                            <input type="url" name="github"
                                class="form-input" placeholder="https://github.com/username">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <!-- === SECTION 5: Status === -->
                <div>
                    <h3 class="text-base font-bold text-primary mb-4 flex items-center gap-2">
                        <i class="fas fa-toggle-on"></i> Visibility Status
                    </h3>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="1" checked class="accent-primary w-4 h-4">
                            <span class="text-gray-700 font-medium">
                                <i class="fas fa-eye text-green-500 mr-1"></i> Active (Visible)
                            </span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="0" class="accent-red-500 w-4 h-4">
                            <span class="text-gray-700 font-medium">
                                <i class="fas fa-eye-slash text-red-400 mr-1"></i> Inactive (Hidden)
                            </span>
                        </label>
                    </div>
                </div>

                <!-- === Form Actions === -->
                <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-end gap-3">
                    <button type="reset" onclick="resetPreview()"
                        class="px-6 py-3 border-2 border-gray-300 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset Form
                    </button>
                    <button type="submit" name="submit" value="1"
                        class="px-8 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg flex items-center gap-2">
                        <i class="fas fa-save"></i> Save Team Member
                    </button>
                </div>

            </form>
        </div>

    </main>

    <script>
    // ── Sub-type options per role ──────────────────────────────────────────────
    const subTypeOptions = <?php 
        $jsOptions = [];
        foreach ($roleGroups as $type => $keys) {
            $jsOptions[$type] = [];
            foreach ($keys as $key) {
                if (isset($subTypeLabels[$key])) {
                    $jsOptions[$type][] = ['value' => $key, 'label' => $subTypeLabels[$key]];
                }
            }
        }
        echo json_encode($jsOptions, JSON_UNESCAPED_UNICODE); 
    ?>;

    const subTypeHints = {
        leader:      '🏅 Select the specific leadership title for this member.',
        team_member: '👥 Select the role category that best describes this team member.',
    };

    function handleTypeChange(type, preSelected = '') {
        const wrapper = document.getElementById('subTypeWrapper');
        const select  = document.getElementById('subTypeSelect');
        const hint    = document.getElementById('subTypeHint');

        if (!subTypeOptions[type]) {
            wrapper.classList.remove('visible');
            select.required = false;
            return;
        }

        // Rebuild options
        select.innerHTML = '<option value="" disabled selected>-- Select Category --</option>';
        subTypeOptions[type].forEach(opt => {
            const o = document.createElement('option');
            o.value = opt.value;
            o.textContent = opt.label;
            if (opt.value === preSelected) o.selected = true;
            select.appendChild(o);
        });

        hint.textContent = subTypeHints[type] || '';
        select.required  = true;
        wrapper.classList.add('visible');
    }

    // Image preview function
    function previewImage(input) {
        const file = input.files[0];
        if (file) {
            document.getElementById('fileName').textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Reset preview back to placeholder
    function resetPreview() {
        document.getElementById('imagePreview').src = 'https://ui-avatars.com/api/?name=Team+Member&background=103182&color=fff&size=120';
        document.getElementById('fileName').textContent = 'No file selected';
        // Also hide sub-type
        document.getElementById('memberType').value = '';
        document.getElementById('subTypeWrapper').classList.remove('visible');
        document.getElementById('subTypeSelect').required = false;
    }

    // Client-side validation on submit
    document.getElementById('addMemberForm').addEventListener('submit', function(e) {
        const name       = this.querySelector('[name="name"]').value.trim();
        const type       = this.querySelector('[name="type"]').value;
        const image      = this.querySelector('[name="image"]').files.length;
        const subType    = document.getElementById('subTypeSelect');

        if (!name || !image) {
            e.preventDefault();
            alert('Please fill in all required fields: Name and Image.');
            return;
        }

        if (type && subType.required && !subType.value) {
            e.preventDefault();
            alert('Please select a Role Category for the selected member type.');
            subType.focus();
            return;
        }

        // File size check (2MB)
        const file = this.querySelector('[name="image"]').files[0];
        if (file && file.size > 2 * 1024 * 1024) {
            e.preventDefault();
            alert('Image file size must be less than 2MB.');
            return;
        }
    });
    </script>

</body>

</html>
