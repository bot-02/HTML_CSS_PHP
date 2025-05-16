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

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $password]);

    header('Location: login.php');
    exit;
}
?>

<form method="POST">
<center>
<br><br><br><br><br>
    Username: <input type="text" name="username" class="f" required>
    Password: <input type="password" name="password" class="f" required>
    email: <input type="text" name="email" class="f" required><br><br><br>
    <button type="submit" class="j">Register</button>
</center>
</form>
