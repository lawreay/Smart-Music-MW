<?php
require_once __DIR__ . '/../Support/DB.php';

class Music
{
    public static function create($userId, $title, $artist, $album, $genre, $duration, $filePath, $fileSize, $fileType, $coverPath = null, $description = null)
    {
        $stmt = DB::pdo()->prepare(
            "INSERT INTO songs (user_id, title, artist, album, genre, duration, file_path, file_size, file_type, cover_art_path, description) 
             VALUES (:user_id, :title, :artist, :album, :genre, :duration, :file_path, :file_size, :file_type, :cover_path, :description)"
        );
        $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':artist' => $artist,
            ':album' => $album,
            ':genre' => $genre,
            ':duration' => $duration,
            ':file_path' => $filePath,
            ':file_size' => $fileSize,
            ':file_type' => $fileType,
            ':cover_path' => $coverPath,
            ':description' => $description,
        ]);
        return DB::pdo()->lastInsertId();
    }

    public static function getPublic($limit = 20, $offset = 0)
    {
        $sql = "SELECT s.*, u.name as artist_name FROM songs s 
                JOIN users u ON s.user_id = u.id
                WHERE s.is_public = 1
                ORDER BY s.created_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getUserSongs($userId, $limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM songs WHERE user_id = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getById($id)
    {
        $stmt = DB::pdo()->prepare("SELECT s.*, u.name as artist_name FROM songs s JOIN users u ON s.user_id = u.id WHERE s.id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
