<?php
require_once __DIR__ . '/../Support/DB.php';

class Project
{
    public static function allPublished(int $limit = 10, int $offset = 0)
    {
        $sql = "SELECT id, title, slug, summary, featured, updated_at
                FROM projects
                WHERE status = :status
                ORDER BY featured DESC, updated_at DESC
                LIMIT :limit OFFSET :offset";
        $stmt = DB::pdo()->prepare($sql);
        $stmt->bindValue(':status', 'published', PDO::PARAM_STR);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
