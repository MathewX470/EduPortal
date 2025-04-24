<?php
include '../connection.php';

$query = "SELECT lc.name, lc.email, f.facultyID, s.subjectName 
          FROM faculty f
          JOIN logincredentials lc ON f.userID = lc.userID 
          JOIN subject s ON f.facultyID = s.facultyID
          WHERE lc.role = 'faculty'";

if (isset($_POST['namef']) && !empty($_POST['namef'])) {
    $searchTerm = $conn->real_escape_string($_POST['namef']);
    $query .= " AND lc.name LIKE ?";
    $stmt = $conn->prepare($query);
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("s", $likeTerm);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $facultyID = htmlspecialchars($row['facultyID']);
        $name = htmlspecialchars($row['name']);
        $subjectName = htmlspecialchars($row['subjectName']);
        $email = htmlspecialchars($row['email']);
        echo "<tr class='bg-white border-b' id='row-$facultyID'>
            <td class='px-6 py-4'>
                <span class='display-name'>$name</span>
                <input type='text' class='edit-name hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$name'>
            </td>
            <td class='px-6 py-4'>$facultyID</td>
            <td class='px-6 py-4'>
                <span class='display-subject'>$subjectName</span>
                <input type='text' class='edit-subject hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$subjectName'>
            </td>
            <td class='px-6 py-4'>
                <span class='display-contact'>$email</span>
                <input type='text' class='edit-contact hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$email'>
            </td>
            <td class='px-6 py-4'>
                <button class='edit-btn text-blue-600 hover:text-blue-900 mr-2' data-faculty-id='$facultyID'>Edit</button>
                <button class='save-btn hidden text-green-600 hover:text-green-900 mr-2' data-faculty-id='$facultyID'>Save</button>
            </td>
          </tr>";
    }
} else {
    echo "<tr><td colspan='5' class='px-6 py-4 text-center'>No faculty found</td></tr>";
}

$stmt->close();
$conn->close();
