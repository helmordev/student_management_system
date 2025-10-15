# Student Management System

This is a web-based Student Management System built with Laravel, designed to help educational institutions manage student information, grades, announcements, and activity logs efficiently.

## Features

- **User Management:** Secure authentication and management of user accounts.
- **Student Management:** Comprehensive services for managing student data.
- **Grade Management:** Record and track student grades.
- **Announcement System:** Create and manage announcements for students and staff.
- **Activity Logging:** Keep a detailed log of system activities.
- **PDF Reporting:** Generate PDF reports for various data (e.g., student records, grades).

## Technologies Used

- **Backend:**
    - PHP 8+
    - Laravel 12 (PHP Framework)
    - Composer (PHP Dependency Manager)
    - Dompdf (for PDF generation)
- **Frontend:**
    - NPM (Node.js Package Manager)
    - Vite (Frontend Build Tool)
    - Tailwind CSS (Styling Framework)
- **Database:**
    - MySQL
- **Testing:**
    - PestPHP

## Installation

Follow these steps to get the project up and running on your local machine.

### Prerequisites

Ensure you have the following installed:

- PHP (8.2 or higher)
- Composer
- Node.js (LTS version recommended)
- NPM or Yarn
- A database server (e.g., MySQL, PostgreSQL, or SQLite for local development)

### 1. Clone the Repository

```bash
git clone https://github.com/helmordev/student_management_system.git
cd student_management_system
```

### 2. Setup the Project (Recommended)

This project includes a convenient `composer setup` script that automates most of the initial configuration:

```bash
composer setup
```

This script will:

- Install PHP dependencies via Composer.
- Copy `.env.example` to `.env`.
- Generate an application key.
- Run database migrations.
- Install Node.js dependencies via NPM.
- Build frontend assets using Vite.

### 3. Manual Setup (If `composer setup` fails or for more control)

#### a. Install PHP Dependencies

```bash
composer install
```

#### b. Environment Configuration

Copy the example environment file and generate an application key:

```bash
cp .env.example .env
php artisan key:generate
```

Open the newly created `.env` file and configure your database connection and other environment variables.

#### c. Database Setup

Run the database migrations to create the necessary tables. If you have seeders, you can run them as well.

```bash
php artisan migrate
php artisan db:seed
```

#### d. Install Node.js Dependencies

```bash
npm install # or yarn install
```

#### e. Build Frontend Assets

```bash
npm run build # or yarn build
```

## Running the Application

### Development Server

To run the application in development mode with hot-reloading for frontend assets, use the `composer dev` script:

```bash
composer run dev
```

This command will concurrently start:

- The Laravel development server (`php artisan serve`)
- A queue listener (`php artisan queue:listen`)
- The Vite development server (`npm run dev`)

Access the application in your browser at `http://127.0.0.1:8000` (or the address shown in your terminal).

## Database Schema (High-Level)

The system utilizes several key tables to manage student data:

- `users`: Stores user authentication information.
- `grades`: Records student grades, likely linked to users/students.
- `announcements`: Stores system-wide announcements.
- `activity_logs`: Logs various actions and events within the system.
- `cache`, `jobs`, `password_reset_tokens`, `sessions`: Standard Laravel tables for caching, queues, password resets, and session management.

## File Generation Commands

### Composer

- `composer require barryvdh/laravel-dompdf`

### Artisan

#### Migrations

- `php artisan make:migration create_grades_table`
- `php artisan make:migration create_announcements_table`
- `php artisan make:migration create_activity_logs_table`

Run Migrations:

- `php artisan migrate`

#### Models

- `php artisan make:model ActivityLog`
- `php artisan make:model Announcement`
- `php artisan make:model Grade`
- `php artisan make:model User`

#### Factories

- `php artisan make:factory AnnouncementFactory`
- `php artisan make:factory GradeFactory`
- `php artisan make:factory UserFactory`

#### Seeders

- `php artisan make:seeder AnnouncementSeeder`
- `php artisan make:seeder GradeSeeder`
- `php artisan make:seeder StudentSeeder`

Run Seeders:

- `php artisan db:seed`

#### Controllers

- `php artisan make:controller Admin/DashboardController`
- `php artisan make:controller Admin/StudentController`
- `php artisan make:controller Admin/GradeController`
- `php artisan make:controller Admin/AnnouncementController`
- `php artisan make:controller Admin/ActivityLogController`
- `php artisan make:controller Admin/ReportController`
- `php artisan make:controller Student/DashboardController`
- `php artisan make:controller Student/ProfileController`
- `php artisan make:controller Student/GradeController`
- `php artisan make:controller Student/AnnouncementController`
- `php artisan make:controller Auth/AuthController`
- `php artisan make:controller PdfReportController`

#### Middleware

- `php artisan make:middleware AdminMiddleware`
- `php artisan make:middleware StudentMiddleware`

