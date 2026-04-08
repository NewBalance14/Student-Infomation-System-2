# 🎓 Student Information System

A comprehensive web-based Student Information System built with Laravel 12, designed to manage students, subjects, enrollments, and academic records efficiently.

![Laravel](https://img.shields.io/badge/Laravel-12.1.1-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.0-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

---

## 📋 Table of Contents

-   [Features](#-features)
-   [Screenshots](#-screenshots)
-   [Tech Stack](#-tech-stack)
-   [Requirements](#-requirements)
-   [Installation](#-installation)
-   [Configuration](#-configuration)
-   [Database Setup](#-database-setup)
-   [Usage](#-usage)
-   [User Roles](#-user-roles)
-   [Recent Updates](#-recent-updates)
-   [Project Structure](#-project-structure)
-   [API Documentation](#-api-documentation)
-   [Contributing](#-contributing)
-   [License](#-license)
-   [Support](#-support)

---

## ✨ Features

### 🎯 Core Functionality

-   **Student Management**: Comprehensive student profile management with enrollment tracking
-   **Subject Management**: Create, update, and delete subjects with flexible department options
-   **Enrollment System**: Enroll students in subjects with grade tracking
-   **Grade Weighted Average (GWA)**: Automatic calculation based on student enrollments
-   **Academic Standing**: Automatic classification (Dean's Lister, With Honors, Passed, Failed)
-   **User Authentication**: Secure login/registration with email verification
-   **Role-Based Access Control**: Admin and Student roles with different permissions

### 🔍 Advanced Features

-   **Dynamic Search & Filters**:
    -   Search subjects by code or name
    -   Search students by student number or name
    -   Filter by department, year level, semester, and verification status
    -   Filters pull data dynamically from the database
-   **Custom Department Support**:

    -   Add custom departments on-the-fly when creating subjects
    -   Toggle between predefined and custom department input
    -   Custom departments automatically appear in filters

-   **Modern UI/UX**:

    -   Clean, minimalistic design with gradient effects
    -   Responsive sidebar navigation
    -   Font Awesome icons throughout
    -   Smooth animations and transitions
    -   Mobile-responsive design

-   **Pagination**: All lists paginated with filter state preservation
-   **Form Validation**: Comprehensive server-side validation
-   **Error Handling**: User-friendly error messages and validation feedback

---

## 📸 Screenshots

### Landing Page

Modern landing page with hero section and feature highlights

### Dashboard

Clean dashboard with student overview and quick actions

### Subject Management

Advanced filtering and search capabilities with custom department support

### Student Profile

Comprehensive student profile with GWA calculation and enrollment history

---

## 🛠 Tech Stack

### Backend

-   **Laravel 12.1.1** - PHP Framework
-   **PHP 8.2+** - Server-side scripting
-   **MySQL 8.0** - Database management
-   **Laravel Breeze** - Authentication scaffolding

### Frontend

-   **Tailwind CSS 3.0** - Utility-first CSS framework
-   **Bootstrap 5.3.0** - Component library (hybrid approach)
-   **Alpine.js** - Lightweight JavaScript framework
-   **Font Awesome 6.4.0** - Icon library
-   **Vite** - Modern build tool

### Development Tools

-   **Composer** - PHP dependency manager
-   **npm** - JavaScript package manager
-   **Git** - Version control

---

## 📦 Requirements

Before you begin, ensure you have the following installed:

-   **PHP**: >= 8.2
-   **Composer**: >= 2.0
-   **Node.js**: >= 18.x
-   **npm**: >= 9.x
-   **MySQL**: >= 8.0
-   **Git**: Latest version

### PHP Extensions Required

-   OpenSSL
-   PDO
-   Mbstring
-   Tokenizer
-   XML
-   Ctype
-   JSON
-   BCMath
-   Fileinfo

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Yosores04/Student-Information-System.git
cd Student-Information-System
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Create Environment File

```bash
# Windows (PowerShell)
Copy-Item .env.example .env

# Linux/Mac
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Configure Database

Edit `.env` file and update the database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wtsmidterm
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. (Optional) Seed Database

```bash
php artisan db:seed
```

### 9. Build Assets

```bash
npm run build

# Or for development with hot reload
npm run dev
```

### 10. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`

---

## ⚙️ Configuration

### Environment Variables

Key environment variables in `.env`:

```env
APP_NAME="Student Information System"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wtsmidterm
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

### Storage Linking

If you plan to use file uploads:

```bash
php artisan storage:link
```

---

## 🗄️ Database Setup

### Database Schema

The application uses the following main tables:

-   **users**: User accounts (students and admins)
-   **students**: Student profiles linked to users
-   **subjects**: Available subjects/courses
-   **enrollments**: Student-subject relationships with grades
-   **password_reset_tokens**: Password reset functionality
-   **sessions**: User sessions

### Migration Files

All migrations are located in `database/migrations/`:

-   `create_users_table.php`
-   `create_students_table.php`
-   `create_subjects_table.php`
-   `create_enrollments_table.php`
-   `update_subjects_table.php`

### Creating the Database

```sql
CREATE DATABASE wtsmidterm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run migrations:

```bash
php artisan migrate
```

---

## 📖 Usage

### Creating an Admin Account

After installation, register a new account and manually set `is_admin` to `1` in the database:

```sql
UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com';
```

### Admin Features

Admins can:

-   ✅ Create, edit, and delete subjects
-   ✅ View all students
-   ✅ Verify student accounts
-   ✅ Manage enrollments
-   ✅ Access full system functionality

### Student Features

Students can:

-   ✅ Register and login
-   ✅ View their profile and GWA
-   ✅ View enrolled subjects
-   ✅ See academic standing
-   ✅ Update profile information

### Using Custom Departments

When creating a subject:

1. Click **"➕ Add custom department"** button
2. Type your custom department name
3. Or select **"➕ Add New Department"** from dropdown
4. Submit the form

Custom departments automatically appear in filter dropdowns!

---

## 👥 User Roles

### Admin

-   Full access to all features
-   Can manage subjects, students, and enrollments
-   Can verify student accounts
-   Access to admin-only routes

### Student

-   Can view their own profile and enrollments
-   Can see their GWA and academic standing
-   Cannot create or modify subjects
-   Limited to student-specific routes

### Guest

-   Can view landing page
-   Can register and login
-   No access to protected routes

---

## 🆕 Recent Updates

### Version 1.3.0 (October 2025)

#### ✨ New Features

-   **Custom Department Support**: Add departments on-the-fly without code changes
-   **Dynamic Filters**: All filters pull data from database dynamically
-   **Enhanced Search**: Search subjects by code/name, students by number/name
-   **Results Counter**: Shows "Showing X to Y of Z results"
-   **Smart No-Results Message**: Context-aware empty state messages

#### 🔧 Bug Fixes

-   Fixed missing `units` field in subject creation form
-   Updated department validation to accept custom values
-   Fixed department dropdown options mismatch
-   Added missing `@stack('scripts')` to app layout

#### 🎨 UI/UX Improvements

-   Modern sidebar navigation with gradients
-   Icon-enhanced auth pages
-   Improved form layouts with better spacing
-   Better error message displays
-   Mobile-responsive design improvements

### Version 1.2.0

-   Implemented comprehensive search and filter system
-   Added pagination with filter preservation
-   Enhanced student profile with GWA calculation
-   Fixed migration ordering issues

### Version 1.1.0

-   Initial release with core functionality
-   Student and subject management
-   Enrollment system
-   Authentication with Laravel Breeze

---

## 📁 Project Structure

```
Student-Information-System/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   └── SubjectController.php
│   │   │   ├── StudentController.php
│   │   │   ├── EnrollmentController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Student.php
│   │   ├── Subject.php
│   │   └── Enrollment.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   ├── layouts/
│   │   ├── subjects/
│   │   ├── students/
│   │   └── enrollments/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   └── auth.php
├── public/
├── storage/
├── tests/
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 📚 API Documentation

### Subject Routes

```php
GET    /subjects              - List all subjects (with filters)
GET    /subjects/create       - Show create form (admin only)
POST   /subjects              - Store new subject (admin only)
GET    /subjects/{subject}    - Show subject details
GET    /subjects/{subject}/edit - Show edit form (admin only)
PUT    /subjects/{subject}    - Update subject (admin only)
DELETE /subjects/{subject}    - Delete subject (admin only)
```

### Student Routes

```php
GET    /students              - List all students (with filters)
GET    /students/{student}    - Show student profile
```

### Enrollment Routes

```php
GET    /enrollments/{student}/create - Show enrollment form
POST   /enrollments                  - Store new enrollment
PUT    /enrollments/{enrollment}     - Update enrollment (grades)
DELETE /enrollments/{enrollment}     - Remove enrollment
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**
    ```bash
    git checkout -b feature/AmazingFeature
    ```
3. **Commit your changes**
    ```bash
    git commit -m 'Add some AmazingFeature'
    ```
4. **Push to the branch**
    ```bash
    git push origin feature/AmazingFeature
    ```
5. **Open a Pull Request**

### Coding Standards

-   Follow PSR-12 coding standards
-   Write meaningful commit messages
-   Add comments for complex logic
-   Update documentation as needed

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 💬 Support

For support, questions, or feature requests:

-   **GitHub Issues**: [Create an issue](https://github.com/Yosores04/Student-Information-System/issues)
-   **Email**: [2201103613@student.buksu.edu.ph](mailto:2201103613@student.buksu.edu.ph)
-   **Documentation**: Check the `/docs` folder for detailed guides

---

## 🙏 Acknowledgments

-   **Laravel Team** - For the amazing framework
-   **Tailwind CSS** - For the utility-first CSS framework
-   **Font Awesome** - For the icon library
-   **Bootstrap** - For UI components

---

## 📝 Additional Documentation

For more detailed information, check these files:

-   **[SEARCH_FILTER_IMPROVEMENTS.md](SEARCH_FILTER_IMPROVEMENTS.md)** - Search and filter implementation details
-   **[SUBJECT_CRUD_FIX.md](SUBJECT_CRUD_FIX.md)** - Subject creation/editing fixes
-   **[CUSTOM_DEPARTMENT_FEATURE.md](CUSTOM_DEPARTMENT_FEATURE.md)** - Custom department feature documentation
-   **[CUSTOM_DEPARTMENT_QUICKSTART.md](CUSTOM_DEPARTMENT_QUICKSTART.md)** - Quick guide for custom departments

---

## 🔮 Roadmap

### Planned Features

-   [ ] Student attendance tracking
-   [ ] Grade export to PDF/Excel
-   [ ] Email notifications for enrollment
-   [ ] Parent/Guardian portal
-   [ ] Academic calendar integration
-   [ ] Subject prerequisites system
-   [ ] Bulk enrollment import
-   [ ] Advanced reporting and analytics

---

<p align="center">
  Made with ❤️ by <a href="https://github.com/Yosores04">Yosores04</a>
</p>

<p align="center">
  ⭐ Star this repository if you find it helpful!
</p>
