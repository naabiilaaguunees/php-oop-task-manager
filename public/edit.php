
<?php

require_once __DIR__ . '/../src/Controllers/TaskController.php';
require_once __DIR__ . '/../src/Services/Csrf.php';

// Validate task ID
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("Invalid task ID.");
}

// Only allow GET and POST
if (!in_array($_SERVER["REQUEST_METHOD"], ["GET", "POST"], true)) {
    http_response_code(405);
    exit("Method not allowed.");
}

// Validate CSRF token for POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $token = $_POST["csrf_token"] ?? null;

    if (!is_string($token) || !Csrf::validateToken($token)) {
        http_response_code(403);
        exit("Invalid CSRF token.");
    }
}

$error = "";
$title = "";
$description = "";
$status = "Pending";

try {

    $controller = new TaskController();

    // Get task information
    $task = $controller->show($id);

    if ($task === null) {
        http_response_code(404);
        exit("Task not found.");
    }

    // Populate form with current data
    $title = $task->getTitle();
    $description = $task->getDescription();
    $status = $task->getStatus();

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $title = $_POST["title"] ?? "";
        $description = $_POST["description"] ?? "";
        $status = $_POST["status"] ?? "";

        if (
            !is_string($title) ||
            !is_string($description) ||
            !is_string($status)
        ) {
            http_response_code(400);
            exit("Invalid form data.");
        }

        $errors = $controller->update(
            $id,
            $title,
            $description,
            $status
        );

        if (!empty($errors)) {

            $error = implode(" ", $errors);

        } else {

            header("Location: index.php");
            exit;
        }
    }

} catch (Throwable $e) {

    error_log("Task editing failed: " . $e->getMessage());

    http_response_code(500);
    exit("Something went wrong. Please try again later.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Task</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<main class="container">

    <h1>Edit Task</h1>

    <p class="subtitle">
        Update your task information.
    </p>

    <section class="task-form-section">

        <?php if ($error !== ""): ?>

            <p role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>

        <?php endif; ?>

        <form method="POST">

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
                    maxlength="150"
                    value="<?= htmlspecialchars(
                        $title,
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>"
                    required
                >

            </div>

            <div class="form-group">

                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    rows="3"
                ><?= htmlspecialchars(
                    $description,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?></textarea>

            </div>

            <div class="form-group">

                <label for="status">Status</label>

                <select id="status" name="status">

                    <?php foreach ([
                        "Pending",
                        "In Progress",
                        "Completed"
                    ] as $option): ?>

                        <option
                            value="<?= $option ?>"
                            <?= $status === $option ? "selected" : "" ?>
                        >
                            <?= $option ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <button type="submit" class="btn-primary">
                Save Changes
            </button>

            <a href="index.php" class="btn-cancel">
                Cancel
            </a>

        </form>

    </section>

</main>

</body>
</html>
