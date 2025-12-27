<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Require login
if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Upload Music - Smart Music</title>
  <link rel="stylesheet" href="/smart-music-mw/Styles/index.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f5f5f5; }
    .upload-container { max-width: 600px; margin: 50px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    h1 { text-align: center; color: #333; }
    .form-group { margin-bottom: 20px; }
    label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
    input[type="text"], input[type="number"], input[type="file"], select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
    input:focus, textarea:focus, select:focus { outline: none; border-color: #4CAF50; }
    button { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    button:hover { background: #45a049; }
    .error { color: #d32f2f; margin-top: 10px; padding: 10px; background: #ffebee; border-radius: 4px; }
    .success { color: #388e3c; margin-top: 10px; padding: 10px; background: #e8f5e9; border-radius: 4px; }
    .file-input-label { display: inline-block; padding: 10px 20px; background: #2196F3; color: white; border-radius: 4px; cursor: pointer; }
    .file-input-label:hover { background: #0b7dda; }
    .back-link { display: block; text-align: center; margin-top: 20px; }
    .back-link a { color: #4CAF50; text-decoration: none; }
  </style>
</head>
<body>
<div class="upload-container">
  <h1>Upload Your Music</h1>
  <form id="uploadForm">
    <div class="form-group">
      <label for="title">Song Title *</label>
      <input type="text" id="title" name="title" required>
    </div>
    <div class="form-group">
      <label for="artist">Artist Name</label>
      <input type="text" id="artist" name="artist">
    </div>
    <div class="form-group">
      <label for="album">Album</label>
      <input type="text" id="album" name="album">
    </div>
    <div class="form-group">
      <label for="genre">Genre</label>
      <input type="text" id="genre" name="genre">
    </div>
    <div class="form-group">
      <label for="duration">Duration (seconds)</label>
      <input type="number" id="duration" name="duration" min="0">
    </div>
    <div class="form-group">
      <label for="music">Audio File * (MP3, M4A, WAV, FLAC, OGG - Max 100MB)</label>
      <label class="file-input-label">
        Select File
        <input type="file" id="music" name="music" accept="audio/*" style="display:none;" required>
      </label>
      <span id="fileName" style="margin-left: 10px;"></span>
    </div>
    <button type="submit">Upload Music</button>
    <div id="message"></div>
  </form>
  <div class="back-link">
    <a href="/smart-music-mw/">Back to Home</a>
  </div>
</div>

<script>
document.getElementById('music').addEventListener('change', (e) => {
  document.getElementById('fileName').textContent = e.target.files[0]?.name || '';
});

document.getElementById('uploadForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const formData = new FormData(document.getElementById('uploadForm'));
  const res = await fetch('/upload-music', { method: 'POST', body: formData });
  const data = await res.json();
  if (data.ok) {
    document.getElementById('message').innerHTML = '<div class="success">Music uploaded successfully!</div>';
    document.getElementById('uploadForm').reset();
    document.getElementById('fileName').textContent = '';
    setTimeout(() => window.location.href = '/', 2000);
  } else {
    document.getElementById('message').innerHTML = '<div class="error">' + (data.error || 'Upload failed') + '</div>';
  }
});
</script>
</body>
</html>
