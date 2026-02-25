# PortfolioGen — HTTP 5310 Capstone Portfolio Generator (Laravel)

PortfolioGen is a Laravel web application that helps users create a clean, recruiter-friendly personal portfolio website in minutes. Users pick a template, enter details (education, experience, skills, projects), and publish a shareable portfolio link. Optional AI suggestions help polish bio and project descriptions.

---

## Features

- ✅ Authentication (Register / Login / Logout)
- ✅ Username-based dashboard route
- ✅ Portfolio wizard (multi-step form)
  - Personal
  - Education
  - Experience
  - Skills
  - Projects
  - Review / Publish
- ✅ Templates selection + template previews
- ✅ Public pages: Home, How it Works, Templates
- ✅ AI suggestions endpoint for text polishing (optional)
- ✅ Image uploads for projects (if enabled in your setup)

---

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Blade + Bootstrap 5
- **Assets:** Vite (Laravel Vite integration)
- **Database:** MySQL (recommended) or SQLite (optional)

---

## Project Structure

This repository contains the Laravel project inside:

- `portfoliogen/`

> Important: `.env` is NOT committed to GitHub. Use `.env.example`.

---

## Requirements

Make sure you have:

- PHP **8.2+** (you are using PHP 8.3.x )
- Composer
- Node.js + npm
- MySQL (or SQLite)
- (Optional) MAMP / XAMPP if you prefer Apache instead of `php artisan serve`

---

## Setup Instructions (Step-by-step)

### 1) Clone the Repository

```bash
git clone https://github.com/ankitkumar279/http5310-capstone-portfolio-generator.git
cd http5310-capstone-portfolio-generator/portfoliogen

# 2) Install PHP dependencies
composer install


# 3) Create .env and generate app key
cp .env.example .env
php artisan key:generate


# 4) Configure database (MySQL example)
# Open .env file and update these values:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfoliogen
DB_USERNAME=root
DB_PASSWORD=

# Make sure you create the database first in phpMyAdmin or MySQL CLI


# 4) Configure database (SQLite option)

touch database/database.sqlite

# Then update .env:

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite


# 5) Run migrations
php artisan migrate


# 6) Create storage symlink
php artisan storage:link


# 7) Install frontend dependencies
npm install


# 8) Build frontend assets (fixes Vite manifest error)

# Production build
npm run build

# OR development mode (keep running in another terminal)
npm run dev


# 9) Run the application
php artisan serve

# Open in browser:
# http://127.0.0.1:8000


# -------------------------
# Common Errors & Fixes
# -------------------------

# vendor/autoload.php missing
composer install


# Vite manifest not found
npm install
npm run build


# .env missing / APP_KEY missing
cp .env.example .env
php artisan key:generate


# Clear cache
php artisan optimize:clear


# Useful commands
php artisan route:list
php artisan config:clear
php artisan view:clear
php artisan migrate:fresh


















































<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

