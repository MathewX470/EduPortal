<?php
include("session_start.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include("connection.php");

$userID1 = $_SESSION['userID'];

// Query admin details with prepared statement
$query = "SELECT * FROM admin WHERE userID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID1); // Assuming userID is an integer
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    echo "Query not executed: " . $conn->error;
} else {
    if ($result->num_rows > 0) {
        $admin_row = $result->fetch_assoc(); // Use a separate variable for the row
        $_SESSION['adminID'] = $admin_row['adminID'];
    } else {
        echo "<script>alert('Error accessing ADMIN details.');</script>";
        $_SESSION['adminID'] = null; // Handle no admin found
    }
}
$stmt->close();

$adminID = $_SESSION['adminID'];

// Query institute details if adminID exists
if ($adminID) {
    $query = "SELECT * FROM institute WHERE adminID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "Query not executed: " . $conn->error;
    } else {
        if ($result->num_rows > 0) {
            $institute_row = $result->fetch_assoc(); // Use a separate variable for the row
            $_SESSION['instituteID'] = $institute_row['instituteID'];
            $_SESSION['instituteName'] = $institute_row['name'];
            $_SESSION['location'] = $institute_row['location'];
        } else {
            echo "<script>alert('Error accessing institute details.');</script>";
            // Optionally set default values or redirect
            $_SESSION['instituteID'] = null;
            $_SESSION['instituteName'] = null;
            $_SESSION['location'] = null;
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
                    <span class="ml-3 text-xl font-semibold text-white">Admin Panel</span>
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
                <li><a href="#" class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100" onclick="showContent('adminDetail')"><i class="ri-admin-line w-5 h-5"></i><span class="ml-3">Admin Detail</span></a></li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('facultySubmenu')">
                        <i class="ri-user-2-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Faculty</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="facultySubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('addFaculty')">Add</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewFaculty')">View</a></li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('classSubmenu')">
                        <i class="ri-team-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Class</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="classSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('addClass')">Add</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewClass')">View</a></li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('timetableSubmenu')">
                        <i class="ri-calendar-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Timetable</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="timetableSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('createTimetable')">Add</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewTimetable')">View</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('editTimetable')">Edit</a></li>
                    </ul>
                </li>
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100" onclick="toggleSubmenu('examSubmenu')">
                        <i class="ri-team-line w-5 h-5"></i><span class="flex-1 ml-3 text-left">Exam</span><i class="ri-arrow-down-s-line"></i>
                    </button>
                    <ul id="examSubmenu" class="hidden py-2 space-y-2 bg-gray-200 rounded-lg">
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('createExam')">Create</a></li>
                        <li><a href="#" class="flex items-center w-full p-2 text-gray-900 transition duration-75 pl-11 rounded-lg hover:bg-gray-100" onclick="showContent('viewExam')">View</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
    <div class="p-4 sm:ml-64 pt-20 transition-all duration-300" id="mainContent">
        <br><br><br>
        <div class="p-4 rounded-lg bg-white min-h-[calc(100vh-6rem)]">
            <h2 class="text-2xl font-bold mb-4">Welcome to Admin Panel</h2>
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
                case 'adminDetail':
                    <?php

                    // Use the existing $conn from the top of the file
                    $instituteID = $_SESSION['instituteID'];

                    // Query to get the number of classes
                    $classQuery = "SELECT COUNT(*) as classCount FROM class WHERE instituteID = ?";
                    $classStmt = $conn->prepare($classQuery);
                    $classStmt->bind_param("i", $instituteID);
                    $classStmt->execute();
                    $classResult = $classStmt->get_result();
                    $classCount = $classResult->fetch_assoc()['classCount'];
                    $classStmt->close();

                    // Query to get the number of faculty
                    $facultyQuery = "SELECT COUNT(*) as facultyCount FROM faculty WHERE instituteID = ?";
                    $facultyStmt = $conn->prepare($facultyQuery);
                    $facultyStmt->bind_param("i", $instituteID);
                    $facultyStmt->execute();
                    $facultyResult = $facultyStmt->get_result();
                    $facultyCount = $facultyResult->fetch_assoc()['facultyCount'];
                    $facultyStmt->close();

                    // Query to get the number of students
                    $studentQuery = "SELECT COUNT(*) as studentCount FROM student WHERE instituteID = ?";
                    $studentStmt = $conn->prepare($studentQuery);
                    $studentStmt->bind_param("i", $instituteID);
                    $studentStmt->execute();
                    $studentResult = $studentStmt->get_result();
                    $studentCount = $studentResult->fetch_assoc()['studentCount'];
                    $studentStmt->close();

                    // Query to get the number of parents
                    $parentQuery = "SELECT COUNT(*) as parentCount FROM parent WHERE instituteID = ?";
                    $parentStmt = $conn->prepare($parentQuery);
                    $parentStmt->bind_param("i", $instituteID);
                    $parentStmt->execute();
                    $parentResult = $parentStmt->get_result();
                    $parentCount = $parentResult->fetch_assoc()['parentCount'];
                    $parentStmt->close();
                    ?>
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Admin Details</h2>
    <div class="grid grid-cols-1 gap-6">
        <div class="space-y-4">
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Name:</span>
                <span class="text-gray-600"><?php echo htmlspecialchars($_SESSION['name']); ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Email:</span>
                <span class="text-gray-600"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Role:</span>
                <span class="text-gray-600"><?php echo htmlspecialchars($_SESSION['role']); ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Institution Name:</span>
                <span class="text-gray-600"><?php echo htmlspecialchars($_SESSION['instituteName']); ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Location:</span>
                <span class="text-gray-600"><?php echo htmlspecialchars($_SESSION['location']); ?></span>
            </div>
        </div>
    </div>
    
    <h2 class="text-2xl font-bold mt-8 mb-6 text-gray-800">Institute Statistics</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-4">
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Number of Classes:</span>
                <span class="text-gray-600"><?php echo $classCount; ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Faculty Count:</span>
                <span class="text-gray-600"><?php echo $facultyCount; ?></span>
            </div>
        </div>
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-4">
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Student Count:</span>
                <span class="text-gray-600"><?php echo $studentCount; ?></span>
            </div>
            <div class="flex items-center">
                <span class="w-40 font-semibold text-gray-700">Parents Count:</span>
                <span class="text-gray-600"><?php echo $parentCount; ?></span>
            </div>
        </div>
    </div>
</div>`;

                    break;

                case 'addFaculty':
                    content = ` <br><br><br><div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h2>Importing Faculty Data</h2>
                </div>
                <div class="card-body">
                    <form id="facultyImportForm" action="adminPanel.php?content=addFaculty" method="post" enctype="multipart/form-data">
                        <input type="file" name="import-file-faculty" class="form-control" accept=".xls, .xlsx">
                        <button type="submit" name="importExcelFaculty" class="btn btn-primary mt-3">Import</button>
                    </form>
                
                </div>
            </div>
        </div>
    </div>
    <?php
    include 'connection.php';
    $sFacultyFile = 0;
    if (isset($_POST['importExcelFaculty'])) {
        $sFacultyFile = 0;
        $fileName = $_FILES['import-file-faculty']['name'];
        $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowed_ext = ["xls", "xlsx"];
        $inputFileName = $_FILES['import-file-faculty']['tmp_name'];
        $spreadsheet = IOFactory::load($inputFileName);
        $data = $spreadsheet->getActiveSheet()->toArray();
        $instituteID = $_SESSION['instituteID'];
        $count = 0;
        $msg = false;
        $conn->begin_transaction();
        try {
            foreach ($data as $row) {
                if ($count == 0) {
                    if ($row[0] != 'Name' || $row[1] != 'Email' || $row[2] != 'Gender' || $row[3] != 'Subject Name') {
                        throw new Exception("Incorrect Excel Format. Expected: Name, Email, Gender, Subject Name.");
                    }
                    $count++;
                    continue;
                }
                $name = trim($row[0]);
                $email = trim($row[1]);
                $gender = trim($row[2]);
                $subjectName = trim($row[3]);
                $passwordf = substr($name, 0, 3) . '123';
                $hashedPassword = password_hash($passwordf, PASSWORD_BCRYPT);
                $stmt = $conn->prepare("INSERT INTO logincredentials (email, password, name, gender, role, instituteID) VALUES (?, ?, ?, ?, 'faculty', ?)");
                $stmt->bind_param("ssssi", $email, $hashedPassword, $name, $gender, $instituteID);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting into logincredentials: " . $stmt->error);
                }
                $facultyUserID = $conn->insert_id;
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO faculty (userID, instituteID) VALUES (?, ?)");
                $stmt->bind_param("ii", $facultyUserID, $instituteID);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting into faculty: " . $stmt->error);
                }
                $facultyID = $conn->insert_id;
                $stmt->close();
                $stmt = $conn->prepare("INSERT INTO subject (subjectName, facultyID, instituteID) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $subjectName, $facultyID, $instituteID);
                if (!$stmt->execute()) {
                    throw new Exception("Error inserting into subject: " . $stmt->error);
                }
                $stmt->close();
                $msg = true;
            }
            $conn->commit();
            //success
            $sFacultyFile = 1;
        } catch (Exception $e) {
            $conn->rollback();
            //error
            $sFacultyFile = 2;
        }
    }
    ?>`;
                    var sFacultyFile = <?php echo $sFacultyFile ?>;

                    if (sFacultyFile == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data Imported Successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (sFacultyFile == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Import Failed ',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }


                    sFacultyFile = 0;
                    break;

                case 'viewFaculty':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">View Faculty</h2>
    <div class="mb-4">
        <input type="text" name="namef" id="searchFaculty" placeholder="Search Faculty by Name..." class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-gray-700 placeholder-gray-400">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Contact</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="facultyTableBody">
                <?php
                include 'connection.php';
                $instituteID = $_SESSION['instituteID'];
                $query = "SELECT lc.name, lc.email, f.facultyID, s.subjectName 
                         FROM faculty f
                         JOIN logincredentials lc ON f.userID = lc.userID 
                         JOIN subject s ON f.facultyID = s.facultyID
                         WHERE lc.role = 'faculty' AND f.instituteID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $instituteID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $facultyID = htmlspecialchars($row['facultyID']);
                        $name = htmlspecialchars($row['name']);
                        $subjectName = htmlspecialchars($row['subjectName']);
                        $email = htmlspecialchars($row['email']);
                        echo "<tr class='bg-white border-b' id='row-$facultyID'>
                            <td class='px-6 py-4'><span class='display-name'>$name</span><input type='text' class='edit-name hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$name'></td>
                            <td class='px-6 py-4'>$facultyID</td>
                            <td class='px-6 py-4'><span class='display-subject'>$subjectName</span><input type='text' class='edit-subject hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$subjectName'></td>
                            <td class='px-6 py-4'><span class='display-contact'>$email</span><input type='text' class='edit-contact hidden w-full py-1 px-2 border border-gray-300 rounded-lg' value='$email'></td>
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
                ?>
            </tbody>
        </table>
    </div>
</div>`;
                    mainContent.innerHTML = content;
                    profileDropdown.classList.remove('show');
                    setTimeout(() => {
                        $('#searchFaculty').on('input', function() {
                            let timeout;
                            clearTimeout(timeout);
                            timeout = setTimeout(function() {
                                let searchTerm = $('#searchFaculty').val();
                                $.ajax({
                                    url: 'AJAX/search_faculty.php',
                                    method: 'POST',
                                    data: {
                                        namef: searchTerm
                                    },
                                    success: function(response) {
                                        $('#facultyTableBody').html(response);
                                        attachEditSaveListeners();
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                    }
                                });
                            }, 300);
                        });

                        function attachEditSaveListeners() {
                            $('.edit-btn').off('click').on('click', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                let facultyId = $(this).data('faculty-id');
                                row.find('.display-name, .display-subject, .display-contact').addClass('hidden');
                                row.find('.edit-name, .edit-subject, .edit-contact').removeClass('hidden');
                                row.find('.edit-btn').addClass('hidden');
                                row.find('.save-btn').removeClass('hidden');
                            });

                            $('.save-btn').off('click').on('click', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                let facultyId = $(this).data('faculty-id');
                                let newName = row.find('.edit-name').val();
                                let newSubject = row.find('.edit-subject').val();
                                let newContact = row.find('.edit-contact').val();
                                $.ajax({
                                    url: 'AJAX/update_faculty.php',
                                    method: 'POST',
                                    data: {
                                        facultyID: facultyId,
                                        name: newName,
                                        subjectName: newSubject,
                                        email: newContact
                                    },
                                    success: function(response) {
                                        if (response === 'success') {
                                            row.find('.display-name').text(newName).removeClass('hidden');
                                            row.find('.display-subject').text(newSubject).removeClass('hidden');
                                            row.find('.display-contact').text(newContact).removeClass('hidden');
                                            row.find('.edit-name, .edit-subject, .edit-contact').addClass('hidden');
                                            row.find('.edit-btn').removeClass('hidden');
                                            row.find('.save-btn').addClass('hidden');
                                        } else {
                                            alert('Error updating faculty: ' + response);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                        alert('Failed to update faculty');
                                    }
                                });
                            });
                        }

                        attachEditSaveListeners();
                    }, 0);
                    return;
                    break;

                case 'addClass':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Add New Class</h2>
    <form action="adminPanel.php?content=addClass" method="POST" class="max-w-lg mb-6" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="className">Class Name</label>
            <input type="text" name="className" id="className" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-2">Assign Faculty</h3>
            <!-- Main Staff Advisor -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="facultyID">Main Staff Advisor</label>
                <select name="facultyID" id="facultyID" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Select a Faculty</option>
                    <?php
                    include 'connection.php';
                    $cAddClassMsg = 0;
                    $instituteID = $_SESSION['instituteID'];
                    $query = "SELECT f.facultyID, lc.name, s.subjectName 
                             FROM faculty f
                             JOIN logincredentials lc ON f.userID = lc.userID
                             LEFT JOIN subject s ON f.facultyID = s.facultyID
                             WHERE lc.role = 'faculty' AND f.instituteID = ?
                             AND f.facultyID NOT IN (SELECT facultyID FROM class)";
                    $stmt = $conn->prepare($query);
                    if ($stmt) {
                        $stmt->bind_param("i", $instituteID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            $facultyID = htmlspecialchars($row['facultyID']);
                            $name = htmlspecialchars($row['name']);
                            $subjectName = htmlspecialchars($row['subjectName'] ?? 'No Subject Assigned');
                            echo "<option value='$facultyID'>$name (ID: $facultyID) - $subjectName</option>";
                        }
                        $stmt->close();
                    } else {
                        echo "<option value=''>Error: " . $conn->error . "</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>
            <!-- Additional 4 Faculty -->
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="additionalFaculty<?php echo $i; ?>">Additional Faculty <?php echo $i; ?></label>
                    <select name="additionalFaculty[]" id="additionalFaculty<?php echo $i; ?>" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select a Faculty</option>
                        <?php
                        include 'connection.php';
                        $cAddClassMsg = 0;
                        $instituteID = $_SESSION['instituteID'];
                        $query = "SELECT f.facultyID, lc.name, s.subjectName 
                                 FROM faculty f
                                 JOIN logincredentials lc ON f.userID = lc.userID
                                 LEFT JOIN subject s ON f.facultyID = s.facultyID
                                 WHERE lc.role = 'faculty' AND f.instituteID = ?";
                        $stmt = $conn->prepare($query);
                        if ($stmt) {
                            $stmt->bind_param("i", $instituteID);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($row = $result->fetch_assoc()) {
                                $facultyID = htmlspecialchars($row['facultyID']);
                                $name = htmlspecialchars($row['name']);
                                $subjectName = htmlspecialchars($row['subjectName'] ?? 'No Subject Assigned');
                                echo "<option value='$facultyID'>$name (ID: $facultyID) - $subjectName</option>";
                            }
                            $stmt->close();
                        } else {
                            echo "<option value=''>Error: " . $conn->error . "</option>";
                        }
                        $conn->close();
                        ?>
                    </select>
                </div>
            <?php endfor; ?>
        </div>
        <h3 class="text-lg font-semibold mb-2">Upload Student Data</h3>
        <div class="mb-4">
            <input type="file" name="studentFile" class="form-control" accept=".xls,.xlsx" required>
        </div>
        <button type="submit" name="addClassSubmit" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700">Add Class & Upload Students</button>
    </form>
    <?php if (isset($_SESSION['classMessage'])): ?>
        <div class="mt-4 text-sm <?php echo strpos($_SESSION['classMessage'], 'Error') !== false ? 'text-red-600' : 'text-green-600'; ?>">
            <?php echo htmlspecialchars($_SESSION['classMessage']);
            unset($_SESSION['classMessage']); ?>
        </div>
    <?php endif; ?>
</div>
<?php
include 'connection.php';
$cAddClassMsg = 0;
if (isset($_POST['addClassSubmit'])) {
    $cAddClassMsg = 0;
    $className = $conn->real_escape_string($_POST['className']);
    $mainFacultyID = $conn->real_escape_string($_POST['facultyID']);
    $additionalFaculty = isset($_POST['additionalFaculty']) ? $_POST['additionalFaculty'] : [];
    $instituteID = $_SESSION['instituteID'];
    if (count($additionalFaculty) !== 4) {
        //$_SESSION['classMessage'] = "Error: Exactly 4 additional faculty must be selected.";
        $cAddClassMsg = 2;
    } else {
        $fileName = $_FILES['studentFile']['name'];
        $file_ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed_ext = ['xls', 'xlsx'];
        if (!in_array($file_ext, $allowed_ext)) {
            //$_SESSION['classMessage'] = "Invalid File Format. Please upload an Excel file (.xls or .xlsx).";
            $cAddClassMsg = 2;
        } else {
            $conn->begin_transaction();
            try {
                $stmt = $conn->prepare("INSERT INTO class (className, facultyID, instituteID) VALUES (?, ?, ?)");
                $stmt->bind_param("sii", $className, $mainFacultyID, $instituteID);
                if (!$stmt->execute()) {
                    throw new Exception("Error adding class: " . $stmt->error);
                }
                $classID = $conn->insert_id;
                $stmt->close();
                foreach ($additionalFaculty as $facultyID) {
                    $facultyID = $conn->real_escape_string($facultyID);
                    $stmt = $conn->prepare("INSERT INTO class_faculty (classID, facultyID) VALUES (?, ?)");
                    $stmt->bind_param("ii", $classID, $facultyID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error adding additional faculty: " . $stmt->error);
                    }
                    $stmt->close();
                }
                $inputFileName = $_FILES['studentFile']['tmp_name'];
                $spreadsheet = IOFactory::load($inputFileName);
                $data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                $count = 0;
                file_put_contents('debug.txt', print_r($data, true));
                foreach ($data as $rowNum => $row) {
                    if ($count == 0) {
                        if (
                            !isset($row['A']) || $row['A'] != 'Roll No' ||
                            !isset($row['B']) || $row['B'] != 'Student Name' ||
                            !isset($row['C']) || $row['C'] != 'Student Email' ||
                            !isset($row['D']) || $row['D'] != 'Student Gender' ||
                            !isset($row['E']) || $row['E'] != 'Parent Name' ||
                            !isset($row['F']) || $row['F'] != 'Parent Email' ||
                            !isset($row['G']) || $row['G'] != 'Parent Gender'
                        ) {
                            throw new Exception("Incorrect Excel Format at row $rowNum. Expected: Roll No, Student Name, Student Email, Student Gender, Parent Name, Parent Email, Parent Gender");
                        }
                        $count++;
                        continue;
                    }
                    $rollNo = isset($row['A']) && $row['A'] !== null ? trim($row['A']) : '';
                    $sName = isset($row['B']) && $row['B'] !== null ? trim($row['B']) : '';
                    $sEmail = isset($row['C']) && $row['C'] !== null ? trim($row['C']) : '';
                    $sGender = isset($row['D']) && $row['D'] !== null ? trim($row['D']) : '';
                    $pName = isset($row['E']) && $row['E'] !== null ? trim($row['E']) : '';
                    $pEmail = isset($row['F']) && $row['F'] !== null ? trim($row['F']) : '';
                    $pGender = isset($row['G']) && $row['G'] !== null ? trim($row['G']) : '';
                    if ($rollNo === '' && $sName === '' && $sEmail === '' && $sGender === '' && $pName === '' && $pEmail === '' && $pGender === '') {
                        continue;
                    }
                    if (empty($sName) || empty($sEmail) || empty($pName) || empty($pEmail)) {
                        throw new Exception("Missing required fields (Name or Email) in row $rowNum");
                    }
                    $sPassword = substr($sName, 0, 3) . '123';
                    $sHashedPassword = password_hash($sPassword, PASSWORD_BCRYPT);
                    $pPassword = substr($pName, 0, 3) . '123';
                    $pHashedPassword = password_hash($pPassword, PASSWORD_BCRYPT);
                    $stmt = $conn->prepare("INSERT INTO logincredentials (email, password, name, gender, role, instituteID) VALUES (?, ?, ?, ?, 'student', ?)");
                    $stmt->bind_param("ssssi", $sEmail, $sHashedPassword, $sName, $sGender, $instituteID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error creating Student account: " . $stmt->error);
                    }
                    $studentUserID = $conn->insert_id;
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO logincredentials (email, password, name, gender, role, instituteID) VALUES (?, ?, ?, ?, 'parent', ?)");
                    $stmt->bind_param("ssssi", $pEmail, $pHashedPassword, $pName, $pGender, $instituteID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error creating Parent account: " . $stmt->error);
                    }
                    $parentUserID = $conn->insert_id;
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO parent (userID, instituteID) VALUES (?, ?)");
                    $stmt->bind_param("ii", $parentUserID, $instituteID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error creating parent: " . $stmt->error);
                    }
                    $parentID = $conn->insert_id;
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO student (userID, instituteID, parentID, classID, RollNo) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("iiiii", $studentUserID, $instituteID, $parentID, $classID, $rollNo);
                    if (!$stmt->execute()) {
                        throw new Exception("Error creating student: " . $stmt->error);
                    }
                    $stmt->close();
                }
                $conn->commit();
                //$_SESSION['classMessage'] = "Class and student data added successfully.";
                $cAddClassMsg = 1;
            } catch (Exception $e) {
                $conn->rollback();
                //$_SESSION['classMessage'] = "Error: " . $e->getMessage();
                $cAddClassMsg = 2;
            } finally {
                $conn->close();
            }
        }
    }
}
?>`;

                    var cAddClassMsg = <?php echo $cAddClassMsg ?>;

                    if (cAddClassMsg == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data imported successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cAddClassMsg == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Import failed.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }


                    cAddClassMsg = 0;

                    break;

                case 'viewClass':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">View Classes</h2>
    <div class="mb-4">
        <input type="text" id="searchClasses" placeholder="Search classes by name..." class="w-full py-2 px-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 text-gray-700 placeholder-gray-400">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Class Name</th>
                    <th class="px-6 py-3">Staff Advisor</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="classTableBody">
                <?php
                include 'connection.php';
                $instituteID = $_SESSION['instituteID'];
                $query = "SELECT c.classID, c.className, lc.name AS staffAdvisorName 
                         FROM class c
                         LEFT JOIN faculty f ON c.facultyID = f.facultyID
                         LEFT JOIN logincredentials lc ON f.userID = lc.userID
                         WHERE c.instituteID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $instituteID);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $classID = htmlspecialchars($row['classID']);
                    echo "<tr class='bg-white border-b' id='row-$classID'>
                        <td class='px-6 py-4'>" . htmlspecialchars($row['className']) . "</td>
                        <td class='px-6 py-4'>" . ($row['staffAdvisorName'] ? htmlspecialchars($row['staffAdvisorName']) : 'None') . "</td>
                        <td class='px-6 py-4'>
                            
                            <button class='view-btn text-purple-600 hover:text-purple-900 mr-2' data-class-id='$classID'>View</button>
                            
                        </td>
                    </tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>`;
                    mainContent.innerHTML = content;
                    profileDropdown.classList.remove('show');
                    setTimeout(() => {
                        // AJAX search for classes
                        let timeoutClasses;
                        $('#searchClasses').on('input', function() {
                            clearTimeout(timeoutClasses);
                            timeoutClasses = setTimeout(function() {
                                let searchTerm = $('#searchClasses').val();
                                $.ajax({
                                    url: 'AJAX/search_classes.php',
                                    method: 'POST',
                                    data: {
                                        searchTerm: searchTerm
                                    },
                                    success: function(response) {
                                        $('#classTableBody').html(response);
                                        attachEditSaveListeners();
                                        attachViewListeners(); // Re-attach view listeners after search
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                    }
                                });
                            }, 300);
                        });

                        // Function to attach edit/save listeners
                        function attachEditSaveListeners() {
                            $('.edit-btn').off('click').on('click', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                let classId = $(this).data('class-id');
                                $.ajax({
                                    url: 'AJAX/fetch_class_faculty.php',
                                    method: 'POST',
                                    data: {
                                        classID: classId
                                    },
                                    success: function(response) {
                                        row.after(response);
                                        row.find('.edit-btn').addClass('hidden');
                                        row.find('.save-btn').removeClass('hidden');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                        alert('Failed to fetch faculty details');
                                    }
                                });
                            });

                            $(document).on('click', '.save-btn', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                let classId = $(this).data('class-id');
                                let editRow = row.next('.edit-row');
                                let mainFacultyID = editRow.find('#editFacultyID').val();
                                let additionalFaculty = [];
                                editRow.find('.additional-faculty-select').each(function() {
                                    additionalFaculty.push($(this).val());
                                });

                                $.ajax({
                                    url: 'AJAX/update_class_faculty.php',
                                    method: 'POST',
                                    data: {
                                        classID: classId,
                                        mainFacultyID: mainFacultyID,
                                        additionalFaculty: additionalFaculty
                                    },
                                    success: function(response) {
                                        if (response === 'success') {
                                            $.ajax({
                                                url: 'AJAX/fetch_class_details.php',
                                                method: 'POST',
                                                data: {
                                                    classID: classId
                                                },
                                                success: function(updatedRow) {
                                                    row.replaceWith(updatedRow);
                                                    attachEditSaveListeners();
                                                    attachViewListeners();
                                                }
                                            });
                                            editRow.remove();
                                        } else {
                                            alert('Error updating class faculty: ' + response);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                        alert('Failed to update class');
                                    }
                                });
                            });
                        }

                        // Function to attach view listeners
                        function attachViewListeners() {
                            $('.view-btn').off('click').on('click', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                let classId = $(this).data('class-id');
                                $.ajax({
                                    url: 'AJAX/fetch_class_faculty_view.php',
                                    method: 'POST',
                                    data: {
                                        classID: classId
                                    },
                                    success: function(response) {
                                        row.after(response);
                                        // Optional: Toggle button text to "Hide" or remove row on second click
                                        $(this).text($(this).text() === 'View' ? 'Hide' : 'View');
                                        $(this).toggleClass('view-btn text-purple-600 hover:text-purple-900 text-gray-600 hover:text-gray-900');
                                    },
                                    error: function(xhr, status, error) {
                                        console.error('AJAX Error: ' + status + ' - ' + error);
                                        alert('Failed to fetch faculty details');
                                    }
                                });
                            });

                            // Handle hide functionality (optional)
                            $(document).on('click', '.text-gray-600', function(e) {
                                e.preventDefault();
                                let row = $(this).closest('tr');
                                row.next('.view-row').remove();
                                $(this).text('View');
                                $(this).removeClass('text-gray-600 hover:text-gray-900');
                                $(this).addClass('view-btn text-purple-600 hover:text-purple-900');
                            });
                        }

                        attachEditSaveListeners();
                        attachViewListeners();
                    }, 0);
                    return;
                    break;

                case 'createTimetable':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Create Timetable</h2>
    <form id="timetableForm" action="adminPanel.php?content=createTimetable" method="POST" class="mb-6">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="classID">Select Class</label>
            <select name="classID" id="classID" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required onchange="fetchFacultyAndToggleHours()">
                <option value="">Select a Class</option>
                <?php
                $cCreateTimeTable = 0;
                include 'connection.php';
                $instituteID = $_SESSION['instituteID'];
                $query = "SELECT classID, className FROM class WHERE instituteID = ? and classID not in (select classID from timetable)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $instituteID);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $classID = htmlspecialchars($row['classID']);
                    $className = htmlspecialchars($row['className']);
                    echo "<option value='$classID'>$className (ID: $classID)</option>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </select>
        </div>
        <div class="mb-4" id="hoursDropdown" style="display: none;">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="hoursPerDay">Number of Hours Per Day</label>
            <select name="hoursPerDay" id="hoursPerDay" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required onchange="generateTimetableTable()">
                <option value="">Select Hours</option>
                <?php for ($i = 4; $i <= 8; $i++) {
                    echo "<option value='$i'>$i Hours</option>";
                } ?>
            </select>
        </div>
        <div id="timetableFields" class="mt-4 overflow-x-auto"></div>
        <button type="submit" name="createTimetableSubmit" id="submitButton" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700 mt-4 hidden">Create Timetable</button>
    </form>
    <?php if (isset($_SESSION['timetableMessage'])): ?>
        <div class="mt-4 text-sm <?php echo strpos($_SESSION['timetableMessage'], 'Error') !== false ? 'text-red-600' : 'text-green-600'; ?>">
            <?php echo htmlspecialchars($_SESSION['timetableMessage']);
            unset($_SESSION['timetableMessage']); ?>
        </div>
    <?php endif; ?>
</div>
<?php
include 'connection.php';
$cCreateTimeTable = 0;
if (isset($_POST['createTimetableSubmit'])) {
    $cCreateTimeTable = 0;
    $classID = $conn->real_escape_string($_POST['classID']);
    $hoursPerDay = $conn->real_escape_string($_POST['hoursPerDay']);
    $timetable = $_POST['timetable'];
    $instituteID = $_SESSION['instituteID'];

    $stmt = $conn->prepare("update class set numPeriods = ? where classID = ?");
    $stmt->bind_param("ii", $hoursPerDay, $classID);
    $stmt->execute();
    $stmt->close();

    $conn->begin_transaction();
    try {
        foreach ($timetable as $day => $periods) {
            foreach ($periods as $periodNumber => $facultyID) {
                $facultyID = $conn->real_escape_string($facultyID);
                $stmt = $conn->prepare("INSERT INTO timetable (classID, dayOfWeek, periodNumber, facultyID, instituteID) 
                                       VALUES (?, ?, ?, ?, ?)
                                       ON DUPLICATE KEY UPDATE facultyID = VALUES(facultyID)");
                $stmt->bind_param("isiii", $classID, $day, $periodNumber, $facultyID, $instituteID);
                if (!$stmt->execute()) {
                    throw new Exception("Error creating timetable for $day, Period $periodNumber: " . $stmt->error);
                }
                $stmt->close();
            }
        }
        $conn->commit();
        $cCreateTimeTable = 1;
        //$_SESSION['timetableMessage'] = "Timetable created successfully.";
    } catch (Exception $e) {
        $conn->rollback();
        $cCreateTimeTable = 2;
        //$_SESSION['timetableMessage'] = "Error: " . $e->getMessage();
    } finally {
        $conn->close();
    }
}
?>`;

                    var cCreateTimeTable = <?php echo $cCreateTimeTable ?>;

                    if (cCreateTimeTable == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Timetable created successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cCreateTimeTable == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Timetable creation failed.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }


                    cCreateTimeTable = 0;

                    break;

                case 'viewTimetable':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">View Timetable</h2>
    <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="classID">Select Class</label>
        <select name="classID" id="classID" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="fetchTimetable()">
            <option value="">Select a Class</option>
            <?php
            include 'connection.php';
            $instituteID = $_SESSION['instituteID'];
            $query = "SELECT classID, className FROM class WHERE instituteID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $instituteID);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                $classID = htmlspecialchars($row['classID']);
                $className = htmlspecialchars($row['className']);
                echo "<option value='$classID'>$className (ID: $classID)</option>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </select>
    </div>
    <div id="timetableDisplay" class="mt-4 overflow-x-auto"></div>
</div>`;
                    break;

                case 'editTimetable':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white">
    <h2 class="text-2xl font-bold mb-4">Edit Timetable</h2>
    <form id="editTimetableForm" action="?content=editTimetable" method="POST" class="mb-6">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="classID">Select Class</label>
            <select name="classID" id="classID" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" onchange="fetchTimetableForEdit()">
                <option value="">Select a Class</option>
                <?php
                $cEditTimeTable = 0;
                include 'connection.php';
                $instituteID = $_SESSION['instituteID'];
                $query = "SELECT classID, className FROM class WHERE instituteID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $instituteID);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $classID = htmlspecialchars($row['classID']);
                    $className = htmlspecialchars($row['className']);
                    echo "<option value='$classID'>$className (ID: $classID)</option>";
                }
                $stmt->close();
                $conn->close();
                ?>
            </select>
        </div>
        <div id="timetableEditDisplay" class="mt-4 overflow-x-auto"></div>
        <button type="submit" name="saveTimetable" id="saveButton" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700 mt-4 hidden">Save Timetable</button>
    </form>
</div>
<?php
include 'connection.php';
$cEditTimeTable = 0;
if (isset($_POST['saveTimetable'])) {
    $cEditTimeTable = 0;
    $_SESSION['timetableEditMessage'] = "";
    $classID = $conn->real_escape_string($_POST['classID']);
    $timetable = $_POST['timetable'];
    $instituteID = $_SESSION['instituteID'];

    $conn->begin_transaction();
    try {
        // Delete existing timetable entries for this class to replace with new ones
        $deleteStmt = $conn->prepare("DELETE FROM timetable WHERE classID = ? AND instituteID = ?");
        $deleteStmt->bind_param("ii", $classID, $instituteID);
        $deleteStmt->execute();
        $deleteStmt->close();

        // Insert updated timetable entries
        foreach ($timetable as $day => $periods) {
            foreach ($periods as $periodNumber => $facultyID) {
                $facultyID = $conn->real_escape_string($facultyID);
                if ($facultyID) { // Only insert if a faculty is selected
                    $stmt = $conn->prepare("INSERT INTO timetable (classID, dayOfWeek, periodNumber, facultyID, instituteID) 
                                           VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("isiii", $classID, $day, $periodNumber, $facultyID, $instituteID);
                    if (!$stmt->execute()) {
                        throw new Exception("Error updating timetable for $day, Period $periodNumber: " . $stmt->error);
                    }
                    $stmt->close();
                }
            }
        }
        $conn->commit();
        $cEditTimeTable = 1;
        //echo "<p class='text-green-600 mt-4 h5'>Timetable updated successfully.</p>";
    } catch (Exception $e) {
        $conn->rollback();
        $cEditTimeTable = 2;
        //echo "<p class='text-red-600 mt-4 h5'>Error: " . $e->getMessage() . "</p>";
    } finally {
        $conn->close();
    }
}
?>`;

                    var cEditTimeTable = <?php echo $cEditTimeTable ?>;

                    if (cEditTimeTable == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Timetable Edited successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cEditTimeTable == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Timetable Updation failed.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }


                    cEditTimeTable = 0;
                    break;


                case 'createExam':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create Exam</h2>
    <form id="examForm" action="adminPanel.php?content=createExam" method="POST" class="max-w-lg mb-6">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="examName">Exam Name</label>
            <input type="text" name="examName" id="examName" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required value="<?php echo isset($_POST['examName']) && !isset($_SESSION['examMessage']) ? htmlspecialchars($_POST['examName']) : ''; ?>">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="classID">Select Class</label>
            <select name="classID" id="classID" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required onchange="fetchSubjects()">
                <option value="">Select a Class</option>
                <?php
                $cCreateExam = 0;
                include 'connection.php';
                $query = "SELECT classID, className FROM class WHERE instituteID = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $_SESSION['instituteID']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $selected = (isset($_POST['classID']) && $_POST['classID'] == $row['classID'] && !isset($_SESSION['examMessage'])) ? 'selected' : '';
                    echo "<option value='" . htmlspecialchars($row['classID']) . "' $selected>" . htmlspecialchars($row['className']) . " (ID: " . htmlspecialchars($row['classID']) . ")</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
        <div id="subjectsList" class="mb-4"></div>
        <button type="submit" name="createExamSubmit" id="submitButton" class="bg-primary text-white font-bold py-2 px-4 rounded hover:bg-blue-700 hidden">Create Exam</button>
    </form>
</div>
<?php
include 'connection.php';
$cCreateExam = 0;
if (isset($_POST['createExamSubmit'])) {
    $cCreateExam = 0;
    $examName = $conn->real_escape_string($_POST['examName']);
    $classID = $conn->real_escape_string($_POST['classID']);
    $totalMarks = $_POST['totalMarks'] ?? [];
    $instituteID = $_SESSION['instituteID'];

    $conn->begin_transaction();
    try {
        $stmt = $conn->prepare("INSERT INTO exam (examName, classID, instituteID) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $examName, $classID, $instituteID);
        if (!$stmt->execute()) {
            throw new Exception("Error creating exam: " . $stmt->error);
        }
        $examID = $conn->insert_id;
        $stmt->close();

        foreach ($totalMarks as $subjectID => $marks) {
            $marks = (int)$marks;
            if ($marks < 0) {
                throw new Exception("Total marks cannot be negative for subject ID: $subjectID");
            }
            $stmt = $conn->prepare("INSERT INTO exam_subject (examID, subjectID, totalMarks) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $examID, $subjectID, $marks);
            if (!$stmt->execute()) {
                throw new Exception("Error adding subject $subjectID: " . $stmt->error);
            }
            $stmt->close();
        }
        $conn->commit();
        $cCreateExam = 1;
        //echo "<p class='text-green-600 mt-4 h5'>Examination created successfully.</p>";
    } catch (Exception $e) {
        $conn->rollback();
        $cCreateExam = 2;
        //echo "<p class='text-red-600 mt-4 h5'>Error: " . $e->getMessage() . "</p>";
    }
}
?>`;

                    var cCreateExam = <?php echo $cCreateExam ?>;

                    if (cCreateExam == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Examination created successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cCreateExam == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error creating examination.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    cCreateExam = 0;

                    break;


                case 'viewExam':
                    content = `<br><br><br>
<div class="p-4 rounded-lg bg-white shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">View Exams</h2>
    <div class="space-y-4">
        <?php
        $cUpdateExam = 0;
        include 'connection.php';
        $instituteID = $_SESSION['instituteID'];

        // Fetch all exams for the institute
        $query = "SELECT e.examID, e.examName, c.className 
                  FROM exam e 
                  JOIN class c ON e.classID = c.classID 
                  WHERE e.instituteID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $instituteID);
        $stmt->execute();
        $examResult = $stmt->get_result();

        if ($examResult->num_rows === 0) {
            echo "<p class='text-gray-600'>No exams found.</p>";
        } else {
            while ($exam = $examResult->fetch_assoc()) {
                $examID = htmlspecialchars($exam['examID']);
                $examName = htmlspecialchars($exam['examName']);
                $className = htmlspecialchars($exam['className']);

                // Fetch subjects and total marks
                $subjectQuery = "SELECT s.subjectID, s.subjectName, es.totalMarks 
                                FROM exam_subject es 
                                JOIN subject s ON es.subjectID = s.subjectID 
                                WHERE es.examID = ?";
                $subjectStmt = $conn->prepare($subjectQuery);
                $subjectStmt->bind_param("i", $examID);
                $subjectStmt->execute();
                $subjectResult = $subjectStmt->get_result();

                echo "<form action='adminPanel.php?content=viewExam' method='POST' class='exam-container border rounded-lg p-4 bg-gray-50' data-exam-id='$examID'>";
                echo "<input type='hidden' name='examID' value='$examID'>";
                echo "<div class='flex justify-between items-center mb-2'>";
                echo "<span class='exam-name text-lg font-semibold'>$examName</span>";
                echo "<div>";
                echo "<button type='button' class='edit-exam-btn bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-600' data-exam-id='$examID'>Edit</button>";
                echo "<button type='submit' name='saveExam' class='save-exam-btn bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600 hidden' data-exam-id='$examID' onclick=''>Save</button>";
                echo "</div>";
                echo "</div>";
                echo "<span class='class-name text-sm text-gray-600'>Class: <b>$className</b></span>";

                // Subjects table
                echo "<div class='subjects-container mt-2'>";
                echo "<table class='w-full border-collapse'>";
                echo "<thead><tr class='bg-gray-200'><th class='p-2 border'>Subject Name</th><th class='p-2 border'>Total Marks</th></tr></thead>";
                echo "<tbody>";
                while ($subject = $subjectResult->fetch_assoc()) {
                    $subjectID = htmlspecialchars($subject['subjectID']);
                    $subjectName = htmlspecialchars($subject['subjectName']);
                    $totalMarks = htmlspecialchars($subject['totalMarks']);
                    echo "<tr class='subject-row' data-subject-id='$subjectID'>";
                    echo "<td class='p-2 border'>$subjectName</td>";
                    echo "<td class='p-2 border'>";
                    echo "<span class='total-marks'>$totalMarks</span>";
                    echo "<input type='number' name='totalMarks[$subjectID]' class='edit-total-marks hidden w-full p-1 border rounded' value='$totalMarks' min='0' data-subject-id='$subjectID'>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "</div>";
                echo "<input type='text' name='examName' class='edit-exam-name hidden w-full p-2 mt-2 border rounded' value='$examName' required>";
                echo "</form>";

                $subjectStmt->close();
            }
        }
        $stmt->close();
        $conn->close();
        ?>
    </div>
    <?php if (isset($_SESSION['examUpdateMessage'])): ?>
        <div class="mt-4 text-sm <?php echo strpos($_SESSION['examUpdateMessage'], 'Error') !== false ? 'text-red-600' : 'text-green-600'; ?>">
            <?php echo htmlspecialchars($_SESSION['examUpdateMessage']);
            unset($_SESSION['examUpdateMessage']); ?>
        </div>
    <?php endif; ?>
</div>`;

                    <?php
                    // Handle save action
                    $cUpdateExam = 0;
                    if (isset($_POST['saveExam'])) {
                        $cUpdateExam = 0;
                        include 'connection.php';
                        $examID = $conn->real_escape_string($_POST['examID']);
                        $examName = $conn->real_escape_string($_POST['examName']);
                        $totalMarks = $_POST['totalMarks'] ?? [];
                        $instituteID = $_SESSION['instituteID'];

                        $conn->begin_transaction();
                        try {
                            // Update exam name
                            $stmt = $conn->prepare("UPDATE exam SET examName = ? WHERE examID = ? AND instituteID = ?");
                            $stmt->bind_param("sii", $examName, $examID, $instituteID);
                            if (!$stmt->execute()) {
                                throw new Exception("Error updating exam name: " . $stmt->error);
                            }
                            $stmt->close();

                            // Update total marks for subjects
                            foreach ($totalMarks as $subjectID => $marks) {
                                $marks = (int)$marks;
                                if ($marks < 0) {
                                    throw new Exception("Total marks cannot be negative for subject ID: $subjectID");
                                }
                                $stmt = $conn->prepare("UPDATE exam_subject SET totalMarks = ? WHERE examID = ? AND subjectID = ?");
                                $stmt->bind_param("iii", $marks, $examID, $subjectID);
                                if (!$stmt->execute()) {
                                    throw new Exception("Error updating total marks for subject ID: $subjectID: " . $stmt->error);
                                }
                                $stmt->close();
                            }
                            $conn->commit();
                            $cUpdateExam = 1;
                            //$_SESSION['examUpdateMessage'] = "Exam updated successfully.";
                        } catch (Exception $e) {
                            $conn->rollback();
                            $cUpdateExam = 2;
                            //$_SESSION['examUpdateMessage'] = "Error: " . $e->getMessage();
                        }
                        $conn->close();
                    }
                    ?>
                    var cUpdateExam = <?php echo $cUpdateExam ?>;

                    if (cUpdateExam == 1) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Examination updated successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (cUpdateExam == 2) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error updating examination.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    cUpdateExam = 0;

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

        let facultyList = []; // Store faculty data globally
        // New functions for timetable creation
        function toggleHoursDropdown() {
            const classID = document.getElementById("classID").value;
            const hoursDropdown = document.getElementById("hoursDropdown");
            const timetableFields = document.getElementById("timetableFields");
            const submitButton = document.getElementById("submitButton");
            if (classID) {
                hoursDropdown.style.display = "block";
            } else {
                hoursDropdown.style.display = "none";
                timetableFields.innerHTML = "";
                submitButton.classList.add("hidden");
            }
        }

        function fetchFacultyAndToggleHours() {
            const classID = document.getElementById("classID").value;
            const hoursDropdown = document.getElementById("hoursDropdown");
            const timetableFields = document.getElementById("timetableFields");
            const submitButton = document.getElementById("submitButton");

            if (classID) {
                hoursDropdown.style.display = "block";
                $.ajax({
                    url: 'AJAX/fetch_class_faculty1.php', // Create this file (see below)
                    method: 'POST',
                    data: {
                        classID: classID
                    },
                    dataType: 'json',
                    success: function(response) {
                        facultyList = response; // Store faculty data
                        generateTimetableTable(); // Generate table if hours already selected
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + ' - ' + error);
                        alert('Failed to fetch faculty list');
                    }
                });
            } else {
                hoursDropdown.style.display = "none";
                timetableFields.innerHTML = "";
                submitButton.classList.add("hidden");
                facultyList = [];
            }
        }

        function generateTimetableTable() {
            const hours = parseInt(document.getElementById("hoursPerDay").value);
            const classID = document.getElementById("classID").value;
            const timetableFields = document.getElementById("timetableFields");
            const submitButton = document.getElementById("submitButton");
            timetableFields.innerHTML = "";
            if (!hours || !classID || facultyList.length === 0) return;

            const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
            let html = `
    <table class="w-full text-sm text-left text-gray-500 border-collapse">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-4 py-3 border">Day</th>`;
            for (let i = 1; i <= hours; i++) {
                html += `<th class="px-4 py-3 border">Period ${i}</th>`;
            }
            html += `
            </tr>
        </thead>
        <tbody>`;
            days.forEach(day => {
                html += `
            <tr class="bg-white border-b">
                <td class="px-4 py-2 border">${day}</td>`;
                for (let i = 1; i <= hours; i++) {
                    html += `
                    <td class="px-4 py-2 border">
                    <select name="timetable[${day}][${i}]" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="">Select Faculty</option>`;
                    facultyList.forEach(faculty => {
                        html += `<option value="${faculty.facultyID}">${faculty.name} (ID: ${faculty.facultyID}) - ${faculty.subjectName || 'No Subject'}</option>`;
                    });
                    html += `
                    </select>
                    </td>`;
                }
                html += `
            </tr>`;
            });
            html += `
        </tbody>
    </table>`;
            timetableFields.innerHTML = html;
            submitButton.classList.remove("hidden");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get("content");
            if (content) {
                showContent(content);
            }
        });


        // For viewTimetable
        function fetchTimetable() {
            const classID = document.getElementById("classID").value;
            const timetableDisplay = document.getElementById("timetableDisplay");

            if (!classID) {
                timetableDisplay.innerHTML = "";
                return;
            }

            $.ajax({
                url: 'AJAX/fetch_timetable.php',
                method: 'POST',
                data: {
                    classID: classID
                },
                dataType: 'json',
                success: function(timetableResponse) {
                    if (timetableResponse.error) {
                        timetableDisplay.innerHTML = `<p class="text-red-600">${timetableResponse.error}</p>`;
                        return;
                    }
                    console.log('Timetable Response:', JSON.stringify(timetableResponse, null, 2));

                    const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
                    const timetableExists = timetableResponse.timetable && timetableResponse.timetable.length > 0;
                    let html = '';

                    if (!timetableExists) {
                        <?php $_SESSION['timetableEditMessage'] = ' '; ?>
                        html = `<p class="text-red-600">No timetable exists for this class.</p>`;
                        timetableDisplay.innerHTML = html;
                        return;
                    }

                    const maxPeriods = timetableResponse.maxPeriods || 0;
                    html = `
    <table class="w-full text-sm text-left text-gray-500 border-collapse">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-4 py-3 border">Day</th>`;
                    for (let i = 1; i <= maxPeriods; i++) {
                        html += `<th class="px-4 py-3 border">Period ${i}</th>`;
                    }
                    html += `
            </tr>
        </thead>
        <tbody>`;
                    days.forEach(day => {
                        html += `
            <tr class="bg-white border-b">
                <td class="px-4 py-2 border">${day}</td>`;
                        for (let i = 1; i <= maxPeriods; i++) {
                            const entry = timetableResponse.timetable.find(t => t.dayOfWeek === day && t.periodNumber === i);
                            html += `
                    <td class="px-4 py-2 border">${entry ? `${entry.name} (${entry.subjectName || 'No Subject'})` : 'Not Assigned'}</td>`;
                        }
                        html += `
            </tr>`;
                    });
                    html += `
        </tbody>
    </table>`;
                    timetableDisplay.innerHTML = html;
                },
                error: function(xhr, status, error) {
                    console.error('Timetable Fetch Error:', status, error, xhr.responseText);
                    timetableDisplay.innerHTML = `<p class="text-red-600">Failed to load timetable. Raw response: ${xhr.responseText}</p>`;
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get("content");
            if (content) {
                showContent(content);
            }
        });


        // For editTimetable
        function fetchTimetableForEdit() {
            const classID = document.getElementById("classID").value;
            const timetableEditDisplay = document.getElementById("timetableEditDisplay");
            const saveButton = document.getElementById("saveButton");

            if (!classID) {
                timetableEditDisplay.innerHTML = "";
                saveButton.classList.add("hidden");
                return;
            }

            $.ajax({
                url: 'AJAX/fetch_timetable.php',
                method: 'POST',
                data: {
                    classID: classID
                },
                dataType: 'json',
                success: function(timetableResponse) {
                    if (timetableResponse.error) {
                        timetableEditDisplay.innerHTML = `<p class="text-red-600">${timetableResponse.error}</p>`;
                        saveButton.classList.add("hidden");
                        return;
                    }
                    console.log('Timetable Response:', JSON.stringify(timetableResponse, null, 2));

                    $.ajax({
                        url: 'AJAX/fetch_class_faculty.php',
                        method: 'POST',
                        data: {
                            classID: classID
                        },
                        dataType: 'json',
                        success: function(facultyResponse) {
                            if (facultyResponse.error) {
                                timetableEditDisplay.innerHTML = `<p class="text-red-600">${facultyResponse.error}</p>`;
                                saveButton.classList.add("hidden");
                                return;
                            }
                            console.log('Faculty Response:', JSON.stringify(facultyResponse, null, 2));

                            const days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
                            const timetableExists = timetableResponse.timetable && timetableResponse.timetable.length > 0;
                            let html = '';

                            if (!timetableExists) {
                                html = `<p class="text-red-600">No timetable exists for this class.</p>`;
                                timetableEditDisplay.innerHTML = html;
                                saveButton.classList.add("hidden");
                                return;
                            }

                            const maxPeriods = timetableResponse.maxPeriods || 0;
                            html = `
    <table class="w-full text-sm text-left text-gray-500 border-collapse">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-4 py-3 border">Day</th>`;
                            for (let i = 1; i <= maxPeriods; i++) {
                                html += `<th class="px-4 py-3 border">Period ${i}</th>`;
                            }
                            html += `
            </tr>
        </thead>
        <tbody>`;
                            days.forEach(day => {
                                html += `
            <tr class="bg-white border-b">
                <td class="px-4 py-2 border">${day}</td>`;
                                for (let i = 1; i <= maxPeriods; i++) {
                                    const entry = timetableResponse.timetable.find(t => t.dayOfWeek === day && t.periodNumber === i);
                                    const currentFacultyID = entry ? String(entry.facultyID) : '';
                                    console.log(`Day: ${day}, Period: ${i}, Entry:`, entry, `Current Faculty ID: ${currentFacultyID}`);
                                    html += `
                    <td class="px-4 py-2 border">
                        <select name="timetable[${day}][${i}]" class="shadow border rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="">Select Faculty</option>`;
                                    facultyResponse.forEach(faculty => {
                                        const facultyID = String(faculty.facultyID);
                                        const selected = currentFacultyID === facultyID ? 'selected' : '';
                                        html += `<option value="${facultyID}" ${selected}>${faculty.name} (ID: ${facultyID}) - ${faculty.subjectName || 'No Subject'}</option>`;
                                    });
                                    html += `
                        </select>
                    </td>`;
                                }
                                html += `
            </tr>`;
                            });
                            html += `
        </tbody>
    </table>`;
                            timetableEditDisplay.innerHTML = html;
                            saveButton.classList.remove("hidden");
                        },
                        error: function(xhr, status, error) {
                            console.error('Faculty Fetch Error:', status, error, xhr.responseText);
                            timetableEditDisplay.innerHTML = `<p class="text-red-600">Failed to fetch faculty list. Raw response: ${xhr.responseText}</p>`;
                            saveButton.classList.add("hidden");
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Timetable Fetch Error:', status, error, xhr.responseText);
                    timetableEditDisplay.innerHTML = `<p class="text-red-600">Failed to load timetable. Raw response: ${xhr.responseText}</p>`;
                    saveButton.classList.add("hidden");
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get("content");
            if (content) {
                showContent(content);
            }
        });

        function fetchSubjects() {
            const classID = document.getElementById('classID').value;
            const subjectsList = document.getElementById('subjectsList');
            const submitButton = document.getElementById('submitButton');
            subjectsList.innerHTML = '';
            if (!classID) {
                submitButton.classList.add('hidden');
                return;
            }
            $.ajax({
                url: 'AJAX/fetch_class_subjects.php',
                method: 'POST',
                data: {
                    classID: classID
                },
                dataType: 'json',
                success: function(response) {
                    if (response.length > 0) {
                        let html = '<h3 class="text-lg font-semibold mb-2">Set Total Marks</h3>';
                        response.forEach(subject => {
                            html += `
    <div class="mb-4 flex items-center">
        <label class="w-48 text-gray-700">${subject.subjectName}</label>
        <input type="number" name="totalMarks[${subject.subjectID}]" class="shadow border rounded w-24 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="0" required>
    </div>`;
                        });
                        subjectsList.innerHTML = html;
                        submitButton.classList.remove('hidden');
                    } else {
                        subjectsList.innerHTML = '<p class="text-red-600">No subjects found for this class.</p>';
                        submitButton.classList.add('hidden');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + ' - ' + error);
                    subjectsList.innerHTML = '<p class="text-red-600">Failed to load subjects.</p>';
                    submitButton.classList.add('hidden');
                }
            });
        }


        function initializeViewExamListeners() {
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-exam-btn')) {
                    const examID = e.target.getAttribute('data-exam-id');
                    const container = document.querySelector(`.exam-container[data-exam-id="${examID}"]`);
                    const examNameSpan = container.querySelector('.exam-name');
                    const totalMarks = container.querySelectorAll('.total-marks');
                    const editTotalMarks = container.querySelectorAll('.edit-total-marks');
                    const editExamName = container.querySelector('.edit-exam-name');
                    const editButton = e.target;
                    const saveButton = container.querySelector('.save-exam-btn');

                    // Switch to edit mode
                    examNameSpan.classList.add('hidden');
                    editExamName.classList.remove('hidden');
                    totalMarks.forEach((mark, index) => {
                        mark.classList.add('hidden');
                        editTotalMarks[index].classList.remove('hidden');
                    });
                    editButton.classList.add('hidden');
                    saveButton.classList.remove('hidden');
                }
            });
        }

        // Call this function after content is loaded
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const content = urlParams.get('content');
            if (content === 'viewExam') {
                initializeViewExamListeners();
            }
        });

        // Override showContent to handle dynamic loading
        const originalShowContent = showContent;
        showContent = function(page) {
            originalShowContent(page);
            if (page === 'viewExam') {
                initializeViewExamListeners();
            }
        };
    </script>
</body>

</html>