<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Verify OTP</h1>
        <form action="" method="post">
            <input type="text" name="otp1" placeholder="Enter your OTP" required>
            <button type="submit" name="verifyOTP">Verify</button>
        </form>
    </div>

    <?php
    if (isset($_POST['verifyOTP'])) {
        // Retrieve the user-entered OTP and the session OTP
        $userotp = $_POST['otp1'];
        $sessionOtp = $_SESSION['otp2'];

        // Validate OTP
        if ($sessionOtp == null) {
            // OTP expired or not set
            echo "<script>alert('OTP has expired. Please try again.');</script>";
            echo "<script>window.location.href='pass-reset.php';</script>";
        } elseif ($userotp == $sessionOtp) {
            // OTP verified successfully
            unset($_SESSION['otp']); // Clear OTP after successful verification
            echo "<script>alert('OTP has been verified successfully');</script>";
            echo "<script>window.location.href='pass-change.php';</script>";
        } else {
            // OTP verification failed
            echo "<script>alert('OTP verification failed. Please try again.');</script>";
            //echo "<script>window.location.href='login.php';</script>";
        }
    }
    ?>
</body>

</html>