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
    <title>EduPortal - Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #f9fafb, #e5e7eb);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-family: 'Pacifico', cursive;
            color: #4F46E5;
            margin-bottom: 10px;
        }

        p {
            color: #6b7280;
            font-size: 14px;
        }

        .role-selection {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .role-btn {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            text-align: center;
            transition: 0.3s;
        }

        .role-btn:hover,
        .role-btn.active {
            border-color: #4F46E5;
            background: rgba(79, 70, 229, 0.1);
        }

        input {
            width: 89%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .input-container {
            position: relative;
            text-align: left;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 43%;
            transform: translateY(-50%);
            color: #6b7280;
        }

        .input-container input {
            padding-left: 30px;
        }

        button {
            width: 100%;
            background: #4F46E5;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #4338ca;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>EduPortal</h1>
        <p>Your Academic Management Portal</p>

        <form action="" method="POST">
            <div class="role-selection">
                <div class="role-btn" onclick="selectRole('student')" data-role="student">
                    <i class="ri-user-line"></i>
                    <span>Student</span>
                </div>
                <div class="role-btn" onclick="selectRole('parent')" data-role="parent">
                    <i class="ri-team-line"></i>
                    <span>Parent</span>
                </div>
                <div class="role-btn" onclick="selectRole('faculty')" data-role="faculty">
                    <i class="ri-graduation-cap-line"></i>
                    <span>Faculty</span>
                </div>
                <div class="role-btn" onclick="selectRole('admin')" data-role="admin">
                    <i class="ri-admin-line"></i>
                    <span>Admin</span>
                </div>
            </div>

            <!-- Hidden input field to store selected role -->
            <input type="hidden" name="selectedRole" id="selectedRole">

            <div class="input-container">
                <i class="ri-mail-line"></i>
                <input type="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="input-container">
                <i class="ri-lock-line"></i>
                <input type="password" name="password" required id="password" placeholder="Enter your password">
            </div>

            <button name="login" type="submit">Login</button>
            <br><br>
            <a href="pass-reset.php">Forgot Password?</a>
            <div class="text-center">
                <p class="text-sm text-gray-600">Don't have an account? <a href="signup.php" class="font-medium text-primary hover:text-primary/80">Sign Up</a></p>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['login'])) {
        if (!empty($_POST["selectedRole"])) {
            $role = $_POST["selectedRole"];
            $email = $_POST['email'];
            $password = $_POST['password'];

            include("connection.php");
            $query = "SELECT * FROM logincredentials WHERE email='$email' and role='$role'";
            $result = $conn->query($query);
            if (!$result) {
                echo "Query not executed";
            } else {
                if ($result->num_rows > 0) {
                    $result = $result->fetch_assoc();
                } else {
                    echo "<script>alert('User not found.');</script>";
                    echo "<script>window.location.href='login.php';</script>";
                    exit();
                }
            }

            if (password_verify($password, $result['password'])) {
                // Display success alert
                echo "<script>
                Swal.fire({
                    title: 'Login Successful',
                    text: 'Welcome to EduPortal',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500 // Show for 2 seconds
                }).then(() => {
                    // After the alert is closed, redirect based on role
                    let role = '{$role}';
                    let redirectUrl = '';

                    if (role === 'student') {
                        window.location.href='studentPanel.php';
                    } else if (role === 'parent') {
                        window.location.href='parentPanel.php';                      
                    } else if (role === 'faculty') {
                        window.location.href='facultyPanel.php';                      
                    } else if (role === 'admin') {
                        window.location.href='adminPanel.php';              
                    }

                    
                });
            </script>";

                // Set session variables
                $_SESSION['name'] = $result['name'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['role'] = $result['role'];
                $_SESSION['userID'] = $result['userID'];
                $_SESSION['instituteID'] = $result['instituteID'];
                $_SESSION['gender'] = $result['gender'];
            } else {
                echo "<script>Swal.fire({
                title: 'Login Failed',
                text: 'Incorrect Password',
                icon: 'error',
            });</script>";
            }
        } else {
            echo "<script>Swal.fire({
            title: 'Login Failed',
            text: 'Please select a role',
            icon: 'warning',
        });</script>";
        }
    }
    ?>


    <script>
        function selectRole(role) {
            document.getElementById('selectedRole').value = role;

            document.querySelectorAll('.role-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-role') === role) {
                    btn.classList.add('active');
                }
            });
        }
    </script>
</body>

</html>