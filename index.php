<?php
<<<<<<< HEAD
header("Location: login.php");
exit;
=======
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'] ?? '';
    $due_date = $_POST['due_date'] ?? null;
    $priority = $_POST['priority'] ?? 'Medium';
    $status = $_POST['status'] ?? 'Pending';

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $due_date, $priority, $status]);
}

$tasks = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$tasks->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-do List</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        text-align: center;
    }

    h1 {
        font-size: 2em;
        margin: 0;
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
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1em;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
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
        color: #4CAF50;
        text-decoration: none;
    }

    .actions a:hover {
        text-decoration: underline;
    }
</style>
</head>
<body>

<header>
    <h1>To-do List</h1>
</header>

<div class="container">
    <form method="POST">
        <input type="text" name="title" placeholder="Masukkan kegiatan" required>
        <textarea name="description" placeholder="Deskripsi tugas"></textarea>
        <input type="date" name="due_date">
        <select name="priority">
            <option value="penting">penting</option>
            <option value="tidak penting" selected>tidak penting</option>
            <option value="biasa">biasa</option>
        </select>
        <select name="status">
            <option value="ditunda" selected>ditunda</option>
            <option value="belum dikerjakan">belum dikerjakan</option>
            <option value="selesai">selesai</option>
        </select>
        <button type="submit">Tambah List</button>
    </form>

    <table>
        <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal Tenggat</th>
            <th>Prioritas</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= htmlspecialchars($task['title']) ?></td>
            <td><?= htmlspecialchars($task['description']) ?></td>
            <td><?= $task['due_date'] ?></td>
            <td><?= htmlspecialchars($task['priority']) ?></td>
            <td><?= htmlspecialchars($task['status']) ?></td>
            <td class="actions">
                <a href="subtasks.php?task_id=<?= $task['id'] ?>">Lihat Subtask</a>
                <a href="delete_task.php?id=<?= $task['id'] ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
