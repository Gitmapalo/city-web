<?php
session_start();
require 'db.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['role'] = $user['role'];

        switch ($user['role']) {
            case 'citizen':
                header('Location: welcome.php');
                break;
            case 'official':
                header('Location: government_dashboard.php');
                break;
            case 'moderator':
                header('Location: moderation_dashboard.php');
                break;
            default:
                header('Location: login.php');
        }
        exit;
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-center mb-8">
                 
                    <h2 class="text-3xl font-bold text-purple-800">voice</h2>
                </div>

                <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">Login to Your Account</h3>

                <form action="login.php" method="post" class="space-y-6">
                    <div>
                        <label for="email" class="sr-only">Email Address</label>
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                required 
                                placeholder="Email Address" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            >
                            <i class="fas fa-envelope absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                required 
                                placeholder="Password" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                            >
                            <i 
                                id="togglePassword" 
                                class="fas fa-eye-slash absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer"
                            ></i>
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        Login
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Don't have an account? 
                        <a href="register.php" class="text-purple-600 hover:underline font-semibold">Register</a>
                    </p>
                    <div class="mt-4">
                      
                    </div>
                    <div class="mt-4">
                        <a href="../index.html" class="text-sm text-gray-600 hover:text-purple-600">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
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
    </script>
</body>
</html>