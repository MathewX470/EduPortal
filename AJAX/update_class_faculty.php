<?php
include '../connection.php';
session_start();

$classID = isset($_POST['classID']) ? $conn->real_escape_string($_POST['classID']) : '';
$mainFacultyID = isset($_POST['mainFacultyID']) ? $conn->real_escape_string($_POST['mainFacultyID']) : '';
$additionalFaculty = isset($_POST['additionalFaculty']) ? array_map([$conn, 'real_escape_string'], $_POST['additionalFaculty']) : [];
$instituteID = $_SESSION['instituteID'];

if (empty($classID) || empty($mainFacultyID) || count($additionalFaculty) !== 4) {
    echo "Error: Invalid input.";
    exit;
}

$conn->begin_transaction();
try {
    // Update Main Staff Advisor in class table
    $stmt = $conn->prepare("UPDATE class SET facultyID = ? WHERE classID = ? AND instituteID = ?");
    $stmt->bind_param("iii", $mainFacultyID, $classID, $instituteID);
    if (!$stmt->execute()) {
        throw new Exception("Error updating main faculty: " . $stmt->error);
    }
    $stmt->close();

    // Delete existing additional faculty
    $stmt = $conn->prepare("DELETE FROM class_faculty WHERE classID = ?");
    $stmt->bind_param("i", $classID);
    if (!$stmt->execute()) {
        throw new Exception("Error deleting existing faculty: " . $stmt->error);
    }
    $stmt->close();

    // Insert new additional faculty
    foreach ($additionalFaculty as $facultyID) {
        $stmt = $conn->prepare("INSERT INTO class_faculty (classID, facultyID) VALUES (?, ?)");
        $stmt->bind_param("ii", $classID, $facultyID);
        if (!$stmt->execute()) {
            throw new Exception("Error adding additional faculty: " . $stmt->error);
        }
        $stmt->close();
    }

    $conn->commit();
    echo "success";
} catch (Exception $e) {
    $conn->rollback();
    echo "Error: " . $e->getMessage();
} finally {
    $conn->close();
}
