<?php
if (session_status() === PHP_SESSION_NONE) session_start();


if (!empty($_SESSION['user_id'])) {
  header('Location: /smart-music-mw/');
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Smart Music</title>
  <link rel="stylesheet" href="/smart-music-mw/Styles/index.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .login-container { max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; color: #333; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
    input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    input[type="email"]:focus, input[type="password"]:focus { outline: none; border-color: #4CAF50; }
    button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    button:hover { background: #45a049; }
    .error { color: #d32f2f; margin-top: 10px; padding: 10px; background: #ffebee; border-radius: 4px; }
    .register-link { text-align: center; margin-top: 20px; }
    .register-link a { color: #4CAF50; text-decoration: none; }
    .register-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="login-container">
  <h1>Login</h1>
  <form id="loginForm">
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Login</button>
    <div id="error"></div>
  </form>
  <div class="register-link">
    Don't have an account? <a href="/smart-music-mw/register">Create one here</a>
  </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(document.getElementById('loginForm'));
  try {
    const res = await fetch('/smart-music-mw/login-submit', { method: 'POST', body: formData, credentials: 'same-origin' });
    const data = await res.json();
    if (data.ok) {
      window.location.href = '/smart-music-mw/';
    } else {
      document.getElementById('error').innerHTML = '<div class="error">' + (data.error || 'Login failed') + '</div>';
    }
  } catch (err) {
    document.getElementById('error').innerHTML = '<div class="error">Network error: ' + err.message + '</div>';
  }
});
</script>
</body>
</html>
