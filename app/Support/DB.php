<?php
class Env
{
    public static function get($key, $default = null)
    {
        $val = getenv($key);
        if ($val === false) {
            if (file_exists(__DIR__ . '/../../.env')) {
                $lines = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    if (strpos(trim($line), '#') === 0) continue;
                    [$k, $v] = array_map('trim', explode('=', $line, 2) + [null, null]);
                    if ($k === $key) return $v;
                }
            }
            return $default;
        }
        return $val;
    }
}

class DB
{
    private static $pdo;

    public static function pdo()
    {
        if (self::$pdo) return self::$pdo;

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            Env::get('DB_HOST', '127.0.0.1'),
            Env::get('DB_PORT', '3306'),
            Env::get('DB_NAME', 'smart_music'),
            Env::get('DB_CHARSET', 'utf8mb4')
        );

        self::$pdo = new PDO($dsn, Env::get('DB_USER'), Env::get('DB_PASS'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return self::$pdo;
    }

    public static function pdoRoot()
    {
        $dsn = sprintf('mysql:host=%s;port=%s', Env::get('DB_HOST', '127.0.0.1'), Env::get('DB_PORT', '3306'));
        return new PDO($dsn, Env::get('DB_USER'), Env::get('DB_PASS'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
