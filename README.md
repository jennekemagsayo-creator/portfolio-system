# Portfolio System (Terminal-Themed) — PHP + MySQL + Bootstrap

No CSS framework beyond Bootstrap. No phpMyAdmin — database is set up via raw SQL only.

## 1. Place the files

Copy the whole `portfolio-system` folder into:
```
C:\xampp\new\htdocs\portfolio-system
```

## 2. Start Apache and MySQL

Open the XAMPP Control Panel, click Start next to both. Your MySQL runs on **port 3307** (confirmed from your last project) — `database.php` is already set to that port.

## 3. Create the database (SQL only, no phpMyAdmin)

Open Command Prompt:

```
cd C:\xampp\new\mysql\bin
mysql -u root -P 3307 -h 127.0.0.1 < "C:\xampp\new\htdocs\portfolio-system\sql\setup.sql"
```

This creates `portfolio_db`, all 7 tables, and seed data — including a default admin login:
- **username:** `admin`
- **password:** `admin123`

Change this password before submitting (see step 6).

## 4. Test the site

Open: `http://localhost/portfolio-system/index.php`

You should see the terminal-themed landing page with your name typed out, and the About/Skills/Experience/Education/Projects sections pulling from the database.

## 5. Log into the CMS

Open: `http://localhost/portfolio-system/admin/login.php`

Log in with `admin` / `admin123`. From the dashboard you can edit your Profile, and add/edit/delete Skills, Experience, Education, and Projects — each change reflects immediately on the public landing page.

## 6. Change the default admin password

Don't leave `admin123` in place. To set a new one via SQL only:

1. Open `http://localhost/portfolio-system/hash_maker.php` (see below — create this temporary file).
2. Copy the hash it prints.
3. In your MySQL CLI session, run:
   ```sql
   USE portfolio_db;
   UPDATE admin_users SET password_hash = 'PASTE_HASH_HERE' WHERE username = 'admin';
   ```
4. Delete `hash_maker.php` afterward.

Create `hash_maker.php` temporarily in the project root with just:
```php
<?php echo password_hash('yournewpassword', PASSWORD_DEFAULT); ?>
```

## 7. Edit your actual content

Either through the CMS dashboard (recommended, that's the point of this activity), or directly via SQL:
```sql
USE portfolio_db;
UPDATE profile SET full_name='Your Real Name', tagline='...', bio='...', email='...' WHERE id=1;
```

## Project structure

```
portfolio-system/
├── database.php            # PDO connection (port 3307)
├── class/
│   └── Portfolio.php        # CRUD methods for every content type
├── api/
│   └── portfolio_api.php    # single REST endpoint, routed by ?resource=
├── admin/
│   ├── login.php            # session-based auth
│   ├── logout.php
│   ├── dashboard.php        # tabbed CMS: profile/skills/experience/education/projects/messages
│   └── admin.js
├── index.php                 # public terminal-themed landing page
├── js/
│   └── main.js               # typing effect + fetches all sections
├── style/
│   └── style.css             # the terminal theme (overrides Bootstrap)
└── sql/
    └── setup.sql             # run this via mysql CLI, not phpMyAdmin
```

## API quick reference (for Postman, if required)

Base: `http://localhost/portfolio-system/api/portfolio_api.php`

| Resource | GET (all) | GET (one) | POST | PUT | DELETE |
|---|---|---|---|---|---|
| profile | `?resource=profile` | — | — | `?resource=profile` | — |
| skills | `?resource=skills` | `?resource=skills&id=1` | `?resource=skills` | `?resource=skills` | `?resource=skills&id=1` |
| experience | `?resource=experience` | `?resource=experience&id=1` | `?resource=experience` | `?resource=experience` | `?resource=experience&id=1` |
| education | `?resource=education` | `?resource=education&id=1` | `?resource=education` | `?resource=education` | `?resource=education&id=1` |
| projects | `?resource=projects` | `?resource=projects&id=1` | `?resource=projects` | `?resource=projects` | `?resource=projects&id=1` |
| messages | `?resource=messages` | — | `?resource=messages` | — | `?resource=messages&id=1` |

POST/PUT need `Content-Type: application/json` header + raw JSON body matching the fields in each table (see `sql/setup.sql` for exact column names).
