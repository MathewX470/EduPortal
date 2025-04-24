<?php
include("session_start.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include("connection.php");

$userID1 = $_SESSION['userID'];

$query = "SELECT * FROM logincredentials WHERE userID=$userID1";
$result = $conn->query($query);
if (!$result) {
    echo "Query not executed";
} else {
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
    } else {
        echo "<script>alert('Error accessing institute details.');</script>";
    }
}

$_SESSION['instituteID'] = $result['instituteID'];
$instituteID1 = $_SESSION['instituteID'];

$query = "SELECT * FROM institute WHERE instituteID=$instituteID1";
$result = $conn->query($query);
if (!$result) {
    echo "Query not executed";
} else {
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
    } else {
        echo "<script>alert('Error accessing institute details.');</script>";
    }
}
$_SESSION['instituteName'] = $result['name'];
$_SESSION['location'] = $result['location'];

$query = "SELECT * FROM student WHERE userID=$userID1";
$result = $conn->query($query);
if (!$result) {
    echo "Query not executed";
} else {
    if ($result->num_rows > 0) {
        $result = $result->fetch_assoc();
    } else {
        echo "<script>alert('Error accessing faculty details.');</script>";
    }
}
$_SESSION['studID'] = $result['studID'];
$_SESSION['classID'] = $result['classID'];


// Fetch number of periods for the student's class
$query = "SELECT numPeriods FROM class WHERE classID = " . $_SESSION['classID'];
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $classRow = $result->fetch_assoc();
    $_SESSION['numPeriods'] = $classRow['numPeriods'];
} else {
    $_SESSION['numPeriods'] = 8; // Fallback to 8 periods if not found
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#64748b'
                    },
                    borderRadius: {
                        'none': '0px',
                        'sm': '4px',
                        DEFAULT: '8px',
                        'md': '12px',
                        'lg': '16px',
                        'xl': '20px',
                        '2xl': '24px',
                        '3xl': '32px',
                        'full': '9999px',
                        'button': '8px'
                    }
                }
            }
        }
    </script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        .dropdown {
            display: none;
        }

        .show {
            display: block;
        }
    </style>
</head>

<body class="bg-gray-50">
    <nav class="fixed top-0 z-50 w-full bg-gray-900 border-b border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebar" class="inline-flex items-center p-2 text-sm text-gray-300 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-600">
                        <i class="ri-menu-line text-xl"></i>
                    </button>
                    <span class="ml-3 text-xl font-semibold text-white">Student Panel</span>
                </div>

                <?php include 'notification_JS.php'; ?>
                <div class="flex items-center ml-auto space-x-4">
                    <div class="relative cursor-pointer" id="notificationIcon" onclick="toggleNotifications()">
                        <i class="ri-notification-3-line text-gray-600 ri-lg"></i>
                        <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center hidden">0</span>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-100 z-50">
                            <div class="p-4 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="font-medium">Notifications</h3>
                                <button onclick="markAllRead()" class="text-xs text-primary hover:underline">Mark all as read</button>
                            </div>
                            <div id="notificationList" class="max-h-96 overflow-y-auto"></div>
                        </div>
                    </div>

                    <div class="relative">
                        <button id="profileButton" class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-800 text-white">
                            <div class="w-8 h-8 flex items-center justify-center bg-primary text-white rounded-full">
                                <i class="ri-user-line"></i>
                            </div>
                            <span><?php echo $_SESSION['name']; ?></span>
                            <i class="ri-arrow-down-s-line"></i>
                        </button>
                        <div id="profileDropdown" class="dropdown absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" onclick="showContent('changePassword')"><i class="ri-lock-password-line mr-2"></i>Change Password</a>
                            <hr class="my-1">
                            <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100"><i class="ri-logout-box-line mr-2"></i>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <ul class="space-y-2 font-medium">
                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('studentDetail')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">Student Details</span></a></li>

                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('attendenceSubmenu')">
                        <i class="ri-team-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Attendence</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="attendenceSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('periodWiseAtt')">Period Wise</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('overallAtt')">Overall</a></li>
                    </ul>
                </li>


                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('result')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">Results</span></a></li>

                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('leaveApplicationSubmenu')">
                        <i class="ri-team-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Leave Application</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="leaveApplicationSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('leaveApplication')">Apply</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('appliedLeaves')">Applied Leaves</a></li>
                    </ul>
                </li>

                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('viewTimetable')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">View TimeTable</span></a></li>



            </ul>
        </div>
    </aside>
    <div class="p-4 sm:ml-64 pt-20 transition-all duration-300" id="mainContent">
        <br><br><br>
        <div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
            <h2 class="text-2xl font-bold mb-4">Welcome to Student Panel</h2>
            <h2 class="text-2xl font-bold mb-4">Welcome, <?php echo $_SESSION['name']; ?></h2>
            <p class="text-gray-600">Select an option from the sidebar to get started.</p>
        </div>
    </div>
    <script>
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');
        const toggleSidebarButton = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        profileButton.addEventListener('click', () => {
            profileDropdown.classList.toggle('show');
        });
        document.addEventListener('click', (e) => {
            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
        toggleSidebarButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            const mainContent = document.getElementById('mainContent');
            mainContent.classList.toggle('sm:ml-64');
            mainContent.classList.toggle('sm:ml-0');
        });

        function toggleSubmenu(id) {
            const submenu = document.getElementById(id);
            submenu.classList.toggle('hidden');
        }

        function showContent(page) {
            const mainContent = document.getElementById('mainContent');
            let content = '';
            switch (page) {
                case 'studentDetail':
                    // Start building the content
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Student Details</h2>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-600"><b>Name:</b> <?php echo $_SESSION['name']; ?></p>
            <p class="text-gray-600"><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
            <p class="text-gray-600"><b>Role:</b> <?php echo $_SESSION['role']; ?></p><br>
            <?php
            include("connection.php");

            $userID = $_SESSION['userID'];

            // Query to get class name and main faculty
            $classQuery = "SELECT c.className, lc.name as facultyName
                           FROM student s
                           JOIN class c ON s.classID = c.classID
                           JOIN faculty f ON c.facultyID = f.facultyID
                           JOIN logincredentials lc ON f.userID = lc.userID
                           WHERE s.userID = ? AND s.instituteID = ? AND c.instituteID = ?";
            $stmt = $conn->prepare($classQuery);
            if (!$stmt) {
                echo '<p class="text-red-600">Query preparation failed: ' . htmlspecialchars($conn->error) . '</p>';
            } else {
                $instituteID = $_SESSION['instituteID'];
                $stmt->bind_param("iii", $userID, $instituteID, $instituteID);
                $stmt->execute();
                $classResult = $stmt->get_result();

                if ($classResult->num_rows > 0) {
                    $classRow = $classResult->fetch_assoc();
                    $className = $classRow['className'];
                    $facultyName = $classRow['facultyName'];

                    echo '<p class="text-gray-600"><b>Class Name:</b> ' . htmlspecialchars($className) . '</p>';
                    echo '<p class="text-gray-600"><b>Main Faculty:</b> ' . htmlspecialchars($facultyName) . '</p>';
                } else {
                    echo '<p class="text-gray-600"><b>Class Name:</b> Not assigned</p>';
                    echo '<p class="text-gray-600"><b>Main Faculty:</b> Not assigned</p>';
                }
                $stmt->close();
            }
            ?>
            <br>
            <p class="text-gray-600"><b>Institution Name:</b> <?php echo $_SESSION['instituteName']; ?></p>
            <p class="text-gray-600"><b>Location:</b> <?php echo $_SESSION['location']; ?></p>
        </div>
    </div>
    <?php
    // Query to get student details including parentID
    $studentQuery = "SELECT parentID FROM student WHERE userID = '$userID'";
    $studentResult = mysqli_query($conn, $studentQuery);

    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
        $studentRow = mysqli_fetch_assoc($studentResult);
        $parentID = $studentRow['parentID'];

        // Query to get parent userID from parent table
        $parentQuery = "SELECT userID FROM parent WHERE parentID = '$parentID'";
        $parentResult = mysqli_query($conn, $parentQuery);

        if ($parentResult && mysqli_num_rows($parentResult) > 0) {
            $parentRow = mysqli_fetch_assoc($parentResult);
            $parentUserID = $parentRow['userID'];

            // Query to get parent details from logincredentials
            $parentDetailsQuery = "SELECT name, email FROM logincredentials WHERE userID = '$parentUserID'";
            $parentDetailsResult = mysqli_query($conn, $parentDetailsQuery);

            if ($parentDetailsResult && mysqli_num_rows($parentDetailsResult) > 0) {
                $parentDetails = mysqli_fetch_assoc($parentDetailsResult);
                $parentName = $parentDetails['name'];
                $parentEmail = $parentDetails['email'];

                // Append parent details to the content
                echo '<h2 class="text-2xl font-bold mt-6 mb-4">Parent Details</h2>';
                echo '<div class="grid grid-cols-2 gap-4">';
                echo '<div>';
                echo '<p class="text-gray-600"><b>Name:</b> ' . $parentName . '</p>';
                echo '<p class="text-gray-600"><b>Email:</b> ' . $parentEmail . '</p>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<p class="text-red-600 mt-4">Parent details not found.</p>';
            }
        } else {
            echo '<p class="text-red-600 mt-4">Parent record not found.</p>';
        }
    } else {
        echo '<p class="text-red-600 mt-4">Student record not found.</p>';
    }
    $conn->close();
    ?>
</div>`;
                    break;

                case 'periodWiseAtt':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">Period-Wise Attendance</h2>
    <?php
    include("connection.php");

    $studID = $_SESSION['studID'];
    $instituteID = $_SESSION['instituteID'];

    // Fetch the student's classID
    $stmt = $conn->prepare("SELECT classID FROM student WHERE studID = ? AND instituteID = ?");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("ii", $studID, $instituteID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">No class assigned to you.</div>';
        } else {
            $class = $classResult->fetch_assoc();
            $classID = $class['classID'];

            echo '<div class="mb-4">';
            echo '<label for="startDate" class="block text-sm font-medium text-gray-700">Start Date:</label>';
            echo '<input type="date" id="startDate" name="startDate" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required>';
            echo '</div>';
            echo '<div class="mb-4">';
            echo '<label for="endDate" class="block text-sm font-medium text-gray-700">End Date:</label>';
            echo '<input type="date" id="endDate" name="endDate" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required>';
            echo '</div>';
            echo '<button id="fetchAttendance" class="mt-2 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600">View Attendance</button>';
            echo '<div id="attendanceOutput" class="mt-4"></div>';
            echo '<input type="hidden" id="classID" value="' . htmlspecialchars($classID) . '">';
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>`;
                    break;

                case 'overallAtt':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">Overall Attendance</h2>
    <?php
    include("connection.php");

    $studID = $_SESSION['studID'];
    $instituteID = $_SESSION['instituteID']; // Assuming instituteID is in session

    // Fetch the student's classID and name
    $stmt = $conn->prepare("SELECT classID, s.userID, lc.name FROM student s JOIN logincredentials lc ON s.userID = lc.userID WHERE s.studID = ? AND s.instituteID = ?");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("ii", $studID, $instituteID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">No class assigned to you.</div>';
        } else {
            $student = $classResult->fetch_assoc();
            $classID = $student['classID'];
            $studentName = $student['name'];
            $stmt->close();

            // Query to get attendance details
            $query = "SELECT 
                        s.subjectName,
                        COUNT(DISTINCT CONCAT(a.date, a.periodNumber)) AS TH,
                        COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) AS AH,
                        COUNT(CASE WHEN a.studentID = ? AND a.status = 'dl' THEN 1 END) AS DL,
                        (COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) + 
                         COUNT(CASE WHEN a.studentID = ? AND a.status = 'dl' THEN 1 END)) AS AH_DL,
                        ROUND(
                            (COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) / 
                             COUNT(DISTINCT CONCAT(a.date, a.periodNumber))) * 100, 
                            2
                        ) AS AH_percentage,
                        ROUND(
                            ((COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) + 
                              COUNT(CASE WHEN a.studentID = ? AND a.status = 'dl' THEN 1 END)) / 
                             COUNT(DISTINCT CONCAT(a.date, a.periodNumber))) * 100, 
                            2
                        ) AS AH_DL_percentage
                    FROM 
                        subject s
                        JOIN timetable t ON s.facultyID = t.facultyID
                        JOIN attendance a ON a.periodNumber = t.periodNumber 
                            AND DAYNAME(a.date) = t.dayOfWeek
                    WHERE 
                        t.classID = ?
                    GROUP BY 
                        s.subjectID, s.subjectName
                    HAVING 
                        TH > 0
                    UNION ALL
                    SELECT 
                        'Total' AS subjectName,
                        SUM(TH) AS TH,
                        SUM(AH) AS AH,
                        SUM(DL) AS DL,
                        SUM(AH_DL) AS AH_DL,
                        ROUND((SUM(AH) / SUM(TH)) * 100, 2) AS AH_percentage,
                        ROUND((SUM(AH_DL) / SUM(TH)) * 100, 2) AS AH_DL_percentage
                    FROM (
                        SELECT 
                            s.subjectName,
                            COUNT(DISTINCT CONCAT(a.date, a.periodNumber)) AS TH,
                            COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) AS AH,
                            COUNT(CASE WHEN a.studentID = ? AND a.status = 'dl' THEN 1 END) AS DL,
                            (COUNT(CASE WHEN a.studentID = ? AND a.status = 'present' THEN 1 END) + 
                             COUNT(CASE WHEN a.studentID = ? AND a.status = 'dl' THEN 1 END)) AS AH_DL
                        FROM 
                            subject s
                            JOIN timetable t ON s.facultyID = t.facultyID
                            JOIN attendance a ON a.periodNumber = t.periodNumber 
                                AND DAYNAME(a.date) = t.dayOfWeek
                        WHERE 
                            t.classID = ?
                        GROUP BY 
                            s.subjectID, s.subjectName
                        HAVING 
                            TH > 0
                    ) AS subquery
                    ORDER BY 
                        subjectName";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiiiiiiiiiii", $studID, $studID, $studID, $studID, $studID, $studID, $studID, $classID, $studID, $studID, $studID, $studID, $classID);
            $stmt->execute();
            $result = $stmt->get_result();

            // Display attendance table
            echo "<h3 class='text-lg font-semibold mb-2'>Student: " . htmlspecialchars($studentName) . " - Class: " . htmlspecialchars($classID) . "</h3>";
            echo "<h4 class='text-lg font-semibold mb-2'>Attendance Report till the date: " . date('Y-m-d') . "</h4>";
            echo '<div class="overflow-x-auto">';
            echo '<p class="text-sm text-gray-600 mb-2">TH: Total Conducted Periods | AH: Attended Periods | DL: Duty Leave Periods | AH+DL: Attended + Duty Leave Periods | AH%: Attendance Percentage | AH+DL%: Attendance + Duty Leave Percentage</p>';
            echo '<h3 class="text-lg font-semibold mb-2">CONSOLIDATED REPORT</h3>';
            echo '<table class="w-full text-sm text-left text-gray-500 border-collapse">';
            echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
            echo '<tr>';
            echo '<th class="px-4 py-2 border text-center">Course Name</th>';
            echo '<th class="px-4 py-2 border text-center">TH</th>';
            echo '<th class="px-4 py-2 border text-center">AH</th>';
            echo '<th class="px-4 py-2 border text-center">DL</th>';
            echo '<th class="px-4 py-2 border text-center">AH+DL</th>';
            echo '<th class="px-4 py-2 border text-center">AH%</th>';
            echo '<th class="px-4 py-2 border text-center">AH+DL%</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo "<tr class='bg-white border-b" . ($row['subjectName'] === 'Total' ? " font-bold" : "") . "'>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['subjectName']) . "</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['TH']) . "</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['AH']) . "</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['DL']) . "</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['AH_DL']) . "</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['AH_percentage']) . "%</td>";
                echo "<td class='px-4 py-2 border text-center'>" . htmlspecialchars($row['AH_DL_percentage']) . "%</td>";
                echo "</tr>";
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>`;
                    break;

                case 'result':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">Results</h2>
    <?php
    include("connection.php");

    $studID = $_SESSION['studID'];
    $instituteID = $_SESSION['instituteID']; // Assuming instituteID is in session

    // Fetch the student's classID and name
    $stmt = $conn->prepare("SELECT classID, s.userID, lc.name FROM student s JOIN logincredentials lc ON s.userID = lc.userID WHERE s.studID = ? AND s.instituteID = ?");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("ii", $studID, $instituteID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">No class assigned to you.</div>';
        } else {
            $student = $classResult->fetch_assoc();
            $classID = $student['classID'];
            $studentName = $student['name'];
            $stmt->close();

            // Fetch all exams for the student's class
            $stmt = $conn->prepare("SELECT DISTINCT e.examID, e.examName FROM exam e WHERE e.classID = ?");
            if (!$stmt) {
                echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
            } else {
                $stmt->bind_param("i", $classID);
                $stmt->execute();
                $examResult = $stmt->get_result();

                if ($examResult->num_rows == 0) {
                    echo '<div class="p-6 text-center text-gray-500">No exams found for your class.</div>';
                } else {
                    echo "<h3 class='text-lg font-semibold mb-2'>Student: " . htmlspecialchars($studentName) . " - Class: " . htmlspecialchars($classID) . "</h3>";
                    while ($exam = $examResult->fetch_assoc()) {
                        $examID = $exam['examID'];
                        $examName = $exam['examName'];

                        // Fetch results for the exam
                        $stmtResult = $conn->prepare("
                            SELECT s.subjectName, r.markObtained, es.totalMarks
                            FROM result r
                            JOIN exam_subject es ON r.examID = es.examID AND r.subjectID = es.subjectID
                            JOIN subject s ON r.subjectID = s.subjectID
                            WHERE r.studentID = ? AND r.examID = ? AND r.classID = ?
                        ");
                        $stmtResult->bind_param("iii", $studID, $examID, $classID);
                        $stmtResult->execute();
                        $resultData = $stmtResult->get_result();

                        if ($resultData->num_rows == 0) {
                            echo "<p class='text-gray-500 mb-4'>No results available for " . htmlspecialchars($examName) . "</p>";
                        } else {
                            $totalObtained = 0;
                            $totalMax = 0;

                            echo "<h4 class='text-lg font-semibold mb-2 mt-4'>" . htmlspecialchars($examName) . "</h4>";
                            echo '<table class="w-full text-sm text-left text-gray-500 border-collapse">';
                            echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
                            echo '<tr>';
                            echo '<th class="px-4 py-2 border text-center">Subject Name</th>';
                            echo '<th class="px-4 py-2 border text-center">Marks Obtained</th>';
                            echo '<th class="px-4 py-2 border text-center">Max Marks</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            while ($row = $resultData->fetch_assoc()) {
                                $obtained = $row['markObtained'] ?? 0;
                                $max = $row['totalMarks'] ?? 0;
                                $totalObtained += $obtained;
                                $totalMax += $max;

                                echo '<tr class="bg-white border-b">';
                                echo '<td class="px-4 py-2 border text-center">' . htmlspecialchars($row['subjectName']) . '</td>';
                                echo '<td class="px-4 py-2 border text-center">' . htmlspecialchars($obtained) . '</td>';
                                echo '<td class="px-4 py-2 border text-center">' . htmlspecialchars($max) . '</td>';
                                echo '</tr>';
                            }

                            // Total row
                            echo '<tr class="font-bold bg-gray-100">';
                            echo '<td class="px-4 py-2 border text-center">Total</td>';
                            echo '<td class="px-4 py-2 border text-center">' . htmlspecialchars($totalObtained) . '</td>';
                            echo '<td class="px-4 py-2 border text-center">' . htmlspecialchars($totalMax) . '</td>';
                            echo '</tr>';

                            // Percentage row
                            $percentage = $totalMax > 0 ? ($totalObtained / $totalMax) * 100 : 0;
                            echo '<tr class="font-bold bg-gray-100">';
                            echo '<td class="px-4 py-2 border text-center">Percentage</td>';

                            echo '<td class="px-4 py-2 border text-center" colspan="2">' . number_format($percentage, 2) . '%</td>';
                            echo '</tr>';

                            echo '</tbody>';
                            echo '</table>';
                        }
                        $stmtResult->close();
                    }
                }
                $stmt->close();
            }
        }
        $conn->close();
    }
    ?>
</div>`;
                    break;


                case 'viewTimetable':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Timetable</h2>
    <?php
    include("connection.php");

    $studID = $_SESSION['studID'];
    $instituteID = $_SESSION['instituteID'];

    // Fetch the student's classID
    $stmt = $conn->prepare("SELECT classID FROM student WHERE studID = ? AND instituteID = ?");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("ii", $studID, $instituteID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">No class assigned to you.</div>';
        } else {
            $class = $classResult->fetch_assoc();
            $classID = $class['classID'];
            $stmt->close();

            // Get the maximum number of periods for the class
            $stmt = $conn->prepare("SELECT MAX(periodNumber) as maxPeriods FROM timetable WHERE classID = ? AND instituteID = ?");
            $stmt->bind_param("ii", $classID, $instituteID);
            $stmt->execute();
            $result = $stmt->get_result();
            $maxPeriodsRow = $result->fetch_assoc();
            $maxPeriods = $maxPeriodsRow['maxPeriods'] ?? 0;
            $stmt->close();

            if ($maxPeriods == 0) {
                echo '<div class="p-6 text-center text-gray-500">No timetable defined for your class.</div>';
            } else {
                // Fetch timetable data
                $stmt = $conn->prepare("
                    SELECT t.dayOfWeek, t.periodNumber, s.subjectName, lc.name as facultyName
                    FROM timetable t
                    JOIN subject s ON t.facultyID = s.facultyID
                    JOIN faculty f ON t.facultyID = f.facultyID
                    JOIN logincredentials lc ON f.userID = lc.userID
                    WHERE t.classID = ? AND t.instituteID = ?
                ");
                $stmt->bind_param("ii", $classID, $instituteID);
                $stmt->execute();
                $timetableResult = $stmt->get_result();

                // Organize timetable data
                $timetableData = [];
                while ($row = $timetableResult->fetch_assoc()) {
                    $timetableData[$row['dayOfWeek']][$row['periodNumber']] = [
                        'subjectName' => $row['subjectName'],
                        'facultyName' => $row['facultyName']
                    ];
                }

                // Define days
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

                // Generate the table
                echo '<table class="w-full border-collapse border border-gray-300">';
                echo '<thead><tr class="bg-gray-100">';
                echo '<th class="border p-2 text-center">Day</th>';
                for ($period = 1; $period <= $maxPeriods; $period++) {
                    echo '<th class="border p-2 text-center">Period ' . $period . '</th>';
                }
                echo '</tr></thead>';
                echo '<tbody>';

                foreach ($days as $day) {
                    echo '<tr>';
                    echo '<td class="border p-2 text-center">' . htmlspecialchars($day) . '</td>';
                    for ($period = 1; $period <= $maxPeriods; $period++) {
                        $data = $timetableData[$day][$period] ?? [];
                        $content = '';
                        if (!empty($data)) {
                            $content = htmlspecialchars($data['facultyName']) . ' (' . htmlspecialchars($data['subjectName']) . ')';
                        }
                        echo '<td class="border p-2 text-center">' . $content . '</td>';
                    }
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            }
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>`;
                    break;


                case 'leaveApplication':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Leave Application</h2>
    <?php
    $sLeaveApply = 0;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitLeave'])) {
        $sLeaveApply = 0;
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $reason = $_POST['reason'];
        $periods = isset($_POST['periods']) ? implode(',', $_POST['periods']) : NULL; // Convert array to comma-separated string
        $userID = $_SESSION['userID'];

        // Validate inputs
        if (empty($startDate) || empty($endDate) || empty($reason)) {
            echo '<p class="text-red-600 mt-4" id="leaveMessage">Cannot submit: All fields (Start Date, End Date, Reason) must be filled.</p>';
        } elseif (strtotime($startDate) > strtotime($endDate)) {
            echo '<p class="text-red-600 mt-4" id="leaveMessage">Cannot submit: Start date (' . htmlspecialchars($startDate) . ') must be less than or equal to end date (' . htmlspecialchars($endDate) . ').</p>';
        } elseif (empty($periods)) {
            echo '<p class="text-red-600 mt-4" id="leaveMessage">Cannot submit: At least one period must be selected.</p>';
        } else {
            include("connection.php");

            // Query to get studID from student table (using prepared statement for security)
            $stmt = $conn->prepare("SELECT studID FROM student WHERE userID = ?");
            $stmt->bind_param("i", $userID);
            $stmt->execute();
            $studentResult = $stmt->get_result();

            if ($studentResult && $studentResult->num_rows > 0) {
                $studentRow = $studentResult->fetch_assoc();
                $studID = $studentRow['studID'];

                // Handle file upload
                $filePath = NULL;
                if (isset($_FILES['leaveFile']) && $_FILES['leaveFile']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'uploads/';
                    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                    $fileName = 'duty_leave_' . $studID . '_' . time() . '.' . pathinfo($_FILES['leaveFile']['name'], PATHINFO_EXTENSION);
                    $filePath = $uploadDir . $fileName;

                    if (!move_uploaded_file($_FILES['leaveFile']['tmp_name'], $filePath)) {
                        $filePath = NULL;
                        echo '<p class="text-red-600 mt-4">Failed to upload file.</p>';
                    }
                }

                // Insert into leaveapplication table with periods
                $insertStmt = $conn->prepare("INSERT INTO leaveapplication (studID, startDate, endDate, reason, filePath, periods, status) 
                                              VALUES (?, ?, ?, ?, ?, ?, 'pending')");
                $insertStmt->bind_param("isssss", $studID, $startDate, $endDate, $reason, $filePath, $periods);
                if ($insertStmt->execute()) {
                    //success
                    $sLeaveApply = 1;
                } else {
                    //Fail
                    $sLeaveApply = 2;
                }
                $insertStmt->close();
            } else {
                echo '<p class="text-red-600 mt-4" id="leaveMessage">Student record not found.</p>';
            }
            $stmt->close();
        }
    }
    ?>
    <form action="studentPanel.php?content=leaveApplication" id="leaveForm" method="POST" enctype="multipart/form-data" class="space-y-4">
        <div>
            <label class="block text-gray-700">Start Date:</label>
            <input type="date" name="startDate" class="w-full p-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700">End Date:</label>
            <input type="date" name="endDate" class="w-full p-2 border rounded" required>
        </div>
        <div>
            <label class="block text-gray-700">Select Periods for Duty Leave (at least one required):</label>
            <div class="grid grid-cols-4 gap-2">
                <?php
                $numPeriods = $_SESSION['numPeriods'];
                for ($i = 1; $i <= $numPeriods; $i++) {
                    echo '<label class="flex items-center">';
                    echo '<input type="checkbox" name="periods[]" value="' . $i . '" class="mr-2">';
                    echo 'Period ' . $i;
                    echo '</label>';
                }
                ?>
            </div>
        </div>
        <div>
            <label class="block text-gray-700">Reason:</label>
            <textarea name="reason" class="w-full p-2 border rounded" rows="3" maxlength="255" required></textarea>
        </div>
        <div>
            <label class="block text-gray-700">Upload File (e.g., Duty Leave Proof):</label>
            <input type="file" name="leaveFile" class="w-full p-2 border rounded" accept=".pdf,.doc,.docx,.jpg,.png" required>
        </div>
        <button type="submit" name="submitLeave" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit Application</button>
    </form>
</div>`;

                    var jsLeaveApply = <?php echo $sLeaveApply ?>;

                    if (jsLeaveApply == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Leave application submitted successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (jsLeaveApply == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to submit leave application!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    jsLeaveApply = 0;
                    break;

                case 'appliedLeaves':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Applied Leaves</h2>
    <?php
    include("connection.php");
    $studID = $_SESSION['studID'];
    $sdeleteLeave = 0;

    // Handle deletion if deleteID is set in URL
    if (isset($_GET['deleteID'])) {
        $sdeleteLeave = 0;
        $leaveID = $_GET['deleteID'];

        // Ensure the leave application belongs to the student
        $stmt = $conn->prepare("SELECT filePath FROM leaveapplication WHERE leaveID = ? AND studID = ?");
        $stmt->bind_param("ii", $leaveID, $studID);
        $stmt->execute();
        $fileResult = $stmt->get_result();

        if ($fileRow = $fileResult->fetch_assoc()) {
            $filePath = $fileRow['filePath'];
            if ($filePath && file_exists($filePath)) {
                unlink($filePath); // Delete the file
            }

            // Delete the record
            $deleteStmt = $conn->prepare("DELETE FROM leaveapplication WHERE leaveID = ? AND studID = ?");
            $deleteStmt->bind_param("ii", $leaveID, $studID);
            if ($deleteStmt->execute()) {
                echo ' ';
                $sdeleteLeave = 1;
            } else {
                echo '<p class="text-red-600 mt-4">Failed to delete leave application.</p>';
                $sdeleteLeave = 2;
            }
            $deleteStmt->close();
        }
        $stmt->close();
    }

    // Query to get all leave applications for the current student
    $stmt = $conn->prepare("SELECT leaveID, startDate, endDate,periods, reason, filePath,appliedDate, status 
                            FROM leaveapplication 
                            WHERE studID = ?");
    $stmt->bind_param("i", $studID);
    $stmt->execute();
    $leaveResult = $stmt->get_result();

    if ($leaveResult && $leaveResult->num_rows > 0) {
        echo '<div class="overflow-x-auto">';
        echo '<table class="min-w-full bg-white border">';
        echo '<thead>';
        echo '<tr>';
        echo '<th class="px-4 py-2 border">Sl No</th>';
        echo '<th class="px-4 py-2 border">Start Date</th>';
        echo '<th class="px-4 py-2 border">End Date</th>';
        echo '<th class="px-4 py-2 border">Periods</th>';
        echo '<th class="px-4 py-2 border">Reason</th>';
        echo '<th class="px-4 py-2 border">File</th>';
        echo '<th class="px-4 py-2 border">Applied On</th>';
        echo '<th class="px-4 py-2 border">Status</th>';
        echo '<th class="px-4 py-2 border">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $serialNo = 1;
        while ($row = $leaveResult->fetch_assoc()) {
            // Determine status class
            $statusClass = '';
            switch ($row['status']) {
                case 'pending':
                    $statusClass = 'bg-gray-200 text-gray-800';
                    break;
                case 'approved':
                    $statusClass = 'bg-green-200 text-green-800';
                    break;
                case 'rejected':
                    $statusClass = 'bg-red-200 text-red-800';
                    break;
            }

            echo '<tr>';
            echo '<td class="px-4 py-2 border">' . $serialNo++ . '</td>';
            echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['startDate']) . '</td>';
            echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['endDate']) . '</td>';
            echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['periods']) . '</td>';
            echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['reason']) . '</td>';
            echo '<td class="px-4 py-2 border">';
            if ($row['filePath']) {
                echo '<a href="' . htmlspecialchars($row['filePath']) . '" target="_blank" class="text-blue-500 hover:underline">View</a>';
            } else {
                echo 'No File';
            }
            echo '</td>';
            echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['appliedDate']) . '</td>';
            echo '<td class="px-4 py-2 border"><span class="inline-block px-2 py-1 rounded ' . $statusClass . '">' . htmlspecialchars($row['status']) . '</span></td>';
            echo '<td class="px-4 py-2 border">';
            if ($row['status'] == 'pending') {
                echo '<a href="?content=appliedLeaves&deleteID=' . $row['leaveID'] . '" class="text-red-600 hover:text-red-800" onclick="return confirm(\'Are you sure you want to delete this application?\')">Delete</a>';
            } else {
                echo '-';
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p class="text-gray-600">No leave applications found.</p>';
    }
    $stmt->close();
    ?>
</div>`;
                    var sdeleteLeave = <?php echo $sdeleteLeave ?>;

                    if (sdeleteLeave == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Leave application deleted successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (sdeleteLeave == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to delete leave application.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    sdeleteLeave = 0;
                    break;


                case 'changePassword':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Change Password</h2>
    <?php
    $cChangePassword = 0;
    include("connection.php");

    $userID = $_SESSION['userID'];
    $error = '';
    $success = '';
    $sChangePassword = false; // Initialize the flag

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updatePassword'])) {
        $cChangePassword = 0;
        $currentPassword = $_POST['currentPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        // Validate inputs
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $error = 'All fields are required.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New password and confirm password do not match.';
        } else {
            // Fetch the current hashed password from the database
            $stmt = $conn->prepare("SELECT password FROM logincredentials WHERE userID = ?");
            if (!$stmt) {
                $error = 'Database error: ' . htmlspecialchars($conn->error);
            } else {
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    $error = 'User not found.';
                } else {
                    $row = $result->fetch_assoc();
                    $storedPassword = $row['password'];

                    // Verify the current password
                    if (!password_verify($currentPassword, $storedPassword)) {
                        $error = 'Current password is incorrect.';
                    } else {
                        // Hash the new password
                        $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

                        // Update the password in the database
                        $updateStmt = $conn->prepare("UPDATE logincredentials SET password = ? WHERE userID = ?");
                        if (!$updateStmt) {
                            $error = 'Database error: ' . htmlspecialchars($conn->error);
                        } else {
                            $updateStmt->bind_param("si", $newPasswordHash, $userID);
                            if ($updateStmt->execute()) {
                                $cChangePassword = 1;
                                //$success = 'Password updated successfully.';
                                $sChangePassword = true; // Set the flag on success
                            } else {
                                $cChangePassword = 2;
                                //$error = 'Failed to update password: ' . htmlspecialchars($updateStmt->error);
                            }
                            $updateStmt->close();
                        }
                    }
                }
                $stmt->close();
            }
        }
    }
    ?>

    <?php if ($error): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <form class="max-w-lg" method="POST" action="?content=changePassword">
        <input type="hidden" name="updatePassword" value="1">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="currentPassword">Current Password</label>
            <input type="password" id="currentPassword" name="currentPassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="newPassword">New Password</label>
            <input type="password" id="newPassword" name="newPassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="confirmPassword">Confirm New Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <button type="submit" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Update Password</button>
    </form>

    
    </div>`;

                    var cChangePassword = <?php echo $cChangePassword ?>;

                    if (cChangePassword == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Password updated successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cChangePassword == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error updating password.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    cChangePassword = 0;

                    break;


                default:
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Welcome to Admin Panel</h2>
    <p class="text-gray-600">Select an option from the sidebar to get started.</p>
</div>`;
            }
            mainContent.innerHTML = content;
            profileDropdown.classList.remove('show');
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get("content");
            if (content) {
                showContent(content);
            }
        });

        // Add this after the existing showContent function
        document.addEventListener('DOMContentLoaded', function() {
            // Existing DOMContentLoaded code...

            // Add leave form handling
            const leaveForm = document.getElementById('leaveForm');
            if (leaveForm) {
                leaveForm.addEventListener('submit', function(e) {
                    // Check if submission was successful
                    setTimeout(() => {
                        const leaveMessage = document.getElementById('leaveMessage');
                        if (leaveMessage && leaveMessage.classList.contains('text-green-600')) {
                            leaveForm.reset();
                        }
                    }, 100); // Small delay to allow PHP to process
                });
            }
        });


        $(document).ready(function() {
            $(document).on('click', '#fetchAttendance', function() {
                let startDate = $('#startDate').val();
                let endDate = $('#endDate').val();
                let classID = $('#classID').val();

                if (!startDate || !endDate) {
                    $('#attendanceOutput').html('<p class="text-red-500">Please select both start and end dates.</p>');
                    return;
                }

                $.ajax({
                    url: 'AJAX/view_period_attendance_ajax.php',
                    type: 'POST',
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                        classID: classID
                    },
                    success: function(response) {
                        $('#attendanceOutput').html(response);
                    },
                    error: function(xhr, status, error) {
                        $('#attendanceOutput').html('<p class="text-red-500">Error loading attendance: ' + error + '</p>');
                    }
                });
            });
        });
    </script>
</body>

</html>