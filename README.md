# Task Management API

A robust Laravel-based API for managing tasks with authentication, featuring Enums, Scopes, Policies, and comprehensive validation.

## Requirements

- **PHP**: ^8.1
- **Laravel**: ^10.10
- **Composer**: ^2.0
- **MySQL**: ^8.0 (or compatible MariaDB version)


## Features

- **Authentication**: Secure user authentication using Laravel Sanctum.
- **Task Management**: Full CRUD operations for tasks (Soft Deletes enabled).
- **Authorization**: Ownership protection via Laravel Policies.
- **Filtering & Pagination**: Advanced task listing with status/priority filters and paginated results.


## Setup Instructions

### 1. Clone & Install
```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Database Configuration
Update your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management_api
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Migrate and Seed
Run the migrations and populate the database with test data (including the default test account).
```bash
php artisan migrate --seed
```

**Default Test Account:**
- **Email**: `test@example.com`
- **Password**: `password`

### 4. Run the Server
```bash
php artisan serve
```

## Production Configuration

To simulate a production environment locally, update your `.env` file:

```env
APP_ENV=production
APP_DEBUG=false
```

---



## Postman Testing

A pre-configured Postman collection is included in the root directory:
**`Task_Management_API.postman_collection.json`**

## Future Work

- **Scheduled Tasks**: Implement a daily scheduled task using Laravel’s scheduler to automatically mark tasks as **overdue** if their due date has passed.  
- **Notifications**: Send email or in-app notifications for overdue tasks.  
- **Additional Filters**: Add more advanced filtering options (e.g., by due date range).  
- **Task Reminders**: Implement reminders for upcoming tasks via email or push notifications.
