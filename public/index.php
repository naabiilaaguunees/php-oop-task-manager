<?php

require_once __DIR__ . '/../src/Controllers/TaskController.php';
require_once __DIR__ . '/../src/Services/Csrf.php';

try {
    $controller = new TaskController();
    $tasks = $controller->index();

} catch (Throwable $e) {
    error_log("Failed to load tasks: " . $e->getMessage());

    http_response_code(500);
    exit("Something went wrong. Please try again later.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Task Manager</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="container">

        <h1>My Task Manager</h1>
        <p class="subtitle">Organize your tasks and stay productive.</p>

        <section class="task-form-section">

    <h2>Add New Task</h2>

    <form action="create.php" method="POST">
        <input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars(
        Csrf::generateToken(),
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
            >

        <div class="form-group">
            <label for="title">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                placeholder="Enter task title"
                maxlength="150"
                required
            >
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea
                id="description"
                name="description"
                placeholder="Enter task description"
                rows="3"
            ></textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <button type="submit" class="btn-primary">
            Add Task
        </button>

    </form>

</section>

        <h2>My Tasks</h2>

        <?php if (empty($tasks)): ?>

            <p>No tasks available yet.</p>

        <?php else: ?>

            <?php foreach ($tasks as $task): ?>

                <?php
                    $statusClass = match ($task->getStatus()) {
                        "Pending" => "status-pending",
                        "In Progress" => "status-in-progress",
                        "Completed" => "status-completed",
                        default => "status-pending"
                    };
                ?>

                <div class="task-card">

                    <h3>
                        <?= htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8') ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars($task->getDescription(), ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <span class="status <?= $statusClass ?>">
                        <?= htmlspecialchars($task->getStatus(), ENT_QUOTES, 'UTF-8') ?>
                    </span>

                    <div class="task-actions">

    <a
        href="edit.php?id=<?= $task->getId() ?>"
        class="btn-edit"
    >
        Edit
    </a>

    <form
        action="delete.php"
        method="POST"
        class="delete-form"
        onsubmit="return confirm('Are you sure you want to delete this task?');"
    >
    <input
    type="hidden"
    name="csrf_token"
    value="<?= htmlspecialchars(
        Csrf::generateToken(),
        ENT_QUOTES,
        'UTF-8'
    ) ?>"
>

        <input
            type="hidden"
            name="id"
            value="<?= $task->getId() ?>"
        >

        <button type="submit" class="btn-delete">
            Delete
        </button>
    </form>

</div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </main>

</body>
</html>