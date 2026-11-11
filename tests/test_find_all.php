<?php

require_once __DIR__ . '/../src/Repositories/task_repository.php';

$repository = new TaskRepository();

$tasks = $repository->findAll();

foreach ($tasks as $task) {

    echo "ID: " . $task->getId() . PHP_EOL;
    echo "Title: " . $task->getTitle() . PHP_EOL;
    echo "Status: " . $task->getStatus() . PHP_EOL;

    echo "------------------------" . PHP_EOL;
}