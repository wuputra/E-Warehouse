<?php if (isset($response) && isset($response['response'])): ?>
    <?php if ($response['response'] === "negative"): ?>
        <script>
            swal('Error', '<?php echo addslashes($response['alert']); ?>', 'error');
        </script>
    <?php elseif ($response['response'] === "positive"): ?>
        <script>
            swal({
                title: "Berhasil",
                text: "",
                type: "success",
                showCancelButton: false,
                confirmButtonText: "Yes",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.href = "<?php echo addslashes($response['redirect']); ?>";
                }
            });
        </script>
    <?php endif; ?>
<?php endif; ?>