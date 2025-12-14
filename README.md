# Clearit by Freightos – Technical Dev Test

Ticket management system built with Laravel, MySQL, and Laravel Breeze (Blade).

The system supports two roles:

- User: creates tickets, uploads documents, and responds to document requests.
- Agent: reviews tickets, updates ticket status, requests additional documents, and reviews uploaded files.

Notifications are implemented using Laravel Notifications with the database channel.

---

## Requirements

- PHP 8.2 or higher (tested with PHP 8.3)
- Composer
- Node.js and npm
- MySQL 8 or higher
- Git

---

## Installation & Setup

### 1. Clone the repository

Clone the repository from GitHub using the following command and access the project folder:

git clone https://github.com/rfascendini/clearit-dev-exam.git  
cd clearit-dev-exam

---

### 2. Install backend dependencies

Install PHP dependencies using Composer:

composer install

---

### 3. Install frontend dependencies

Install Node dependencies required for Tailwind CSS and Vite:

npm install

---

### 4. Environment configuration

Create the environment file based on the example file:

cp .env.example .env

Generate the Laravel application key:

php artisan key:generate

Configure the database connection in the .env file with your local MySQL credentials.

---

### 5. Database setup

Create a MySQL database for the project using your preferred database tool.

---

### 6. Migrations and seeders

Run migrations and seeders to create the required tables and insert sample data:

php artisan migrate --seed

This process will create all required tables and insert sample users with predefined roles (user and agent).

---

### 7. Storage configuration

Create the storage symbolic link so uploaded documents can be accessed correctly:

php artisan storage:link

---

### 8. Run the application

Start the Laravel development server:

php artisan serve

Start the frontend development server for assets and styles:

npm run dev

Access the application through the local development URL, usually http://127.0.0.1:8000.

---

## Test Accounts

After seeding the database, you can log in using the following credentials.

### User
- Email: user@clearit.com
- Password: user123

### Agent
- Email: agent@clearit.com
- Password: agent123

---

## Main Flows

### User

- Login
- Create tickets
- View ticket details
- Upload documents
- Upload documents requested by an agent

### Agent

- Login
- View all tickets
- Change ticket status from new to in progress and completed
- Request additional documents
- Review uploaded documents

---

## Notifications

Notifications are stored in the database and include:

- New ticket created
- Document request created
- Document uploaded for a request
- Ticket status updated

Notifications are accessible from the notifications section of the application.

---

## Useful Commands

Clear application caches:

php artisan optimize:clear

List all registered routes:

php artisan route:list

---

## Author

Technical test implementation for Clearit by Freightos by Renzo Fascendini.
