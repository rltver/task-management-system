# Task Management System

A **Task Management System** built with **Laravel**, designed to organize and manage tasks with support for categories, priorities, attachments, comments, and historical tracking.

## Features

- Full CRUD for tasks
- Soft delete & restore functionality
- Task comments and file attachments
- Dynamic dashboard with time-based statistics (daily, weekly, monthly)
- Export tasks data as PDF and CSV
- Task filtering and sorting
- User authentication
- Lazy loading with Eloquent relationships
- File uploads and storage handling
- Clean UI with custom `flux` components

---

## Tech Stack

- **Laravel 12**
- **Blade** templating engine
- **Laravel DomPDF** for PDF generation
- **MySQL** database
- **Tailwind CSS**
- **Livewire**
- **Eloquent SoftDeletes**
- **Queue system** for asynchronous operations

---
## Installation

```bash
git clone https://github.com/rltver/task-management-system.git
cd task-management-system
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```
---
## ⚙️ Database Configuration

This project uses **MySQL** as its database. To configure:

1. Create a MySQL database (e.g., `task_management_system`).
2. Copy `.env.example` to `.env`:

```bash
cp .env.example .env
```
Update your .env file with your MySQL server credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management_system
DB_USERNAME=root
DB_PASSWORD=your_password
```
