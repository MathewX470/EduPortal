<?php
session_start();
if (empty($_SESSION['email'])) {
    echo "<script>window.location.href='welcomePage.php';</script>";
    exit();
}
?>