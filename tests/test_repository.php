<?php

require_once __DIR__ . '/../src/Repositories/task_repository.php';

$repository = new TaskRepository();

$result = $repository->create(
    "Finish my PHP project",
    "Build a Task Manager using PHP OOP and MySQL",
    "In Progress"
);

if ($result) {
    echo "Task created successfully!" . PHP_EOL;
}