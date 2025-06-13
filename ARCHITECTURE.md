# Quick Line Medical Case Study Management System

## Overview

Quick Line is a Laravel-based web application for managing medical case studies, users (doctors, laboratories, managers, etc.), and related workflows. It supports case study creation, assignment, review, document generation, and role-based dashboards for different user types.

## Features
- User management (Admin, Doctor, Laboratory, Manager, Assigner, Quality Controller, Collector, etc.)
- Case study creation, assignment, and tracking
- Study types, modalities, and status management
- File and image uploads for case studies
- PDF and Word document generation for case studies
- Role-based dashboards and access control
- Audit logs for doctors and laboratories
- 2FA (Two-Factor Authentication) support

## Setup Instructions

### Requirements
- PHP 8.1+
- Composer
- MySQL or compatible database
- Node.js & npm (for frontend assets)

### Installation
1. Clone the repository and navigate to the project directory.
2. Install PHP dependencies:
   ```
   composer install
   ```
3. Copy `.env.example` to `.env` and configure your database and mail settings.
4. Generate application key:
   ```
   php artisan key:generate
   ```
5. Run migrations:
   ```
   php artisan migrate
   ```
6. (Optional) Seed the database:
   ```
   php artisan db:seed
   ```
7. Install frontend dependencies and build assets:
   ```
   npm install && npm run build
   ```
8. Start the development server:
   ```
   php artisan serve
   ```

## Database Structure (Key Tables)

### users
- id (PK)
- name
- email (unique)
- password
- ... (timestamps, etc.)

### doctors
- id (PK)
- name
- email
- phone_number
- user_id (FK to users)
- status (enum: 0, 1)

### patients
- id (PK)
- patient_id (unique)
- name
- age
- gender
- clinical_history

### case_studies
- id (PK)
- laboratory_id (FK)
- patient_id (FK)
- doctor_id (FK, nullable)
- qc_id (FK to users, nullable)
- assigner_id (FK to users, nullable)
- clinical_history
- is_emergency, is_post_operative, is_follow_up, is_subspecialty, is_callback (smallint flags)
- study_status_id (FK)
- status_updated_on (datetime)

### studies
- id (PK)
- study_type_id (FK)
- description

### study_types
- id (PK)
- modality_id (FK)
- name
- status

### modalities
- id (PK)
- name
- description
- status (enum: 0, 1)

### study_images
- id (PK)
- case_study_id (FK)
- image (string)

### doctor_modalities
- id (PK)
- doctor_id (FK)
- modality_id (FK)

### lab_modalities
- id (PK)
- laboratory_id (FK)
- modality_id (FK)
- status

### doctor_logs / laboratory_logs
- id (PK)
- type (enum: add, update, delete, active, inactive)
- doctor_id / laboratorie_id (FK)
- log (string)
- user_id (FK)
- column_name, old_value, new_value (nullable)

### study_price_group
- id (PK)
- name (unique)
- default_price (decimal)
- timestamps

### study_center_prices
- id (PK)
- center_id (FK to laboratories)
- study_type_id (FK to study_types)
- price (decimal)
- timestamps

## Usage Instructions

- Access the application at `/admin`.
- Login as an admin to manage users, laboratories, doctors, and assign roles.
- Create and manage case studies, assign to doctors, upload images, and generate reports.
- Use the dashboard for an overview of case studies and workflow status.
- Use the provided routes (see `routes/web.php`) for all major features. Key routes include:
  - `/admin/dashboard` — Dashboard
  - `/admin/add-user`, `/admin/view-user` — User management
  - `/admin/add-doctor`, `/admin/view-doctor` — Doctor management
  - `/admin/add-laboratory`, `/admin/view-laboratory` — Laboratory management
  - `/admin/view-case-study` — View case studies
  - `/admin/download-word/{id}` — Download case study as Word document
  - `/case-study/pdf/{case_study_id}` — Download case study as PDF

## Dependencies
- Laravel Framework 10.x
- barryvdh/laravel-dompdf (PDF generation)
- phpoffice/phpword (Word document generation)
- endroid/qr-code (QR code support)
- guzzlehttp/guzzle (HTTP client)
- laravel/fortify, laravel/sanctum (authentication)
- pragmarx/google2fa-laravel (2FA)
- razorpay/razorpay (payment integration)

## Additional Notes
- For more details, see the controller files in `app/Http/Controllers/` and the migration files in `database/migrations/`.
- For customization, review the Blade templates in `resources/views/admin/`.
- For troubleshooting, check the logs in `storage/logs/`.
