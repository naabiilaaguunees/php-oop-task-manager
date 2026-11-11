
<?php

require_once __DIR__ . '/../Repositories/task_repository.php';
require_once __DIR__ . '/../Services/TaskValidator.php';

class TaskController {

    private TaskRepository $repository;
    private TaskValidator $validator;

    public function __construct() {

        $this->repository = new TaskRepository();
        $this->validator = new TaskValidator();
    }

    // Get all tasks
    public function index(): array {

        return $this->repository->findAll();
    }

    // Get a single task
    public function show(int $id): ?Task {

        return $this->repository->findById($id);
    }

    // Create a new task
    public function store(
        string $title,
        string $description,
        string $status
    ): array {

        $errors = $this->validator->validate(
            $title,
            $status
        );

        if (!empty($errors)) {
            return $errors;
        }

        $created = $this->repository->create(
            trim($title),
            trim($description),
            $status
        );

        if (!$created) {
            throw new RuntimeException(
                "Task could not be created."
            );
        }

        return [];
    }

    // Update an existing task
    public function update(
        int $id,
        string $title,
        string $description,
        string $status
    ): array {

        $errors = $this->validator->validate(
            $title,
            $status
        );

        if (!empty($errors)) {
            return $errors;
        }

        $task = $this->repository->findById($id);

        if ($task === null) {
            throw new RuntimeException(
                "Task not found."
            );
        }

        $task->setTitle(trim($title));
        $task->setDescription(trim($description));
        $task->setStatus($status);

        $updated = $this->repository->update($task);

        if (!$updated) {
            throw new RuntimeException(
                "Task could not be updated."
            );
        }

        return [];
    }

    // Delete a task
    public function destroy(int $id): bool {

        return $this->repository->delete($id);
    }
}
