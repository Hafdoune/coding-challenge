# Coding Challenge

A modern web application built with Laravel and Vue.js.

## Features

- Product Management System
  - List products with filtering and sorting
  - Create new products via Web or CLI

## Requirements

- PHP = 7.3
- Node.js = 16
- Composer
- MySQL

## Installation

1. Clone the repository
```bash
git clone https://github.com/Hafdoune/coding-challenge.git
cd coding-challenge
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations
```bash
php artisan migrate
```

5. Start the development server
```bash
php artisan serve
npm run dev
```

## Testing

```bash
php artisan test
```

## CLI Commands

### Product Management

Create a new product via command line:
```bash
php artisan product:create
```

Options:
- `--name`: Product name
- `--description`: Product description
- `--price`: Product price
- `--image`: Path to product image
- `--categories`: Product categories (names or IDs)

Example:
```bash
php artisan product:create --name="New Product" --price=99.99 --categories="Electronics,Gadgets"
```
