<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header('location: index.php');
    exit;
}

// Fetch all team members from DB, newest first
include '../db_connection/connection.php';
include '../db_connection/team_config.php';

$query  = "SELECT * FROM team_members ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('Database error: ' . mysqli_error($conn));
}

// Stats
$totalMembers  = mysqli_num_rows($result);
$activeQuery   = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM team_members WHERE status = 1");
$activeData    = mysqli_fetch_assoc($activeQuery);
$activeCount   = $activeData['cnt'];
$inactiveCount = $totalMembers - $activeCount;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Members | Research Academia</title>
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

        .card-shadow { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }

        .member-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #103182;
            flex-shrink: 0;
        }

        .table-row:hover { background-color: #f8fafc; }

        .truncate-cell {
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        html, body { overflow-x: hidden; }

        .table-wrapper {
            overflow-x: auto;
            overflow-y: visible;
            width: 100%;
        }
        .table-wrapper::-webkit-scrollbar { height: 6px; }
        .table-wrapper::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .table-wrapper::-webkit-scrollbar-thumb { background: #103182; border-radius: 4px; }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include 'dashboardsidebar.php'; ?>

        <!-- Main Content: min-w-0 prevents flex child from overflowing -->
        <main class="flex-1 min-w-0 overflow-y-auto overflow-x-hidden p-6 md:p-8">

            <!-- Flash Messages -->
            <?php if (isset($_SESSION['success'])): ?>
            <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-600"></i>
                <span class="text-green-800 font-medium"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            </div>
            <?php unset($_SESSION['success']); endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
            <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <span class="text-red-800 font-medium"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            </div>
            <?php unset($_SESSION['error']); endif; ?>

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">
                        <i class="fas fa-users text-primary mr-2"></i>Team Members
                    </h1>
                    <p class="text-gray-500 text-sm">Manage your research team members</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center gap-3">
                    <?php include 'notification_bar.php'; ?>
                    <a href="Add_team_members.php"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i> Add New Member
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

                <!-- Total -->
                <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i class="fas fa-users text-primary text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Members</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $totalMembers; ?></p>
                    </div>
                </div>

                <!-- Leaders -->
                <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center">
                        <i class="fas fa-crown text-yellow-500 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Leaders</p>
                        <p class="text-2xl font-bold text-gray-900"><?php
                            $lq = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM team_members WHERE type IN ('leader','co_leader')");
                            echo mysqli_fetch_assoc($lq)['cnt'];
                        ?></p>
                    </div>
                </div>

                <!-- Active -->
                <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Active (Visible)</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $activeCount; ?></p>
                    </div>
                </div>

                <!-- Inactive -->
                <div class="bg-white rounded-2xl card-shadow p-5 border border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center">
                        <i class="fas fa-eye-slash text-red-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Inactive (Hidden)</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $inactiveCount; ?></p>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-2xl card-shadow border border-gray-100 overflow-hidden">

                <!-- Table Header + Search -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">All Team Members</h3>
                        <p class="text-gray-400 text-xs mt-0.5">Click on a row to see full details</p>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Search by name or role category..."
                            class="pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none w-full md:w-72 transition">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-wrapper">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Member</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role Category</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Skills</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Social</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Added</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="memberTableBody">

                            <?php if ($totalMembers > 0):
                                $counter = 1;
                                // Reset result pointer
                                mysqli_data_seek($result, 0);
                                while ($member = mysqli_fetch_assoc($result)):
                            ?>
                            <tr class="table-row transition duration-150 cursor-pointer">

                                <!-- Counter -->
                                <td class="px-4 py-3">
                                    <span class="w-7 h-7 rounded-lg bg-primary flex items-center justify-center text-white text-xs font-bold">
                                        <?php echo $counter++; ?>
                                    </span>
                                </td>

                                <!-- Member -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="../<?php echo htmlspecialchars($member['image']); ?>"
                                            alt="<?php echo htmlspecialchars($member['name']); ?>"
                                            class="member-avatar"
                                            onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($member['name']); ?>&background=103182&color=fff&size=44'">
                                        <div>
                                            <p class="font-semibold text-gray-900 truncate-cell"><?php echo htmlspecialchars($member['name']); ?></p>
                                            <?php if (!empty($member['description'])): ?>
                                            <p class="text-xs text-gray-400 truncate-cell"><?php echo htmlspecialchars(substr($member['description'], 0, 60)) . (strlen($member['description']) > 60 ? '...' : ''); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Role Category -->
                                <td class="px-4 py-3">
                                    <span class="text-gray-700 font-medium whitespace-nowrap block">
                                        <?php 
                                            $st = $member['sub_type'] ?? '';
                                            $label = getSubTypeLabel($st);
                                            echo !empty($label) ? $label : '<span class="text-gray-300 italic">Not set</span>'; 
                                        ?>
                                    </span>
                                </td>

                                <!-- Member Type Badge -->
                                <td class="px-4 py-3">
                                    <?php
                                    $typeMap = [
                                         'leader'      => ['label' => 'Leader',      'class' => 'bg-yellow-100 text-yellow-700 border-yellow-200'],
                                         'co_leader'   => ['label' => 'Co-Leader',   'class' => 'bg-purple-100 text-purple-700 border-purple-200'],
                                         'team_member' => ['label' => 'Team Member',  'class' => 'bg-blue-100 text-blue-700 border-blue-200'],
                                         'advisor'     => ['label' => 'Advisor',      'class' => 'bg-teal-100 text-teal-700 border-teal-200'],
                                     ];
                                    $t = $member['type'] ?? 'team_member';
                                    $badge = $typeMap[$t] ?? ['label' => ucfirst($t), 'class' => 'bg-gray-100 text-gray-600 border-gray-200'];
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border <?php echo $badge['class']; ?> whitespace-nowrap">
                                        <?php echo $badge['label']; ?>
                                    </span>
                                </td>

                                <!-- Skills -->
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        <?php
                                        $skills = array_filter([$member['skill_1'], $member['skill_2'], $member['skill_3']]);
                                        if (!empty($skills)):
                                            foreach ($skills as $skill):
                                        ?>
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-50 text-primary border border-blue-100">
                                            <?php echo htmlspecialchars($skill); ?>
                                        </span>
                                        <?php endforeach; else: ?>
                                        <span class="text-gray-300 text-xs italic">—</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Social Links -->
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <?php if (!empty($member['twitter'])): ?>
                                        <a href="<?php echo htmlspecialchars($member['twitter']); ?>" target="_blank"
                                            class="w-7 h-7 rounded-full bg-sky-100 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition text-xs"
                                            title="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if (!empty($member['linkedin'])): ?>
                                        <a href="<?php echo htmlspecialchars($member['linkedin']); ?>" target="_blank"
                                            class="w-7 h-7 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center hover:bg-blue-700 hover:text-white transition text-xs"
                                            title="LinkedIn">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if (!empty($member['github'])): ?>
                                        <a href="<?php echo htmlspecialchars($member['github']); ?>" target="_blank"
                                            class="w-7 h-7 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center hover:bg-gray-800 hover:text-white transition text-xs"
                                            title="GitHub">
                                            <i class="fab fa-github"></i>
                                        </a>
                                        <?php endif; ?>
                                        <?php if (empty($member['twitter']) && empty($member['linkedin']) && empty($member['github'])): ?>
                                        <span class="text-gray-300 text-xs italic">—</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    <?php if ($member['status'] == 1): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Active
                                    </span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400 mr-1.5"></span> Inactive
                                    </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Date Added -->
                                <td class="px-4 py-3 text-gray-500">
                                    <p class="text-xs"><?php echo date('M d, Y', strtotime($member['created_at'])); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo date('h:i A', strtotime($member['created_at'])); ?></p>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <!-- Edit Button -->
                                        <a href="team_member_edit.php?id=<?php echo $member['id']; ?>"
                                           class="inline-flex items-center px-3 py-1.5 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-xs font-medium"
                                           title="Edit Member">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <button onclick="confirmDelete(<?php echo $member['id']; ?>, '<?php echo htmlspecialchars(addslashes($member['name'])); ?>')"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-xs font-medium"
                                            title="Delete Member">
                                            <i class="fas fa-trash-alt mr-1"></i> Delete
                                        </button>
                                    </div>
                                </td>

                            </tr>
                            <?php endwhile; else: ?>
                            <!-- Empty State -->
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="mx-auto w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-gray-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-700 mb-1">No team members yet</h3>
                                    <p class="text-gray-400 text-sm mb-5">Start building your research team by adding the first member.</p>
                                    <a href="Add_team_members.php"
                                        class="inline-flex items-center px-6 py-2.5 bg-primary text-white font-semibold rounded-xl hover:bg-blue-700 transition">
                                        <i class="fas fa-plus mr-2"></i> Add First Member
                                    </a>
                                </td>
                            </tr>
                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>

                <!-- Table Footer -->
                <div class="px-6 py-3 border-t border-gray-100 bg-gray-50">
                    <p class="text-xs text-gray-500">
                        Showing <span class="font-semibold text-gray-700" id="visibleCount"><?php echo $totalMembers; ?></span>
                        of <span class="font-semibold"><?php echo $totalMembers; ?></span> members
                    </p>
                </div>

            </div>
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 animate-bounce-once">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 mx-auto mb-4">
                <i class="fas fa-trash-alt text-red-500 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">Delete Team Member</h3>
            <p class="text-gray-500 text-center text-sm mb-1">Are you sure you want to delete</p>
            <p class="text-gray-800 font-semibold text-center mb-5" id="deleteMemberName">—</p>
            <p class="text-xs text-red-400 text-center mb-6">This action cannot be undone. The profile image will also be deleted.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                    class="flex-1 py-2.5 border-2 border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition">
                    Cancel
                </button>
                <a id="confirmDeleteBtn" href="#"
                    class="flex-1 py-2.5 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition text-center">
                    Yes, Delete
                </a>
            </div>
        </div>
    </div>

    <script>
    // Search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchVal = this.value.toLowerCase();
        const rows = document.querySelectorAll('#memberTableBody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchVal)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('visibleCount').textContent = visibleCount;
    });

    // Delete modal
    function confirmDelete(id, name) {
        document.getElementById('deleteMemberName').textContent = name;
        document.getElementById('confirmDeleteBtn').href = 'team_member_delete.php?id=' + id;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Close modal on backdrop click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    </script>

</body>

</html>
