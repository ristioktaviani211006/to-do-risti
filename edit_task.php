<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$task_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$task_id, $user_id]);
$task = $stmt->fetch();

if (!$task) {
    echo "Task not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, status = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$title, $description, $due_date, $priority, $status, $task_id, $user_id]);

    header("Location: tasks.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 36px;
            color: white;
        }

        .logout-button {
            text-decoration: none;
            background-color: rgb(255, 255, 255);
<<<<<<< HEAD
            
=======
            color: ;
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 10px;
        }

        .logout-button:hover {
            background-color: rgb(125, 57, 192);
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgb(255, 255, 255);
        }

        input[type="text"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: rgb(97, 76, 175);
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(97, 76, 175);
        }

        .logout-button {
            padding: 10px 20px;
            background-color: white;
            color: rgb(97, 76, 175);
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .logout-button:hover {
            background-color: #ddd;
        }

        #due_date {
            width: calc(100% - 20px);
        }

        header {
            background-color: rgb(97, 76, 175);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<header>
    <h1>Edit Task</h1>
    <a href="logout.php" class="logout-button">Logout</a>
</header>

<div class="container">
    <form method="POST">
<<<<<<< HEAD
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required <?php if ($task['status'] == 'selesai' || ($task['priority'] != 'penting' && strtotime($task['due_date']) < time())) echo 'disabled';?>

=======
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>>
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
        <textarea name="description" placeholder="Deskripsi tugas" <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>><?= htmlspecialchars($task['description']) ?></textarea>
        <input type="date" name="due_date" value="<?= htmlspecialchars($task['due_date']) ?>" required <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>>
        <select name="priority" <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>>
            <option value="penting" <?= $task['priority'] == 'penting' ? 'selected' : '' ?>>penting</option>
            <option value="tidak penting" <?= $task['priority'] == 'tidak penting' ? 'selected' : '' ?>>tidak penting</option>
            <option value="biasa" <?= $task['priority'] == 'biasa' ? 'selected' : '' ?>>biasa</option>
        </select>
<<<<<<< HEAD
        
=======
        <select name="status" <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>>
            <option value="ditunda" <?= $task['status'] == 'ditunda' ? 'selected' : '' ?>>ditunda</option>
            <option value="belum dikerjakan" <?= $task['status'] == 'belum dikerjakan' ? 'selected' : '' ?>>belum dikerjakan</option>
            <option value="selesai" <?= $task['status'] == 'selesai' ? 'selected' : '' ?>>selesai</option>
        </select>
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
        <button type="submit" <?php if ($task['status'] == 'selesai' || strtotime($task['due_date']) < time()) echo 'disabled'; ?>>Update Task</button>
    </form>

    <a href="tasks.php" class="back-button">Kembali</a>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    const dueDate = document.querySelector('[name="due_date"]').value;

    if (dueDate && dueDate < today) {
        const inputs = document.querySelectorAll('input, select, textarea, button');
        inputs.forEach(input => {
            input.disabled = true;
        });
    }

    document.getElementById('due_date').setAttribute('min', today);
</script>

</body>
</html>
