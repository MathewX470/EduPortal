<?php
session_start();

$_SESSION = array(); // Clear all session data
session_destroy(); // Destroy the session

// Output the SweetAlert script first
echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Logout Successful',
            text: 'Redirecting to Homepage',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500 // Timer set for 1.5 seconds
        }).then(() => {
            window.location.href = 'welcomePage.php'; // Redirect to homepage after alert
        });
    });
</script>";

exit(); // Ensure no further PHP code is executed
