<?php
session_start();

if (isset($_SESSION['role'])) {
    $r = $_SESSION['role'];
    if ($r == "admin") {
        echo "<script>window.location.href='adminPanel.php';</script>";
        exit();
    } else if ($r == "student") {
        echo "<script>window.location.href='studentPanel.php';</script>";
        exit();
    } else if ($r == "parent") {
        echo "<script>window.location.href='parentPanel.php';</script>";
        exit();
    } else if ($r == "faculty") {
        echo "<script>window.location.href='facultyPanel.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - EduPortal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#6366F1'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('https://public.readdy.ai/ai/img_res/018c8840e04e4c4fb792be9d2ec92934.jpg'); background-size: cover;">
        <div class="max-w-md w-full space-y-8 bg-white/95 backdrop-blur-sm p-8 rounded-lg shadow-xl">
            <div>
                <h1 class="text-center text-4xl font-['Pacifico'] text-primary mb-2">EduPortal</h1>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Create your account</h2>
                <p class="mt-2 text-center text-sm text-gray-600">Join our educational community today</p>
            </div>

            <form action="" method="POST" class="mt-8 space-y-6" id="signupForm">
                <div class="space-y-4">
                    <div>
                        <label for="fullName" class="block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-user-line text-gray-400"></i>
                            </div>
                            <input id="fullName1" name="fullName" type="text" required class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm" placeholder="Enter your full name">
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-gray-400"></i>
                            </div>
                            <input id="email1" name="email" type="email" required class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm" placeholder="Enter your email">
                        </div>
                        <p id="emailCheck"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                        <div class="mt-1 flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="form-radio text-primary">
                                <span class="ml-2 text-sm text-gray-700">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="form-radio text-primary">
                                <span class="ml-2 text-sm text-gray-700">Female</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-lock-line text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required class="appearance-none block w-full pl-10 pr-10 py-2 border border-gray-300 rounded-button text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm" placeholder="Create a password">
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" id="togglePassword">
                                <i class="ri-eye-line text-gray-400"></i>
                            </button>
                        </div>

                    </div>

                    <div>
                        <label for="institute" class="block text-sm font-medium text-gray-700">Institute Name <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-building-line text-gray-400"></i>
                            </div>
                            <input id="institute" name="instituteName" type="text" required class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm" placeholder="Enter your institute name">
                        </div>
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Institute Location <span class="text-red-500">*</span></label>
                        <div class="mt-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-map-pin-line text-gray-400"></i>
                            </div>
                            <input id="location" name="location" type="text" required class="appearance-none block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent sm:text-sm" placeholder="Enter institute location">
                        </div>
                    </div>
                </div>

                <div>
                    <button name="createAccount" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-button text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-sm text-gray-600">Already have an account? <a href="login.php" class="font-medium text-primary hover:text-primary/80">Sign in</a></p>
            </div>
        </div>

        <div id="notification" class="fixed top-4 right-4 transform transition-transform duration-300 translate-x-full"></div>
    </div>

    <?php
    if (isset($_POST['createAccount'])) {
        $name = $_POST['fullName'];
        $email = $_POST['email'];
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $instituteName = $_POST['instituteName'];
        $location = $_POST['location'];

        $_SESSION['institutionName'] = $instituteName;
        $_SESSION['location'] = $location;

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        include("connection.php");

        // Start a transaction for data consistency
        $conn->begin_transaction();

        try {
            // Insert admin into logincredentials table
            $stmt = $conn->prepare("INSERT INTO logincredentials (email, password, name, gender, role) VALUES (?, ?, ?, ?, 'admin')");
            $stmt->bind_param("ssss", $email, $hashedPassword, $name, $gender);
            if (!$stmt->execute()) {
                throw new Exception("Error creating account: " . $stmt->error);
            }
            $adminUserID = $conn->insert_id; // Get admin user ID
            $stmt->close();

            // Insert admin into admin table
            $stmt = $conn->prepare("INSERT INTO admin (userID) VALUES (?)");
            $stmt->bind_param("i", $adminUserID);
            if (!$stmt->execute()) {
                throw new Exception("Error creating admin: " . $stmt->error);
            }
            $adminID = $conn->insert_id; // Get adminID
            $stmt->close();

            // Insert institute details into institute table
            $stmt = $conn->prepare("INSERT INTO institute (name, location, adminID) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $instituteName, $location, $adminID);
            if (!$stmt->execute()) {
                throw new Exception("Error creating institute: " . $stmt->error);
            }
            $instituteID = $conn->insert_id; // Get instituteID
            $stmt->close();

            // Update logincredentials with instituteID using a prepared statement
            $stmt = $conn->prepare("UPDATE logincredentials SET instituteID = ? WHERE userID = ?");
            $stmt->bind_param("ii", $instituteID, $adminUserID);
            if (!$stmt->execute()) {
                throw new Exception("Error updating instituteID in logincredentials: " . $stmt->error);
            }
            $stmt->close();

            // Commit the transaction if all queries succeed
            $conn->commit();

            // Success message and redirect
            echo "<script>alert('Account created successfully! Redirecting to login page.');</script>";
            echo "<script>window.location.href='login.php';</script>";
        } catch (Exception $e) {
            // Roll back the transaction on any error
            $conn->rollback();
            die("Transaction failed: " . $e->getMessage());
        } finally {
            // Ensure the connection is closed (optional, depending on your setup)
            $conn->close();
        }
    }
    ?>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('signupForm');
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            //const passwordStrength = document.getElementById('passwordStrength');
            const notification = document.getElementById('notification');
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.innerHTML = type === 'password' ?
                    '<i class="ri-eye-line text-gray-400"></i>' :
                    '<i class="ri-eye-off-line text-gray-400"></i>';
            });

            $(document).ready(function() {
                $("#email1").on("blur", function() {
                    var email = $(this).val();

                    if (emailRegex.test(email)) { // Check only when input has some length
                        $.ajax({
                            url: "checkEmail.php",
                            method: "POST",
                            data: {
                                email: email
                            },
                            success: function(response) {
                                if (response.trim() === "exists") {
                                    $("#emailCheck").html("<span class='text-red-500'>Email already exists. Try another.</span>");
                                }
                            }
                        });
                    } else {
                        $("#emailCheck").html(""); // Clear message if input is empty
                    }
                });
            });
        });
    </script>
</body>

</html>