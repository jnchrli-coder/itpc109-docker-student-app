# ITPC 109 Docker Student Information System

## Purpose
A student information application that supports adding, viewing,
editing, and deleting fictional student records.

## Technologies
- Apache
- PHP 8.3 with PDO_MYSQL
- MySQL 8.4
- phpMyAdmin
- Docker Desktop and Docker Compose
- Git and GitHub

## Architecture
The browser sends requests to Apache in the web container.
PHP uses PDO to communicate with the MySQL db container.
phpMyAdmin provides a browser interface for database administration.

## Installation
1. Install Git and Docker Desktop.
2. Clone this repository and open its folder in a terminal.
3. Copy the environment template using PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

4. Edit .env and replace the password placeholders with local passwords.
   Choose these before starting the database for the first time.
5. Start Docker Desktop.
6. Build and start the services:

   ```powershell
   docker compose up -d --build
   ```

## URLs
- Application: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Local Database Configuration
- Hostname inside Docker: db
- Database: student_db
- Username: student_user
- Password: the MYSQL_PASSWORD value in your local .env file

Use these details to log in to phpMyAdmin.

The students table and two fictional records are created by
db/init.sql when the database volume is first initialized.

## Features
- Add student records
- View student records
- Edit and update student records
- Delete student records
- Validate required fields on the server
- Reject duplicate student numbers
- Use prepared statements for database changes

## Useful Docker Commands

Check services:
```powershell
docker compose ps
```

View web server logs:
```powershell
docker compose logs web --tail=50
```

Rebuild after changing PHP files:
```powershell
docker compose up -d --build
```

Stop containers while preserving database records:
```powershell
docker compose down
```

Start again:
```powershell
docker compose up -d
```

## Data Persistence
The mysql_data named volume stores database records.
Normal stopping and restarting preserves this volume.

Running docker compose down -v deletes the database volume
and its records. Use it only when intentionally resetting the database.

Changing init.sql or the passwords in .env does not automatically
change an existing initialized database.

## Credentials
The .env file is excluded from Git.
.env.example contains placeholders for local configuration.
Do not commit actual passwords or API keys.

## Developer
Name: Your Name
Section: Your Section
Subject: ITPC 109 – Web Systems and Technologies