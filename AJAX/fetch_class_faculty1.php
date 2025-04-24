<?php
session_start();
include '../connection.php';

if (!isset($_POST['classID']) || !isset($_SESSION['instituteID'])) {
    echo json_encode([]);
    exit;
}

$classID = $conn->real_escape_string($_POST['classID']);
$instituteID = $_SESSION['instituteID'];

$query = "SELECT f.facultyID, lc.name, s.subjectName 
          FROM faculty f
          JOIN logincredentials lc ON f.userID = lc.userID
          LEFT JOIN subject s ON f.facultyID = s.facultyID
          WHERE f.instituteID = ? 
          AND (f.facultyID IN (SELECT facultyID FROM class WHERE classID = ?) 
               OR f.facultyID IN (SELECT facultyID FROM class_faculty WHERE classID = ?))";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $instituteID, $classID, $classID);
$stmt->execute();
$result = $stmt->get_result();

$facultyList = [];
while ($row = $result->fetch_assoc()) {
    $facultyList[] = [
        'facultyID' => htmlspecialchars($row['facultyID']),
        'name' => htmlspecialchars($row['name']),
        'subjectName' => htmlspecialchars($row['subjectName'] ?? 'No Subject')
    ];
}

$stmt->close();
$conn->close();

echo json_encode($facultyList);
