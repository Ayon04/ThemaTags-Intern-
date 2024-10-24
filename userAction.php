<?php
session_start();

require '../Model/data.php';

class User {
    public $fullname;
    public $username;
    public $email;
    public $password;

    public function __construct($fullname, $username, $email, $password) {
        $this->fullname = $this->sanitizeInput($fullname);
        $this->username = $this->sanitizeInput($username);
        $this->email = $this->sanitizeInput($email);
        $this->password = $this->sanitizeInput($password);
    }

    private function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    public function validate() {
        $errors = [];

        if (empty($this->fullname)) {
            $errors['fullname'] = "Full name is required.";
        }
        if (empty($this->username)) {
            $errors['username'] = "Username is required.";
        }
        if (empty($this->email)) {
            $errors['email'] = "Email is required.";
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format.";
        }
        if (empty($this->password)) {
            $errors['password'] = "Password is required.";
        } elseif (strlen($this->password) < 6) {
            $errors['password'] = "Password must be at least 6 characters long.";
        }

        return $errors;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    unset($_SESSION['error_fullname'], $_SESSION['error_username'], $_SESSION['error_email'], $_SESSION['error_password']);

    // Create a User instance
    $user = new User($_POST['fullname'], $_POST['username'], $_POST['email'], $_POST['password']);
    
    $errors = $user->validate();

    if (empty($errors)) {
        // Hash the password
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);

        // Call insertUser with the user properties
        if (insertUser($user->fullname, $user->username, $user->email, $hashedPassword)) {
            header("Location: ../View/dashboard.php");
            exit();
        } else {
            $_SESSION['error_general'] = "Error: Could not register user.";
            header("Location: ../View/user.php");
            exit();
        }
    } else {
        foreach ($errors as $key => $message) {
            $_SESSION['error_' . $key] = $message;
        }
        header("Location: ../View/user.php");
        exit();
    }
}
?>
