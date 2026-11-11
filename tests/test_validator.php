<?php

require_once __DIR__ . '/../src/Services/TaskValidator.php';

$validator = new TaskValidator();

// Test 1: Valid task
$errors = $validator->validate(
    "Study PHP",
    "Pending"
);

echo "Test 1:" . PHP_EOL;
print_r($errors);

// Test 2: Invalid task
$errors = $validator->validate(
    "",
    "Unknown"
);

echo "Test 2:" . PHP_EOL;
print_r($errors);