<?php

include('dbConn.php'); 

class Data {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function insertUser($fullname, $username, $email, $hashedPassword) {
        $stmt = $this->pdo->prepare("INSERT INTO signupuser (fullname, username, email, password) VALUES (:fullname, :username, :email, :password)");

        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function fetchUserByUsername($username) {
        $stmt = $this->pdo->prepare("SELECT * FROM signupuser WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data
    }

    public function loginCheck($username, $password) {
        $stmt = $this->pdo->prepare("SELECT * FROM signupuser WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true; 
        }

        return false; 
    }
}

?>
