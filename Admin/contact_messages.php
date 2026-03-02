<?php
// Admin/contact_messages.php
// Shows all contact form submissions in a clean table

session_start();

// Simple admin protection – redirect if not logged in
if (!isset($_SESSION['super_admin_id'])) {
    header('Location: superadminlogin.php');
    exit();
}

// Connect to database
include '../db_connection/connection.php';

// -------------------------------------------------------
// Handle "Mark as Read" action
// -------------------------------------------------------
if (isset($_GET['mark_read']) && is_numeric($_GET['mark_read'])) {
    $msg_id = intval($_GET['mark_read']);
    $sql    = "UPDATE contact_messages SET status = 'read' WHERE id = $msg_id";
    mysqli_query($conn, $sql);
    header('Location: contact_messages.php?status=marked');
    exit();
}

// -------------------------------------------------------
// Handle "Delete" action
// -------------------------------------------------------
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $msg_id = intval($_GET['delete']);
    $sql    = "DELETE FROM contact_messages WHERE id = $msg_id";
    mysqli_query($conn, $sql);
    header('Location: contact_messages.php?status=deleted');
    exit();
}

// -------------------------------------------------------
// Fetch all messages (newest first)
// -------------------------------------------------------
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

if ($filter == 'unread') {
    $sql = "SELECT * FROM contact_messages WHERE status = 'unread' ORDER BY created_at DESC";
} elseif ($filter == 'read') {
    $sql = "SELECT * FROM contact_messages WHERE status = 'read' ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
}

$result   = mysqli_query($conn, $sql);
$messages = [];
while ($row = mysqli_fetch_assoc($result)) {
    $messages[] = $row;
}

// Count unread for the badge
$unread_result = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM contact_messages WHERE status = 'unread'");
$unread_row    = mysqli_fetch_assoc($unread_result);
$unread_count  = $unread_row['cnt'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Messages | Admin</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'Outfit', sans-serif;
    }
    </style>
</head>

<body class="bg-gray-50">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <?php include 'dashboardsidebar.php'; ?>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-8">

            <!-- Page Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Contact Messages</h1>
                    <p class="text-gray-500 mt-1">Messages submitted through the contact form</p>
                </div>
                <div class="flex items-center gap-3">
                    <?php include 'notification_bar.php'; ?>
                    <?php if ($unread_count > 0): ?>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl font-semibold text-sm">
                        <i class="fas fa-envelope text-red-500"></i>
                        <?php echo $unread_count; ?> Unread
                    </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Status Toast -->
            <?php if (isset($_GET['status'])): ?>
            <div class="mb-6 px-5 py-3 rounded-xl border font-medium text-sm flex items-center gap-3
                <?php echo $_GET['status'] == 'deleted' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-green-50 border-green-200 text-green-700'; ?>">
                <i class="fas <?php echo $_GET['status'] == 'deleted' ? 'fa-trash' : 'fa-check-circle'; ?>"></i>
                <?php echo $_GET['status'] == 'deleted' ? 'Message deleted successfully.' : 'Message marked as read.'; ?>
            </div>
            <?php endif; ?>

            <!-- Filter Tabs -->
            <div class="flex gap-3 mb-6">
                <a href="contact_messages.php"
                    class="px-5 py-2 rounded-xl text-sm font-semibold transition-all <?php echo $filter == 'all' ? 'bg-primary text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'; ?>">
                    All Messages
                </a>
                <a href="contact_messages.php?filter=unread"
                    class="px-5 py-2 rounded-xl text-sm font-semibold transition-all <?php echo $filter == 'unread' ? 'bg-primary text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'; ?>">
                    Unread
                </a>
                <a href="contact_messages.php?filter=read"
                    class="px-5 py-2 rounded-xl text-sm font-semibold transition-all <?php echo $filter == 'read' ? 'bg-primary text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'; ?>">
                    Read
                </a>
            </div>

            <!-- Messages Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <?php if (empty($messages)): ?>
                <div class="py-24 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-inbox text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-700">No messages yet</h3>
                    <p class="text-gray-400 mt-1 text-sm">When visitors submit the contact form, messages will appear here.</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Department</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Subject</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <?php foreach ($messages as $msg): ?>
                            <tr class="hover:bg-gray-50 transition <?php echo $msg['status'] == 'unread' ? 'bg-blue-50/40' : ''; ?>">

                                <!-- Status Badge -->
                                <td class="px-6 py-4">
                                    <?php if ($msg['status'] == 'unread'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>Unread
                                    </span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>Read
                                    </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($msg['name']); ?>
                                    <?php if (!empty($msg['phone'])): ?>
                                    <div class="text-xs text-gray-400 font-normal mt-0.5">
                                        <i class="fas fa-phone mr-1"></i><?php echo htmlspecialchars($msg['phone']); ?>
                                    </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Email -->
                                <td class="px-6 py-4 text-gray-600">
                                    <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>"
                                        class="hover:text-primary transition">
                                        <?php echo htmlspecialchars($msg['email']); ?>
                                    </a>
                                </td>

                                <!-- Department -->
                                <td class="px-6 py-4">
                                    <?php if (!empty($msg['department'])): ?>
                                    <span class="px-2.5 py-1 bg-purple-50 text-purple-700 rounded-lg text-xs font-medium capitalize">
                                        <?php echo htmlspecialchars($msg['department']); ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="text-gray-400 text-xs">—</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Subject + Message Preview -->
                                <td class="px-6 py-4 max-w-xs">
                                    <div class="font-medium text-gray-800"><?php echo htmlspecialchars($msg['subject']); ?></div>
                                    <div class="text-xs text-gray-400 mt-0.5 truncate"><?php echo htmlspecialchars(substr($msg['message'], 0, 80)) . (strlen($msg['message']) > 80 ? '...' : ''); ?></div>
                                </td>

                                <!-- Date -->
                                <td class="px-6 py-4 text-gray-500 text-xs whitespace-nowrap">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    <?php echo date('d M Y', strtotime($msg['created_at'])); ?>
                                    <div class="mt-0.5">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo date('h:i A', strtotime($msg['created_at'])); ?>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <!-- View Full Message Button -->
                                        <button
                                            onclick="openModal('<?php echo addslashes(htmlspecialchars($msg['name'])); ?>', '<?php echo addslashes(htmlspecialchars($msg['email'])); ?>', '<?php echo addslashes(htmlspecialchars($msg['phone'] ?? '')); ?>', '<?php echo addslashes(htmlspecialchars($msg['department'] ?? '')); ?>', '<?php echo addslashes(htmlspecialchars($msg['subject'])); ?>', '<?php echo addslashes(htmlspecialchars($msg['message'])); ?>', '<?php echo date('d M Y h:i A', strtotime($msg['created_at'])); ?>')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary/10 text-primary hover:bg-primary hover:text-white transition"
                                            title="View Full Message">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>

                                        <!-- Mark as Read -->
                                        <?php if ($msg['status'] == 'unread'): ?>
                                        <a href="contact_messages.php?mark_read=<?php echo $msg['id']; ?>&filter=<?php echo $filter; ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-green-50 text-green-600 hover:bg-green-500 hover:text-white transition"
                                            title="Mark as Read">
                                            <i class="fas fa-check text-xs"></i>
                                        </a>
                                        <?php endif; ?>

                                        <!-- Delete -->
                                        <a href="contact_messages.php?delete=<?php echo $msg['id']; ?>&filter=<?php echo $filter; ?>"
                                            onclick="return confirm('Are you sure you want to delete this message? This cannot be undone.')"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition"
                                            title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Footer count -->
                <div class="px-6 py-4 border-t border-gray-100 text-sm text-gray-500">
                    Showing <strong><?php echo count($messages); ?></strong> message(s)
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Full Message Modal -->
    <div id="messageModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col overflow-hidden"
            style="max-height: 500px;">

            <!-- Modal Header (sticky) -->
            <div class="flex items-center justify-between px-6 py-4 bg-gradient-to-r from-primary to-blue-700 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-envelope text-white text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-white leading-none">Message Details</h2>
                        <p class="text-blue-200 text-xs mt-0.5">Full contact submission</p>
                    </div>
                </div>
                <button onclick="closeModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-xl bg-white/20 hover:bg-white/30 text-white transition">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Modal Body (scrollable) -->
            <div class="flex-1 overflow-y-auto px-6 py-4 space-y-3">

                <!-- Row 1: Name + Date -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">
                            <i class="fas fa-user mr-1"></i>From
                        </p>
                        <p class="font-semibold text-gray-800 text-sm leading-tight" id="modal-name"></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">
                            <i class="fas fa-calendar-alt mr-1"></i>Date
                        </p>
                        <p class="font-semibold text-gray-800 text-sm leading-tight" id="modal-date"></p>
                    </div>
                </div>

                <!-- Row 2: Email -->
                <div class="bg-gray-50 rounded-xl px-3 py-2.5 border border-gray-100">
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">
                        <i class="fas fa-envelope mr-1"></i>Email
                    </p>
                    <p class="font-semibold text-primary text-sm" id="modal-email"></p>
                </div>

                <!-- Row 3: Phone + Department -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">
                            <i class="fas fa-phone mr-1"></i>Phone
                        </p>
                        <p class="font-semibold text-gray-800 text-sm" id="modal-phone"></p>
                    </div>
                    <div class="bg-gray-50 rounded-xl px-3 py-2.5 border border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider mb-1">
                            <i class="fas fa-building mr-1"></i>Department
                        </p>
                        <p class="font-semibold text-gray-800 text-sm capitalize" id="modal-department"></p>
                    </div>
                </div>

                <!-- Row 4: Subject -->
                <div class="bg-blue-50 rounded-xl px-3 py-2.5 border border-blue-100">
                    <p class="text-[10px] text-blue-400 uppercase font-bold tracking-wider mb-1">
                        <i class="fas fa-tag mr-1"></i>Subject
                    </p>
                    <p class="font-bold text-gray-900 text-sm" id="modal-subject"></p>
                </div>

                <!-- Row 5: Message -->
                <div class="rounded-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 px-3 py-2 border-b border-gray-100">
                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">
                            <i class="fas fa-comment-alt mr-1"></i>Message
                        </p>
                    </div>
                    <div class="px-3 py-3 bg-white">
                        <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap" id="modal-message"></p>
                    </div>
                </div>

            </div>

            <!-- Modal Footer (sticky) -->
            <div class="flex gap-2 px-6 py-3 border-t border-gray-100 bg-gray-50/80 flex-shrink-0">
                <a id="modal-reply-btn" href="#" target="_blank" rel="noopener noreferrer"
                    class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 text-white rounded-xl font-semibold text-sm hover:bg-red-600 transition">
                    <i class="fab fa-google"></i>Reply via Gmail
                </a>
                <button onclick="closeModal()"
                    class="px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl font-semibold text-sm hover:bg-gray-100 transition">
                    Close
                </button>
            </div>

        </div>
    </div>

    <script>
    function openModal(name, email, phone, department, subject, message, date) {
        document.getElementById('modal-name').textContent       = name;
        document.getElementById('modal-email').textContent      = email;
        document.getElementById('modal-phone').textContent      = phone || '—';
        document.getElementById('modal-department').textContent = department || '—';
        document.getElementById('modal-subject').textContent    = subject;
        document.getElementById('modal-message').textContent    = message;
        document.getElementById('modal-date').textContent       = date;
        // Build Gmail compose URL - opens Gmail in a new tab with pre-filled fields
        var gmailBody = 'Dear ' + name + ',' + '%0A%0A' +
                        'Thank you for reaching out to us regarding: ' + encodeURIComponent(subject) + '%0A%0A' +
                        'We have received your message and wanted to follow up.%0A%0A' +
                        'Best regards,%0AResearch Academia Team';

        var gmailUrl = 'https://mail.google.com/mail/?view=cm' +
                       '&to='  + encodeURIComponent(email) +
                       '&su='  + encodeURIComponent('Re: ' + subject) +
                       '&body=' + gmailBody;

        document.getElementById('modal-reply-btn').href = gmailUrl;
        document.getElementById('messageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('messageModal').classList.add('hidden');
    }

    // Close modal if clicking the dark overlay
    document.getElementById('messageModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    </script>

</body>

</html>
