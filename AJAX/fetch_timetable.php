<?php
session_start();
header('Content-Type: application/json');
include '../connection.php';

if (!isset($_POST['classID']) || !isset($_SESSION['instituteID'])) {
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$classID = $conn->real_escape_string($_POST['classID']);
$instituteID = $_SESSION['instituteID'];

$query = "SELECT t.dayOfWeek, t.periodNumber, t.facultyID, lc.name, s.subjectName 
          FROM timetable t
          JOIN faculty f ON t.facultyID = f.facultyID
          JOIN logincredentials lc ON f.userID = lc.userID
          LEFT JOIN subject s ON f.facultyID = s.facultyID
          WHERE t.classID = ? AND t.instituteID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $classID, $instituteID);
$stmt->execute();
$result = $stmt->get_result();

$timetable = [];
while ($row = $result->fetch_assoc()) {
    $timetable[] = [
        'dayOfWeek' => $row['dayOfWeek'],
        'periodNumber' => (int)$row['periodNumber'],
        'facultyID' => $row['facultyID'],
        'name' => htmlspecialchars($row['name']),
        'subjectName' => htmlspecialchars($row['subjectName'] ?? 'No Subject')
    ];
}

$maxPeriodsQuery = "SELECT MAX(periodNumber) as maxPeriods FROM timetable WHERE classID = ? AND instituteID = ?";
$maxStmt = $conn->prepare($maxPeriodsQuery);
$maxStmt->bind_param("ii", $classID, $instituteID);
$maxStmt->execute();
$maxResult = $maxStmt->get_result();
$maxRow = $maxResult->fetch_assoc();
$maxPeriods = $maxRow['maxPeriods'] ?? 0;

$stmt->close();
$maxStmt->close();
$conn->close();

echo json_encode(['timetable' => $timetable, 'maxPeriods' => $maxPeriods]);
