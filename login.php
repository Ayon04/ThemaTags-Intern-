<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Signup</title>
</head>
<body>

    <h1>User Login</h1>

    <?php
    session_start();

   

    if (isset($_SESSION['error_username'])) {
        echo "<p style='color:red;'>".$_SESSION['error_username']."</p>";
        unset($_SESSION['error_username']);
    }

   
    if (isset($_SESSION['error_password'])) {
        echo "<p style='color:red;'>".$_SESSION['error_password']."</p>";
        unset($_SESSION['error_password']);
    }
    ?>

    <form action="../Controller/loginAction.php" method="POST" novalidate>
                
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>

</body>
</html>
