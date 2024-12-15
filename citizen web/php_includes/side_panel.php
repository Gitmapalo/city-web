<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Sidebar - positioned 40% from top -->
    <aside id="sidebar" class="fixed top-[27%] left-0 z-40 transition-transform -translate-x-full sm:translate-x-0 duration-300">
        <div class="flex flex-col w-72 bg-white border border-gray-200 rounded-r-2xl shadow-lg max-h-[80vh]">
            <!-- Header -->
            <div class="flex items-center justify-between h-12 px-4 border-b border-gray-200">
                <span class="text-sm font-semibold text-gray-800">Quick Navigation</span>
                <button id="toggleSidebarMobile" class="p-1.5 rounded-lg sm:hidden hover:bg-gray-100">
                    <i class="fa fa-times text-gray-600"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-3 space-y-0.5 overflow-y-auto">
                <a href="<?php 
                    if ($_SESSION['role'] == 'moderator') {
                        echo 'moderation_dashboard.php';
                    } elseif ($_SESSION['role'] == 'official') {
                        echo 'government_dashboard.php';
                    } else {
                        echo 'welcome.php';
                    }
                ?>" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                    <i class="fa fa-dashboard w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <a href="view_feedback.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                    <i class="fa fa-comment w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ml-3">Feedback/Suggestion</span>
                </a>

                <a href="view_polls.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                    <i class="fa fa-check-circle w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ml-3">Government Polls</span>
                </a>

                <a href="view_projects.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                    <i class="fa fa-folder-open w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ml-3">Projects</span>
                </a>

                <a href="view_townhalls.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                    <i class="fa fa-users w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                    <span class="ml-3">Townhall Meetings</span>
                </a>

                <?php if ($_SESSION['role'] == 'citizen'): ?>
                    <div class="pt-2">
                        <p class="px-3 mb-1 text-xs font-semibold text-gray-400 uppercase">Actions</p>
                        <a href="feedback.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <i class="fa fa-pencil w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                            <span class="ml-3">Submit Feedback</span>
                        </a>
                        <a href="report_issue.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                            <i class="fa fa-exclamation-circle w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                            <span class="ml-3">Report Issue</span>
                        </a>
                    </div>
                <?php elseif ($_SESSION['role'] != 'citizen'): ?>
                    <div class="pt-2">
                        <p class="px-3 mb-1 text-xs font-semibold text-gray-400 uppercase">Admin</p>
                        <?php if ($_SESSION['role'] == 'moderator'): ?>
                            <a href="manage_users.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                                <i class="fa fa-users-cog w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                                <span class="ml-3">Manage Users</span>
                            </a>
                        <?php elseif ($_SESSION['role'] == 'official'): ?>
                            <a href="create_poll.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                                <i class="fa fa-plus-circle w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                                <span class="ml-3">Create Poll</span>
                            </a>
                            <a href="create_townhall.php" class="flex items-center px-3 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 group">
                                <i class="fa fa-calendar-plus w-4 h-4 text-gray-500 group-hover:text-gray-900"></i>
                                <span class="ml-3">Schedule Town Hall</span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </nav>

            <!-- Footer -->
            <div class="p-3 border-t border-gray-200">
                <a href="logout.php" class="flex items-center px-3 py-2 text-sm text-red-600 rounded-lg hover:bg-red-50 group">
                    <i class="fa fa-sign-out-alt w-4 h-4"></i>
                    <span class="ml-3">Logout</span>
                </a>
            </div>
        </div>
    </aside>

    <!-- Mobile Toggle Button -->
    <button id="toggleSidebarButton" class="fixed top-[45%] left-4 z-50 p-2 bg-white rounded-lg shadow-lg sm:hidden hover:bg-gray-100">
        <i class="fa fa-bars text-gray-600"></i>
    </button>

    <!-- Main Content -->
    <div class="sm:ml-72">
        <main class="p-4">
            <!-- Your main content here -->
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebarButton = document.getElementById('toggleSidebarButton');
        const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
        }

        toggleSidebarButton.addEventListener('click', toggleSidebar);
        toggleSidebarMobile.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 640) {
                if (!sidebar.contains(e.target) && 
                    e.target !== toggleSidebarButton && 
                    !toggleSidebarButton.contains(e.target)) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 640) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
</body>
</html>