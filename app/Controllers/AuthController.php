<?php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Support/DB.php';

class AuthController
{
    public static function registerFromPost()
    {
        header('Content-Type: application/json');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || !$password) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Missing fields']);
            return;
        }

        if (User::findByEmail($email)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Email already registered']);
            return;
        }

        $id = User::create($name, $email, $password, 'admin');
        $_SESSION['user_id'] = $id;
        echo json_encode(['ok' => true, 'id' => $id]);
    }

    public static function loginFromPost()
    {
        header('Content-Type: application/json');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Missing credentials']);
            return;
        }

        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password_hash'])) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Invalid credentials']);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['ok' => true, 'id' => $user['id']]);
    }

    public static function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header('Location: /smart-music-mw/');
        exit;
    }
}
