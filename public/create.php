
<?php

require_once __DIR__ . '/../src/Controllers/TaskController.php';
require_once __DIR__ . '/../src/Services/Csrf.php';

// Only accept POST requests
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

// Read form data
$title = $_POST["title"] ?? "";
$description = $_POST["description"] ?? "";
$status = $_POST["status"] ?? "Pending";

// Ensure form values are strings
if (
    !is_string($title) ||
    !is_string($description) ||
    !is_string($status)
) {
    http_response_code(400);
    exit("Invalid form data.");
}

try {

    $controller = new TaskController();

    // Validate and create task
    $errors = $controller->store(
        $title,
        $description,
        $status
    );

    if (!empty($errors)) {
        http_response_code(400);

        foreach ($errors as $error) {
            echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
            echo "<p></p>";
        }

        exit;
    }

    // Redirect after successful creation
    header("Location: index.php");
    exit;

} catch (Throwable $e) {

    error_log("Task creation failed: " . $e->getMessage());

    http_response_code(500);
    exit("Something went wrong. Please try again later.");
}
