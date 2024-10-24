<?php
// Assuming you have a database connection in dbConn.php


session_start();
if (!isset($_SESSION['LoggedIn']) || $_SESSION['LoggedIn'] !== true) {
    header("Location: ../View/login.php"); // Redirect to login if not logged in
    exit();
}
include('../Model/dbConn.php');

$stmt = $pdo->query("SELECT fullname, username, email FROM signupuser");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>
<body>
    
<h1>Hello, User</h1>

<table border="1">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Username</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No users found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>


<a style="color: blue; font-weight: bold;" href="../controller/LogoutAction.php">Logout</a>


</body>
</html>
