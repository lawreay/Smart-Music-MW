# Smart Music - Complete Setup Guide

## Requirements

- PHP >= 8.1 with extensions: `pdo`, `pdo_mysql`, `mbstring`
- MySQL 5.7+ or MariaDB
- XAMPP (for local development on Windows)

## Database Setup

The database has been updated to support music uploads. Key tables:

- **users**: User accounts with password hashing
- **projects**: Content projects
- **contacts**: Contact form submissions
- **sessions**: Session management
- **songs**: Music files (NEW) with user associations, metadata, and public/private control

### Quick Import (Recommended)

1. Open PowerShell or Command Prompt in XAMPP folder.

2. Import the database schema:
```powershell
"C:\xampp\mysql\bin\mysql.exe" -u root -p < C:\xampp\htdocs\Smart-Music-MW\database.sql
```

3. Seed the database with an admin user and sample projects:
```powershell
C:\xampp\php\php.exe C:\xampp\htdocs\Smart-Music-MW\bin\seed.php
```

**Default admin credentials:**
- Email: `lareay1@gmail.com`
- Password: `password123`

## Running the Application

### Option 1: PHP Built-in Server (Local Testing)
```powershell
cd C:\xampp\htdocs\Smart-Music-MW\public
C:\xampp\php\php.exe -S localhost:8000
```

Visit: http://localhost:8000

### Option 2: XAMPP Apache
- Place the project in `C:\xampp\htdocs\Smart-Music-MW`
- Configure `httpd-vhosts.conf` or use default localhost
- Access via: `http://localhost/Smart-Music-MW/public/`

## Key Features

### Authentication
- **Login**: `/login.php` - Secure login with sessions
- **Register**: `/register.php` - Create new user accounts
- **Logout**: `/logout` - Destroy session and redirect

### Music Management
- **Upload**: `/upload.php` - Upload music files (MP3, M4A, WAV, FLAC, OGG)
  - Max file size: 100MB
  - Requires authentication
- **API**: `/api/music` - Retrieve public songs (JSON)
- **User Music**: `/api/my-music` - Get logged-in user's songs

### File Uploads
- Uploaded files are stored in `uploads/music/`
- Directory is created automatically on first upload
- Files are validated by extension and size

## API Endpoints

### Public Endpoints
- `GET /api/projects?limit=10&offset=0` - List published projects
- `GET /api/music?limit=20&offset=0` - List public songs
- `POST /contact-submit` - Submit contact form (form data)

### Authenticated Endpoints
- `GET /api/my-music` - Get user's uploaded songs
- `POST /upload-music` - Upload music file (multipart/form-data)

### Form Fields for Upload
```
title (required): Song title
artist (optional): Artist name
album (optional): Album name
genre (optional): Genre
duration (optional): Duration in seconds
music (required): Audio file
```

## Database Schema Notes

### Songs Table
```sql
CREATE TABLE songs (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,  -- Artist/uploader
  title VARCHAR(255) NOT NULL,
  artist VARCHAR(255),
  album VARCHAR(255),
  genre VARCHAR(100),
  duration INT,
  file_path VARCHAR(512) NOT NULL,  -- Path in uploads/music/
  file_size BIGINT,
  file_type VARCHAR(50),
  cover_art_path VARCHAR(512),  -- Future: album artwork
  description TEXT,
  is_public TINYINT(1) DEFAULT 1,  -- Control visibility
  download_count INT DEFAULT 0,  -- Track downloads
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## Project Structure

```
Smart-Music-MW/
├── app/
│   ├── Support/DB.php          # PDO connection helper
│   ├── Models/
│   │   ├── User.php            # User CRUD
│   │   ├── Music.php           # Music/Songs CRUD
│   │   └── ...
│   └── Controllers/
│       ├── AuthController.php  # Login/Register/Logout
│       ├── MusicController.php # Upload & retrieval
│       └── ...
├── public/
│   ├── index.php               # Front controller/router
│   ├── login.php               # Login form
│   ├── register.php            # Registration form
│   ├── upload.php              # Music upload form
│   └── ...
├── uploads/
│   └── music/                  # Uploaded audio files (created on first upload)
├── bin/
│   ├── migrate.php             # Run migrations
│   └── seed.php                # Seed database with sample data
├── database.sql                # Complete database dump
├── composer.json               # PHP dependencies (requires >= 8.1)
└── ...
```

## Troubleshooting

### "Access denied for user"
- Ensure MySQL is running: `xampp-control.exe` start Apache + MySQL
- Check DB credentials in `.env` match your MySQL setup
- If using root, ensure password is correct

### "File upload failed"
- Check `uploads/music/` directory exists and is writable
- Verify file size < 100MB
- Ensure file is a valid audio format (MP3, M4A, WAV, FLAC, OGG)

### "Session not starting"
- Ensure `session.save_path` in `php.ini` is writable
- Check PHP error logs: `C:\xampp\php\logs\`

## Security Notes

1. **Password Security**: Uses PHP's `password_hash()` (bcrypt).
2. **SQL Injection**: All queries use prepared statements with `PDO::ATTR_EMULATE_PREPARES = false`.
3. **File Upload Validation**: Extension and size checks on server side.
4. **Session Handling**: Secure cookies with `session_regenerate_id()` on login.

## Next Steps (Optional Enhancements)

- Add album cover upload
- Implement search via full-text index on songs
- Add download tracking and statistics
- Create admin panel for moderation
- Add user profiles
- Implement playlist/favorite system

---

**Created**: December 27, 2025
**Project**: Smart Music - Community Music Platform for Malawi
