<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            background-color: lightblue;
        }
        .f {
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            color: blue;
        }
        .j {
            background-color: blue;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php
// Include database connection
require_once '../config/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Invalid credentials";
    }
}
?>

<form method="POST">
<center>
    <br><br><br><br><br>
    Username: <input type="text" name="username" class="f" required>
    Password: <input type="password" name="password" class="f" required><br><br><br>
    <button type="submit" class="j">Login</button>
</center>
</form>