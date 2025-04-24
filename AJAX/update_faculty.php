<?php
include '../connection.php';

if (isset($_POST['facultyID']) && isset($_POST['name']) && isset($_POST['subjectName']) && isset($_POST['email'])) {
    $facultyID = $conn->real_escape_string($_POST['facultyID']);
    $name = $conn->real_escape_string($_POST['name']);
    $subjectName = $conn->real_escape_string($_POST['subjectName']);
    $email = $conn->real_escape_string($_POST['email']);

    try {
        $conn->begin_transaction();

        // Update logincredentials
        $stmt = $conn->prepare("UPDATE logincredentials lc
                                JOIN faculty f ON lc.userID = f.userID
                                SET lc.name = ?, lc.email = ?
                                WHERE f.facultyID = ?");
        $stmt->bind_param("sss", $name, $email, $facultyID);
        $stmt->execute();
        $stmt->close();

        // Update subject
        $stmt = $conn->prepare("UPDATE subject SET subjectName = ? WHERE facultyID = ?");
        $stmt->bind_param("ss", $subjectName, $facultyID);
        $stmt->execute();
        $stmt->close();

        $conn->commit();
        echo "success";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $conn->close();
} else {
    echo "Invalid input";
}
