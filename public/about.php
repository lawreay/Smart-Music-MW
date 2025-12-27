<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>About - Smart Music Malawi</title>
  <link rel="stylesheet" href="/smart-music-mw/Styles/index.css">
  <link rel="stylesheet" href="/smart-music-mw/Styles/home.css">
  <link rel="shortcut icon" href="/smart-music-mw/logo.png" type="image/x-icon">
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; }
    .page-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
    h1 { color: #333; margin-bottom: 20px; }
    h2 { color: #4CAF50; margin-top: 30px; margin-bottom: 15px; }
    p { color: #666; margin-bottom: 15px; }
    .team-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0; }
    .team-card { background: #f9f9f9; padding: 20px; border-radius: 8px; text-align: center; }
    .team-card h3 { color: #333; margin-bottom: 10px; }
    .team-card p { color: #666; font-size: 0.9em; }
    header { background: #333; color: white; padding: 15px 20px; display: flex; align-items: center; gap: 15px; }
    header img { width: 50px; height: 50px; }
    header h1 { margin: 0; }
    nav { background: #f5f5f5; padding: 10px 20px; }
    nav a { margin: 0 15px; text-decoration: none; color: #333; display: inline-block; }
    nav a:hover { color: #4CAF50; }
    nav .auth-btn { background: #4CAF50; color: white; padding: 8px 15px; border-radius: 4px; }
    nav .auth-btn:hover { background: #45a049; }
    footer { background: #333; color: white; padding: 20px; text-align: center; margin-top: 40px; }
  </style>
</head>
<body>
  <header>
    <img src="/smart-music-mw/logo.png" alt="Smart Music Logo">
    <h1>Smart Music Malawi</h1>
  </header>
  <nav>
    <a href="/smart-music-mw/">Home</a>
    <a href="/smart-music-mw/about">About</a>
    <a href="/smart-music-mw/services">Services</a>
    <?php if (!empty($_SESSION['user_id'])): ?>
      <a href="/smart-music-mw/logout" class="auth-btn">Logout</a>
    <?php else: ?>
      <a href="/smart-music-mw/login" class="auth-btn">Log In</a>
      <a href="/smart-music-mw/register" class="auth-btn register-btn">Create account</a>
    <?php endif; ?>
  </nav>

  <div class="page-container">
    <h1>About Smart Music Malawi</h1>
    
    <p>
      Smart Music Malawi is a community-first music streaming and sharing platform dedicated to showcasing and supporting Malawi's next generation of artists. We believe in empowering local talent and providing a space where musicians can connect directly with their audience.
    </p>

    <h2>Our Mission</h2>
    <p>
      To create a platform that celebrates Malawian music, connects artists with listeners worldwide, and provides tools for musicians to manage and monetize their work. We are committed to supporting the growth of the Malawian music industry while maintaining community values and cultural integrity.
    </p>

    <h2>Our Vision</h2>
    <p>
      A vibrant digital ecosystem where every Malawian artist has the opportunity to reach a global audience, collaborate with peers, and build sustainable careers through their music.
    </p>

    <h2>What We Offer</h2>
    <ul style="color: #666; margin: 15px 0; padding-left: 20px;">
      <li><strong>Music Streaming:</strong> High-quality audio playback of thousands of tracks from Malawian artists</li>
      <li><strong>Artist Tools:</strong> Upload, manage, and promote your music with ease</li>
      <li><strong>Community Features:</strong> Connect with fans, get feedback, and grow your audience</li>
      <li><strong>Analytics:</strong> Track your music performance and listener engagement</li>
      <li><strong>Support:</strong> Dedicated support to help artists succeed</li>
    </ul>

    <h2>Our Team</h2>
    <div class="team-grid">
      <div class="team-card">
        <h3>Lawrence Chikapa Phuka</h3>
        <p>Founder & Lead Developer</p>
        <p>A passionate developer dedicated to building tools that empower Malawian artists.</p>
      </div>
      <div class="team-card">
        <h3>You</h3>
        <p>Our Community</p>
        <p>Artists and listeners who make Smart Music what it is.</p>
      </div>
    </div>

    <h2>Contact Us</h2>
    <p>
      Have questions or feedback? We'd love to hear from you. Visit our <a href="/smart-music-mw/services">Services page</a> or use the contact form on the platform.
    </p>
  </div>

  <footer>
    <p>&copy; 2024 Smart Music Malawi. All rights reserved.</p>
    Developed by <b>Lawrence Chikapa Phuka</b>
  </footer>
</body>
</html>
