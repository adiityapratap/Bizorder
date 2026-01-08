<!-- logout.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Logout</title>
</head>
<body>
    <script>
        // Clear local storage upon logout
       
        localStorage.clear();
        // Redirect to login page or any other page after logout
        window.location.replace("<?php echo $redirectUrl ?>");
    </script>
</body>
</html>
