<!DOCTYPE html>
<html>
<head>
    <title>Preparing Download</title>
</head>
<body>
    <p>Preparing your download...</p>

    <script>
        // Trigger file download
        window.location.href = "{{ $download_url }}";

        // Redirect after 3 seconds
        setTimeout(function() {
            window.location.href = "{{ $redirect_url }}";
        }, 3000);
    </script>
</body>
</html>
