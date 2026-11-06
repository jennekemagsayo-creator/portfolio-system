-- Run this with the MySQL command line (no phpMyAdmin needed):
--   cd C:\xampp\new\mysql\bin
--   mysql -u root -P 3307 -h 127.0.0.1 < "C:\xampp\new\htdocs\portfolio-system\sql\setup.sql"
--
-- Or interactively:
--   mysql -u root -P 3307 -h 127.0.0.1
--   then paste this whole file's contents at the prompt.

CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- One row: your resume/profile info shown in the hero + about section
CREATE TABLE IF NOT EXISTS profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    tagline VARCHAR(150) NOT NULL,
    bio TEXT NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    github_url VARCHAR(255),
    linkedin_url VARCHAR(255),
    photo_path VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(100) NOT NULL,
    proficiency INT NOT NULL DEFAULT 50,
    category VARCHAR(50) NOT NULL DEFAULT 'General'
);

CREATE TABLE IF NOT EXISTS experience (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company VARCHAR(150) NOT NULL,
    role VARCHAR(150) NOT NULL,
    start_date VARCHAR(30) NOT NULL,
    end_date VARCHAR(30) NOT NULL DEFAULT 'Present',
    description TEXT
);

CREATE TABLE IF NOT EXISTS education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    school VARCHAR(150) NOT NULL,
    degree VARCHAR(150) NOT NULL,
    start_date VARCHAR(30) NOT NULL,
    end_date VARCHAR(30) NOT NULL DEFAULT 'Present',
    description TEXT
);

CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    tech_stack VARCHAR(255) NOT NULL,
    image_path VARCHAR(255),
    project_url VARCHAR(255),
    github_url VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Seed data: edit these values to be your actual info
INSERT INTO profile (full_name, tagline, bio, email, phone, github_url, linkedin_url, photo_path) VALUES
('Your Name', 'BS Computer Science Student', 'Third-year Computer Science student who returned to school after a gap and rebuilt everything from the ground up. I like solving real problems with code, and I don''t give up when the environment fights back.', 'you@example.com', '09XXXXXXXXX', 'https://github.com/yourusername', 'https://linkedin.com/in/yourusername', '');

INSERT INTO skills (skill_name, proficiency, category) VALUES
('PHP', 75, 'Languages'),
('MySQL', 70, 'Languages'),
('JavaScript', 65, 'Languages'),
('HTML/CSS', 80, 'Languages'),
('Bootstrap', 70, 'Tools'),
('Git', 60, 'Tools'),
('Postman', 65, 'Tools');

INSERT INTO experience (company, role, start_date, end_date, description) VALUES
('Sample Company', 'Intern / Student Developer', '2026-06', 'Present', 'Describe what you worked on here.');

INSERT INTO education (school, degree, start_date, end_date, description) VALUES
('Western Mindanao State University', 'BS Computer Science', '2022', 'Present', 'Returned after a 4-year gap; third-year standing.');

INSERT INTO projects (title, description, tech_stack, image_path, project_url, github_url) VALUES
('Employee Management System', 'A full CRUD web app for managing employee records, built with a custom REST API.', 'PHP, MySQL, PDO, Vanilla JS, Bootstrap', '', '', 'https://github.com/yourusername/employee-management');

-- Default admin login: username "admin", password "admin123"
-- CHANGE THIS PASSWORD before submitting/deploying anywhere real.
INSERT INTO admin_users (username, password_hash) VALUES
('admin', '$2b$12$YWtFPP6e4vBF2WdoMJwtR.b81w.EXhq2tmFcfPtTBV80/DdF4YkVm');
