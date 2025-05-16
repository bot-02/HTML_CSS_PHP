<?php 
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$username = isset($_GET['username']) ? trim($_GET['username']) : '';

$results = [];

if (!empty($username)) {
    // Query to search workouts by username
    $query = "
        SELECT w.*, u.username 
        FROM workouts w
        JOIN users u ON w.user_id = u.id
        WHERE u.username LIKE ?
        ORDER BY w.workout_date DESC
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(["%$username%"]);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Workouts by Username</title>
    <style>
        body {
            background-color: lightblue;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            width: 90%;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        thead {
            background-color: #007BFF;
            color: white;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            margin: 20px auto;
            display: block;
            width: fit-content;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .search-form {
            text-align: center;
            margin-bottom: 30px;
        }

        .search-form input {
            padding: 8px;
            margin: 0 5px;
        }

        a {
            text-decoration: none;
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Search Workouts by Username</h2>

<form method="get" action="search.php" class="search-form">
    <input type="text" name="username" placeholder="Enter Username" value="<?= htmlspecialchars($username) ?>" required>
    <button type="submit" class="btn">Search</button>
</form>

<?php if (!empty($username)): ?>
    <h3 style="text-align:center;">Results for: <?= htmlspecialchars($username) ?></h3>
    <?php if (count($results) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Exercise Type</th>
                    <th>Duration (min)</th>
                    <th>Calories Burned</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['workout_date']) ?></td>
                        <td><?= htmlspecialchars($row['exercise_type']) ?></td>
                        <td><?= htmlspecialchars($row['duration']) ?></td>
                        <td><?= htmlspecialchars($row['calories_burned']) ?></td>
                        <td>
                            <a href="edit_workout.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete_workout.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this workout?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No workouts found for this username.</p>
    <?php endif; ?>
<?php endif; ?>

<a href="dashboard.php" class="btn">Back to Dashboard</a>

</body>
</html>
