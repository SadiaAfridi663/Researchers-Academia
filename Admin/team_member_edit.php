<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header('location: index.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = 'Invalid request.';
    header('location: team_members_table.php');
    exit;
}

include '../db_connection/connection.php';
include '../db_connection/team_config.php';

$id     = (int)$_GET['id'];
$query  = mysqli_query($conn, "SELECT * FROM team_members WHERE id = $id");

if (!$query || mysqli_num_rows($query) === 0) {
    $_SESSION['error'] = 'Team member not found.';
    header('location: team_members_table.php');
    exit;
}

$m = mysqli_fetch_assoc($query); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team Member | Research Academia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { primary: '#103182', secondary: '#4fc5c1' } } }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-size: 0.95rem;
            background: #fff;
        }
        .form-input:focus { border-color: #103182; box-shadow: 0 0 0 3px rgba(16,49,130,0.1); }
        .form-label { display: block; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem; font-size: 0.9rem; }
        .section-divider { border: none; border-top: 2px dashed #e5e7eb; margin: 1.5rem 0; }
        .image-preview-box { width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid #103182; }
        .upload-zone { border: 2px dashed #103182; border-radius: 1rem; padding: 1.25rem; text-align: center; background: #f8faff; cursor: pointer; }
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

<body class="bg-gray-50 min-h-screen flex">
    <?php include 'dashboardsidebar.php'; ?>
    <main class="flex-1 min-w-0 overflow-y-auto p-6 md:p-8">
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-primary mb-1"><i class="fas fa-user-edit mr-2"></i> Edit Member</h1>
                <p class="text-gray-500 text-sm">Update profile details for <strong><?php echo htmlspecialchars($m['name']); ?></strong></p>
            </div>
            <div class="flex items-center gap-3">
                <?php include 'notification_bar.php'; ?>
                <a href="team_members_table.php" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition"><i class="fas fa-arrow-left mr-2"></i> Back</a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-blue-700 p-6">
                <h2 class="text-xl font-bold text-white"><i class="fas fa-id-card mr-2"></i> Member details</h2>
            </div>

            <form method="POST" action="team_member_update.php" enctype="multipart/form-data" class="p-6 md:p-8 space-y-8">
                <input type="hidden" name="id" value="<?php echo $m['id']; ?>">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" required class="form-input" value="<?php echo htmlspecialchars($m['name']); ?>">
                    </div>
                    <div>
                        <label class="form-label">Member Type *</label>
                        <div class="relative">
                            <select name="type" id="memberType" required class="form-input appearance-none pr-10 bg-white cursor-pointer" onchange="handleTypeChange(this.value)">
                                <option value="leader" <?php echo $m['type'] === 'leader' ? 'selected' : ''; ?>>&#128081; Leader</option>
                                <option value="team_member" <?php echo $m['type'] === 'team_member' ? 'selected' : ''; ?>>&#128100; Team Member</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Sub-Type (dynamic) -->
                    <div>
                        <div class="sub-type-wrapper" id="subTypeWrapper">
                            <label class="form-label">
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
                    <div class="md:col-span-2">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-input resize-none"><?php echo htmlspecialchars($m['description']); ?></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">Quote</label>
                        <input type="text" name="quote" class="form-input" value="<?php echo htmlspecialchars($m['quote']); ?>">
                    </div>
                </div>

                <hr class="section-divider">

                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img id="imagePreview" src="../<?php echo htmlspecialchars($m['image']); ?>" class="image-preview-box" onerror="this.src='https://ui-avatars.com/api/?name=User&background=103182&color=fff'">
                    <div class="flex-1 w-full">
                        <label class="form-label">Change Photo (Optional)</label>
                        <div class="upload-zone" onclick="document.getElementById('imageInput').click()">
                            <i class="fas fa-cloud-upload-alt text-primary text-2xl mb-2"></i>
                            <p class="text-gray-600 font-medium">Click to change</p>
                            <input type="file" id="imageInput" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </div>
                    </div>
                </div>

                <hr class="section-divider">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><label class="form-label">Skill 1</label><input type="text" name="skill_1" class="form-input" value="<?php echo htmlspecialchars($m['skill_1']); ?>"></div>
                    <div><label class="form-label">Skill 2</label><input type="text" name="skill_2" class="form-input" value="<?php echo htmlspecialchars($m['skill_2']); ?>"></div>
                    <div><label class="form-label">Skill 3</label><input type="text" name="skill_3" class="form-input" value="<?php echo htmlspecialchars($m['skill_3']); ?>"></div>
                </div>

                <hr class="section-divider">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div><label class="form-label">Twitter</label><input type="url" name="twitter" class="form-input" value="<?php echo htmlspecialchars($m['twitter']); ?>"></div>
                    <div><label class="form-label">LinkedIn</label><input type="url" name="linkedin" class="form-input" value="<?php echo htmlspecialchars($m['linkedin']); ?>"></div>
                    <div><label class="form-label">GitHub</label><input type="url" name="github" class="form-input" value="<?php echo htmlspecialchars($m['github']); ?>"></div>
                </div>

                <div class="pt-6 flex justify-end gap-3">
                    <a href="team_members_table.php" class="px-6 py-3 border border-gray-300 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit" name="update" class="px-8 py-3 bg-primary text-white font-bold rounded-xl hover:bg-blue-800 transition shadow-md">Update Member</button>
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
        select.innerHTML = '<option value="" disabled>-- Select Category --</option>';
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

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('imagePreview').src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-initialize sub-type if editing existing member
    const savedType    = '<?php echo addslashes($m["type"]); ?>';
    const savedSubType = '<?php echo addslashes($m["sub_type"] ?? ""); ?>';
    if (savedType) {
        handleTypeChange(savedType, savedSubType);
    }
    </script>
</body>
</html>
