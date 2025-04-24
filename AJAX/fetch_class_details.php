<?php
include '../connection.php';
session_start();

$classID = isset($_POST['classID']) ? $conn->real_escape_string($_POST['classID']) : '';
$instituteID = $_SESSION['instituteID'];

if (empty($classID)) {
    echo "Error: No class ID provided.";
    exit;
}

$query = "SELECT c.className, lc.name AS staffAdvisorName 
         FROM class c
         LEFT JOIN faculty f ON c.facultyID = f.facultyID
         LEFT JOIN logincredentials lc ON f.userID = lc.userID
         WHERE c.classID = ? AND c.instituteID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $classID, $instituteID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "<tr class='bg-white border-b' id='row-$classID'>
    <td class='px-6 py-4'>" . htmlspecialchars($row['className']) . "</td>
    <td class='px-6 py-4'>" . ($row['staffAdvisorName'] ? htmlspecialchars($row['staffAdvisorName']) : 'None') . "</td>
    <td class='px-6 py-4'>
        <button class='edit-btn text-blue-600 hover:text-blue-900 mr-2' data-class-id='$classID'>Edit</button>
        <button class='save-btn hidden text-green-600 hover:text-green-900 mr-2' data-class-id='$classID'>Save</button>
    </td>
</tr>";

$stmt->close();
$conn->close();
