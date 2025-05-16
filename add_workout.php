<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';
$date = $type = $duration = $calories = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['workout_date'];
    $type = $_POST['exercise_type'];
    $duration = $_POST['duration'];
    $calories = $_POST['calories_burned'];

    $stmt = $pdo->prepare("INSERT INTO workouts (user_id, workout_date, exercise_type, duration, calories_burned)
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $date, $type, $duration, $calories]);
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Workout</title>
    <style>
        body {
            background-color: #f4f7fc;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back-link {
            text-align: center;
            margin-top: 15px;
            display: block;
            color: #007BFF;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form method="POST" class="form-container" action="add_workout.php">
        <h2>Add New Workout</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <label for="workout_date">Date</label>
        <input type="date" name="workout_date" id="workout_date" required value="<?= htmlspecialchars($date) ?>">

        <label for="exercise_type">Exercise Type</label>
        <input type="text" name="exercise_type" id="exercise_type" required value="<?= htmlspecialchars($type) ?>">

        <label for="duration">Duration (min)</label>
        <input type="number" name="duration" id="duration" required value="<?= htmlspecialchars($duration) ?>">

        <label for="calories_burned">Calories Burned</label>
        <input type="number" name="calories_burned" id="calories_burned" required value="<?= htmlspecialchars($calories) ?>">

        <button type="submit">Add Workout</button>
        <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
    </form>

</body>
</html>
