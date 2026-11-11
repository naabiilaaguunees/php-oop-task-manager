<?php

class TaskValidator {

    private const ALLOWED_STATUSES = [
        "Pending",
        "In Progress",
        "Completed"
    ];

    public function validate(
        string $title,
        string $status
    ): array {

        $errors = [];

        if (trim($title) === "") {
            $errors[] = "Task title is required.";
        }

        if (mb_strlen($title) > 150) {
            $errors[] = "Task title cannot exceed 150 characters.";
        }

        if (!in_array($status, self::ALLOWED_STATUSES, true)) {
            $errors[] = "Invalid task status.";
        }

        return $errors;
    }
}