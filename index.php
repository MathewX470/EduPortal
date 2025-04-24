<?php
// Simulate some input or task
$number = 24; // Replace with your actual input or logic
$show_modal = false;

if ($number % 2 == 0) {
    $show_modal = true; // Trigger modal if number is even
}
?>

<html>

<head>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Bootstrap Modal -->
    <div id="saveModal" class="modal fade" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white text-center p-4 rounded-top border-0 ">
                    <h5 class="modal-title" id="saveModalLabel">Success</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light">
                    <span class="display-4 text-success">✓</span>
                    <p class="mt-3 fs-4">Work Saved!</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">Got It</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Check PHP condition
            var showModal = <?php echo json_encode($show_modal); ?>;

            // Show modal if number is even
            if (showModal) {
                $("#saveModal").modal("show");
            }
        });
    </script>
</body>

</html>