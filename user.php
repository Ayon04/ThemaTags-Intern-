<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
</head>
<body>

    <h1>User Signup</h1>

    <?php
    session_start();

    if (isset($_SESSION['error_fullname'])) {
        echo "<p style='color:red;'>".$_SESSION['error_fullname']."</p>";
        unset($_SESSION['error_fullname']);
    }

    if (isset($_SESSION['error_username'])) {
        echo "<p style='color:red;'>".$_SESSION['error_username']."</p>";
        unset($_SESSION['error_username']);
    }

    if (isset($_SESSION['error_email'])) {
        echo "<p style='color:red;'>".$_SESSION['error_email']."</p>";
        unset($_SESSION['error_email']);
    }

    if (isset($_SESSION['error_password'])) {
        echo "<p style='color:red;'>".$_SESSION['error_password']."</p>";
        unset($_SESSION['error_password']);
    }
    ?>

    <form action="../Controller/userAction.php" method="POST" novalidate>
        <label for="fullname">Full Name:</label>
        <input type="text" id="fullname" name="fullname" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Sign Up">
    </form>

</body>
</html>
