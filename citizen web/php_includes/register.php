<?php
session_start();
require 'db.php';

$error = "";
$step = "role_selection"; // Tracks the current step

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['role'])) {
        // Step 1: Role selection
        $role = $_POST['role'];
        $_SESSION['role'] = $role; // Store role in session
        $step = "registration";
    } elseif (isset($_POST['first_name'])) {
        // Step 2: Registration
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_SESSION['role'];

        // Validate email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email already exists!";
        } else {
            // Hash password
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$firstName, $lastName, $email, $passwordHash, $role])) {
                // Registration successful
                header('Location: login.php');
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Citizen Central</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="absolute inset-0 bg-cover bg-center filter brightness-50" style="background-image: url('https://source.unsplash.com/1920x1080/?city')"></div>
    <div class="absolute inset-0 bg-purple-900/60"></div>

    <div class="relative z-10 w-full max-w-lg bg-white/90 backdrop-blur-lg rounded-xl shadow-2xl overflow-hidden">
        <?php if ($step == "role_selection"): ?>
        <!-- Role Selection -->
        <div class="p-8">
            <h2 class="text-3xl font-bold text-center text-purple-600 mb-6">Choose Your Role</h2>
            <p class="text-gray-600 text-center mb-8">What role best describes you? Choose an option to proceed with registration.</p>
            <form method="post" class="space-y-6">
                <button 
                    type="submit" 
                    name="role" 
                    value="Government Official" 
                    class="w-full py-4 px-6 bg-purple-600 text-white text-lg rounded-lg shadow-lg hover:bg-purple-700 transform transition hover:scale-105 flex items-center justify-center space-x-4">
                    <i class="fas fa-landmark text-2xl"></i>
                    <span>Government Official</span>
                </button>
                <button 
                    type="submit" 
                    name="role" 
                    value="Citizen" 
                    class="w-full py-4 px-6 bg-blue-600 text-white text-lg rounded-lg shadow-lg hover:bg-blue-700 transform transition hover:scale-105 flex items-center justify-center space-x-4">
                    <i class="fas fa-user text-2xl"></i>
                    <span>Citizen</span>
                </button>
                <button 
                    type="submit" 
                    name="role" 
                    value="Moderator" 
                    class="w-full py-4 px-6 bg-green-600 text-white text-lg rounded-lg shadow-lg hover:bg-green-700 transform transition hover:scale-105 flex items-center justify-center space-x-4">
                    <i class="fas fa-shield-alt text-2xl"></i>
                    <span>Moderator</span>
                </button>
            </form>
        </div>
        <?php elseif ($step == "registration"): ?>
        <!-- Registration Form -->
        <div class="p-8">
            <h2 class="text-3xl font-bold text-center text-purple-600 mb-6">Register as <?= htmlspecialchars($_SESSION['role']); ?></h2>
            <?php if ($error): ?>
                <div class="text-red-500 text-center mb-4"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form method="post" class="space-y-6">
                <div class="relative">
                    <input type="text" name="first_name" placeholder="First Name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-user absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative">
                    <input type="text" name="last_name" placeholder="Last Name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-user-tie absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative">
                    <input type="email" name="email" placeholder="Email Address" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="Password" required oninput="checkPasswordStrength()" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <i id="togglePassword" class="fas fa-eye-slash absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"></i>
                </div>
                <div class="mt-2 h-2 bg-gray-200 rounded-full overflow-hidden">
                    <div id="progressBar" class="h-full transition-all duration-300 ease-in-out"></div>
                </div>
                <button type="submit" class="w-full py-4 px-6 bg-purple-600 text-white text-lg rounded-lg shadow-lg hover:bg-purple-700 transform transition hover:scale-105">Register</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            const passwordField = document.getElementById("password");
            const icon = this;
            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        });

        function checkPasswordStrength() {
            const password = document.getElementById("password").value;
            const progressBar = document.getElementById("progressBar");
            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password)) strength += 25;
            if (/[^A-Za-z0-9]/.test(password)) strength += 25;

            progressBar.style.width = strength + '%';

            if (strength < 50) {
                progressBar.className = 'h-full bg-red-500';
            } else if (strength < 75) {
                progressBar.className = 'h-full bg-yellow-500';
            } else {
                progressBar.className = 'h-full bg-green-500';
            }
        }
    </script>
</body>
</html>
