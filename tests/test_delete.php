<?php

require_once __DIR__ . '/../src/Repositories/task_repository.php';

$repository = new TaskRepository();

// Create a temporary task
$repository->create(
    "Temporary task",
    "This task will be deleted",
    "Pending"
);

// Get all tasks
$tasks = $repository->findAll();

// The newest task is first
$task = $tasks[0];

echo "Deleting: " . $task->getTitle() . PHP_EOL;

// Delete the task
$deleted = $repository->delete($task->getId());

if ($deleted) {
    echo "Task deleted successfully!" . PHP_EOL;
} else {
    echo "Task not found." . PHP_EOL;
}