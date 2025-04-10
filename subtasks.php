<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_GET['task_id'])) {
    header("Location: login.php");
    exit;
}

$task_id = $_GET['task_id'];

$stmt = $pdo->prepare("SELECT title, due_date FROM tasks WHERE id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch();

$due_date = $task['due_date'];
$current_date = date('Y-m-d');


$is_due_passed = $current_date > $due_date;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['description'])) {
    $description = $_POST['description'];
    $stmt = $pdo->prepare("INSERT INTO subtasks (task_id, description) VALUES (?, ?)");
    $stmt->execute([$task_id, $description]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subtask_id']) && isset($_POST['completed'])) {
    $subtask_id = $_POST['subtask_id'];
    $completed = $_POST['completed'] == 'on' ? 1 : 0;
    $stmt = $pdo->prepare("UPDATE subtasks SET completed = ? WHERE id = ?");
    $stmt->execute([$completed, $subtask_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && isset($_POST['subtask_id'])) {
    $subtask_id = $_POST['subtask_id'];
    $stmt = $pdo->prepare("DELETE FROM subtasks WHERE id = ?");
    $stmt->execute([$subtask_id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subtask_id']) && isset($_POST['new_description'])) {
    $edit_subtask_id = $_POST['edit_subtask_id'];
    $new_description = $_POST['new_description'];
    $stmt = $pdo->prepare("UPDATE subtasks SET description = ? WHERE id = ?");
    $stmt->execute([$new_description, $edit_subtask_id]);
}

$subtasks = $pdo->prepare("SELECT * FROM subtasks WHERE task_id = ?");
$subtasks->execute([$task_id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subtasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: rgb(97, 76, 175);
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            margin: 0;
            font-size: 2em;
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

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"],
        textarea,
        select,
        input[type="date"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            width: 100%;
        }

        textarea {
            grid-column: span 2;
            height: 100px;
        }

        button {
            grid-column: span 2;
            padding: 12px;
            background-color: rgb(97, 76, 175);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(80, 60, 150);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .actions a {
            margin-right: 10px;
            color: rgb(97, 76, 175);
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

    </style>
</head>
<body>

<header>
    <h1>Subtasks</h1>
    <h2>Tugas Utama: <?= htmlspecialchars($task['title']) ?></h2>
</header>

<div class="container">
    <form method="POST">
        <input type="text" name="description" placeholder="Subtask Description" required <?= $is_due_passed ? 'disabled' : '' ?>>
        <button type="submit" <?= $is_due_passed ? 'disabled' : '' ?>>Tambah Subtask</button>
    </form>

    <table>
        <tr>
            <th>Deskripsi</th>
            <th>Selesai</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($subtasks as $subtask): ?>
            <tr>
                <td><?= htmlspecialchars($subtask['description']) ?></td>
                <td class="checkbox">
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="subtask_id" value="<?= $subtask['id'] ?>">
                        <input type="checkbox" name="completed" <?= $subtask['completed'] ? 'checked' : '' ?> 
                               onclick="this.form.submit()" <?= $is_due_passed ? 'disabled' : '' ?>>
                    </form>
                </td>
                <td>
                    <form method="POST" style="margin: 30;">
                        <input type="hidden" name="edit_subtask_id" value="<?= $subtask['id'] ?>">
                        <input type="text" name="new_description" placeholder="Edit subtask" required <?= $is_due_passed ? 'disabled' : '' ?>>
                        <button type="submit" <?= $is_due_passed ? 'disabled' : '' ?>>Edit</button>
                    </form>
                    <form method="POST" style="margin: 0;">
                        <input type="hidden" name="subtask_id" value="<?= $subtask['id'] ?>">
                        <div></div>
                        <button type="submit" name="delete" value="1" onclick="return confirm('Apakah kamu yakin ingin menghapus subtask ini?');" <?= $is_due_passed ? 'disabled' : '' ?>>Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="tasks.php">Kembali</a>
</div>

</body>
</html>
