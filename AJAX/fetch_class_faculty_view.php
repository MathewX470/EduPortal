<?php
include '../connection.php';
session_start();

$classID = isset($_POST['classID']) ? $conn->real_escape_string($_POST['classID']) : '';
$instituteID = $_SESSION['instituteID'];

if (empty($classID)) {
    echo "Error: No class ID provided.";
    exit;
}

// Fetch Main Staff Advisor
$query = "SELECT c.facultyID AS mainFacultyID, lc.name AS mainFacultyName, s.subjectName AS mainSubjectName 
         FROM class c
         LEFT JOIN faculty f ON c.facultyID = f.facultyID
         LEFT JOIN logincredentials lc ON f.userID = lc.userID
         LEFT JOIN subject s ON f.facultyID = s.facultyID
         WHERE c.classID = ? AND c.instituteID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $classID, $instituteID);
$stmt->execute();
$result = $stmt->get_result();
$mainFaculty = $result->fetch_assoc();
$stmt->close();

// Fetch Additional Faculty
$query = "SELECT cf.facultyID, lc.name AS facultyName, s.subjectName 
         FROM class_faculty cf
         JOIN faculty f ON cf.facultyID = f.facultyID
         JOIN logincredentials lc ON f.userID = lc.userID
         LEFT JOIN subject s ON f.facultyID = s.facultyID
         WHERE cf.classID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $classID);
$stmt->execute();
$result = $stmt->get_result();
$additionalFaculty = [];
while ($row = $result->fetch_assoc()) {
    $additionalFaculty[] = $row;
}
$stmt->close();

// Generate read-only view
echo "<tr class='view-row bg-gray-100'>
    <td colspan='3' class='px-6 py-4'>
        <div class='mb-4'>
            <label class='block text-gray-700 text-sm font-bold mb-2'>Main Staff Advisor</label>
            <p class='text-gray-700'>" . ($mainFaculty['mainFacultyName'] ? htmlspecialchars($mainFaculty['mainFacultyName'] . " (ID: " . $mainFaculty['mainFacultyID'] . ") - " . $mainFaculty['mainSubjectName']) : 'None') . "</p>
        </div>";
for ($i = 0; $i < 4; $i++) {
    $faculty = isset($additionalFaculty[$i]) ? $additionalFaculty[$i] : ['facultyName' => 'None', 'facultyID' => '', 'subjectName' => 'No Subject'];
    echo "  <div class='mb-4'>
                <label class='block text-gray-700 text-sm font-bold mb-2'>Faculty " . ($i + 1) . "</label>
                <p class='text-gray-700'>" . htmlspecialchars($faculty['facultyName'] . " (ID: " . $faculty['facultyID'] . ") - " . $faculty['subjectName']) . "</p>
            </div>";
}
echo "  </td>
</tr>";
