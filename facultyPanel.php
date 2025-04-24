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

$query = "SELECT * FROM faculty WHERE userID=$userID1";
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
$_SESSION['facultyID'] = $result['facultyID'];
$facultyID = $_SESSION['facultyID'];

$query = "SELECT * FROM class WHERE facultyID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $facultyID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Query not executed";
} else {
    if ($result->num_rows > 0) {
        $_SESSION['isMain'] = TRUE;
        $row = $result->fetch_assoc(); // Fetch the first row
        $_SESSION['classID'] = $row['classID'];
    } else {
        $_SESSION['isMain'] = FALSE;
        $_SESSION['classID'] = null; // Optional: Clear classID if no class found
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Panel</title>
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
                    <span class="ml-3 text-xl font-semibold text-white">Faculty Panel</span>
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
                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('facultyDetail')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">Faculty Detail</span></a></li>
                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('viewTimetable')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">Timetable</span></a></li>

                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('facultySubmenu')">
                        <i class="ri-user-2-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Attendance</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="facultySubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('markAtt')">Mark</a></li>
                        <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('viewAttendancesubmenu')">
                            <i class="ri-user-2-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">View</span><i class="ri-arrow-down-s-line"></i>
                        </button>
                        <ul id="viewAttendancesubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">

                            <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewAtt')">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspPeriod Wise</a></li>
                            <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewAttSubject')">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSubject Wise</a></li>
                            <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewAttOverall')">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCourse Wise</a></li>
                        </ul>

                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('resultSubmenu')">
                        <i class="ri-team-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Result</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="resultSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('uploadResult')">Upload</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewResult')">View</a></li>
                    </ul>
                </li>


                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('leaveApp')"><i class="ri-mail-line"></i><span class="ml-3">Leave Application</span></a></li>

            </ul>
        </div>
    </aside>
    <div class="p-4 sm:ml-64 pt-20 transition-all duration-300" id="mainContent">
        <br><br><br>
        <div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
            <h2 class="text-2xl font-bold mb-4">Welcome to Faculty Panel</h2>
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
                case 'facultyDetail':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
<h2 class="text-2xl font-bold mb-4">Faculty Details</h2>
<div class="grid grid-cols-2 gap-4">
<div>
<p class="text-gray-600"><b>Name:</b> <?php echo $_SESSION['name']; ?></p>
<p class="text-gray-600"><b>Email:</b> <?php echo $_SESSION['email']; ?></p>
<p class="text-gray-600"><b>Role:</b>  <?php echo $_SESSION['role']; ?></p>
</div>
<div>
<p class="text-gray-600"><b>Institution Name:</b> <?php echo $_SESSION['instituteName']; ?></p>
<p class="text-gray-600"><b>Institution Location:</b> <?php echo $_SESSION['location']; ?></p>
</div>
</div>
</div>`;
                    break;


                case 'viewTimetable':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Timetable</h2>
    <?php
    include("connection.php");

    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Fetch classes where the faculty is either the main teacher or an additional faculty
    $stmt = $conn->prepare("
        SELECT DISTINCT c.classID, c.className
        FROM class c
        LEFT JOIN class_faculty cf ON c.classID = cf.classID
        WHERE c.facultyID = ? OR cf.facultyID = ?
    ");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("ii", $facultyID, $facultyID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">You are not assigned to any classes.</div>';
        } else {
            echo '<div class="mb-4">';
            echo '<label for="classSelect" class="block text-sm font-medium text-gray-700">Select Class:</label>';
            echo '<select id="classSelect" name="classID" class="w-full py-2 px-4 border border-gray-300 rounded-lg" data-faculty-id="' . htmlspecialchars($facultyID) . '">';
            echo '<option value="">-- Select a Class --</option>';
            while ($row = $classResult->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['classID']) . '">' . htmlspecialchars($row['className']) . '</option>';
            }
            echo '</select>';
            echo '</div>';
            echo '<div id="timetableOutput" class="mt-4"></div>';
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>`;
                    break;



                    break;
                case 'markAtt':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Mark Attendance</h2>
    <form id="attendanceForm" class="mb-4">
        <div class="form-group mb-4">
            <label for="attDate" class="block text-sm font-medium text-gray-700">Select Date:</label>
            <input type="date" id="attDate" name="date" max="<?= date('Y-m-d'); ?>" class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-gray-700" required>
        </div>
        <div id="classPeriodSection" class="mb-4"></div>
    </form>
</div>`;

                    mainContent.innerHTML = content;
                    profileDropdown.classList.remove('show');
                    setTimeout(() => {
                        const attDate = document.getElementById('attDate');
                        const classPeriodSection = document.getElementById('classPeriodSection');
                        const attendanceForm = document.getElementById('attendanceForm');

                        attDate.addEventListener('change', async function() {
                            const date = this.value;
                            if (!date) {
                                alert('Please select a date');
                                return;
                            }
                            try {
                                const response = await fetch('AJAX/ajax_handler.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `action=get_classes_and_periods&date=${encodeURIComponent(date)}`
                                });
                                if (response.ok) {
                                    classPeriodSection.innerHTML = await response.text();

                                    const periodSelect = document.getElementById('period');
                                    const studentSection = document.getElementById('studentSection');

                                    periodSelect.addEventListener('change', async function() {
                                        const periodValue = this.value;
                                        if (!periodValue) {
                                            studentSection.innerHTML = '';
                                            return;
                                        }
                                        try {
                                            const response = await fetch('AJAX/ajax_handler.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: `action=get_students&date=${encodeURIComponent(date)}&period=${encodeURIComponent(periodValue)}`
                                            });
                                            if (response.ok) {
                                                studentSection.innerHTML = await response.text();
                                            } else {
                                                throw new Error('Failed to load students');
                                            }
                                        } catch (error) {
                                            console.error(error);
                                            alert('Error loading students');
                                        }
                                    });
                                } else {
                                    throw new Error('Failed to load classes and periods');
                                }
                            } catch (error) {
                                console.error(error);
                                alert('Error loading data');
                            }
                        });

                        attendanceForm.addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const formData = new FormData(this);
                            formData.append('action', 'submit_attendance');
                            try {
                                const response = await fetch('AJAX/ajax_handler.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await response.text();
                                if (result === 'success') {

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Attendance marked successfully.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });

                                    //alert('Attendance marked successfully!');
                                    this.reset();
                                    classPeriodSection.innerHTML = '';
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Error marking attendance.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    //alert('Error: ' + result);
                                }
                            } catch (error) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: 'Error marking attendance.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                console.error(error);
                                //alert('Failed to submit attendance');
                            }
                        });
                    }, 0);
                    return;

                    break;

                case 'viewAtt':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Attendance</h2>
    <?php
    include("connection.php");
    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Combined query for classes where faculty is either main advisor or additional faculty
    $queryClasses = "SELECT DISTINCT c.classID, c.className 
                     FROM class c 
                     LEFT JOIN class_faculty cf ON c.classID = cf.classID 
                     WHERE (c.facultyID = ? OR cf.facultyID = ?) AND c.instituteID = ?";
    $stmtClasses = $conn->prepare($queryClasses);
    $stmtClasses->bind_param("iii", $facultyID, $facultyID, $instituteID);
    $stmtClasses->execute();
    $resultClasses = $stmtClasses->get_result();

    if ($resultClasses->num_rows > 0) {
        // Class selection form
        echo '<form method="POST" action="facultyPanel.php?content=viewAtt" class="mb-6">';
        echo '<div class="mb-4">';
        echo '<label class="block text-gray-700 text-sm font-bold mb-2" for="classSelect">Select Class</label>';
        echo '<select name="classID" id="classSelect" class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="this.form.submit()" required>';
        echo '<option value="">-- Select a Class --</option>';

        while ($row = $resultClasses->fetch_assoc()) {
            $selected = (isset($_POST['classID']) && $_POST['classID'] == $row['classID']) ? 'selected' : '';
            echo "<option value='{$row['classID']}' $selected>{$row['className']}</option>";
        }

        echo '</select>';
        echo '</div>';

        // Date picker (shown only if class is selected)
        if (isset($_POST['classID']) && !empty($_POST['classID'])) {
            $classID = $_POST['classID'];
            echo '<div class="mb-4">';
            echo '<label class="block text-gray-700 text-sm font-bold mb-2" for="attendanceDate">Select Date</label>';
            echo '<input type="date" name="attendanceDate" id="attendanceDate" value="' . (isset($_POST['attendanceDate']) ? $_POST['attendanceDate'] : '') . '" class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="this.form.submit()" required>';
            echo '</div>';

            // Period selection (shown only if date is selected)
            if (isset($_POST['attendanceDate']) && !empty($_POST['attendanceDate'])) {
                $attendanceDate = $_POST['attendanceDate'];
                $dayOfWeek = date('l', strtotime($attendanceDate));

                // Fetch periods from timetable for this class and faculty on the selected day
                $queryPeriods = "SELECT DISTINCT periodNumber 
                                 FROM timetable 
                                 WHERE classID = ? AND instituteID = ? AND dayOfWeek = ? AND facultyID = ?";
                $stmtPeriods = $conn->prepare($queryPeriods);
                $stmtPeriods->bind_param("iisi", $classID, $instituteID, $dayOfWeek, $facultyID);
                $stmtPeriods->execute();
                $resultPeriods = $stmtPeriods->get_result();

                if ($resultPeriods->num_rows > 0) {
                    echo '<div class="mb-4">';
                    echo '<label class="block text-gray-700 text-sm font-bold mb-2" for="periodSelect">Select Period</label>';
                    echo '<select name="periodNumber" id="periodSelect" class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="this.form.submit()" required>';
                    echo '<option value="">-- Select a Period --</option>';

                    while ($row = $resultPeriods->fetch_assoc()) {
                        $selected = (isset($_POST['periodNumber']) && $_POST['periodNumber'] == $row['periodNumber']) ? 'selected' : '';
                        echo "<option value='{$row['periodNumber']}' $selected>{$row['periodNumber']}th Period</option>";
                    }

                    echo '</select>';
                    echo '</div>';
                } else {
                    echo '<p class="text-gray-600 mb-4">No periods scheduled for this class on this date.</p>';
                }
                $stmtPeriods->close();
            }

            // Show attendance records if class, date, and period are selected
            if (isset($_POST['periodNumber']) && !empty($_POST['periodNumber'])) {
                $periodNumber = $_POST['periodNumber'];

                // Verify faculty authorization for this class and period
                $verifyQuery = "SELECT COUNT(*) 
                                FROM timetable 
                                WHERE classID = ? AND periodNumber = ? AND facultyID = ? AND instituteID = ? AND dayOfWeek = ?";
                $verifyStmt = $conn->prepare($verifyQuery);
                $verifyStmt->bind_param("iiiis", $classID, $periodNumber, $facultyID, $instituteID, $dayOfWeek);
                $verifyStmt->execute();
                $verifyStmt->bind_result($count);
                $verifyStmt->fetch();
                $verifyStmt->close();

                if ($count > 0) {
                    // Fetch class name for display
                    $classNameQuery = "SELECT className FROM class WHERE classID = ?";
                    $classNameStmt = $conn->prepare($classNameQuery);
                    $classNameStmt->bind_param("i", $classID);
                    $classNameStmt->execute();
                    $className = $classNameStmt->get_result()->fetch_assoc()['className'];

                    echo "<h3 class='text-lg font-semibold mb-2'>Class: $className - {$periodNumber}th Period</h3>";
                    echo '<div class="overflow-x-auto">';
                    echo '<table class="w-full text-sm text-left text-gray-500">';
                    echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
                    echo '<tr>';
                    echo '<th class="px-6 py-3">Roll No</th>';
                    echo '<th class="px-6 py-3">Student Name</th>';
                    echo '<th class="px-6 py-3">Status</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    // Fetch students and their attendance for the selected class, date, and period
                    $queryAttendance = "SELECT s.studID, s.RollNo, lc.name, a.status 
                                        FROM student s 
                                        JOIN logincredentials lc ON s.userID = lc.userID 
                                        LEFT JOIN attendance a ON s.studID = a.studentID AND a.date = ? AND a.periodNumber = ?
                                        WHERE s.classID = ? AND s.instituteID = ?
                                        ORDER BY s.RollNo";
                    $stmtAttendance = $conn->prepare($queryAttendance);
                    $stmtAttendance->bind_param("siii", $attendanceDate, $periodNumber, $classID, $instituteID);
                    $stmtAttendance->execute();
                    $resultAttendance = $stmtAttendance->get_result();

                    if ($resultAttendance->num_rows > 0) {
                        while ($row = $resultAttendance->fetch_assoc()) {
                            $status = $row['status'] ?? 'Not Recorded';
                            $statusClass = $row['status'] === 'present' ? 'text-green-600' : ($row['status'] === 'absent' ? 'text-red-600' : 'text-gray-600');
                            echo "<tr class='bg-white border-b'>";
                            echo "<td class='px-6 py-4'>" . htmlspecialchars($row['RollNo']) . "</td>";
                            echo "<td class='px-6 py-4'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td class='px-6 py-4 $statusClass'>" . htmlspecialchars($status) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3' class='px-6 py-4 text-center'>No attendance records found for this class, date, and period.</td></tr>";
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                    $stmtAttendance->close();
                    $classNameStmt->close();
                } else {
                    echo '<p class="text-red-600 mb-4">You are not authorized to view attendance for this period.</p>';
                }
            }
        }
        echo '</form>';
    } else {
        echo '<p class="text-gray-600">You are not assigned to any classes.</p>';
    }

    $stmtClasses->close();
    $conn->close();
    ?>
</div>`;
                    break;

                case 'viewAttSubject':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Subject-Wise Attendance</h2>
    <?php
    include("connection.php");
    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Query to get classes where the faculty teaches (from timetable)
    $queryClasses = "SELECT DISTINCT c.classID, c.className 
                     FROM class c 
                     JOIN timetable t ON c.classID = t.classID 
                     WHERE t.facultyID = ? AND c.instituteID = ?";
    $stmtClasses = $conn->prepare($queryClasses);
    $stmtClasses->bind_param("ii", $facultyID, $instituteID);
    $stmtClasses->execute();
    $resultClasses = $stmtClasses->get_result();

    if ($resultClasses->num_rows > 0) {
        // Class selection form
        echo '<form method="POST" action="facultyPanel.php?content=viewAttSubject" class="mb-6">';
        echo '<div class="mb-4">';
        echo '<label class="block text-gray-700 text-sm font-bold mb-2" for="classSelect">Select Class</label>';
        echo '<select name="classID" id="classSelect" class="shadow border rounded w-full py-2 px-3 text-gray-700" onchange="this.form.submit()" required>';
        echo '<option value="">-- Select a Class --</option>';

        while ($row = $resultClasses->fetch_assoc()) {
            $selected = (isset($_POST['classID']) && $_POST['classID'] == $row['classID']) ? 'selected' : '';
            echo "<option value='{$row['classID']}' $selected>{$row['className']}</option>";
        }
        echo '</select>';
        echo '</div>';

        // Display attendance if class is selected
        if (isset($_POST['classID']) && !empty($_POST['classID'])) {
            $classID = $_POST['classID'];

            // Fetch class name and subject for display
            $queryDetails = "SELECT c.className, s.subjectName 
                             FROM class c 
                             LEFT JOIN subject s ON s.facultyID = ?
                             WHERE c.classID = ?";
            $stmtDetails = $conn->prepare($queryDetails);
            $stmtDetails->bind_param("ii", $facultyID, $classID);
            $stmtDetails->execute();
            $details = $stmtDetails->get_result()->fetch_assoc();
            $className = $details['className'];
            $subjectName = $details['subjectName'] ?? 'Subject Not Assigned';

            echo "<h3 class='text-lg font-semibold mb-2'>Class: $className - Subject: $subjectName</h3>";

            // Subject-wise attendance query
            $queryAttendance = "WITH SubjectAttendance AS (
                SELECT 
                    st.studID,
                    st.RollNo,
                    lc.name,
                    COUNT(CASE WHEN a.status = 'present' THEN 1 END) AS attended_hours,
                    COUNT(CASE WHEN a.status = 'dl' THEN 1 END) AS duty_leave
                FROM 
                    student st
                LEFT JOIN 
                    attendance a ON st.studID = a.studentID
                JOIN 
                    timetable t ON t.classID = st.classID 
                        AND t.periodNumber = a.periodNumber 
                        AND DAYNAME(a.date) = t.dayOfWeek
                JOIN 
                    logincredentials lc ON st.userID = lc.userID
                WHERE 
                    st.classID = ? 
                    AND t.facultyID = ?
                GROUP BY 
                    st.studID, st.RollNo, lc.name
            ),
            TotalSubjectHours AS (
                SELECT 
                    st.classID,
                    COUNT(DISTINCT CONCAT(a.date, '-', a.periodNumber)) AS total_hours
                FROM 
                    attendance a
                JOIN 
                    student st ON a.studentID = st.studID
                JOIN 
                    timetable t ON t.classID = st.classID 
                        AND t.periodNumber = a.periodNumber 
                        AND DAYNAME(a.date) = t.dayOfWeek
                WHERE 
                    st.classID = ? 
                    AND t.facultyID = ?
                GROUP BY 
                    st.classID
            )
            SELECT 
                a.RollNo AS 'rollnumber',
                a.name AS 'studentname',
                COALESCE(t.total_hours, 0) AS 'TH',
                a.attended_hours AS 'AH',
                a.duty_leave AS 'DL',
                (a.attended_hours + a.duty_leave) AS 'AH+DL',
                ROUND((a.attended_hours / NULLIF(t.total_hours, 0)) * 100, 2) AS 'AH%',
                ROUND(((a.attended_hours + a.duty_leave) / NULLIF(t.total_hours, 0)) * 100, 2) AS 'AH+DL%'
            FROM 
                SubjectAttendance a
            CROSS JOIN 
                TotalSubjectHours t
            ORDER BY 
                a.RollNo";

            $stmtAttendance = $conn->prepare($queryAttendance);
            $stmtAttendance->bind_param("iiii", $classID, $facultyID, $classID, $facultyID);
            $stmtAttendance->execute();
            $resultAttendance = $stmtAttendance->get_result();

            if ($resultAttendance->num_rows > 0) {
                echo '<div class="overflow-x-auto">';
                echo '<table class="w-full text-sm text-left text-gray-500">';
                echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
                echo '<tr>';
                echo '<th class="px-6 py-3">Roll Number</th>';
                echo '<th class="px-6 py-3">Student Name</th>';
                echo '<th class="px-6 py-3">TH</th>';
                echo '<th class="px-6 py-3">AH</th>';
                echo '<th class="px-6 py-3">DL</th>';
                echo '<th class="px-6 py-3">AH+DL</th>';
                echo '<th class="px-6 py-3">AH%</th>';
                echo '<th class="px-6 py-3">AH+DL%</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = $resultAttendance->fetch_assoc()) {
                    echo "<tr class='bg-white border-b'>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['rollnumber']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['studentname']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['TH']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['AH']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['DL']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['AH+DL']) . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['AH%'] ?? 'N/A') . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['AH+DL%'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p class="text-gray-600 mb-4">No attendance records found for this subject in this class.</p>';
            }

            $stmtAttendance->close();
            $stmtDetails->close();
        }

        echo '</form>';
    } else {
        echo '<p class="text-gray-600">You are not assigned to teach any classes.</p>';
    }

    $stmtClasses->close();
    $conn->close();
    ?>
</div>`;
                    break;

                case 'viewAttOverall':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Overall Attendance (Main Faculty)</h2>
    <?php
    include("connection.php");

    // Ensure the user is logged in
    if (!isset($_SESSION['userID'])) {
        echo '<p class="text-red-600">Session expired. Please log in again.</p>';
        exit;
    }

    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Check if the faculty is a main advisor for any class
    $queryCheck = "SELECT c.classID, c.className 
                   FROM class c 
                   WHERE c.facultyID = ? AND c.instituteID = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("ii", $facultyID, $instituteID);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        $row = $resultCheck->fetch_assoc();
        $classID = $row['classID'];
        $className = $row['className'];

        // Form for roll number input
        echo '<form method="POST" action="facultyPanel.php?content=viewAttOverall" class="mb-6">';
        echo '<div class="mb-4">';
        echo '<label class="block text-gray-700 text-sm font-bold mb-2" for="rollNo">Enter Roll Number</label>';
        echo '<input type="text" name="rollNo" id="rollNo" class="shadow border rounded w-full py-2 px-3 text-gray-700" placeholder="Enter Roll Number" required>';
        echo '</div>';
        echo '<button type="submit" name="viewAttendance" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700">View</button>';
        echo '</form>';

        // Handle form submission to display attendance
        if (isset($_POST['viewAttendance']) && isset($_POST['rollNo'])) {
            $rollNo = $conn->real_escape_string($_POST['rollNo']);

            if (empty($rollNo) || !is_numeric($rollNo) || $rollNo <= 0) {
                echo '<p class="text-red-600">Please enter a valid roll number.</p>';
            } else {
                // Verify the student exists in the class
                $queryStudent = "SELECT s.studID, lc.name 
                                 FROM student s 
                                 JOIN logincredentials lc ON s.userID = lc.userID 
                                 WHERE s.classID = ? AND s.RollNo = ? AND s.instituteID = ?";
                $stmtStudent = $conn->prepare($queryStudent);
                $stmtStudent->bind_param("iii", $classID, $rollNo, $instituteID);
                $stmtStudent->execute();
                $resultStudent = $stmtStudent->get_result();

                if ($resultStudent->num_rows == 0) {
                    echo '<p class="text-red-600">Invalid roll number or student not found in this class.</p>';
                } else {
                    $student = $resultStudent->fetch_assoc();
                    $studID = $student['studID'];
                    $studentName = $student['name'];
                    $stmtStudent->close();

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
                    echo "<h3 class='text-lg font-semibold mb-2'>Student: " . htmlspecialchars($studentName) . " (Roll No: " . htmlspecialchars($rollNo) . ") - Class: " . htmlspecialchars($className) . "</h3>";
                    echo "<h4 class='text-lg font-semibold mb-2'>Attendance Report till the date : " . date('Y-m-d') . "</h4>";
                    echo '<div class="overflow-x-auto">';
                    echo '<p class="text-sm text-gray-600 mb-2">TH: Total Conducted Periods | AH: Attended Periods | DL: Duty Leave Periods | AH+DL: Attended + Duty Leave Periods | AH%: Attendance Percentage | AH+DL%: Attendance + Duty Leave Percentage</p>';
                    echo '<h3 class="text-lg font-semibold mb-2">CONSOLIDATED REPORT</h3>';
                    echo '<table class="w-full text-sm text-left text-gray-500 border-collapse">';
                    echo '<thead class="text-xs text-gray-700 uppercase bg-gray-50">';
                    echo '<tr>';
                    echo '<th class="px-4 py-2 border">Course Name</th>';
                    echo '<th class="px-4 py-2 border">TH</th>';
                    echo '<th class="px-4 py-2 border">AH</th>';
                    echo '<th class="px-4 py-2 border">DL</th>';
                    echo '<th class="px-4 py-2 border">AH+DL</th>';
                    echo '<th class="px-4 py-2 border">AH%</th>';
                    echo '<th class="px-4 py-2 border">AH+DL%</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='bg-white border-b" . ($row['subjectName'] === 'Total' ? " font-bold" : "") . "'>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['subjectName']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['TH']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['AH']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['DL']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['AH_DL']) . "</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['AH_percentage']) . "%</td>";
                        echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['AH_DL_percentage']) . "%</td>";
                        echo "</tr>";
                    }

                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                }
            }
        }
    } else {
        echo '<p class="text-gray-600">You are not the main faculty of any class and cannot view overall attendance.</p>';
    }

    $stmtCheck->close();
    $conn->close();
    ?>
</div>`;

                    break;

                case 'uploadResult':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">Upload Results</h2>
    <?php
    $cUploadResult = 0;
    include("connection.php");

    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Fetch classes where the faculty is either the main teacher or an additional faculty with their subjects
    $stmt = $conn->prepare("
        SELECT DISTINCT c.classID, c.className, s.subjectName
        FROM class c
        LEFT JOIN class_faculty cf ON c.classID = cf.classID
        LEFT JOIN exam e ON c.classID = e.classID
        LEFT JOIN exam_subject es ON e.examID = es.examID
        LEFT JOIN subject s ON es.subjectID = s.subjectID AND s.facultyID = ?
        WHERE (c.facultyID = ? OR cf.facultyID = ?)
        AND s.subjectID IS NOT NULL -- Ensure a subject is assigned
    ");
    if (!$stmt) {
        echo '<div class="p-6 text-center text-red-500">Query preparation failed: ' . htmlspecialchars($conn->error) . '</div>';
    } else {
        $stmt->bind_param("iii", $facultyID, $facultyID, $facultyID);
        $stmt->execute();
        $classResult = $stmt->get_result();

        if ($classResult->num_rows == 0) {
            echo '<div class="p-6 text-center text-gray-500">You are not assigned to any classes with subjects.</div>';
        } else {
            echo '<div class="mb-4">';
            echo '<label for="classSelect" class="block text-sm font-medium text-gray-700">Select Class and Subject:</label>';
            echo '<select id="classSelect" name="classID" class="w-full py-2 px-4 border border-gray-300 rounded-lg" data-faculty-id="' . htmlspecialchars($facultyID) . '">';
            echo '<option value="">-- Select a Class and Subject --</option>';
            while ($row = $classResult->fetch_assoc()) {
                $displayText = htmlspecialchars($row['className'] ?? 'Unknown Class');
                if (!empty($row['subjectName'])) {
                    $displayText .= ' - ' . htmlspecialchars($row['subjectName']);
                }
                echo '<option value="' . htmlspecialchars($row['classID']) . '">' . $displayText . '</option>';
            }
            echo '</select>';
            echo '</div>';

            echo '<div id="examSection" class="mb-4 hidden">';
            echo '<label for="examSelect" class="block text-sm font-medium text-gray-700">Select Exam:</label>';
            echo '<select id="examSelect" name="examID" class="w-full py-2 px-4 border border-gray-300 rounded-lg">';
            echo '<option value="">-- Select an Exam --</option>';
            echo '</select>';
            echo '</div>';

            echo '<form id="resultForm" method="POST" class="hidden">';
            echo '<div id="editNotice" class="hidden mb-4 text-yellow-600">You are editing previously uploaded results.</div>';
            echo '<div id="studentResults" class="mt-4"></div>';
            echo '<button type="submit" class="mt-4 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600">Submit Results</button>';
            echo '</form>';
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</div>`;

                    break;

                case 'viewResult':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
    <h2 class="text-2xl font-bold mb-4">View Results</h2>
    <?php
    include("connection.php");

    $facultyID = $_SESSION['facultyID'];
    $instituteID = $_SESSION['instituteID'];

    // Check if faculty is main faculty for any class
    $stmt = $conn->prepare("SELECT classID FROM class WHERE facultyID = ?");
    $stmt->bind_param("i", $facultyID);
    $stmt->execute();
    $classResult = $stmt->get_result();

    if ($classResult->num_rows == 0) {
        echo '<div class="p-6 text-center text-gray-500">You are not authorized to view results as a main faculty.</div>';
    } else {
        echo '<div class="mb-4">';
        echo '<label for="rollNo" class="block text-sm font-medium text-gray-700">Enter Roll Number:</label>';
        echo '<input type="text" id="rollNo" name="rollNo" class="w-full py-2 px-4 border border-gray-300 rounded-lg" required>';
        echo '<button id="searchResult" class="mt-2 bg-primary text-white py-2 px-4 rounded hover:bg-blue-600">Search</button>';
        echo '</div>';
        echo '<div id="resultOutput" class="mt-4"></div>';
    }

    $stmt->close();
    $conn->close();
    ?>
</div>`;
                    break;

                case 'leaveApp':
                    content = `<br><br><br>
    <div class="p-4 rounded-lg bg-white">
        <h2 class="text-2xl font-bold mb-4">Leave Applications</h2>
        <?php
        $cLeaveApplication = 0;
        $classID = $_SESSION['classID'];
        if ($_SESSION['role'] !== 'faculty' || !$_SESSION['isMain']) {
            echo '<p class="text-red-600">Access denied. Only the main faculty can view this section.</p>';
        } else {
            include("connection.php");

            // Handle approval/rejection
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['leaveID'])) {
                $cLeaveApplication = 0;
                $leaveID = $_POST['leaveID'];
                $action = $_POST['action'];

                // Fetch leave application details
                $stmt = $conn->prepare("SELECT studID, startDate, endDate, periods FROM leaveapplication WHERE leaveID = ?");
                if (!$stmt) {
                    echo '<p class="text-red-600 mt-4">Database error: ' . $conn->error . '</p>';
                } else {
                    $stmt->bind_param("i", $leaveID);
                    if ($stmt->execute()) {
                        $leaveResult = $stmt->get_result();
                        $leaveRow = $leaveResult->fetch_assoc();

                        if ($leaveRow === null) {
                            echo '<p class="text-red-600 mt-4"> </p>';
                        } else {
                            $studID = $leaveRow['studID'];
                            $startDate = $leaveRow['startDate'];
                            $endDate = $leaveRow['endDate'];
                            $periods = $leaveRow['periods'] ? explode(',', $leaveRow['periods']) : [];

                            if ($action === 'approve') {
                                // Check attendance for each date and period
                                $allAbsent = true;
                                $date = $startDate;

                                while (strtotime($date) <= strtotime($endDate)) {
                                    if (empty($periods)) {
                                        // Fetch max periods from class for "All Periods" case
                                        $classStmt = $conn->prepare("SELECT numPeriods FROM class WHERE classID = (SELECT classID FROM student WHERE studID = ?)");
                                        $classStmt->bind_param("i", $studID);
                                        $classStmt->execute();
                                        $classResult = $classStmt->get_result();
                                        $numPeriods = $classResult->fetch_assoc()['numPeriods'] ?? 8;
                                        $classStmt->close();
                                        $periodsToCheck = range(1, $numPeriods);
                                    } else {
                                        $periodsToCheck = $periods;
                                    }

                                    $placeholders = implode(',', array_fill(0, count($periodsToCheck), '?'));
                                    $query = "SELECT COUNT(*) as total, SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent 
                                          FROM attendance WHERE studentID = ? AND date = ? AND periodNumber IN ($placeholders)";
                                    $attStmt = $conn->prepare($query);
                                    $params = array_merge([$studID, $date], $periodsToCheck);
                                    $types = 'is' . str_repeat('i', count($periodsToCheck));
                                    $attStmt->bind_param($types, ...$params);
                                    $attStmt->execute();
                                    $attResult = $attStmt->get_result();
                                    $attRow = $attResult->fetch_assoc();
                                    $attStmt->close();

                                    // Must have all periods marked, and all must be "absent"
                                    if ($attRow['total'] != count($periodsToCheck) || $attRow['absent'] != count($periodsToCheck)) {
                                        $allAbsent = false;
                                        break;
                                    }
                                    $date = date('Y-m-d', strtotime($date . ' +1 day'));
                                }

                                if (!$allAbsent) {
                                    $cLeaveApplication = 3;
                                    //echo '<p class="text-red-600 mt-4">Cannot approve: All applied dates and periods must be marked as absent.</p>';
                                } else {
                                    // Approve and update attendance
                                    $date = $startDate;
                                    while (strtotime($date) <= strtotime($endDate)) {
                                        $placeholders = implode(',', array_fill(0, count($periodsToCheck), '?'));
                                        $query = "UPDATE attendance SET status = 'dl' WHERE studentID = ? AND date = ? AND periodNumber IN ($placeholders)";
                                        $updateStmt = $conn->prepare($query);
                                        $params = array_merge([$studID, $date], $periodsToCheck);
                                        $updateStmt->bind_param('is' . str_repeat('i', count($periodsToCheck)), ...$params);
                                        $updateStmt->execute();
                                        $updateStmt->close();
                                        $date = date('Y-m-d', strtotime($date . ' +1 day'));
                                    }

                                    $stmt = $conn->prepare("UPDATE leaveapplication SET status = 'approved' WHERE leaveID = ?");
                                    $stmt->bind_param("i", $leaveID);
                                    if ($stmt->execute()) {
                                        $cLeaveApplication = 1;
                                        //echo '<p class="text-green-600 mt-4">Leave application approved and attendance updated to Duty Leave.</p>';
                                    }
                                }
                            } elseif ($action === 'reject') {
                                $stmt = $conn->prepare("UPDATE leaveapplication SET status = 'rejected' WHERE leaveID = ?");
                                $stmt->bind_param("i", $leaveID);
                                if ($stmt->execute()) {
                                    $cLeaveApplication = 2;
                                    //echo '<p class="text-green-600 mt-4">Leave application rejected.</p>';
                                }
                            }
                        }
                    } else {
                        echo '<p class="text-red-600 mt-4">Database error: ' . $stmt->error . '</p>';
                    }
                    $stmt->close();
                }
            }

            //$classID=$_SESSION['classID'];
            // Display all leave applications
            $stmt = $conn->prepare("SELECT la.leaveID, s.RollNo, lc.name, la.startDate, la.endDate, la.periods, la.reason, la.filePath,la.appliedDate, la.status 
                  FROM leaveapplication la 
                  JOIN student s ON la.studID = s.studID 
                  JOIN logincredentials lc ON s.userID = lc.userID
                  JOIN class c ON s.classID = c.classID
                  WHERE c.classID = ?");
            $stmt->bind_param("i", $classID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                echo '<div class="overflow-x-auto">';
                echo '<table class="min-w-full bg-white border">';
                echo '<thead>';
                echo '<tr>';
                echo '<th class="px-4 py-2 border">Sl No</th>';
                echo '<th class="px-4 py-2 border">Roll Number</th>';
                echo '<th class="px-4 py-2 border">Student Name</th>';
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
                while ($row = $result->fetch_assoc()) {
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
                    echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['RollNo']) . '</td>';
                    echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['startDate']) . '</td>';
                    echo '<td class="px-4 py-2 border">' . htmlspecialchars($row['endDate']) . '</td>';
                    echo '<td class="px-4 py-2 border">' . ($row['periods'] ? htmlspecialchars($row['periods']) : 'All Periods') . '</td>';
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
                    if ($row['status'] === 'pending') {
                        echo '<form method="POST" action="facultyPanel.php?content=leaveApp" class="inline">';
                        echo '<input type="hidden" name="leaveID" value="' . $row['leaveID'] . '">';
                        echo '<select name="action" onchange="this.form.submit()" class="p-1 border rounded">';
                        echo '<option value="">Select</option>';
                        echo '<option value="approve">Approve</option>';
                        echo '<option value="reject">Reject</option>';
                        echo '</select>';
                        echo '</form>';
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
        }
        ?>
    </div>`;

                    var cLeaveApplication = <?php echo $cLeaveApplication ?>;

                    if (cLeaveApplication == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Leave application approved and attendance updated to Duty Leave.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cLeaveApplication == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Leave application rejected.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cLeaveApplication == 3) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Cannot approve: All applied dates and periods must be marked as absent.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }


                    cLeaveApplication = 0;

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
        <h2 class="text-2xl font-bold mb-4">Welcome to Faculty Panel</h2>
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


        $(document).ready(function() {
            $(document).on('change', '#classSelect', function() {
                let classID = $(this).val();
                let facultyID = $(this).data('faculty-id');
                if (classID) {
                    if ($('#timetableOutput').length) { // Check if viewing timetable
                        $.ajax({
                            url: 'AJAX/view_timetable_ajax.php',
                            type: 'POST',
                            data: {
                                classID: classID,
                                facultyID: facultyID
                            },
                            success: function(response) {
                                $('#timetableOutput').html(response);
                            },
                            error: function(xhr, status, error) {
                                $('#timetableOutput').html('<p class="text-red-500">Error loading timetable: ' + error + '</p>');
                            }
                        });
                    } else {
                        $.ajax({
                            url: 'AJAX/faculty_ajax_handler.php',
                            type: 'POST',
                            data: {
                                action: 'get_exams',
                                classID: classID
                            },
                            success: function(response) {
                                $('#examSelect').html(response);
                                $('#examSection').removeClass('hidden');
                                $('#studentResults').empty();
                                $('#resultForm').addClass('hidden');
                                $('#editNotice').addClass('hidden');
                            },
                            error: function(xhr, status, error) {
                                alert('Failed to load exams: ' + error);
                            }
                        });
                    }
                } else {
                    if ($('#timetableOutput').length) {
                        $('#timetableOutput').empty();
                    } else {
                        $('#examSection').addClass('hidden');
                        $('#studentResults').empty();
                        $('#resultForm').addClass('hidden');
                        $('#editNotice').addClass('hidden');
                    }
                }
            });

            $(document).on('change', '#examSelect', function() {
                let examID = $(this).val();
                let classID = $('#classSelect').val();
                let facultyID = $('#classSelect').data('faculty-id');
                if (examID) {
                    $.ajax({
                        url: 'AJAX/faculty_ajax_handler.php',
                        type: 'POST',
                        data: {
                            action: 'get_students_and_subject',
                            classID: classID,
                            examID: examID,
                            facultyID: facultyID
                        },
                        success: function(response) {
                            $('#studentResults').html(response);
                            $('#resultForm').removeClass('hidden');
                            if (response.includes('data-existing="true"')) {
                                $('#editNotice').removeClass('hidden');
                            } else {
                                $('#editNotice').addClass('hidden');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Failed to load students: ' + error);
                        }
                    });
                } else {
                    $('#studentResults').empty();
                    $('#resultForm').addClass('hidden');
                    $('#editNotice').addClass('hidden');
                }
            });

            $(document).on('submit', '#resultForm', function(e) {
                e.preventDefault();
                let formData = $(this).serialize() + '&action=submit_results';
                $.ajax({
                    url: 'AJAX/faculty_ajax_handler.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response === 'success') {
                            // Determine if it's an upload or update based on #editNotice visibility
                            let actionText = $('#editNotice').is(':visible') ? 'updated' : 'uploaded';
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Results ' + actionText + ' successfully!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            // Clear the form and UI after the alert
                            $('#studentResults').empty();
                            $('#resultForm').addClass('hidden');
                            $('#editNotice').addClass('hidden');

                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Error submitting results.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error submitting results.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            });

            // Handle View Result roll number search
            $(document).on('click', '#searchResult', function() {
                let rollNo = $('#rollNo').val();
                let facultyID = <?php echo $_SESSION['facultyID']; ?>;
                if (rollNo) {
                    $.ajax({
                        url: 'AJAX/view_result_ajax.php',
                        type: 'POST',
                        data: {
                            rollNo: rollNo,
                            facultyID: facultyID
                        },
                        success: function(response) {
                            $('#resultOutput').html(response);
                        },
                        error: function(xhr, status, error) {
                            $('#resultOutput').html('<p class="text-red-500">Error loading results: ' + error + '</p>');
                        }
                    });
                } else {
                    $('#resultOutput').html('<p class="text-red-500">Please enter a roll number.</p>');
                }
            });
        });
    </script>
</body>

</html>