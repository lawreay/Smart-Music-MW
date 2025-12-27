<?php
require_once __DIR__ . '/../Support/DB.php';

class Contact
{
    public static function create(string $name, string $email, ?string $phone, string $message)
    {
        $stmt = DB::pdo()->prepare(
            "INSERT INTO contacts (name, email, phone, message) VALUES (:name, :email, :phone, :message)"
        );
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':message' => $message,
        ]);
        return DB::pdo()->lastInsertId();
    }
}
