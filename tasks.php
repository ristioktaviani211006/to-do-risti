<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Menambahkan tugas baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];
    $priority = $_POST['priority'];

    $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date, priority, status) 
                           VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $due_date, $priority, "belum dikerjakan"]);
}

// Mengupdate status tugas jika tidak memiliki subtask yang belum selesai
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $task_id = $_POST['task_id'];

    // Cek apakah masih ada subtask yang belum selesai
    $subtask_check = $pdo->prepare("SELECT COUNT(*) FROM subtasks WHERE task_id = ? AND completed != 0");
    $subtask_check->execute([$task_id]);
    $unfinished_subtasks = $subtask_check->fetchColumn();

    if ($unfinished_subtasks > 0) {
        $_SESSION['error'] = "Tidak bisa menyelesaikan tugas karena masih ada subtask yang belum selesai!";
        header("Location: index.php");
        exit;
    }

    // Jika tidak ada subtask yang belum selesai, update status tugas
    $stmt = $pdo->prepare("UPDATE tasks SET status = 'selesai' WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $user_id]);
}

// Mengambil daftar tugas dan jumlah subtask yang belum selesai
$tasks = $pdo->prepare("
    SELECT t.*, 
           (SELECT COUNT(*) FROM subtasks WHERE task_id = t.id AND status != 'selesai') AS unfinished_subtasks
    FROM tasks t
    WHERE t.user_id = ?
    ORDER BY t.status ASC, t.due_date ASC
");
$tasks->execute([$user_id]);
?>

<!DOCTYPE html>
<html lang="id">
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

        .status-checkbox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .completed {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>
<body>

<header>
    <h1>To-do List</h1>
    <a href="logout.php" class="logout-button">Logout</a>
</header>

<div class="container">
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Judul Tugas" required>
        <textarea name="description" placeholder="Deskripsi tugas"></textarea>
        <input type="date" name="due_date" id="due_date" required min="<?= date('Y-m-d') ?>">

        <select name="priority">
            <option value="penting">penting</option>
            <option value="tidak penting" selected>tidak penting</option>
            <option value="biasa">biasa</option>
        </select>
        <button type="submit">Tambah Tugas</button>
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
            <td class="<?= $task['status'] === 'selesai' ? 'completed' : '' ?>">
                <?= htmlspecialchars($task['title']) ?>
            </td>
            <td class="<?= $task['status'] === 'selesai' ? 'completed' : '' ?>">
                <?= htmlspecialchars($task['description']) ?>
            </td>
            <td><?= htmlspecialchars($task['due_date']) ?></td>
            <td><?= htmlspecialchars($task['priority']) ?></td>
            <td class="status-checkbox">
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                    <input type="hidden" name="update_status" value="1">
                    <input type="checkbox" name="status" 
    <?= $task['status'] === 'selesai' ? 'checked' : '' ?>
    <?= $task['unfinished_subtasks'] > 0 ? 'disabled' : '' ?>
    onchange="this.form.submit();"
    onclick="return confirmSubtasks(<?= $task['unfinished_subtasks'] ?>)">

                </form>
            </td>
            <td class="actions">
                <a href="subtasks.php?task_id=<?= $task['id'] ?>">Lihat Subtask</a>
                <a href="edit_task.php?id=<?= $task['id'] ?>" <?= $task['status'] === 'selesai' ? 'style="pointer-events: none; color: gray;"' : '' ?>>Edit</a>
                <a href="delete_task.php?id=<?= $task['id'] ?>">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
    function confirmSubtasks(unfinishedCount) {
        if (unfinishedCount > 0) {
            alert("Tidak bisa menyelesaikan tugas karena masih ada subtask yang belum selesai!");
            return false;
        }
        return true;
    }
</script>

</body>
</html>
