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
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
