<?php
session_start();
include("connection.php");

if (isset($_GET['leaveID']) && isset($_SESSION['studID'])) {
    $leaveID = $_GET['leaveID'];
    $studID = $_SESSION['studID'];

    // Ensure the leave application belongs to the logged-in student
    $stmt = $conn->prepare("DELETE FROM leaveapplication WHERE leaveID = ? AND studID = ?");
    $stmt->bind_param("ii", $leaveID, $studID);

    if ($stmt->execute()) {
        // Optionally delete the file from the filesystem
        $fileQuery = $conn->prepare("SELECT filePath FROM leaveapplication WHERE leaveID = ?");
        $fileQuery->bind_param("i", $leaveID);
        $fileQuery->execute();
        $fileResult = $fileQuery->get_result();
        if ($fileRow = $fileResult->fetch_assoc()) {
            $filePath = $fileRow['filePath'];
            if ($filePath && file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }
        }
        $fileQuery->close();
    }

    $stmt->close();
}

// Redirect back to the appliedLeaves section
//header("Location: student_panel.php?content=appliedLeaves");
echo '<script>window.location.href = "student_panel.php?content=appliedLeaves";</script>';
exit;
