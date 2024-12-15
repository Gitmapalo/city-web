<?php
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: login.php');
    exit;
}

// Get user info from session
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$role = $_SESSION['role'];

// Count unread notifications
$unread_stmt = $pdo->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE user_id = ? AND is_read = 0");
$unread_stmt->execute([$_SESSION['user_id']]);
$unread_notifications = $unread_stmt->fetch(PDO::FETCH_ASSOC)['unread_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DyZv4M5ZP14uEVW9A0Hq+HsTA1l0/8L0kIdgS4f5XpDnpN+H7b7e6Od8mPQPT9V" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Add your stylesheet here -->
    <style>
        .notification-icon {
            position: relative; /* Positioning context for the badge */
        }

        .notification-badge {
            position: absolute;
            top: -5px; /* Adjust as needed */
            right: -10px; /* Adjust as needed */
            background-color: red; /* Badge color */
            color: white; /* Text color */
            border-radius: 50%; /* Circular shape */
            padding: 4px 8px; /* Padding for the badge */
            font-size: 12px; /* Font size for the badge */
            font-weight: bold; /* Make the text bold */
            min-width: 20px; /* Minimum width for small numbers */
            text-align: center; /* Center the text */
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="nav-bar">
            <?php if ($role == 'citizen') : ?>
                <a href="welcome.php" class="logo">
                    <img src="../assets/images/logo.png" alt="">
                    Citizen Voice
                </a>
            <?php elseif ($role == 'moderator'): ?>
                <a href="moderation_dashboard.php" class="logo">
                    <img src="../assets/images/logo.png" alt="">
                    Citizen Voice
                </a>
            <?php elseif ($role == 'official'): ?>
                <a href="government_dashboard.php" class="logo">
                    <img src="../assets/images/logo.png" alt="">
                    Citizen Voice
                </a>
            <?php endif ?>
            <div class="user">
                <div class="icons">
                    <a href="notification_center.php" class="notification-icon">
                        <i class="fa fa-bell icon <?php echo $unread_notifications > 0 ? 'notification-active' : ''; ?>"></i>
                        <?php if ($unread_notifications > 0): ?>
                            <span class="notification-badge"><?php echo $unread_notifications; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <p>
                    <span class="role-info highlight">
                        <?php if ($role == 'official'): ?>
                            Government
                        <?php elseif ($role == 'citizen'): ?>
                            Citizen
                        <?php elseif ($role == 'moderator'): ?>
                            Moderator
                        <?php endif; ?>
                    </span>
                    <?php echo htmlspecialchars(' | ' . $first_name . ' ' . $last_name); ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
