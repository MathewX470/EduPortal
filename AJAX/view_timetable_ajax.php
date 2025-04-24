<?php
session_start();
include("../connection.php");

// Set content type to HTML for AJAX responses
header('Content-Type: text/html; charset=UTF-8');

$classID = $_POST['classID'] ?? '';
$facultyID = $_POST['facultyID'] ?? 0;

if (empty($classID) || !is_numeric($classID) || !is_numeric($facultyID)) {
    echo '<p class="text-red-500">Error: Invalid class ID or faculty ID</p>';
    exit;
}

// Fetch timetable for the selected class where the faculty is assigned
$stmt = $conn->prepare("
    SELECT dayOfWeek, periodNumber
    FROM timetable
    WHERE classID = ? AND facultyID = ? AND instituteID = ?
");
if (!$stmt) {
    echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}
$instituteID = $_SESSION['instituteID'];
$stmt->bind_param("iii", $classID, $facultyID, $instituteID);
$stmt->execute();
$timetableResult = $stmt->get_result();

// Organize timetable data
$timetableData = [];
if ($timetableResult->num_rows > 0) {
    while ($row = $timetableResult->fetch_assoc()) {
        $timetableData[$row['dayOfWeek']][$row['periodNumber']] = true; // Mark presence
    }
}

// Define days and periods (match the enum and your schedule)
$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
$periods = range(1, 8); // Adjust the number of periods (e.g., 1 to 8)

echo '<table class="w-full border-collapse border border-gray-300">';
echo '<thead><tr class="bg-gray-100">';
echo '<th class="border p-2">Day</th>';
foreach ($periods as $period) {
    echo '<th class="border p-2">Period ' . $period . '</th>';
}
echo '</tr></thead>';
echo '<tbody>';

foreach ($days as $day) {
    echo '<tr>';
    echo '<td class="border p-2">' . htmlspecialchars($day) . '</td>';
    foreach ($periods as $period) {
        $isAssigned = $timetableData[$day][$period] ?? false;
        echo '<td class="border p-2">' . ($isAssigned ? 'Assigned' : '') . '</td>';
    }
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$stmt->close();
$conn->close();
