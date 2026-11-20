# 🛍️ JuniorG — Modern Full-Stack E-Commerce & Retail Management Platform

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-%5E8.1-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Vite](https://img.shields.io/badge/Vite-4.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Razorpay](https://img.shields.io/badge/Razorpay-Integrated-0C2340?style=for-the-badge&logo=razorpay&logoColor=white)](https://razorpay.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**JuniorG** is an enterprise-grade, full-featured B2C E-Commerce and Retail Management platform built with **Laravel 10**, **Bootstrap 5**, and **MySQL**. It provides a high-converting, mobile-responsive shopping experience for retail customers alongside a secure, role-restricted backoffice management suite for merchants, inventory controllers, and administrators.

---

## 📑 Table of Contents

- [Overview & Architecture](#-overview--architecture)
- [Key Features](#-key-features)
  - [Customer Storefront](#customer-storefront)
  - [Admin Backoffice & Control Center](#admin-backoffice--control-center)
  - [Omnichannel Notifications & Messaging](#omnichannel-notifications--messaging)
  - [Payment Gateways & Checkout](#payment-gateways--checkout)
- [Tech Stack](#-tech-stack)
- [System Requirements](#-system-requirements)
- [Installation & Setup](#-installation--setup)
- [Environment Configuration](#-environment-configuration)
- [Default Access Points & Credentials](#-default-access-points--credentials)
- [Directory Structure](#-directory-structure)
- [Production Deployment & Optimization](#-production-deployment--optimization)
- [Contributing & License](#-contributing--license)

---

## 🏛️ Overview & Architecture

JuniorG is designed with modularity, scalability, and security at its core:

- **Multi-Guard Authentication Architecture**: Separate authentication states and session management for retail customers (`customer` guard), backoffice personnel (`ecomadmin` guard), and default web users (`web` guard).
- **Role-Based Access Control (RBAC)**: Built upon `spatie/laravel-permission` to define custom roles, assign granular permissions, and control access across administrative modules.
- **Hybrid Cart Engine**: Dynamic shopping cart that supports guest sessions and automatically merges session items with persistent database records once a customer logs in.
- **Variant Matrix & Inventory Engine**: Handles multi-attribute product variants (Color, Size/Unit, SKU, Stock, Pricing) with real-time stock decrementing upon order confirmation and audit logging.

---

## 🚀 Key Features

### Customer Storefront

- **Dynamic Catalog & Filtering**: Browse products categorized hierarchically with instant search, category filtering, and responsive grid layouts.
- **Multi-Attribute Product Variants**: Select colors, sizes, and measurement units dynamically with real-time stock validation and adaptive pricing.
- **Smart Cart & Persistence**: Session-backed cart for guest shoppers that seamlessly merges into the customer's account upon authentication.
- **Multi-Address Book**: Manage multiple delivery addresses with city/state cascade dropdowns.
- **Order Lifecycle & Tracking**: Real-time status progression (Pending, Processing, Completed, Cancelled) and instant invoice generation.
- **Ratings & Reviews**: Verified purchase reviews with star ratings and feedback submission.
- **Social & OTP Authentication**:
  - One-click login with **Google OAuth 2.0** (`laravel/socialite`).
  - Mobile login via **OTP (One-Time Password)**.
  - Standard email/password registration with password reset flows and **Google reCAPTCHA v2** protection.
- **Community & Content Engagement**:
  - **Blog System**: Category-based articles with reader comments.
  - **Community Posts**: Interactive user post creation and community commenting feeds.
  - **Newsletter Subscription**: Direct subscription capture for promotional campaigns.

### Admin Backoffice & Control Center (`/admin`)

- **Executive Analytics Dashboard**: Real-time KPIs for total revenue, active orders, customer metrics, inventory alerts, and quick actions.
- **Product & Catalog Management**: Full CRUD operations for Products, Categories, Units, Colors, and Product Image Galleries.
- **Inventory & Stock Management**:
  - Track stock levels per variant.
  - Log inward stock receipts and outward stock adjustments.
  - Export stock and transaction histories in bulk.
- **Order Processing & Fulfillment**:
  - Detailed order view with customer breakdown, shipping details, and ordered item variants.
  - Order status management workflow.
  - One-click printable PDF invoice generation.
  - Direct refund dispatch integrations.
- **Role & Employee Management**: Create custom roles, configure granular permissions, and manage staff credentials with audit tracking.
- **Promotions & Marketing**:
  - Create promotional offers, discounted product bundles, and seasonal deals.
  - Banner advertisements and homepage slider management.
  - Newsletter subscriber management.
- **Rich Media & Content**:
  - Integrated **UniSharp Laravel Filemanager** for drag-and-drop media uploads.
  - Contact request inbox with automated response message templates.
- **Security & Activity Logging**: Comprehensive `LogActivity` tracker recording user actions, IP addresses, HTTP methods, and timestamps.

### Omnichannel Notifications & Messaging

- **WhatsApp Integration**: Automated WhatsApp messaging for order confirmations and transactional updates via MsgClub API.
- **SMS Gateway**: Transactional SMS alerts and OTP delivery via MsgClub SMS Gateway.
- **Email Notifications**: Transactional emails for order placements, account confirmations, and password resets via SMTP.

### Payment Gateways & Checkout

- **Razorpay**: Direct integration with Razorpay checkout (`razorpay/razorpay`) supporting Credit/Debit Cards, UPI, Net Banking, and Wallets.
- **Cashfree**: Integrated Cashfree payment gateway with API-level verification and automated refund dispatch.
- **Cash on Delivery (COD)**: Safe COD fulfillment workflow with order confirmation triggers.

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 10.x |
| **Language** | PHP 8.1+ |
| **Frontend Framework** | Bootstrap 5.2, SASS, Blade Templating |
| **Build Tool** | Vite 4.x |
| **Database** | MySQL 8.0+ / MariaDB 10.4+ |
| **Payment Gateways** | Razorpay SDK, Cashfree Payments API |
| **Authentication & RBAC** | Laravel Multi-Guard, Socialite (Google OAuth), Spatie Permission |
| **Data Tables** | Yajra DataTables (`yajra/laravel-datatables-oracle`) |
| **Media Management** | UniSharp Laravel Filemanager (`unisharp/laravel-filemanager`) |
| **Messaging & SMS** | MsgClub SMS & WhatsApp API |
| **Bot Protection** | Google reCAPTCHA v2 |

---

## 📋 System Requirements

Ensure your server or local development environment satisfies the following prerequisites:

- **PHP**: `^8.1` or `^8.2`
- **Composer**: `^2.x`
- **Node.js**: `^18.x` or `^20.x` & **NPM**: `^9.x`
- **MySQL**: `^8.0` or **MariaDB**: `^10.4`
- **Required PHP Extensions**:
  - `BCMath`
  - `Ctype`
  - `cURL`
  - `DOM` / `XML`
  - `Fileinfo`
  - `GD` or `Imagick`
  - `JSON`
  - `Mbstring`
  - `OpenSSL`
  - `PDO` & `pdo_mysql`
  - `Tokenizer`

---

## ⚙️ Installation & Setup

Follow these steps to set up JuniorG on your local development machine:

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/JuniorG.git
cd JuniorG
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install & Build Frontend Assets

```bash
# Install frontend packages
npm install

# Build production assets with Vite
npm run build

# Alternatively, run the Vite development server during active UI development:
# npm run dev
```

### 4. Configure Environment Variables

Duplicate the template configuration file:

```bash
cp .env.example .env
```

Open `.env` in your preferred editor and update the database credentials and application settings:

```env
APP_NAME=JuniorG
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=juniorg_db
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### 5. Generate Application Encryption Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations & Seeders

Ensure your MySQL database exists (e.g., `juniorg_db`), then execute the database migrations and seed default administrative credentials:

```bash
php artisan migrate --seed
```

> [!NOTE]
> The default seeder executes `AdminSeeder`, which provisions initial administrative accounts.
> If you also wish to seed global country, state, and city tables, run:
> ```bash
> php artisan db:seed --class=CountrySeeder
> php artisan db:seed --class=StateSeeder
> php artisan db:seed --class=CitySeeder
> ```

### 7. Create Storage Symbolic Link

Link the private storage directory to the public directory for media and file access:

```bash
php artisan storage:link
```

### 8. Publish Package Assets (Laravel Filemanager)

Publish configuration and asset files for the file manager:

```bash
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public
```

### 9. Start the Development Server

```bash
php artisan serve
```

The application will be accessible at: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔐 Environment Configuration

Key configuration parameters inside `.env`:

### Database Connection
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=juniorg_db
DB_USERNAME=root
DB_PASSWORD=
```

### Payment Gateways

```env
# Razorpay Credentials
RAZOR_KEY=rzp_test_yourKeyHere
RAZOR_SECRET=yourRazorpaySecretHere

# Cashfree Credentials
CASHFREE_API_URL=https://sandbox.cashfree.com
CASHFREE_API_KEY=your_cashfree_app_id
CASHFREE_API_SECRET=your_cashfree_secret_key
```

### Google OAuth (Socialite) & Google reCAPTCHA

```env
GOOGLE_CLIENT_ID=your_google_client_id.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT=http://localhost:8000/auth/google/callback

GOOGLE_RECAPTCHA_KEY=your_recaptcha_site_key
GOOGLE_RECAPTCHA_SECRET=your_recaptcha_secret_key
```

### SMS & WhatsApp Gateway (MsgClub)

```env
MSGCLUB_AUTH_KEY=your_msgclub_auth_key
MSGCLUB_SENDER_ID=your_sender_id
MSGCLUB_SMS_ROUTE=1
MSGCLUB_WHATSAPP_TRANSACTIONAL_ROUTE=21
MSGCLUB_SERVER_URL=msg.icloudsms.com
MSGCLUB_AWHATSAPP_NO=your_registered_whatsapp_no
```

### Mail Configuration (SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_smtp_username
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="care@juniorg.in"
MAIL_FROM_NAME="JuniorG Store"
```

---

## 🔑 Default Access Points & Credentials

| Portal | URL | Guard | Default Access |
|---|---|---|---|
| **Storefront** | `http://localhost:8000` | `customer` | Open to Public / Shoppers |
| **Admin Control Panel** | `http://localhost:8000/admin/login` | `ecomadmin` | Backoffice Administrators |
| **System Cache Utility** | `http://localhost:8000/service/clear` | `web` | Artisan Cache Flush Route |

### Default Seeded Admin Accounts (from `AdminSeeder`)

| Name | Email | Password | Role |
|---|---|---|---|
| **Super Admin** | `admin@admin.com` | `password` | Administrator |
| **Rohit** | `rohit@admin.com` | `password` | Administrator |
| **Prince** | `prince@admin.com` | `password` | Administrator |
| **Shailendra** | `shailendra@admin.com` | `password` | Administrator |

> [!CAUTION]
> Remember to change all default passwords immediately when deploying to a staging or production environment!

---

## 📂 Directory Structure

```text
JuniorG-main/
├── app/
│   ├── Helpers/
│   │   └── helper.php             # Global helper routines (cart sync, SMS/WhatsApp dispatch, logging)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── CustomerController.php   # Storefront customer authentication & profile logic
│   │   │   ├── Ecom/                    # Storefront & Admin controllers (Catalog, Orders, Payments, etc.)
│   │   │   └── Master/                  # Message & communication templates
│   │   └── Middleware/                  # Custom multi-guard authentication & role filters
│   ├── Models/                          # Eloquent models (Products, Variants, Orders, Payments, etc.)
│   └── Rules/                           # Validation rules (ReCaptcha, etc.)
├── config/                              # Application configuration files (auth, services, lfm, etc.)
├── database/
│   ├── factories/                       # Model factories
│   ├── migrations/                      # Database schema migrations
│   └── seeders/                         # Database seeders (AdminSeeder, City/State/Country)
├── public/
│   ├── assets/                          # Core CSS/JS and vendor assets
│   ├── ecom/                            # Storefront and admin UI theme assets
│   ├── sql/                             # Geographic SQL dumps (cities, states, countries, world)
│   └── index.php                        # Application entry point
├── resources/
│   ├── js/                              # JavaScript source files
│   ├── sass/                            # SASS source stylesheets
│   └── views/
│       ├── admin/                       # General admin master layouts
│       ├── auth/                        # Default web auth views
│       └── ecom/
│           ├── admin/                   # Backoffice module views (Orders, Inventory, Roles, etc.)
│           └── web/                     # Customer storefront views (Catalog, Cart, Checkout, etc.)
├── routes/
│   ├── admin.php                        # Backoffice administrative routes (prefix: /admin)
│   ├── api.php                          # API endpoints
│   ├── ecom.php                         # E-Commerce customer storefront routes
│   └── web.php                          # Service & system maintenance routes
├── vite.config.js                       # Vite frontend asset bundling configuration
└── composer.json                        # PHP project dependencies and metadata
```

---

## ⚡ Production Deployment & Optimization

When deploying JuniorG to a production server (Ubuntu/Debian VPS, AWS EC2, DigitalOcean, or cPanel):

### 1. Optimize Configurations and Caching

Run the following Artisan optimization commands to cache configuration, routes, and views for optimal performance:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 2. Set Appropriate File Permissions

Ensure the web server user (e.g., `www-data` or your cPanel user) has write permissions for `storage` and `bootstrap/cache`:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 3. Web Server Virtual Host Configuration

Ensure the document root of your web server points to the `public/` directory:

```apache
<VirtualHost *:80>
    ServerName juniorg.example.com
    DocumentRoot /var/www/JuniorG/public

    <Directory /var/www/JuniorG/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/juniorg-error.log
    CustomLog ${APACHE_LOG_DIR}/juniorg-access.log combined
</VirtualHost>
```

---

## 🤝 Contributing & License

Contributions, issues, and feature requests are welcome! Feel free to check the [issues page](https://github.com/your-username/JuniorG/issues).

Distributed under the **MIT License**. See `LICENSE` for more information.
