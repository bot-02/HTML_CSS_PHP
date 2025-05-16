<?php
require_once '../config/db.php';
session_start();

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Make sure an ID was provided
if (!isset($_GET['id'])) {
    echo "Workout ID not provided.";
    exit;
}

$workoutId = $_GET['id'];
$userId = $_SESSION['user_id'];

// Delete the workout that belongs to the logged-in user
$stmt = $pdo->prepare("DELETE FROM workouts WHERE id = ? AND user_id = ?");
$deleted = $stmt->execute([$workoutId, $userId]);

// Redirect back to dashboard.php
header("Location: dashboard.php");
exit;
?>