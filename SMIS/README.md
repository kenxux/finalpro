Here’s a detailed **README** file for the **School Management Information System (SMIS)** project, including setup instructions, database details, and basic functionality.

---

# School Management Information System (SMIS)

## Project Overview

The **School Management Information System (SMIS)** is a web-based system designed to manage various administrative and academic tasks for a school, including user management, attendance, classes, grades, and more. The system supports multiple user roles such as admin, teachers, students, parents, accountants, and librarians, each with its own dashboard and functionality.

## Features

- Admin panel for managing users, classes, subjects, and exams.
- Teachers can manage assignments, grade books, and attendance.
- Students can view their class schedules, grades, and take online exams.
- Parents can monitor student progress and make payments online.
- Librarians manage book records and student interactions.
- Accountants handle fees, expenses, and invoicing.
- Secure login with password hashing using **SHA-256**.

## Project Directory Structure

```bash
school_management_system/
├── assets/               # CSS and JS files
├── includes/             # Reusable components like header, footer
├── pages/                # Specific feature pages (e.g., manage users, manage classes)
├── config/               # Configuration files
├── db_connect.php        # Database connection file
├── index.php             # Main homepage
├── login.php             # Admin and user login page
├── admin_dashboard.php   # Admin dashboard
├── logout.php            # Logout functionality
├── README.md             # Project documentation (this file)
```

## Technologies Used

- **Backend**: PHP 7.x/8.x
- **Frontend**: HTML5, CSS3, JavaScript (can integrate with Bootstrap for styling)
- **Database**: MySQL (with secure password hashing using SHA-256)
- **Local Server**: XAMPP/WAMP (or any local server that supports PHP and MySQL)

## Database Setup

### Create Database

You need to create the database `SMIS_db`. You can do this either via **phpMyAdmin** or directly using MySQL queries.

```sql
CREATE DATABASE SMIS_db;
USE SMIS_db;
```

### Users Table

Run the following SQL query to create the `users` table, which stores user details for various roles:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'teacher', 'student', 'parent', 'accountant', 'librarian') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Insert Sample Users

The system has sample data for 10 users in each category (admin, teacher, student, parent, accountant, librarian). Run the following SQL to insert them:

```sql
-- Insert sample users for admin, teacher, student, etc.
INSERT INTO users (username, password, email, role) VALUES
('admin1', SHA2('admin123', 256), 'admin1@school.com', 'admin'),
('teacher1', SHA2('teacher123', 256), 'teacher1@school.com', 'teacher'),
-- Add additional users for each role...
('librarian10', SHA2('library123', 256), 'librarian10@school.com', 'librarian');
```

## System Setup

1. **Clone or Download the Project**:
   Place the project folder `school_management_system` in your local server directory (e.g., `htdocs` for XAMPP or `www` for WAMP).

2. **Database Configuration**:
   - Update the `db_connect.php` file with your local database credentials (e.g., `root` for user and an empty password if you’re using XAMPP/WAMP):

   ```php
   <?php
   $host = "localhost";
   $user = "root";
   $password = "";  // Default for XAMPP/WAMP
   $dbname = "SMIS_db"; // Your database name
   
   $conn = mysqli_connect($host, $user, $password, $dbname);
   
   if (!$conn) {
       die("Connection failed: " . mysqli_connect_error());
   }
   ?>
   ```

3. **Start Your Local Server**:
   Make sure **Apache** and **MySQL** services are running in your XAMPP/WAMP.

4. **Access the Application**:
   - Go to your browser and open the following URL:
   ```
   http://localhost/school_management_system/login.php
   ```

5. **Login**:
   Use any of the default user accounts to log in.
   Example credentials for admin:
   ```
   Username: admin1
   Password: admin123
   ```

## Core Files

### 1. `db_connect.php`
Manages the database connection using PHP's `mysqli`.

### 2. `login.php`
Handles the login functionality. It takes user input (username and password) and validates it against the database using a hashed password (`SHA-256`).

### 3. `admin_dashboard.php`
Admin dashboard where admins can access features like managing users, classes, and subjects.

### 4. `logout.php`
Logs out the user by destroying the session and redirecting them to the login page.

## Password Hashing

Passwords are hashed using **SHA-256**. This ensures the security of user credentials when stored in the database.

```sql
-- Hashing example:
SHA2('password', 256)
```

## Features in Progress

- **User Role Management**: Create, update, delete users for each role.
- **Class and Subject Management**: Manage classes and subjects.
- **Attendance and Grading**: Track student attendance and grade reports.
- **Payments**: Implement fee management for accountants and parents to pay online.

## Future Enhancements

- **User Notifications via SMS/Email**: Notify users about important events.
- **Reporting Tools**: Implement advanced reporting tools for better data analysis.
- **Mobile App Integration**: Provide a mobile-friendly interface or native app.

## Contributions

Feel free to contribute to this project. Please create a pull request with detailed notes on the improvements or new features you’ve implemented.

## License

This project is licensed under the MIT License.


