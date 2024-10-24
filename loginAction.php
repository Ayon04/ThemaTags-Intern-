<?php
session_start();
require '../Model/data.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['error_login']);

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Input validation
    $errors = [];
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    // If there are no validation errors, proceed to check credentials
    if (empty($errors)) {
        if (loginCheck($username, $password)) {
            $_SESSION['LoggedIn'] = true;
            $_SESSION['user'] = $username; // Store username in session

            header("Location: ../View/dashboard.php");
            exit();
        } else {
            $_SESSION['error_login'] = "Invalid username or password.";
            header("Location: ../View/login.php");
            exit();
        }
    } else {
        // Store errors in session for display
        foreach ($errors as $key => $message) {
            $_SESSION['error_' . $key] = $message;
        }
        header("Location: ../View/login.php");
        exit();
    }
}
?>
