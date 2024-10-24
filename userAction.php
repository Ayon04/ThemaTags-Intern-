<?php
session_start();
require '../Model/dbConn.php'; // Ensure your database connection is included

class User {
    private $fullname;
    private $username;
    private $email;
    private $password;
    private $pdo;

    public function __construct($fullname, $username, $email, $password, $pdo) {
        $this->fullname = $this->sanitizeInput($fullname);
        $this->username = $this->sanitizeInput($username);
        $this->email = $this->sanitizeInput($email);
        $this->password = $this->sanitizeInput($password);
        $this->pdo = $pdo; // Store PDO instance
    }

    private function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
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

    public function register() {
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        return $this->insertUser($this->fullname, $this->username, $this->email, $hashedPassword);
    }

    private function insertUser($fullname, $username, $email, $hashedPassword) {
        $stmt = $this->pdo->prepare("INSERT INTO signupuser (fullname, username, email, password) VALUES (:fullname, :username, :email, :password)");

        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }
}

class UserRegistration {
    private $user;

    public function __construct($fullname, $username, $email, $password, $pdo) {
        $this->user = new User($fullname, $username, $email, $password, $pdo);
    }

    public function handleRegistration() {
        unset($_SESSION['error_fullname'], $_SESSION['error_username'], $_SESSION['error_email'], $_SESSION['error_password']);
        
        $errors = $this->user->validate();

        if (empty($errors)) {
            if ($this->user->register()) {
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
}

// Usage
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new PDO('mysql:host=localhost;dbname=user;charset=utf8mb4', 'root', '');
    $registration = new UserRegistration(
        $_POST['fullname'],
        $_POST['username'],
        $_POST['email'],
        $_POST['password'],
        $pdo // Pass the PDO instance
    );
    $registration->handleRegistration();
}
?>
