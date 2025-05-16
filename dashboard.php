<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch only the workouts for the logged-in user
$stmt = $pdo->prepare("SELECT * FROM workouts WHERE user_id = ? ORDER BY workout_date DESC");
$stmt->execute([$user_id]);
$workouts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your existing styles */
        body {
            background-color: lightblue;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            max-width: 800px;
            margin: auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            margin: 0 5px;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .center {
            text-align: center;
            margin-top: 50px;
        }

        .add-link {
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .add-link:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
<center>
    <table id="workoutTable">
        <br><br><br><br><br>
        <thead>
    <tr>
        <th>Date</th>
        <th>Exercise Type</th>
        <th>Duration (min)</th>
        <th>Calories Burned</th>
        <th>Actions</th>
    </tr>
</thead>

<tbody>
    <?php foreach ($workouts as $workout): ?>
        <tr>
            <td><?= htmlspecialchars($workout['workout_date']) ?></td>
            <td><?= htmlspecialchars($workout['exercise_type']) ?></td>
            <td><?= htmlspecialchars($workout['duration']) ?></td>
            <td><?= htmlspecialchars($workout['calories_burned']) ?></td>
            <td>
                <a href="edit_workout.php?id=<?= $workout['id'] ?>">Edit</a>
                <a href="delete_workout.php?id=<?= $workout['id'] ?>" onclick="return confirm('Are you sure you want to delete this workout?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <br><br><br>
    <a href="search.php" class="btn">Search</a>
    <a href="add_workout.php" class="btn">Add Workout</a>
</center>
</body>
</html>
