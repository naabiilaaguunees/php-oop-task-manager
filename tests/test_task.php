<?php

//loads the Task class from the src/Models directory
require_once __DIR__ . '/../src/Models/Task.php'; 


// Create two Task objects

$task1 = new Task(
    1,
    "Learn PHP OOP",
    "Study classes and objects",
    "Pending"
);

$task2 = new Task(
    2,
    "Clean my room",
    "Organize my desk",
    "Completed"
);

// Display task titles

echo $task1->getTitle() . PHP_EOL;
echo $task2->getTitle() . PHP_EOL;

// Update task status

$task1->setStatus("In Progress");

echo $task1->getStatus() . PHP_EOL; //adds a new line after the status output