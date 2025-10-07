# Repository Guidelines

## Project Structure & Module Organization

The **sekolah-web** project is organized as a Laravel-based school management system with clear separation of concerns:

- **`app/`** - Core application logic with MVC architecture
  - `Http/Controllers/` - Controllers organized by user roles (Admin, Teacher, Student, Public)
  - `Models/` - Eloquent models for database entities
  - `Services/` - Business logic services
- **`resources/views/`** - Blade templates organized by user roles and features
- **`database/`** - Migrations, seeders, and factories
- **`public/`** - Web-accessible assets and entry point
- **`config/`** - Application configuration including custom `school.php` config

## Build, Test, and Development Commands

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate
php artisan storage:link

# Database setup
php artisan migrate
php artisan db:seed

# Development server
php artisan serve
npm run dev

# Build for production
npm run build

# Testing
php artisan test
```

## Coding Style & Naming Conventions

- **Indentation**: 4 spaces (PHP), 2 spaces (JavaScript/CSS)
- **File naming**: PascalCase for classes, kebab-case for views
- **Function/variable naming**: camelCase for methods, snake_case for database fields
- **Controllers**: Organized by role (`Admin/`, `Teacher/`, `Student/`, `Public/`)
- **Models**: Singular PascalCase (e.g., `Student`, `Teacher`, `User`)

## Testing Guidelines

- **Framework**: PHPUnit for backend testing
- **Test files**: Located in `tests/Feature/` and `tests/Unit/`
- **Running tests**: `php artisan test`
- **Coverage**: Focus on critical business logic and user workflows

## Commit & Pull Request Guidelines

- **Commit format**: Descriptive messages focusing on feature/fix purpose
- **PR process**: Feature-based development with role-specific testing
- **Branch naming**: `feature/`, `fix/`, `enhancement/` prefixes

---

# Repository Tour

## 🎯 What This Repository Does

**sekolah-web** is a comprehensive school management system built with Laravel that provides digital infrastructure for educational institutions. It manages students, teachers, academic content, and administrative processes through role-based interfaces.

**Key responsibilities:**
- Student and teacher profile management with role-based authentication
- Academic content delivery (assignments, materials, quizzes, grades)
- School administration (announcements, calendar, extracurriculars)
- Public-facing website with school information and news

---

## 🏗️ Architecture Overview

### System Context
```
[Public Users] → [Public Interface] → [Laravel Application] → [MySQL Database]
[Students] → [Student Dashboard] ↗
[Teachers] → [Teacher Dashboard] ↗
[Admins] → [Admin Panel] ↗
```

### Key Components
- **Authentication System** - Multi-role authentication using Spatie Laravel Permission
- **Role-Based Controllers** - Separate controller namespaces for Admin, Teacher, Student, and Public access
- **Content Management** - Blog posts, announcements, media galleries, and academic materials
- **Academic Management** - Student registration, attendance tracking, grade management, and QR-based systems
- **Public Website** - School information, news, achievements, and contact forms

### Data Flow
1. **User Authentication**: Role-based login redirects to appropriate dashboard
2. **Content Creation**: Admins/Teachers create academic content and announcements
3. **Student Interaction**: Students access materials, submit assignments, take quizzes
4. **Data Processing**: System tracks attendance, grades, and generates reports
5. **Public Display**: School information and news displayed on public website

---

## 📁 Project Structure [Partial Directory Tree]

```
sekolah-web/
├── app/
│   ├── Http/Controllers/        # MVC Controllers organized by role
│   │   ├── Admin/              # Administrative functions
│   │   ├── Teacher/            # Teacher-specific features
│   │   ├── Student/            # Student portal functions
│   │   └── Public/             # Public website controllers
│   ├── Models/                 # Eloquent models (40+ models)
│   ├── Services/               # Business logic services
│   ├── Traits/                 # Reusable traits
│   └── Providers/              # Service providers
├── resources/views/            # Blade templates
│   ├── admin/                  # Admin panel views
│   ├── teacher/                # Teacher dashboard views
│   ├── student/                # Student portal views
│   ├── public/                 # Public website views
│   └── layouts/                # Layout templates
├── database/
│   ├── migrations/             # Database schema migrations
│   ├── seeders/                # Data seeders for testing
│   └── factories/              # Model factories
├── config/
│   ├── school.php              # School-specific configuration
│   ├── permission.php          # Role/permission settings
│   └── video.php               # Media configuration
├── public/                     # Web root and assets
└── routes/
    ├── web.php                 # Main application routes
    ├── auth.php                # Authentication routes
    └── api.php                 # API endpoints
```

### Key Files to Know

| File | Purpose | When You'd Touch It |
|------|---------|---------------------|
| `routes/web.php` | Main application routing | Adding new features/pages |
| `config/school.php` | School-specific settings | Configuring academic structure |
| `app/Models/User.php` | Core user model with roles | User-related modifications |
| `app/Models/Student.php` | Student data model | Student management features |
| `app/Models/Teacher.php` | Teacher data model | Teacher management features |
| `composer.json` | PHP dependencies | Adding Laravel packages |
| `package.json` | Frontend dependencies | Adding JS/CSS libraries |
| `.env.example` | Environment configuration | Setting up new environments |

---

## 🔧 Technology Stack

### Core Technologies
- **Language:** PHP 8.1+ - Modern PHP with strong typing and performance
- **Framework:** Laravel 10.x - Full-featured MVC framework with Eloquent ORM
- **Database:** MySQL - Relational database for structured academic data
- **Frontend:** Blade Templates + Alpine.js + Tailwind CSS - Modern, responsive UI

### Key Libraries
- **Spatie Laravel Permission** - Role-based access control system
- **Laravel Breeze** - Authentication scaffolding and user management
- **Intervention Image** - Image processing for avatars and media
- **Maatwebsite Excel** - Excel import/export for student data
- **Endroid QR Code** - QR code generation for attendance system
- **Barryvdh DomPDF** - PDF generation for reports and documents

### Development Tools
- **Vite** - Modern build tool for asset compilation
- **PHPUnit** - Testing framework for backend functionality
- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Lightweight JavaScript framework for interactivity

---

## 🌐 External Dependencies

### Required Services
- **MySQL Database** - Primary data storage for all application data
- **File Storage** - Local storage for uploaded files (avatars, documents, media)
- **Email Service** - SMTP configuration for notifications and communications

### Optional Integrations
- **Cloud Storage** - Can be configured for file uploads (AWS S3, etc.)
- **External APIs** - Extensible for third-party integrations

### Environment Variables

```bash
# Required
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=sekolah_web
DB_USERNAME=root
DB_PASSWORD=

# Application
APP_NAME="School Management System"
APP_URL=http://localhost
APP_TIMEZONE=Asia/Jakarta

# Optional
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
```

---

## 🔄 Common Workflows

### Student Registration & Management
1. **Admin creates student records** via `Admin/StudentController`
2. **Student data validation** using custom request classes
3. **Role assignment** through Spatie Permission system
4. **QR code generation** for attendance tracking

**Code path:** `Admin/StudentController` → `Student Model` → `QR Attendance Service`

### Academic Content Delivery
1. **Teachers create materials/assignments** via Teacher dashboard
2. **Content storage** in database with file attachments
3. **Student access** through role-based permissions
4. **Progress tracking** and grade management

**Code path:** `Teacher/LearningController` → `Assignment/Material Models` → `Student Dashboard`

### Attendance Management
1. **QR code scanning** by students using mobile interface
2. **Real-time attendance logging** with location tracking
3. **Teacher verification** and manual adjustments
4. **Report generation** for administrators

**Code path:** `Student/AttendanceController` → `QrAttendance Model` → `AttendanceLog Model`

---

## 📈 Performance & Scale

### Performance Considerations
- **Database Indexing** - Optimized queries for student/teacher lookups
- **File Storage** - Efficient handling of uploaded media and documents
- **Role-Based Caching** - Cached permissions and user roles

### Monitoring
- **Activity Logging** - Comprehensive user activity tracking
- **Error Logging** - Laravel's built-in logging system
- **Performance Metrics** - Database query optimization

---

## 🚨 Things to Be Careful About

### 🔒 Security Considerations
- **Role-Based Access** - Strict permission checking on all admin/teacher functions
- **Data Validation** - Comprehensive input validation for student data
- **File Upload Security** - Restricted file types and size limits
- **Session Management** - Secure session handling with logout tracking

### 📊 Data Handling
- **Student Privacy** - Sensitive student information requires careful handling
- **Academic Records** - Grade and attendance data integrity is critical
- **File Management** - Proper cleanup of uploaded files and media

### 🎯 Academic Workflow
- **Grade Calculations** - Ensure accurate grade computation and reporting
- **Attendance Tracking** - QR code system requires proper validation
- **Content Access** - Role-based content visibility must be maintained

---

*Updated at: 2024-12-22 UTC*