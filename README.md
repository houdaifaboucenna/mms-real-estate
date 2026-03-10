<h1 align="center">MMS Real Estate</h1>

<p align="center">
  A modern, bilingual (Arabic / English) real-estate web platform built with Laravel 12 and a Vue 3 + Inertia.js SPA front-end.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-v12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/Vue-v3-4FC08D?style=flat-square&logo=vue.js&logoColor=white" alt="Vue 3" />
  <img src="https://img.shields.io/badge/Inertia.js-v2-9553E9?style=flat-square&logo=inertia&logoColor=white" alt="Inertia.js v2" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v3-38BDF8?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS v3" />
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.4" />
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License" />
</p>

---

## ✨ Features

### Public-Facing Site
- **Hero landing page** — property type browser, featured listings, latest blog posts, and an FAQ accordion
- **Property listings** — infinite-scroll paginated grid with live filtering by type, city, town, and price range
- **Property detail page** — multi-image carousel with thumbnail strip, rich bilingual description, price range info, similar properties sidebar, and a sticky contact/WhatsApp CTA
- **Blog** — paginated posts with comments; readers can post comments directly
- **FAQ page** — animated accordion, fully bilingual
- **Search** — global site search across estates and posts
- **Contact form** — stored in the database and visible in the admin panel
- **Bilingual (AR / EN)** — every public page is fully translated; locale switching is a single click

### Admin Panel (`/admin`, role-protected)
- **Dashboard** — at-a-glance stats for estates, posts, messages, and site settings
- **Estates CRUD** — create / edit / delete listings with multi-image upload, slug generation, city/town selectors, type enum, and price range
- **Posts CRUD** — bilingual blog posts with cover image upload and comment moderation
- **FAQ CRUD** — manage questions and answers in both languages
- **Messages & Comments** — inbox for contact form submissions and post comments
- **Site Settings** — update branding, contact info, social links (WhatsApp, phone, address), and logo from a single page
- **Trash / Soft-Deletes** — restore or permanently delete soft-deleted records
- **Role-based access control** via `spatie/laravel-permission`

### Developer-Friendly
- **Laravel Pulse** dashboard for real-time app monitoring
- **Laravel Sanctum** for API authentication
- **SEO Tools** (`artesaos/seotools`) — meta title, description, and OG tags on every page
- **Ziggy** — type-safe named routes available in Vue components
- **Vite** with hot-module replacement for instant front-end feedback
- **PHPUnit** feature & unit test suite
- **Laravel Pint + Duster + Rector** for consistent code style and automated refactoring

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.4 · Laravel 12 |
| SPA Bridge | Inertia.js v2 |
| Frontend Framework | Vue 3 (Composition API, `<script setup>`) |
| Styling | Tailwind CSS v3 · Bootstrap 5 (admin shell) |
| Bundler | Vite 7 |
| Auth | Laravel Breeze · Laravel Sanctum |
| Permissions | Spatie Laravel Permission |
| Database | SQLite (dev) / MySQL (prod) |
| SEO | artesaos/seotools |
| Monitoring | Laravel Pulse |
| Routes in JS | Tightenco Ziggy |
| Icons | Iconify |
| Testing | PHPUnit 11 |
| Code Quality | Laravel Pint · Duster · Rector |

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 20+ & npm

### One-command setup

```bash
composer run setup
```

This will install all dependencies, copy `.env.example` → `.env`, generate the app key, run migrations, and build front-end assets.

### Development server

```bash
composer run dev
```

Starts the Laravel dev server, queue worker, Pail log viewer, and Vite HMR concurrently.

---

## 📁 Project Structure

```
app/
├── Enums/          # EstateTypeEnum, etc.
├── Helpers/        # Global helper functions
├── Http/
│   ├── Controllers/
│   │   ├── Front/  # Public-facing controllers
│   │   └── ...     # Admin controllers
│   └── Requests/   # Form Request classes with validation
├── Models/         # Eloquent models (Estate, Post, City, CityTown, …)
resources/
└── js/
    ├── Components/ # Reusable Vue components (EstateCard, Lightbox, …)
    ├── Layouts/    # AppLayout, AdminLayout
    └── Pages/      # Inertia page components
        ├── Admin/  # Admin panel pages
        ├── Auth/   # Authentication pages
        └── ...     # Public pages
```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
