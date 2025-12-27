<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Smart Music</title>
  <link rel="stylesheet" href="/Styles/index.css">
  <style>
    nav { padding: 15px; background: #333; }
    nav a { color: white; margin: 0 15px; text-decoration: none; }
    nav a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<header>
  <nav>
    <a href="/">Home</a> |
    <a href="/player">Player</a> |
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="/upload.php">Upload Music</a> |
      <a href="/logout">Logout</a>
    <?php else: ?>
      <a href="/login.php">Login</a> |
      <a href="/register.php">Register</a>
    <?php endif; ?>
  </nav>
</header>
