<?php
require_once __DIR__ . '/../Support/DB.php';
require_once __DIR__ . '/../Models/Music.php';

class MusicController
{
    private static $uploadDir = __DIR__ . '/../../uploads/music';
    private static $maxFileSize = 100 * 1024 * 1024; // 100MB
    private static $allowedExtensions = ['mp3', 'm4a', 'wav', 'flac', 'ogg'];

    public static function upload()
    {
        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
            return;
        }

        if (!isset($_FILES['music']) || $_FILES['music']['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'No file or upload error']);
            return;
        }

        $file = $_FILES['music'];
        $title = trim($_POST['title'] ?? '');
        $artist = trim($_POST['artist'] ?? '');
        $album = trim($_POST['album'] ?? '');
        $genre = trim($_POST['genre'] ?? '');
        $duration = (int)($_POST['duration'] ?? 0);

        if (!$title) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Title is required']);
            return;
        }

        if ($file['size'] > self::$maxFileSize) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'File too large (max 100MB)']);
            return;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedExtensions)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'File type not allowed']);
            return;
        }

        if (!is_dir(self::$uploadDir)) {
            mkdir(self::$uploadDir, 0755, true);
        }

        $fileName = uniqid('song_', true) . '.' . $ext;
        $filePath = self::$uploadDir . '/' . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'Failed to save file']);
            return;
        }

        try {
            $id = Music::create(
                $_SESSION['user_id'],
                $title,
                $artist ?: 'Unknown Artist',
                $album ?: 'Unknown Album',
                $genre ?: 'Unclassified',
                $duration,
                'uploads/music/' . $fileName,
                $file['size'],
                $file['type'] ?: 'audio/' . $ext
            );
            echo json_encode(['ok' => true, 'id' => $id, 'message' => 'Music uploaded successfully']);
        } catch (Exception $e) {
            @unlink($filePath);
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    public static function getPublic()
    {
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        echo json_encode(Music::getPublic($limit, $offset));
    }

    public static function getUserMusic()
    {
        if (empty($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
            return;
        }
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        echo json_encode(Music::getUserSongs($_SESSION['user_id'], $limit, $offset));
    }
}
