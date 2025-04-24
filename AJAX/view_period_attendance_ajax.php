<?php
session_start();
include("../connection.php");

// Set content type to HTML for AJAX responses
header('Content-Type: text/html; charset=UTF-8');

$studID = $_SESSION['studID'] ?? 0;
$startDate = $_POST['startDate'] ?? '';
$endDate = $_POST['endDate'] ?? '';
$classID = $_POST['classID'] ?? 0;

if (empty($studID) || empty($startDate) || empty($endDate) || empty($classID) || !is_numeric($studID) || !is_numeric($classID)) {
    echo '<p class="text-red-500">Error: Invalid parameters</p>';
    exit;
}

// Validate dates
$start = new DateTime($startDate);
$end = new DateTime($endDate);
if ($start > $end) {
    echo '<p class="text-red-500">Error: Start date must be less than or equal to end date</p>';
    exit;
}

// Get the maximum number of periods for the class (across all days)
$stmt = $conn->prepare("SELECT MAX(periodNumber) as maxPeriods FROM timetable WHERE classID = ?");
if (!$stmt) {
    echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}
$stmt->bind_param("i", $classID);
$stmt->execute();
$result = $stmt->get_result();
$maxPeriodsRow = $result->fetch_assoc();
$maxPeriods = $maxPeriodsRow['maxPeriods'] ?? 0;
$stmt->close();

if ($maxPeriods == 0) {
    echo '<p class="text-red-500">Error: No periods defined for this class</p>';
    exit;
}

// Fetch attendance data with faculty and subject information
$stmt = $conn->prepare("
    SELECT a.date, a.periodNumber, a.status, s.subjectName, lc.name as facultyName
    FROM attendance a
    JOIN timetable t ON t.classID = ? 
        AND t.periodNumber = a.periodNumber 
        AND t.dayOfWeek = DAYNAME(a.date)
    JOIN subject s ON s.facultyID = t.facultyID
    JOIN faculty f ON f.facultyID = t.facultyID
    JOIN logincredentials lc ON lc.userID = f.userID
    WHERE a.studentID = ? 
        AND a.date BETWEEN ? AND ?
");
if (!$stmt) {
    echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
    exit;
}
$stmt->bind_param("iiss", $classID, $studID, $startDate, $endDate);
$stmt->execute();
$attendanceResult = $stmt->get_result();

// Organize attendance data
$attendanceData = [];
while ($row = $attendanceResult->fetch_assoc()) {
    $date = $row['date'];
    $period = $row['periodNumber'];
    $attendanceData[$date][$period] = [
        'status' => $row['status'],
        'subjectName' => $row['subjectName'],
        'facultyName' => $row['facultyName']
    ];
}

// Generate date range for the table rows
$interval = new DateInterval('P1D');
$periodRange = new DatePeriod($start, $interval, $end->modify('+1 day')); // Include end date

echo '<table class="w-full border-collapse border border-gray-300">';
echo '<thead><tr class="bg-gray-100">';
echo '<th class="border p-2 text-center">Date</th>';
for ($period = 1; $period <= $maxPeriods; $period++) {
    echo '<th class="border p-2 text-center">Period ' . $period . '</th>';
}
echo '</tr></thead>';
echo '<tbody>';

foreach ($periodRange as $date) {
    $dateStr = $date->format('Y-m-d');
    echo '<tr>';
    echo '<td class="border p-2 text-center">' . htmlspecialchars($dateStr) . '</td>';
    for ($period = 1; $period <= $maxPeriods; $period++) {
        $data = $attendanceData[$dateStr][$period] ?? [];
        $status = $data['status'] ?? '';
        $tooltip = '';
        if ($status) {
            $subjectName = htmlspecialchars($data['subjectName'] ?? 'Unknown Subject');
            $facultyName = htmlspecialchars($data['facultyName'] ?? 'Unknown Faculty');
            $tooltip = 'title="Subject: ' . $subjectName . ' | Faculty: ' . $facultyName . '"';
        }

        if ($status === 'present') {
            echo '<td class="border p-2 text-center text-green-500" ' . $tooltip . '>P</td>';
        } elseif ($status === 'absent') {
            echo '<td class="border p-2 text-center text-red-500" ' . $tooltip . '>A</td>';
        } elseif ($status === 'dl') {
            echo '<td class="border p-2 text-center text-blue-500" ' . $tooltip . '>DL</td>';
        } else {
            echo '<td class="border p-2 text-center"></td>'; // No record
        }
    }
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

$stmt->close();
$conn->close();
