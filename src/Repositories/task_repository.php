
<?php

require_once __DIR__ . '/../Database/Database.php';
require_once __DIR__ . '/../Models/Task.php';

class TaskRepository {

    private PDO $connection;

    // Constructor: Connect to the database
    public function __construct() {

        $database = new Database();

        $this->connection = $database->connect();
    }

    // CREATE: Insert a new task
    public function create(
        string $title,
        string $description,
        string $status = "Pending"
    ): bool {

        $sql = "INSERT INTO tasks (title, description, status)
                VALUES (:title, :description, :status)";

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            "title" => $title,
            "description" => $description,
            "status" => $status
        ]);
    }

    // READ: Get all tasks
    public function findAll(): array {

        $sql = "SELECT * FROM tasks ORDER BY id DESC";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $tasks = [];

        foreach ($rows as $row) {

            $task = new Task(
                (int) $row["id"],
                $row["title"],
                $row["description"] ?? "",
                $row["status"]
            );

            $tasks[] = $task;
        }

        return $tasks;
    }

    // READ: Find a task by ID
    public function findById(int $id): ?Task {

        $sql = "SELECT * FROM tasks WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            "id" => $id
        ]);

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row === false) {
            return null;
        }

        return new Task(
            (int) $row["id"],
            $row["title"],
            $row["description"] ?? "",
            $row["status"]
        );
    }

    // UPDATE: Modify an existing task
    public function update(Task $task): bool {

        $sql = "UPDATE tasks
                SET title = :title,
                    description = :description,
                    status = :status
                WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            "id" => $task->getId(),
            "title" => $task->getTitle(),
            "description" => $task->getDescription(),
            "status" => $task->getStatus()
        ]);
    }

    // DELETE: Remove a task by ID
    public function delete(int $id): bool {

        $sql = "DELETE FROM tasks WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            "id" => $id
        ]);

        return $statement->rowCount() > 0;
    }
}
