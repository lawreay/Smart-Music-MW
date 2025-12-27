<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Services - Smart Music Malawi</title>
  <link rel="stylesheet" href="/smart-music-mw/Styles/index.css">
  <link rel="stylesheet" href="/smart-music-mw/Styles/home.css">
  <link rel="shortcut icon" href="/smart-music-mw/logo.png" type="image/x-icon">
  <style>
    body { font-family: Arial, sans-serif; line-height: 1.6; }
    .page-container { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
    h1 { color: #333; margin-bottom: 20px; }
    h2 { color: #4CAF50; margin-top: 30px; margin-bottom: 15px; }
    p { color: #666; margin-bottom: 15px; }
    .services-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin: 30px 0; }
    .service-card { background: #f9f9f9; padding: 25px; border-radius: 8px; border-left: 4px solid #4CAF50; }
    .service-card h3 { color: #333; margin-bottom: 10px; }
    .service-card p { color: #666; }
    .service-card ul { color: #666; padding-left: 20px; margin: 10px 0; }
    .service-card li { margin: 8px 0; }
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
    <h1>Our Services</h1>
    
    <p>
      Smart Music Malawi offers comprehensive services to support both music lovers and artists. Whether you're looking to discover new music or share your talent with the world, we have the tools and features you need.
    </p>

    <div class="services-grid">
      <div class="service-card">
        <h3>🎵 Music Streaming</h3>
        <p>
          Access thousands of tracks from Malawian artists in high-quality audio. Enjoy curated playlists, recommendations, and discover new music tailored to your taste.
        </p>
        <ul>
          <li>High-quality audio playback</li>
          <li>Offline downloads (Pro)</li>
          <li>Custom playlists</li>
          <li>Smart recommendations</li>
        </ul>
      </div>

      <div class="service-card">
        <h3>📤 Music Upload & Management</h3>
        <p>
          Upload your music and manage your artist profile. Reach listeners worldwide and track your performance with detailed analytics.
        </p>
        <ul>
          <li>Unlimited uploads (for members)</li>
          <li>Multiple format support</li>
          <li>Metadata management</li>
          <li>Performance analytics</li>
        </ul>
      </div>

      <div class="service-card">
        <h3>👥 Artist Community</h3>
        <p>
          Connect with other musicians, collaborate on projects, and build your fanbase. Share experiences and grow together as a community.
        </p>
        <ul>
          <li>Artist profiles</li>
          <li>Collaboration tools</li>
          <li>Fan engagement features</li>
          <li>Community forums</li>
        </ul>
      </div>

      <div class="service-card">
        <h3>📊 Analytics & Insights</h3>
        <p>
          Track your music performance with comprehensive analytics. Understand your listeners and optimize your strategy.
        </p>
        <ul>
          <li>Play count tracking</li>
          <li>Listener demographics</li>
          <li>Geographic data</li>
          <li>Trend analysis</li>
        </ul>
      </div>

      <div class="service-card">
        <h3>🎤 Artist Support</h3>
        <p>
          Get personalized support to help you succeed. Our team is dedicated to helping artists thrive on the platform.
        </p>
        <ul>
          <li>Priority support</li>
          <li>Marketing guidance</li>
          <li>Distribution assistance</li>
          <li>Technical help</li>
        </ul>
      </div>

      <div class="service-card">
        <h3>💼 Monetization</h3>
        <p>
          Earn from your music. We're building sustainable revenue streams for artists through streaming and direct fan support.
        </p>
        <ul>
          <li>Revenue sharing</li>
          <li>Direct tipping (coming soon)</li>
          <li>Exclusive content (Pro)</li>
          <li>Sponsorship opportunities</li>
        </ul>
      </div>
    </div>

    <h2>Membership Tiers</h2>
    <p>
      Smart Music Malawi offers flexible membership options:
    </p>
    <ul style="color: #666; margin: 15px 0; padding-left: 20px;">
      <li><strong>Free:</strong> Stream music, create a profile, upload up to 5 songs/month</li>
      <li><strong>Plus:</strong> Unlimited uploads, ad-free listening, offline downloads, analytics</li>
      <li><strong>Pro:</strong> Everything in Plus, plus exclusive content, priority support, and higher earnings</li>
    </ul>

    <h2>Getting Started</h2>
    <p>
      Ready to get started? 
      <?php if (empty($_SESSION['user_id'])): ?>
        <a href="/smart-music-mw/register">Create an account</a> and begin your journey with Smart Music Malawi today.
      <?php else: ?>
        Check out your <a href="/smart-music-mw/upload">upload page</a> or browse our collection.
      <?php endif; ?>
    </p>
  </div>

  <footer>
    <p>&copy; 2024 Smart Music Malawi. All rights reserved.</p>
    Developed by <b>Lawrence Chikapa Phuka</b>
  </footer>
</body>
</html>
