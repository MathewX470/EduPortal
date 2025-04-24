
<?php   
session_start();
header('Content-Type: application/json'); // Force JSON response

include '../connection.php';

if (!isset($_POST['classID']) || !isset($_SESSION['instituteID'])) {
    echo json_encode(['error' => 'Invalid request: Missing classID or instituteID']);
    exit;
}

$classID = $conn->real_escape_string($_POST['classID']);
$instituteID = $_SESSION['instituteID'];

$query = "SELECT f.facultyID, lc.name, s.subjectName 
          FROM faculty f
          JOIN logincredentials lc ON f.userID = lc.userID
          LEFT JOIN subject s ON f.facultyID = s.facultyID
          WHERE f.instituteID = ? 
          AND (f.facultyID IN (SELECT facultyID FROM class WHERE classID = ?) 
               OR f.facultyID IN (SELECT facultyID FROM class_faculty WHERE classID = ?))";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmt->bind_param("iii", $instituteID, $classID, $classID);
if (!$stmt->execute()) {
    echo json_encode(['error' => 'Execute failed: ' . $stmt->error]);
    exit;
}
$result = $stmt->get_result();

$facultyList = [];
while ($row = $result->fetch_assoc()) {
    $facultyList[] = [
        'facultyID' => htmlspecialchars($row['facultyID']),
        'name' => htmlspecialchars($row['name']),
        'subjectName' => htmlspecialchars($row['subjectName'] ?? 'No Subject')
    ];
}

$stmt->close();
$conn->close();

ob_clean(); // Clear any stray output before JSON
echo json_encode($facultyList);
?>