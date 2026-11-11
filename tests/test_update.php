<?php

require_once __DIR__ . '/../src/Repositories/task_repository.php';

$repository = new TaskRepository();

$tasks = $repository->findAll();

if (empty($tasks)) {
    echo "No tasks found." . PHP_EOL;
    exit;
}

$task = $tasks[0];

echo "Before: " . $task->getStatus() . PHP_EOL;

$task->setStatus("Completed");

$repository->update($task);

echo "After: " . $task->getStatus() . PHP_EOL;