
<?php

require_once __DIR__ . '/../src/Controllers/TaskController.php';
require_once __DIR__ . '/../src/Services/Csrf.php';

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

// Validate CSRF token
$token = $_POST["csrf_token"] ?? null;

if (!is_string($token) || !Csrf::validateToken($token)) {
    http_response_code(403);
    exit("Invalid CSRF token.");
}

// Validate task ID
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("Invalid task ID.");
}

try {

    $controller = new TaskController();

    // Delete task using controller
    $deleted = $controller->destroy($id);

    if (!$deleted) {
        http_response_code(404);
        exit("Task not found.");
    }

    // Redirect after successful deletion
    header("Location: index.php");
    exit;

} catch (Throwable $e) {

    error_log("Task deletion failed: " . $e->getMessage());

    http_response_code(500);
    exit("Something went wrong. Please try again later.");
}
