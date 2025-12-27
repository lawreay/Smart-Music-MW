# Smart Music Malawi - PHP Web Application

A community-first music streaming platform for discovering and sharing Malawian music.

## ✨ Features

- **User Authentication**: Secure login and registration with bcrypt password hashing
- **Music Uploads**: Artists can upload their music (MP3, M4A, WAV, FLAC, OGG)
- **Music Discovery**: Browse and search public music tracks
- **User Profiles**: Artist profiles with music management
- **File Storage**: Secure file storage with automatic directory management
- **Session Management**: Secure PHP sessions with proper cookie handling

## 📋 Requirements

- **PHP** >= 8.1
- **MySQL** 5.7+ or MariaDB
- **Apache** with `mod_rewrite` enabled (for .htaccess routing)
- **Extensions**: `pdo`, `pdo_mysql`, `mbstring`

## 🚀 Quick Start

### 1. Database Setup

Create the database by importing the SQL file:

```bash
mysql -u root -p < smart_music.sql
```

Then seed it with an admin user:

```bash
php bin/seed.php
```

**Default admin credentials:**
- Email: `lawreay1@gmil.com`
- Password: `password123`

### 2. Access the Application

**Option A: Using Apache (Recommended)**
```
http://localhost/smart-music-mw/
```

**Option B: Using PHP Built-in Server**
```bash
cd public
php -S localhost:8000
```
Then visit: `http://localhost:8000/`

## 📁 Project Structure

```
smart-music-mw/
├── index.php                 # Root entry point (routes to public/)
├── .htaccess                 # Apache rewrite rules
├── app/
│   ├── Support/
│   │   └── DB.php           # Database connection helper
│   ├── Models/
│   │   ├── User.php         # User model
│   │   ├── Music.php        # Music/Songs model
│   │   └── ...
│   └── Controllers/
│       ├── AuthController.php
│       ├── MusicController.php
│       ├── ProjectController.php
│       └── ContactController.php
├── public/
│   ├── index.php            # Main router
│   ├── index-landing.php    # Home page
│   ├── login.php            # Login form
│   ├── register.php         # Registration form
│   ├── about.php            # About page
│   ├── services.php         # Services page
│   └── upload.php           # Music upload form
├── bin/
│   ├── migrate.php          # Database migration runner
│   └── seed.php             # Database seeding script
├── migrations/
│   └── 001_init.sql         # Database schema
├── database.sql             # Complete SQL dump
├── uploads/                 # User-uploaded files (created automatically)
│   └── music/              # Uploaded audio files
├── media/                   # Sample media files
├── Styles/                  # CSS stylesheets
├── views/                   # Reusable PHP view snippets
├── composer.json            # PHP dependencies
└── SETUP.md                 # Detailed setup guide

```

## 🔐 Security Features

- **Prepared Statements**: All database queries use prepared statements to prevent SQL injection
- **Password Hashing**: Uses PHP's `password_hash()` with bcrypt algorithm
- **Session Handling**: Secure session management with `session_regenerate_id()`
- **File Validation**: Server-side file type and size validation
- **CORS Support**: Proper content-type headers for API responses

## 📡 API Endpoints

### Public
- `GET /api/projects` - List published projects
- `GET /api/music` - List public songs
- `POST /contact-submit` - Submit contact form

### Authenticated (login required)
- `POST /register-submit` - Register new account
- `POST /login-submit` - Login user
- `GET /logout` - Logout user
- `GET /api/my-music` - Get user's uploaded songs
- `POST /upload-music` - Upload music file

## 🎵 Supported Audio Formats

- MP3 (audio/mpeg)
- M4A (audio/mp4)
- WAV (audio/wav)
- FLAC (audio/flac)
- OGG (audio/ogg)

**Max file size**: 100MB

## 📊 Database Schema

### users
Stores user accounts with authentication data.

### songs
Stores uploaded music files with metadata.

### projects
Stores project/content information.

### contacts
Stores contact form submissions.

### sessions
Stores user session data.

## 🛠️ Troubleshooting

### "Not found" error at localhost/smart-music-mw/

**Solution**: Enable Apache's `mod_rewrite`:
1. Edit `C:\xampp\apache\conf\httpd.conf`
2. Uncomment: `LoadModule rewrite_module modules/mod_rewrite.so`
3. Restart Apache

Or use the PHP built-in server instead (see Quick Start above).

### "Access denied" for MySQL

Check your database credentials match in the seed script or migrations.

### Upload fails

- Check `uploads/music/` directory exists and is writable
- Verify file size < 100MB
- Ensure file is a supported audio format

## 📝 Configuration

The application uses environment variables from a `.env` file (if present) for database configuration:

```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=smart_music
DB_USER=smart_user
DB_PASS=your_password
DB_CHARSET=utf8mb4
```

If `.env` is not present, the app uses default localhost values.

## 🚀 Deployment

For production:

1. Copy the entire project to your web server
2. Set document root to the project root (not `/public`)
3. Configure Apache to use `.htaccess` rewriting
4. Update database credentials in `.env` or environment variables
5. Run: `php bin/migrate.php` (if not already migrated)
6. Set proper file permissions on `uploads/` directory

## 📄 Files Removed During Cleanup

The following files were removed as they were replaced by PHP versions:
- `index.html` → `public/index-landing.php`
- `login.html` → `public/login.php`
- `player.html` → `/player` route
- `home.html` → `/home` route
- Old JS files: `player.js`, `songs-loader.js`, `likes-manager.js`
- Old documentation files

## 👨‍💻 Developer

Developed by **Lawrence Chikapa Phuka**

## 📜 License

All rights reserved © 2024 Smart Music Malawi

---

**Version**: 2.0 (PHP Refactor)  
**Last Updated**: December 27, 2025
