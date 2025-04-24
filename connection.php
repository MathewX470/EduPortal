<?php
$conn = new mysqli("localhost", 'root', 'root123', 'eduportal');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else
    $db = mysqli_select_db($conn, "eduportal");
if (!$db) {
    echo "Database not selected";
}
?>