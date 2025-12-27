<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if already logged in
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
  <title>Register - Smart Music</title>
  <link rel="stylesheet" href="/smart-music-mw/Styles/index.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .register-container { max-width: 400px; margin: 100px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; color: #333; }
    .form-group { margin-bottom: 15px; }
    label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
    input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus { outline: none; border-color: #4CAF50; }
    button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    button:hover { background: #45a049; }
    .error { color: #d32f2f; margin-top: 10px; padding: 10px; background: #ffebee; border-radius: 4px; }
    .login-link { text-align: center; margin-top: 20px; }
    .login-link a { color: #4CAF50; text-decoration: none; }
    .login-link a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<div class="register-container">
  <h1>Create Account</h1>
  <form id="registerForm">
    <div class="form-group">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required minlength="6">
    </div>
    <div class="form-group">
      <label for="password_confirm">Confirm Password:</label>
      <input type="password" id="password_confirm" name="password_confirm" required minlength="6">
    </div>
    <button type="submit">Create Account</button>
    <div id="error"></div>
  </form>
  <div class="login-link">
    Already have an account? <a href="/smart-music-mw/login">Login here</a>
  </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const password = document.getElementById('password').value;
  const confirm = document.getElementById('password_confirm').value;
  if (password !== confirm) {
    document.getElementById('error').innerHTML = '<div class="error">Passwords do not match</div>';
    return;
  }
  const formData = new FormData(document.getElementById('registerForm'));
  const res = await fetch('/smart-music-mw/register-submit', { method: 'POST', body: formData });
  const data = await res.json();
  if (data.ok) {
    window.location.href = '/smart-music-mw/';
  } else {
    document.getElementById('error').innerHTML = '<div class="error">' + (data.error || 'Registration failed') + '</div>';
  }
});
</script>
</body>
</html>
