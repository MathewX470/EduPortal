<script src="path/to/jquery.js"></script>
<script src="path/to/bootstrap.js"></script>
<script src="path/to/otherfile.js"></script>
<script>
    $(document).ready(function() {
        var showModal = '<?php echo $show_modal; ?>';
        if (showModal == "1") {
            $("#myModal").modal("show");
        }
    });
</script>