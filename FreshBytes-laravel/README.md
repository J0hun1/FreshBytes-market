# FreshBytes Market

FreshBytes Market is a modern e-commerce web application built with Laravel, designed for selling fresh produce, groceries, and market items. It features a responsive design using Tailwind CSS and Flowbite components, providing a seamless shopping experience for customers.

## Technologies Used

- **Laravel**: PHP framework for backend development
- **Tailwind CSS**: Utility-first CSS framework for styling
- **Flowbite**: UI components built on top of Tailwind CSS
- **Vite**: Fast build tool for modern web development
- **MySQL**: Database for storing application data

## Prerequisites
- PHP 8.1 or higher
- Composer (PHP dependency manager)
- Node.js 16 or higher
- npm or yarn
- MySQL or another supported database
- Git

## Installation

Follow these steps to set up the FreshBytes Market application on your local machine:


### 1. Install PHP Dependencies
```bash
composer install
```

### 2. Install Node.js Dependencies
```bash
npm install
```

### 3. Install Flowbite
```bash
npm install flowbite
```

### 4. Environment Configuration

```bash
cp .env.example .env
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Database Migrations
```bash
php artisan migrate
```


### 7. Build Assets
```bash
npm run dev
```

```bash
npm run build
```

### 8. Serve the Application
```bash
composer run dec
```

