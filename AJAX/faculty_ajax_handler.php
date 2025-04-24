<?php
session_start();
include("../connection.php"); // Adjusted path to reach parent directory

// Set content type to HTML for AJAX responses
header('Content-Type: text/html; charset=UTF-8');

$action = $_POST['action'] ?? '';
if (empty($action)) {
    echo "Error: No action specified";
    exit;
}

switch ($action) {
    case 'get_exams':
        $classID = $_POST['classID'] ?? '';
        if (empty($classID) || !is_numeric($classID)) {
            echo '<option value="">Error: Invalid or missing class ID</option>';
            exit;
        }

        // Prepare query to fetch exams for the selected class
        $stmt = $conn->prepare("SELECT examID, examName FROM exam WHERE classID = ?");
        if (!$stmt) {
            echo '<option value="">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</option>';
            exit;
        }
        $stmt->bind_param("i", $classID);
        if (!$stmt->execute()) {
            echo '<option value="">Error: Query execution failed - ' . htmlspecialchars($stmt->error) . '</option>';
            $stmt->close();
            exit;
        }
        $result = $stmt->get_result();

        // Output exam options
        echo '<option value="">-- Select an Exam --</option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['examID']) . '">' . htmlspecialchars($row['examName']) . '</option>';
            }
        } else {
            echo '<option value="">No exams found for this class</option>';
        }
        $stmt->close();
        break;

    case 'get_students_and_subject':
        $classID = $_POST['classID'] ?? '';
        $examID = $_POST['examID'] ?? '';
        $facultyID = $_POST['facultyID'] ?? '';

        if (empty($classID) || empty($examID) || empty($facultyID) || !is_numeric($classID) || !is_numeric($examID) || !is_numeric($facultyID)) {
            echo '<p class="text-red-500">Error: Missing or invalid parameters</p>';
            exit;
        }

        // Get subject taught by this faculty for the exam
        $stmt = $conn->prepare("
            SELECT s.subjectID, s.subjectName, es.totalMarks
            FROM subject s
            JOIN exam_subject es ON s.subjectID = es.subjectID
            WHERE s.facultyID = ? AND es.examID = ?
        ");
        if (!$stmt) {
            echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
            exit;
        }
        $stmt->bind_param("ii", $facultyID, $examID);
        $stmt->execute();
        $subjectResult = $stmt->get_result();

        if ($subjectResult->num_rows == 0) {
            echo '<p class="text-red-500">You are not assigned a subject for this exam.</p>';
            $stmt->close();
            exit;
        }

        $subject = $subjectResult->fetch_assoc();
        $subjectID = $subject['subjectID'];
        $totalMarks = $subject['totalMarks'];
        $stmt->close();

        // Get students and their existing results
        $stmt = $conn->prepare("
            SELECT s.studID, s.RollNo, lc.name, r.markObtained
            FROM student s
            JOIN logincredentials lc ON s.userID = lc.userID
            LEFT JOIN result r ON s.studID = r.studentID 
                AND r.examID = ? AND r.subjectID = ? AND r.classID = ?
            WHERE s.classID = ?
            ORDER BY s.RollNo
        ");
        if (!$stmt) {
            echo '<p class="text-red-500">Error: Database prepare failed - ' . htmlspecialchars($conn->error) . '</p>';
            exit;
        }
        $stmt->bind_param("iiii", $examID, $subjectID, $classID, $classID);
        $stmt->execute();
        $studentResult = $stmt->get_result();

        // Check for existing results
        $hasResults = false;
        while ($row = $studentResult->fetch_assoc()) {
            if ($row['markObtained'] !== null) {
                $hasResults = true;
                break;
            }
        }
        $studentResult->data_seek(0); // Reset pointer

        // Output student table
        echo '<div ' . ($hasResults ? 'data-existing="true"' : '') . '>';
        echo '<input type="hidden" name="examID" value="' . htmlspecialchars($examID) . '">';
        echo '<input type="hidden" name="subjectID" value="' . htmlspecialchars($subjectID) . '">';
        echo '<input type="hidden" name="classID" value="' . htmlspecialchars($classID) . '">';
        echo '<table class="w-full border-collapse border border-gray-300">';
        echo '<thead><tr class="bg-gray-100">';
        echo '<th class="border p-2">Roll No</th>';
        echo '<th class="border p-2">Name</th>';
        echo '<th class="border p-2">Marks Obtained</th>';
        echo '<th class="border p-2">Max Marks</th>';
        echo '</tr></thead>';
        echo '<tbody>';
        while ($row = $studentResult->fetch_assoc()) {
            $markObtained = $row['markObtained'] !== null ? htmlspecialchars($row['markObtained']) : '';
            echo '<tr>';
            echo '<td class="border p-2">' . htmlspecialchars($row['RollNo']) . '</td>';
            echo '<td class="border p-2">' . htmlspecialchars($row['name']) . '</td>';
            echo '<td class="border p-2"><input type="number" name="marks[' . htmlspecialchars($row['studID']) . ']" value="' . $markObtained . '" min="0" max="' . htmlspecialchars($totalMarks) . '" step="0.01" class="w-full p-1 border rounded" required></td>';
            echo '<td class="border p-2"><input type="number" value="' . htmlspecialchars($totalMarks) . '" class="w-full p-1 bg-gray-100" readonly></td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
        $stmt->close();
        break;

    case 'submit_results':
        $examID = $_POST['examID'] ?? '';
        $subjectID = $_POST['subjectID'] ?? '';
        $classID = $_POST['classID'] ?? '';
        $marks = $_POST['marks'] ?? [];
        $instituteID = $_SESSION['instituteID'] ?? '';

        if (empty($examID) || empty($subjectID) || empty($classID) || empty($instituteID) || empty($marks)) {
            echo 'Error: Missing required data';
            exit;
        }

        $conn->begin_transaction();
        try {
            // Fetch the exam name
            $stmtExam = $conn->prepare("SELECT examName FROM exam WHERE examID = ?");
            $stmtExam->bind_param("i", $examID);
            $stmtExam->execute();
            $examData = $stmtExam->get_result()->fetch_assoc();
            $examName = $examData['examName'] ?? 'Unknown Exam';
            $stmtExam->close();

            // Fetch the subject name
            $stmtSubject = $conn->prepare("SELECT subjectName FROM subject WHERE subjectID = ?");
            $stmtSubject->bind_param("i", $subjectID);
            $stmtSubject->execute();
            $subjectData = $stmtSubject->get_result()->fetch_assoc();
            $subjectName = $subjectData['subjectName'] ?? 'Unknown Subject';
            $stmtSubject->close();

            $stmt = $conn->prepare("
                INSERT INTO result (studentID, instituteID, subjectID, examID, classID, markObtained, totalMark)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE markObtained = VALUES(markObtained), totalMark = VALUES(totalMark)
            ");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            foreach ($marks as $studID => $markObtained) {
                // Fetch total marks for the subject
                $stmt2 = $conn->prepare("SELECT totalMarks FROM exam_subject WHERE examID = ? AND subjectID = ?");
                $stmt2->bind_param("ii", $examID, $subjectID);
                $stmt2->execute();
                $totalMark = $stmt2->get_result()->fetch_assoc()['totalMarks'] ?? 0;
                $stmt2->close();

                // Insert or update the result
                $stmt->bind_param("iiiiidd", $studID, $instituteID, $subjectID, $examID, $classID, $markObtained, $totalMark);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed: " . $stmt->error);
                }

                // Fetch student and parent userIDs
                $stmt3 = $conn->prepare("SELECT userID, parentID FROM student WHERE studID = ?");
                $stmt3->bind_param("i", $studID);
                $stmt3->execute();
                $studentData = $stmt3->get_result()->fetch_assoc();
                $studentUserID = $studentData['userID'] ?? null;
                $parentID = $studentData['parentID'] ?? null;
                $stmt3->close();

                // Prepare notification messages with exam and subject names
                $message = "Your result for $examName - $subjectName has been uploaded.";
                $messageParent = "Your child's result for $examName - $subjectName has been uploaded.";

                // Insert notification for the student
                if ($studentUserID) {
                    $notificationQuery = "INSERT INTO notifications (userID, message, type, isRead, createdAt) VALUES (?, ?, 'success', 0, NOW())";
                    $notificationStmt = $conn->prepare($notificationQuery);
                    $notificationStmt->bind_param("is", $studentUserID, $message);
                    $notificationStmt->execute();
                    $notificationStmt->close();
                }

                // Insert notification for the parent
                if ($parentID) {
                    $stmt4 = $conn->prepare("SELECT userID FROM parent WHERE parentID = ?");
                    $stmt4->bind_param("i", $parentID);
                    $stmt4->execute();
                    $parentData = $stmt4->get_result()->fetch_assoc();
                    $parentUserID = $parentData['userID'] ?? null;
                    $stmt4->close();

                    if ($parentUserID) {
                        $notificationStmt = $conn->prepare($notificationQuery);
                        $notificationStmt->bind_param("is", $parentUserID, $messageParent);
                        $notificationStmt->execute();
                        $notificationStmt->close();
                    }
                }
            }

            $conn->commit();
            echo 'success';
        } catch (Exception $e) {
            $conn->rollback();
            echo 'Error: ' . htmlspecialchars($e->getMessage());
        }
        $stmt->close();
        break;

    default:
        echo 'Error: Invalid action';
        break;
}

$conn->close();
