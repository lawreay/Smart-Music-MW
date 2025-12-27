# 🚀 Quick Start - Smart Music Malawi

## Start Here (3 Steps)

### Step 1: Database Import
Open PowerShell and run:
```powershell
mysql -u root -p < database.sql
```

Then seed it:
```powershell
php bin/seed.php
```

### Step 2: Start the Server
Choose ONE option:

**Option A - Apache (Best):**
Visit: `http://localhost/smart-music-mw/`

**Option B - PHP Built-in Server:**
```powershell
cd public
php -S localhost:8000
```
Then visit: `http://localhost:8000/`

### Step 3: Login
Use these credentials:
- **Email**: `admin@local.test`
- **Password**: `password123`

## ✨ Features Ready to Use

✅ **User Authentication**
- Register new accounts: `/register.php`
- Login: `/login.php`
- Logout: Click logout button

✅ **Music Management**
- Upload music: `/upload.php` (logged in only)
- Browse music: `/` (home page)

✅ **Navigation**
- Home: `/`
- About: `/about`
- Services: `/services`

✅ **API Endpoints**
- Public music: `/api/music`
- Your music: `/api/my-music` (logged in only)

## 🎵 Test Data Included

Sample songs preloaded:
- Halsey - Without Me
- Nasty C - See Me Now (Remix)
- Malinga - Chete ft. Zeze Kingston
- Pop Smoke - What You Know Bout Love

## 📁 Important Files

| File | Purpose |
|------|---------|
| `database.sql` | Database schema - import this first |
| `bin/seed.php` | Create admin user - run after import |
| `README.md` | Full documentation |
| `SETUP.md` | Detailed setup guide |
| `CLEANUP.md` | What changed from HTML to PHP |

## ⚠️ Requirements

- PHP 8.1+
- MySQL/MariaDB
- Apache with mod_rewrite (for localhost/smart-music-mw/)

## 🆘 Troubleshooting

**Page shows "Not found"**
- Ensure Apache `mod_rewrite` is enabled
- Or use the PHP built-in server (Option B above)

**Database error**
- Check MySQL is running
- Run `mysql -u root -p` to verify access
- Import database.sql with correct user

**Upload fails**
- Check `uploads/music/` directory exists
- Ensure it's writable
- File must be < 100MB

**More help?**
- See `README.md` for complete docs
- See `SETUP.md` for detailed configuration

---

**Version**: 2.0 (PHP - Cleaned)  
**Status**: ✅ Production Ready  
**Last Updated**: December 27, 2025
