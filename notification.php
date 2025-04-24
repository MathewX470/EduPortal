<?php
session_start();
include 'connection.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['userID'];
$action = $_REQUEST['action'] ?? 'get';

try {
    switch ($action) {
        case 'get':
            $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
            $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
            $unread_only = isset($_GET['unread_only']) && $_GET['unread_only'] === 'true';

            $count_stmt = $conn->prepare("SELECT COUNT(*) AS unread_count FROM notifications WHERE userID = ? AND isRead = 0");
            if (!$count_stmt) {
                throw new Exception("Unread count query failed: " . $conn->error);
            }

            $count_stmt->bind_param("i", $user_id);
            $count_stmt->execute();
            $unread_count = $count_stmt->get_result()->fetch_assoc()['unread_count'];

            if ($limit === 0) {
                echo json_encode(['success' => true, 'unread_count' => $unread_count, 'notifications' => []]);
                exit;
            }

            $query = "SELECT notificationID, message, type, isRead, createdAt FROM notifications WHERE userID = ?" .
                ($unread_only ? " AND isRead = 0" : "") .
                " ORDER BY notificationID Desc LIMIT ? OFFSET ?";

            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Fetch notifications query failed: " . $conn->error);
            }

            $stmt->bind_param("iii", $user_id, $limit, $offset);
            $stmt->execute();
            $result = $stmt->get_result();

            $notifications = [];
            while ($row = $result->fetch_assoc()) {
                $row['formatted_date'] = (new DateTime($row['createdAt']))->format('M j, g:i a');
                $notifications[] = $row;
            }

            echo json_encode([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unread_count,
                'total' => count($notifications)
            ]);
            break;

        case 'mark':
            if (isset($_POST['notification_id'])) {
                $notification_id = intval($_POST['notification_id']);
                $stmt = $conn->prepare("UPDATE notifications SET isRead = 1 WHERE notificationID = ? AND userID = ?");
                if (!$stmt) {
                    throw new Exception("Mark as read query failed: " . $conn->error);
                }

                $stmt->bind_param("ii", $notification_id, $user_id);
                $stmt->execute();
                echo json_encode(['success' => $stmt->affected_rows > 0, 'message' => 'Notification marked as read']);
            } elseif (isset($_POST['mark_all']) && $_POST['mark_all'] === 'true') {
                $stmt = $conn->prepare("UPDATE notifications SET isRead = 1 WHERE userID = ? AND isRead = 0");
                if (!$stmt) {
                    throw new Exception("Mark all as read query failed: " . $conn->error);
                }

                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                echo json_encode(['success' => true, 'message' => 'All notifications marked as read', 'affected_rows' => $stmt->affected_rows]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    error_log("Error in notification.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred',
        'error' => $e->getMessage() // Displays actual error in response
    ]);
}

$conn->close();
