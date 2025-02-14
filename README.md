# Modern E-Commerce Marketplace

A robust and scalable e-commerce platform built with Laravel 11 and Vue.js, enabling sellers to list products and buyers to make secure purchases in a modern, responsive environment.

## 🌟 Overview

This marketplace platform provides a comprehensive solution for online commerce, featuring real-time updates, secure payments, and a seamless user experience for both buyers and sellers.

## 🚀 Key Features

### For Buyers
- Advanced product search with filters and categories
- Real-time inventory tracking
- Secure checkout with multiple payment options
- Order tracking and history
- Product reviews and ratings
- Personalized recommendations
- Wishlist management

### For Sellers
- Intuitive product listing management
- Inventory control and tracking
- Order fulfillment dashboard
- Analytics and sales reports
- Customer messaging system
- Bulk product operations

### Platform Features
- Multi-vendor support
- Real-time notifications
- Responsive design
- Admin dashboard
- Advanced analytics
- SEO optimization
- Multi-language support
- Dark/Light mode

## 🛠️ Technology Stack

### Backend
- **Framework:** Laravel 11
- **Database:** PostgreSQL
- **Caching:** Redis
- **Storage:** Cloudflare R2
- **Queue:** Laravel Horizon
- **Search:** Meilisearch
- **Testing:** PHPUnit

### Frontend
- **Framework:** Vue.js 3
- **Router:** Inertia.js
- **State Management:** Pinia
- **UI Components:** shadcn-vue
- **Styling:** Tailwind CSS
- **Forms:** VeeValidate
- **Testing:** Vitest

## ⚙️ Prerequisites

- PHP 8.2 or higher
- Node.js 18 or higher
- PostgreSQL 14 or higher
- Redis
- Composer
- npm/yarn
- Cloudflare R2 account
- Stripe/PayPal account (for payments)

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/ecommerce-marketplace.git
   cd ecommerce-marketplace
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure environment variables**
   ```
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   REDIS_HOST=127.0.0.1
   REDIS_PASSWORD=null
   REDIS_PORT=6379

   R2_ACCESS_KEY=your_access_key
   R2_SECRET_KEY=your_secret_key
   R2_BUCKET=your_bucket
   ```

5. **Database setup**
   ```bash
   php artisan migrate --seed
   ```

6. **Build assets**
   ```bash
   npm run dev
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

## 📚 Documentation

Detailed documentation is available in the `/docs` directory:
- [Setup Guide](docs/setup.md)
- [Architecture Overview](docs/architecture.md)
- [API Documentation](docs/api.md)
- [Contributing Guidelines](docs/contributing.md)

## 🧪 Testing
