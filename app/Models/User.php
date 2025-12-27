<?php
require_once __DIR__ . '/../Support/DB.php';

class User
{
    public static function create(string $name, string $email, string $password, string $role = 'viewer')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = DB::pdo()->prepare(
            "INSERT INTO users (name, email, password_hash, role) VALUES (:name, :email, :hash, :role)"
        );
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':hash' => $hash,
            ':role' => $role,
        ]);
        return DB::pdo()->lastInsertId();
    }

    public static function findByEmail(string $email)
    {
        $stmt = DB::pdo()->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public static function findById($id)
    {
        $stmt = DB::pdo()->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
