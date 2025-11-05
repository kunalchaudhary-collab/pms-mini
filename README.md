# 🗂️ Project Management System (PMS) — Laravel 12


A simple and functional **Project Management System** built with **Laravel 10+** that demonstrates Authentication, CRUD, Task Assignment, Commenting, and Activity Logging (with JSON data).

---

## 🚀 Features

✅ User Authentication (Login, Register, Logout)  
✅ Dashboard summary with total projects & tasks  
✅ CRUD for Projects  
✅ CRUD for Tasks (assign users, statuses, due dates)  
✅ Comment System for Projects & Tasks  
✅ Activity Logs (JSON data for all CRUD actions)  
✅ Publicly visible comments on Dashboard  
✅ Simple layout using Blade (`@extends`, `@yield`)  
✅ Clean folder structure —  CSS/JS 
✅ AJAX for task updates and comments  

---

## 🧠 Tech Stack

| Component | Technology |
|------------|-------------|
| Framework | Laravel 12+|
| Language | PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade + jQuery |
| Auth Middleware |  Web routes |
| Xampp | PHP 8.2+

---

## ⚙️ Installation Guide

### 1️⃣ Clone or Download the Repository

```bash
git clone https://github.com/kunalchaudhary-collab/pms-mini
cd pms-laravel-mini
```

### 2️⃣ Install Dependencies
- Make sure Composer and PHP 8.1+ are installed.
```
composer install

```

### 3️⃣ Configure Environment

- Copy the .env file:
```bash
cp .env.example .env

```

- Then open .env and set your database details:

```bash
DB_DATABASE=pms_db
DB_USERNAME=root
DB_PASSWORD=
```

- then migrate tables 
```bash
php artisan migrate
```


### 4️⃣ Generate App Key
```bash
php artisan key:generate
```

### 3️⃣ Run Development Server
```bash
php artisan serve
```


- Now open your browser and visit:
```bash
http://127.0.0.1:8000
```