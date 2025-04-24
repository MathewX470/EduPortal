<?php
session_start();
include("../connection.php");

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    echo '<p class="text-red-600">Session expired. Please log in again.</p>';
    exit;
}

$facultyID = $_SESSION['facultyID'];
$instituteID = $_SESSION['instituteID'];

// Check if the faculty is a main advisor for any class
$queryCheck = "SELECT c.classID, c.className 
               FROM class c 
               WHERE c.facultyID = ? AND c.instituteID = ?";
$stmtCheck = $conn->prepare($queryCheck);
$stmtCheck->bind_param("ii", $facultyID, $instituteID);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();

if ($resultCheck->num_rows == 0) {
    echo '<p class="text-gray-600">You are not the main faculty of any class and cannot view overall attendance.</p>';
    $stmtCheck->close();
    $conn->close();
    exit;
}

$row = $resultCheck->fetch_assoc();
$classID = $row['classID'];
$className = $row['className'];
$stmtCheck->close();

// Get the roll number from the AJAX request
$rollNo = isset($_POST['rollNo']) ? $conn->real_escape_string($_POST['rollNo']) : '';

if (empty($rollNo)) {
    echo '<p class="text-red-600">Please enter a roll number.</p>';
    $conn->close();
    exit;
}

// Verify the student exists in the class and get their studID
$queryStudent = "SELECT s.studID, lc.name 
                 FROM student s 
                 JOIN logincredentials lc ON s.userID = lc.userID 
                 WHERE s.classID = ? AND s.RollNo = ? AND s.instituteID = ?";
$stmtStudent = $conn->prepare($queryStudent);
$stmtStudent->bind_param("isi", $classID, $rollNo, $instituteID);
$stmtStudent->execute();
$resultStudent = $stmtStudent->get_result();

if ($resultStudent->num_rows == 0) {
    echo '<p class="text-red-600">Invalid roll number or student not found in this class.</p>';
    $stmtStudent->close();
    $conn->close();
    exit;
}

$student = $resultStudent->fetch_assoc();
$studID = $student['studID'];
$studentName = $student['name'];
$stmtStudent->close();

// Get all subjects for the class (via timetable and subject table)
$querySubjects = "SELECT DISTINCT t.facultyID, s.subjectName
                 FROM timetable t
                 JOIN subject s ON t.facultyID = s.facultyID
                 WHERE t.classID = ?";
$stmtSubjects = $conn->prepare($querySubjects);
$stmtSubjects->bind_param("i", $classID);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();

$subjects = [];
while ($row = $resultSubjects->fetch_assoc()) {
    $subjects[] = [
        'facultyID' => $row['facultyID'],
        'subjectName' => $row['subjectName']
    ];
}

if (empty($subjects)) {
    echo '<p class="text-red-600">No subjects found for this class.</p>';
    $stmtSubjects->close();
    $conn->close();
    exit;
}

$stmtSubjects->close();

// Calculate attendance for the specific student (based on studID)
$attendanceData = [];
$totalTH = 0;
$totalAH = 0;
$totalDL = 0;

foreach ($subjects as $index => $subject) {
    $facultyID = $subject['facultyID'];

    // Calculate TH (total hours scheduled for the subject in the class)
    $queryTH = "SELECT COUNT(*) AS total_hours
                FROM timetable t
                WHERE t.classID = ? AND t.facultyID = ?";
    $stmtTH = $conn->prepare($queryTH);
    $stmtTH->bind_param("ii", $classID, $facultyID);
    $stmtTH->execute();
    $resultTH = $stmtTH->get_result();
    $totalHours = $resultTH->fetch_assoc()['total_hours'] ?? 0;
    $stmtTH->close();

    // Calculate AH and DL for the specific student
    $queryAttendance = "SELECT 
                        COUNT(CASE WHEN a.status = 'present' THEN 1 END) AS attended_hours,
                        COUNT(CASE WHEN a.status = 'dl' THEN 1 END) AS duty_leave
                       FROM timetable t
                       LEFT JOIN attendance a ON a.studentID = ? 
                           AND a.periodNumber = t.periodNumber 
                           AND DAYNAME(a.date) = t.dayOfWeek
                       WHERE t.classID = ? AND t.facultyID = ?";
    $stmtAttendance = $conn->prepare($queryAttendance);
    $stmtAttendance->bind_param("iii", $studID, $classID, $facultyID);
    $stmtAttendance->execute();
    $resultAttendance = $stmtAttendance->get_result();
    $attendance = $resultAttendance->fetch_assoc();
    $attendedHours = $attendance['attended_hours'] ?? 0;
    $dutyLeave = $attendance['duty_leave'] ?? 0;
    $stmtAttendance->close();

    // Calculate AH+DL, AH%, and AH+DL%
    $ahPlusDl = $attendedHours + $dutyLeave;
    $ahPercentage = $totalHours > 0 ? round(($attendedHours / $totalHours) * 100, 2) : 'N/A';
    $ahPlusDlPercentage = $totalHours > 0 ? round(($ahPlusDl / $totalHours) * 100, 2) : 'N/A';

    // Add to totals
    $totalTH += $totalHours;
    $totalAH += $attendedHours;
    $totalDL += $dutyLeave;

    // Store attendance data
    $attendanceData[] = [
        'slNo' => $index + 1,
        'courseName' => $subject['subjectName'],
        'TH' => $totalHours,
        'AH' => $attendedHours,
        'DL' => $dutyLeave,
        'AH_DL' => $ahPlusDl,
        'AH_percentage' => $ahPercentage,
        'AH_DL_percentage' => $ahPlusDlPercentage
    ];
}

// Calculate total percentages
$totalAHPercentage = $totalTH > 0 ? round(($totalAH / $totalTH) * 100, 2) : 'N/A';
$totalAHDLPercentage = $totalTH > 0 ? round((($totalAH + $totalDL) / $totalTH) * 100, 2) : 'N/A';

// Display the attendance data for the specific student
echo "<h3 class='text-lg font-semibold mb-2'>Student: " . htmlspecialchars($studentName) . " (Roll No: " . htmlspecialchars($rollNo) . ") - Class: " . htmlspecialchars($className) . "</h3>";
echo '<div class="overflow-x-auto">';
echo '<p class="text-sm text-gray-600 mb-2">TH: Total Hours | AH: Attended Hours | DL: Total Duty Leave Hours Taken | %AH: Attendance Percentage | %AH+DL: Attendance with Duty Leave Percentage</p>';
echo '<div class="flex justify-end mb-2">';
echo '<button class="bg-purple-600 text-white font-bold py-1 px-2 rounded hover:bg-purple-700 mr-2">Export</button>';
echo '<button class="bg-purple-600 text-white font-bold py-1 px-2 rounded hover:bg-purple-700">Print</button>';
echo '</div>';
echo '<h3 class="text-lg font-semibold mb-2">CONSOLIDATED REPORT</h3>';
echo '<table class="w-full text-sm text-left text-gray-500 border-collapse">';
echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
echo '<tr>';
echo '<th class="px-4 py-2 border">SL No.</th>';
echo '<th class="px-4 py-2 border">Course Name</th>';
echo '<th class="px-4 py-2 border">TH</th>';
echo '<th class="px-4 py-2 border">AH</th>';
echo '<th class="px-4 py-2 border">DL</th>';
echo '<th class="px-4 py-2 border">AH+DL</th>';
echo '<th class="px-4 py-2 border">AH%</th>';
echo '<th class="px-4 py-2 border">AH+DL%</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

foreach ($attendanceData as $data) {
    echo "<tr class='bg-white border-b'>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['slNo']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['courseName']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['TH']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['AH']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['DL']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['AH_DL']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['AH_percentage']) . "</td>";
    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($data['AH_DL_percentage']) . "</td>";
    echo "</tr>";
}

// Add total row
echo "<tr class='bg-white border-b font-bold'>";
echo "<td class='px-4 py-2 border'>Total</td>";
echo "<td class='px-4 py-2 border'>Total</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalTH) . "</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalAH) . "</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalDL) . "</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalAH + $totalDL) . "</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalAHPercentage) . "</td>";
echo "<td class='px-4 py-2 border'>" . htmlspecialchars($totalAHDLPercentage) . "</td>";
echo "</tr>";

echo '</tbody>';
echo '</table>';
echo '</div>';

$conn->close();
