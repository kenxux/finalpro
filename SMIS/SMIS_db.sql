-- Create the database
CREATE DATABASE IF NOT EXISTS SMIS_db;

-- Use the database
USE SMIS_db;

-- Drop the users table if it exists (optional)
DROP TABLE IF EXISTS users;

-- Create users table for different roles
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'teacher', 'student', 'parent', 'accountant', 'librarian') NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL, -- Added profile_picture column for storing image paths
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone_number VARCHAR(15),
    profile_picture VARCHAR(255),
    hire_date DATE,
    subject VARCHAR(100),  -- Column for the subject taught
    class_assigned VARCHAR(100),  -- Column for the class assigned
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Ensure MySQL version supports SHA2 function
SELECT VERSION();

-- Passwords are hashed using SHA-256 (Secure Hash Algorithm 256-bit) for secure password storage

-- Insert Admins with profile pictures
INSERT INTO users (username, password, email, role, profile_picture) VALUES
('admin1', SHA2('admin123', 256), 'admin1@school.com', 'admin', 'profile_picture1 (2).jpg'),
('admin2', SHA2('admin123', 256), 'admin2@school.com', 'admin', 'profile_picture1 (3).jpg');

-- Insert Teachers with profile pictures
INSERT INTO users (username, password, email, role, profile_picture) VALUES
('teacher1', SHA2('teacher123', 256), 'teacher1@school.com', 'teacher', 'profile_picture1 (4).jpg'),
('teacher2', SHA2('teacher123', 256), 'teacher2@school.com', 'teacher', 'profile_picture1 (5).jpg');

-- Insert Students with profile pictures
INSERT INTO users (username, password, email, role, profile_picture) VALUES
('student1', SHA2('student123', 256), 'student1@school.com', 'student', 'profile_picture1 (6).jpg'),
('student2', SHA2('student123', 256), 'student2@school.com', 'student', 'profile_picture1 (7).jpg');

-- Verify if the users have been inserted properly
SELECT * FROM users;
