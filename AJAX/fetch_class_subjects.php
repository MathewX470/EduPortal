<?php
include("../connection.php");
session_start();
$classID = $_POST['classID'];
$instituteID = $_SESSION['instituteID'];

$query = "SELECT DISTINCT s.subjectID, s.subjectName
          FROM subject s
          WHERE s.facultyID IN (
              SELECT facultyID FROM class WHERE classID = ? AND instituteID = ?
              UNION
              SELECT facultyID FROM class_faculty WHERE classID = ?
          ) AND s.instituteID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiii", $classID, $instituteID, $classID, $instituteID);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = [
        'subjectID' => htmlspecialchars($row['subjectID']),
        'subjectName' => htmlspecialchars($row['subjectName'])
    ];
}
$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($subjects);
