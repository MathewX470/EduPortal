<?php
header('Content-Type: text/html');
session_start();
include '../connection.php';

if (!isset($_SESSION['userID']) || !isset($_SESSION['instituteID'])) {
    echo "Session expired. Please log in again.";
    exit;
}

$instituteID = $_SESSION['instituteID'];
$userID = $_SESSION['userID'];

// Verify user is a faculty member
$query = "SELECT facultyID FROM faculty WHERE userID = ? AND instituteID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $userID, $instituteID);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    echo "Unauthorized access.";
    exit;
}
$facultyID = $result->fetch_assoc()['facultyID'];
$stmt->close();

if (isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'get_classes_and_periods':
            $date = $_POST['date'];
            $dayOfWeek = date('l', strtotime($date));

            // Fetch distinct class-period combinations for the faculty on this date
            $query = "SELECT t.classID, c.className, t.periodNumber 
                     FROM timetable t 
                     JOIN class c ON t.classID = c.classID 
                     WHERE t.instituteID = ? AND t.dayOfWeek = ? AND t.facultyID = ?
                     ORDER BY c.className, t.periodNumber";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("isi", $instituteID, $dayOfWeek, $facultyID);
            $stmt->execute();
            $result = $stmt->get_result();

            $html = '
                <div class="form-group mb-4" id="periodSection">
                    <label for="period" class="block text-sm font-medium text-gray-700">Select Class and Period:</label>
                    <select id="period" name="period" class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-gray-700" required>
                        <option value="">Select Class and Period</option>';
            while ($row = $result->fetch_assoc()) {
                $value = htmlspecialchars($row['classID'] . '|' . $row['periodNumber']);
                $display = htmlspecialchars($row['className'] . ' - ' . $row['periodNumber'] . 'th Period');
                $html .= "<option value='$value'>$display</option>";
            }
            $html .= '
                    </select>
                </div>
                <div id="studentSection" class="overflow-x-auto"></div>';
            echo $html;
            $stmt->close();
            break;

        case 'get_students':
            $date = $_POST['date'];
            list($classID, $period) = explode('|', $_POST['period']); // Split classID|periodNumber
            $dayOfWeek = date('l', strtotime($date));

            // Verify faculty authorization
            $query = "SELECT COUNT(*) FROM timetable WHERE instituteID = ? AND classID = ? AND dayOfWeek = ? AND periodNumber = ? AND facultyID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iisii", $instituteID, $classID, $dayOfWeek, $period, $facultyID);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            if ($count == 0) {
                echo "You are not authorized to mark attendance for this class and period.";
                exit;
            }

            // Fetch students
            $query = "SELECT s.studID, s.RollNo, lc.name AS studentName, a.status 
                     FROM student s 
                     JOIN logincredentials lc ON s.userID = lc.userID 
                     LEFT JOIN attendance a ON s.studID = a.studentID AND a.date = ? AND a.periodNumber = ?
                     WHERE s.instituteID = ? AND s.classID = ?
                     ORDER BY s.RollNo";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("siii", $date, $period, $instituteID, $classID);
            $stmt->execute();
            $result = $stmt->get_result();

            $existingAttendance = $result->num_rows > 0 && $result->fetch_assoc()['status'] !== null;
            $result->data_seek(0); // Reset result pointer

            $html = '
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-6 py-3">Roll No</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Present</th>
                        </tr>
                    </thead>
                    <tbody>';
            while ($row = $result->fetch_assoc()) {
                $checked = $existingAttendance ? ($row['status'] === 'present' ? 'checked' : '') : 'checked'; // Default checked unless already marked otherwise
                $disabled = $existingAttendance ? 'disabled' : '';
                $html .= "
                    <tr class='bg-white border-b'>
                        <td class='px-6 py-4'>" . htmlspecialchars($row['RollNo']) . "</td>
                        <td class='px-6 py-4'>" . htmlspecialchars($row['studentName']) . "</td>
                        <td class='px-6 py-4'>
                            <input type='checkbox' name='attendance[" . htmlspecialchars($row['studID']) . "]' value='present' 
                                   class='h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded' $checked $disabled>
                        </td>
                    </tr>";
            }
            $html .= '
                    </tbody>
                </table>
                <div class="mt-4">';
            if ($existingAttendance) {
                $html .= '<p class="text-red-600">Attendance already marked for this date and period.</p>';
            } else {
                $html .= '<button type="submit" class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Mark Attendance</button>';
            }
            $html .= '</div>';
            echo $html;
            $stmt->close();
            break;

        case 'submit_attendance':
            $date = $_POST['date'];
            list($classID, $period) = explode('|', $_POST['period']); // Split classID|periodNumber
            $attendance = isset($_POST['attendance']) ? $_POST['attendance'] : [];
            $dayOfWeek = date('l', strtotime($date));

            // Verify faculty authorization
            $query = "SELECT COUNT(*) FROM timetable WHERE instituteID = ? AND classID = ? AND dayOfWeek = ? AND periodNumber = ? AND facultyID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iisii", $instituteID, $classID, $dayOfWeek, $period, $facultyID);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            if ($count == 0) {
                echo "Unauthorized action.";
                exit;
            }

            // Check for existing attendance
            $query = "SELECT COUNT(*) FROM attendance WHERE date = ? AND periodNumber = ? AND studentID IN (SELECT studID FROM student WHERE classID = ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $date, $period, $classID);
            $stmt->execute();
            $stmt->bind_result($existing);
            $stmt->fetch();
            $stmt->close();
            if ($existing > 0) {
                echo "Attendance already marked for this period.";
                exit;
            }

            // Start transaction
            $conn->begin_transaction();

            try {
                // Insert attendance
                $query = "INSERT INTO attendance (studentID, date, periodNumber, status) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $studentQuery = "SELECT studID, userID, parentID FROM student WHERE classID = ? AND instituteID = ?";
                $studentStmt = $conn->prepare($studentQuery);
                $studentStmt->bind_param("ii", $classID, $instituteID);
                $studentStmt->execute();
                $studentResult = $studentStmt->get_result();

                $presentStudents = [];
                $absentStudents = [];
                while ($row = $studentResult->fetch_assoc()) {
                    $studentID = $row['studID'];
                    $status = isset($attendance[$studentID]) ? 'present' : 'absent'; // Checkbox checked = present, unchecked = absent
                    $stmt->bind_param("isis", $studentID, $date, $period, $status);
                    $stmt->execute();
                    if ($status === 'present') {
                        $presentStudents[] = $studentID;
                    } else {
                        $absentStudents[] = $studentID;
                    }
                }
                $stmt->close();
                $studentStmt->close();

                // Insert notifications for absent students and their parents
                foreach ($absentStudents as $studentID) {
                    $query = "SELECT userID, parentID FROM student WHERE studID = ? AND instituteID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("ii", $studentID, $instituteID);
                    $stmt->execute();
                    $stmt->bind_result($userID, $parentID);
                    $stmt->fetch();
                    $stmt->close();

                    // Insert notification for the student
                    $notificationMessage = "You were marked as absent for the class on " . date('Y-m-d', strtotime($date)) . " during period " . $period;
                    $notificationQuery = "INSERT INTO notifications (userID, message, type, isRead, createdAt) VALUES (?, ?, ?, ?, ?)";
                    $notificationStmt = $conn->prepare($notificationQuery);
                    $type = 'warning';
                    $isRead = 0; // Not read
                    $createdAt = date('Y-m-d H:i:s');
                    $notificationStmt->bind_param("issis", $userID, $notificationMessage, $type, $isRead, $createdAt);
                    $notificationStmt->execute();

                    // If a parent exists, notify them as well
                    if ($parentID) {
                        $stmt = $conn->prepare("SELECT userID FROM parent WHERE parentID = ?");
                        $stmt->bind_param("i", $parentID);
                        $stmt->execute();
                        $stmt->bind_result($parentUserID);
                        $stmt->fetch();
                        $stmt->close();

                        // Notify the parent
                        if ($parentUserID) {
                            $parentMessage = "Your child was marked as absent on " . date('Y-m-d', strtotime($date)) . " during period " . $period;
                            $notificationStmt->bind_param("issis", $parentUserID, $parentMessage, $type, $isRead, $createdAt); // Correct binding
                            $notificationStmt->execute();
                        }
                    }

                    $notificationStmt->close();
                }

                // Commit transaction
                $conn->commit();
                echo 'success';
            } catch (Exception $e) {
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }
            break;
    }
}
$conn->close();
