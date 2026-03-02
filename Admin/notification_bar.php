<?php
// Admin/notification_bar.php
// Reusable notification bell for the admin panel.
// Shows unread contact messages.

if (!isset($conn)) {
    include dirname(__DIR__) . '/db_connection/connection.php';
}

// Fetch latest 5 unread messages
$notif_sql = "SELECT id, name, subject, created_at FROM contact_messages WHERE status = 'unread' ORDER BY created_at DESC LIMIT 5";
$notif_res = mysqli_query($conn, $notif_sql);
$notifs = [];
while ($row = mysqli_fetch_assoc($notif_res)) {
    $notifs[] = $row;
}

// Total unread count
$count_res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM contact_messages WHERE status = 'unread'");
$total_unread = (int)mysqli_fetch_assoc($count_res)['cnt'];
?>

<div class="relative" id="notifArea">
    <!-- Bell Icon -->
    <button id="notifBell" onclick="toggleNotifPanel()" 
        class="relative p-2.5 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm group">
        <i class="fas fa-bell text-gray-500 group-hover:text-primary <?php echo $total_unread > 0 ? 'animate-bounce' : ''; ?>"></i>
        <?php if ($total_unread > 0): ?>
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-white">
            <?php echo $total_unread > 9 ? '9+' : $total_unread; ?>
        </span>
        <?php endif; ?>
    </button>

    <!-- Dropdown Panel -->
    <div id="notifPanel" class="hidden absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-[100] overflow-hidden">
        <div class="px-5 py-4 bg-gradient-to-r from-primary to-blue-700 flex justify-between items-center">
            <h3 class="text-white font-bold text-sm">New Messages</h3>
            <?php if ($total_unread > 0): ?>
            <span class="text-[10px] bg-white/20 text-white px-2 py-0.5 rounded-full font-bold uppercase"><?php echo $total_unread; ?> Unread</span>
            <?php endif; ?>
        </div>

        <div class="max-h-[350px] overflow-y-auto divide-y divide-gray-50">
            <?php if (empty($notifs)): ?>
            <div class="p-8 text-center">
                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-check text-gray-300"></i>
                </div>
                <p class="text-gray-500 text-xs font-medium">No new notifications</p>
            </div>
            <?php else: ?>
                <?php foreach ($notifs as $n): ?>
                <a href="contact_messages.php" class="block p-4 hover:bg-blue-50/50 transition border-l-4 border-transparent hover:border-primary">
                    <div class="flex justify-between items-start mb-1">
                        <span class="text-xs font-bold text-gray-900 truncate pr-2"><?php echo htmlspecialchars($n['name']); ?></span>
                        <span class="text-[9px] text-gray-400 whitespace-nowrap">
                            <?php 
                                $time = strtotime($n['created_at']);
                                echo date('H:i', $time);
                            ?>
                        </span>
                    </div>
                    <p class="text-[11px] text-gray-500 truncate"><?php echo htmlspecialchars($n['subject']); ?></p>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a href="contact_messages.php" class="block w-full text-center py-3 bg-gray-50 text-primary text-[11px] font-bold hover:bg-gray-100 transition border-t border-gray-100">
            VIEW ALL MESSAGES
        </a>
    </div>
</div>

<script>
function toggleNotifPanel() {
    const p = document.getElementById('notifPanel');
    p.classList.toggle('hidden');
}
window.addEventListener('click', function(e) {
    const area = document.getElementById('notifArea');
    const panel = document.getElementById('notifPanel');
    if (area && !area.contains(e.target)) {
        panel.classList.add('hidden');
    }
});
</script>
