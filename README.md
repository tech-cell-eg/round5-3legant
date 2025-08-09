<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 3legant - E-Commerce Furniture Store Backend

## Overview
This project is a backend system for an e-commerce furniture store, developed using **Laravel** to provide API endpoints for a mobile application. The system includes features such as user authentication, profile management, product browsing, search, shopping cart, checkout, and an admin dashboard. The development tasks are distributed among four trainees—Ahmed, Abanoub, Hisham, and Maryam—each responsible for specific endpoints based on their skill levels.

## Objective
To build a robust and secure API that supports a mobile application for browsing and purchasing furniture, managing user accounts, and administering the system via a dedicated dashboard.

## Task Distribution
The tasks are assigned to the trainees based on their expertise and the complexity of the endpoints:

### **Ahmed** 
- **Authentication**:
    - User registration with email verification.
    - Login with access token generation.
    - Password reset using a verification code.
    - Logout with token invalidation.
- **Admin Dashboard**:
    - Product management (create, update, delete).
    - Category management (create, update, delete).

### **Abanoub** 
- **Shop Page**:
    - Display products with pagination.
    - Sort products (e.g., by price, newest).
    - Filter products by categories or price range.
- **Search**:
    - Search products using keywords.
- **Admin Dashboard**:
    - Order management (view, update status).
    - User management (view, update, delete).

### **Hisham** 
- **Home Page**:
    - Display categories.
    - Show new arrivals.
    - List additional products (More Products).
    - Showcase shop collections.
    - Highlight best-selling products.
- **Blog**:
    - List blog articles with pagination.
    - Display details of a specific article.

### **Maryam** 
- **User Profile**:
    - Update user profile information.
    - Add, edit, or delete addresses.
- **Wishlist**:
    - Display wishlist items.
    - Add or remove products from the wishlist.
- **Order History**:
    - Display user order history with pagination.

### **Shared Tasks (To Be Assigned Later)**
- **Shopping Cart**:
    - Add/remove products, update quantities, apply discount coupons.
- **Product Details**:
    - Display product details and related products (You Might Also Like).
- **Checkout**:
    - Process checkout, referencing the Figma design for details.

## Technologies Used
- **Backend**: Laravel (PHP) for API development.
- **Database**: MySQL (or any Laravel-compatible database).
- **Authentication**: Laravel Sanctum or JWT for token management.
- **Email Service**: Mailgun or similar for sending verification emails.
- **Storage**: Laravel Storage for handling product image uploads.

## Development Requirements
1. **Environment**:
    - PHP >= 8.0
    - Composer
    - Laravel >= 9.x
    - MySQL or compatible database
2. **Setup Instructions**:
    - Clone the repository: `git clone https://github.com/tech-cell-eg/round5-3legant.git`
    - Configure the `.env` file and set up the database.
    - Run migrations: `php artisan migrate`
    - Start the server: `php artisan serve`


## Guidelines
- **Priorities**: Start with Authentication and Home Page endpoints, as they are foundational.
- **Security**: Secure all endpoints with appropriate middleware, especially for admin-related functionality.
- **Code Review**: Ahmed and Abanoub are responsible for reviewing Hisham and Maryam’s code.
- **Communication**: Conduct daily stand-up meetings to track progress.
- **Design Reference**: Consult the Figma file to ensure API compatibility with the frontend design.

