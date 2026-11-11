<?php

require_once __DIR__ . '/../src/Controllers/TaskController.php';

$controller = new TaskController();

// Test 1: Get all tasks
$tasks = $controller->index();

echo "Total tasks: " . count($tasks) . PHP_EOL;

// Test 2: Validate invalid task
$errors = $controller->store(
    "",
    "Testing controller validation",
    "Pending"
);

echo "Validation errors:" . PHP_EOL;

print_r($errors);

// Test 3: Get a non-existing task
$task = $controller->show(999999);

echo "Task found: ";

echo $task === null ? "No" : "Yes";

echo PHP_EOL;