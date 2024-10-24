<?php
include('dbConn.php'); 

function insertUser($fullname, $username, $email, $hashedPassword) {
    global $pdo; 

    $stmt = $pdo->prepare("INSERT INTO signupuser (fullname, username, email, password) VALUES (:fullname, :username, :email, :password)");

    $stmt->bindParam(':fullname', $fullname);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    return $stmt->execute();
}


function fetchUserByUsername($username) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM signupuser WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch user data
}


function loginCheck($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM signupuser WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists, verify the password
    if ($user && password_verify($password, $user['password'])) {
        return true; // Credentials are valid
    }

    return false; // Invalid credentials
}




?>
