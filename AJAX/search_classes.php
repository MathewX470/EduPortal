<?php
include '../connection.php';
session_start();

$searchTerm = isset($_POST['searchTerm']) ? $conn->real_escape_string($_POST['searchTerm']) : '';
$instituteID = $_SESSION['instituteID'];

$query = "SELECT c.classID, c.className, lc.name AS staffAdvisorName 
          FROM class c
          LEFT JOIN faculty f ON c.facultyID = f.facultyID
          LEFT JOIN logincredentials lc ON f.userID = lc.userID
          WHERE c.instituteID = ?";
if (!empty($searchTerm)) {
    $query .= " AND c.className LIKE ?";
    $stmt = $conn->prepare($query);
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("is", $instituteID, $likeTerm);
} else {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $instituteID);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classID = htmlspecialchars($row['classID']);
        echo "<tr class='bg-white border-b' id='row-$classID'>
            <td class='px-6 py-4'>" . htmlspecialchars($row['className']) . "</td>
            <td class='px-6 py-4'>" . ($row['staffAdvisorName'] ? htmlspecialchars($row['staffAdvisorName']) : 'None') . "</td>
            <td class='px-6 py-4'>
                <button class='edit-btn text-blue-600 hover:text-blue-900 mr-2' data-class-id='$classID'>Edit</button>
                <button class='save-btn hidden text-green-600 hover:text-green-900 mr-2' data-class-id='$classID'>Save</button>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='3' class='px-6 py-4 text-center'>No classes found</td></tr>";
}

$stmt->close();
$conn->close();
