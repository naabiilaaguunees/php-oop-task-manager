
<?php

class Csrf {

    public static function generateToken(): string {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }

        return $_SESSION["csrf_token"];
    }

    public static function validateToken(?string $token): bool {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $savedToken = $_SESSION["csrf_token"] ?? null;

        if ($savedToken === null || $token === null) {
            return false;
        }

        return hash_equals($savedToken, $token);
    }
}
