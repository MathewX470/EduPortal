<?php
session_start();
include("../connection.php");

// Set content type to HTML for AJAX responses
header('Content-Type: text/html; charset=UTF-8');

$rollNo = $_POST['rollNo'] ?? '';
$facultyID = $_POST['facultyID'] ?? 0;

if (empty($rollNo) || !is_numeric($facultyID)) {
    echo '<p class="text-red-500">Error: Invalid roll number or faculty ID</p>';
    exit;
}

// Find student and verify class belongs to main faculty
$stmt = $conn->prepare("
    SELECT s.studID, s.RollNo, lc.name, c.classID, c.className
    FROM student s
    JOIN logincredentials lc ON s.userID = lc.userID
    JOIN class c ON s.classID = c.classID
    WHERE s.RollNo = ? AND c.facultyID = ?
");
if (!$stmt) {
    echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}
$stmt->bind_param("si", $rollNo, $facultyID);
$stmt->execute();
$studentResult = $stmt->get_result();

if ($studentResult->num_rows == 0) {
    echo '<p class="text-red-500">No student found with roll number ' . htmlspecialchars($rollNo) . ' or you are not authorized.</p>';
    $stmt->close();
    exit;
}

$student = $studentResult->fetch_assoc();
echo '<div class="mb-4">';
echo '<h3 class="text-lg font-semibold">Student Details</h3>';
echo '<p>Roll No: ' . htmlspecialchars($student['RollNo']) . '</p>';
echo '<p>Name: ' . htmlspecialchars($student['name']) . '</p>';
echo '<p>Class: ' . htmlspecialchars($student['className']) . '</p>';
echo '</div>';

// Get all exams for the student's class
$classID = $student['classID'];
$stmt = $conn->prepare("
    SELECT e.examID, e.examName
    FROM exam e
    WHERE e.classID = ?
");
if (!$stmt) {
    echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}
$stmt->bind_param("i", $classID);
$stmt->execute();
$examResult = $stmt->get_result();

if ($examResult->num_rows == 0) {
    echo '<p class="text-red-500">No exams found for this class.</p>';
} else {
    while ($exam = $examResult->fetch_assoc()) {
        $examID = $exam['examID'];
        $examName = htmlspecialchars($exam['examName']);

        // Get results for this exam
        $stmt = $conn->prepare("
            SELECT s.subjectName, r.markObtained, es.totalMarks
            FROM result r
            JOIN subject s ON r.subjectID = s.subjectID
            JOIN exam_subject es ON r.subjectID = es.subjectID AND r.examID = es.examID
            WHERE r.studentID = ? AND r.examID = ? AND r.classID = ?
        ");
        if (!$stmt) {
            echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
            exit;
        }
        $stmt->bind_param("iii", $student['studID'], $examID, $classID);
        $stmt->execute();
        $resultResult = $stmt->get_result();

        $totalObtained = 0;
        $totalMax = 0;

        echo '<div class="mt-4">';
        echo '<h3 class="text-lg font-semibold">' . $examName . '</h3>';
        echo '<table class="w-full border-collapse border border-gray-300">';
        echo '<thead><tr class="bg-gray-100">';
        echo '<th class="border p-2">Subject Name</th>';
        echo '<th class="border p-2">Marks Obtained</th>';
        echo '<th class="border p-2">Max Marks</th>';
        echo '</tr></thead>';
        echo '<tbody>';

        while ($result = $resultResult->fetch_assoc()) {
            $markObtained = $result['markObtained'] ?? 0;
            $totalMarks = $result['totalMarks'] ?? 0;
            echo '<tr>';
            echo '<td class="border p-2">' . htmlspecialchars($result['subjectName']) . '</td>';
            echo '<td class="border p-2">' . htmlspecialchars($markObtained) . '</td>';
            echo '<td class="border p-2">' . htmlspecialchars($totalMarks) . '</td>';
            echo '</tr>';
            $totalObtained += $markObtained;
            $totalMax += $totalMarks;
        }

        $percentage = ($totalMax > 0) ? ($totalObtained / $totalMax * 100) : 0;
        echo '<tr class="font-bold">';
        echo '<td class="border p-2">Total</td>';
        echo '<td class="border p-2">' . htmlspecialchars($totalObtained) . '</td>';
        echo '<td class="border p-2">' . htmlspecialchars($totalMax) . '</td>';
        echo '</tr>';
        echo '<tr class="font-bold">';
        echo '<td class="border p-2">Percentage</td>';
        echo '<td colspan="2" class="border p-2">' . number_format($percentage, 2) . '%</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        $stmt->close();
    }
}
$examResult->free();


$conn->close();
