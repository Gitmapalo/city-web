<?php
session_start();

// If a registration type is selected, store it and redirect to registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registration_type'])) {
    $_SESSION['registration_type'] = $_POST['registration_type'];
    header('Location: register.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Registration Type - Citizen Central</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="absolute inset-0 bg-cover bg-center filter brightness-50" style="background-image: url('/api/placeholder/1920/1080')"></div>
    
    <div class="relative z-10 w-full max-w-xl bg-white/90 backdrop-blur-sm rounded-xl shadow-2xl overflow-hidden">
        <div class="p-8">
            <div class="flex items-center justify-center mb-8">
                <img src="/assets/images/logo.png" alt="Citizen Central Logo" class="h-16 w-16 mr-4">
                <h2 class="text-3xl font-bold text-purple-800">Citizen Central</h2>
            </div>

            <h3 class="text-2xl font-semibold text-center text-gray-800 mb-6">Select Your Registration Type</h3>

            <form action="" method="post" class="space-y-6">
                <div class="grid grid-cols-3 gap-6">
                    <label class="registration-type-label">
                        <input 
                            type="radio" 
                            name="registration_type" 
                            value="citizen" 
                            class="hidden" 
                            required
                        >
                        <div class="registration-type-card">
                            <i class="fas fa-user text-5xl text-purple-600"></i>
                            <span class="mt-4 text-lg font-semibold">Citizen</span>
                        </div>
                    </label>

                    <label class="registration-type-label">
                        <input 
                            type="radio" 
                            name="registration_type" 
                            value="government_official" 
                            class="hidden"
                        >
                        <div class="registration-type-card">
                            <i class="fas fa-landmark text-5xl text-blue-600"></i>
                            <span class="mt-4 text-lg font-semibold">Government Official</span>
                        </div>
                    </label>

                    <label class="registration-type-label">
                        <input 
                            type="radio" 
                            name="registration_type" 
                            value="moderator" 
                            class="hidden"
                        >
                        <div class="registration-type-card">
                            <i class="fas fa-gavel text-5xl text-green-600"></i>
                            <span class="mt-4 text-lg font-semibold">Moderator</span>
                        </div>
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500"
                >
                    Continue to Registration
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="../index.html" class="text-sm text-gray-600 hover:text-purple-600">Back to Home</a>
            </div>
        </div>
    </div>

    <style>
        .registration-type-label input:checked + .registration-type-card {
            @apply border-purple-600 ring-2 ring-purple-500 bg-purple-50;
        }

        .registration-type-card {
            @apply flex flex-col items-center justify-center p-6 border-2 border-gray-300 rounded-lg cursor-pointer transition duration-300 ease-in-out hover:border-purple-500 hover:bg-gray-50 text-center;
        }
    </style>

    <script>
        document.querySelectorAll('.registration-type-label').forEach(label => {
            label.addEventListener('click', () => {
                document.querySelectorAll('.registration-type-label').forEach(l => {
                    l.querySelector('input').checked = false;
                });
                label.querySelector('input').checked = true;
            });
        });
    </script>
</body>
</html>