<?php
session_start();
?>
<?php
if (isset($_POST['confirm'])) {
    $errorMessage = ''; // Initialize the error message
    $email = $_SESSION['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password != $cpassword) {
        $errorMessage =  '<p class="error">Passwords do not match. Please try again.</p>';
    } else {

        include("connection.php");
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "UPDATE logincredentials SET password='$hashed_password' WHERE email='$email'";
        $result = $conn->query($query);
        if ($result) {
            echo '<script>alert("Password changed successfully!");</script>';
            $_SESSION = array(); // Clear all session data
            session_destroy();
            echo '<script>window.location.href="login.php";</script>';
        } else {
            echo 'Password change failed. Please try again.';
        }
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        select,
        input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            width: 100%;
            max-width: 300px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            max-width: 300px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error,
        .success {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Change Password</h1>
        <form action="" method="post">

            <input type="password" name="password" placeholder="Enter your new password" required>

            <input type="password" name="cpassword" placeholder="Confirm your new password" required>

            <button type="submit" name="confirm">Confirm</button><br><br>
            <?php
            // Display the error message below the submit button
            if (!empty($errorMessage)) {
                echo $errorMessage;
            }
            ?>
        </form>
    </div>

</body>

</html>