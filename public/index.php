<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../app/Support/DB.php';
require_once __DIR__ . '/../app/Controllers/ProjectController.php';
require_once __DIR__ . '/../app/Controllers/ContactController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MusicController.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if (strpos($path, '/smart-music-mw/') === 0) {
    $path = substr($path, strlen('/smart-music-mw'));
}


if (!$path || $path === '') {
    $path = '/';
}

if ($path === '/api/projects') {
    header('Content-Type: application/json');
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
    echo json_encode(Project::allPublished($limit, $offset));
    exit;
}

if ($path === '/api/music') {
    header('Content-Type: application/json');
    MusicController::getPublic();
    exit;
}

if ($path === '/api/my-music') {
    header('Content-Type: application/json');
    MusicController::getUserMusic();
    exit;
}

if ($path === '/contact-submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? null;
    $message = $_POST['message'] ?? '';
    try {
        $id = Contact::create($name, $email, $phone, $message);
        header('Content-Type: application/json');
        echo json_encode(['ok' => true, 'id' => $id]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

if ($path === '/upload-music' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    MusicController::upload();
    exit;
}

if ($path === '/register-submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    AuthController::registerFromPost();
    exit;
}

if ($path === '/login-submit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    AuthController::loginFromPost();
    exit;
}

if ($path === '/logout') {
    AuthController::logout();
}

switch ($path) {
    case '/':
    case '/index.php':
    case '/index.html':
        include __DIR__ . '/index-landing.php';
        break;
    case '/about':
    case '/about.php':
        include __DIR__ . '/about.php';
        break;
    case '/services':
    case '/services.php':
        include __DIR__ . '/services.php';
        break;
    case '/login':
    case '/login.html':
    case '/login.php':
        include __DIR__ . '/login.php';
        break;
    case '/register':
    case '/register.php':
        include __DIR__ . '/register.php';
        break;
    case '/upload':
    case '/upload.php':
        include __DIR__ . '/upload.php';
        break;
    default:
        http_response_code(404);
        echo "Not found";
}
