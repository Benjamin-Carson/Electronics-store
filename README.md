# ElectroMart - Electronics Store Management System

## Overview

ElectroMart is a comprehensive, full-stack e-commerce web application developed iteratively over 7 weeks. The platform provides complete functionality for managing an online electronics store, including user authentication, product management, order processing, and administrative analytics. This project demonstrates professional software development practices with emphasis on security, scalability, and user experience.

---

## Technologies and Languages Used

### Backend Development
- PHP 7.x / 8.x - Server-side programming and logic
- MySQL - Relational database management system
- SQL - Database queries and schema management

### Frontend Development
- HTML5 - Semantic markup and structure
- CSS3 - Responsive design with modern styling (glassmorphism effects)
- Vanilla JavaScript - Client-side interactivity

### Server and Infrastructure
- Apache - Web server (via XAMPP)
- XAMPP - Local development environment

### Development Practices
- GIT - Version control and source management
- MVC Architecture - Organized codebase structure
- Prepared Statements - SQL security implementation
- Password Hashing - Bcrypt algorithm for security

---

## Development Timeline and Features

### Week 1: Foundation and Database Setup
**Objectives:** Establish core infrastructure and database structure

**Features Implemented:**
- Database schema design with 4 primary tables (users, products, orders, order_items)
- Initial database connectivity layer (db_connect.php)
- Basic product listing page with data retrieval
- Static dashboard interface
- HTML5/CSS3 styling foundation

**Technologies:** PHP, MySQL, HTML5, CSS3, SQL

**Key Files:**
- db_connect.php - Database connection handler
- products.php - Product listing and display
- index.php - Application entry point
- Week1db.sql - Initial database schema

---

### Week 2: Authentication and Dashboard
**Objectives:** Implement user authentication and create dashboard interface

**Features Implemented:**
- Secure login system with form validation
- Session management for authenticated users
- Dashboard with key metrics display
- Sidebar navigation menu
- User interface refinement with glassmorphism effects
- Responsive layout design

**Technologies:** PHP, MySQL, HTML5, CSS3, Session Management

**Key Files:**
- login.php - Authentication logic
- dashboard.php - Dashboard interface
- sidebar.php - Navigation component
- style.css - Professional UI styling

---

### Week 3: User Registration and Role Management
**Objectives:** Expand user management and implement role-based access

**Features Implemented:**
- User registration with comprehensive validation
- Email format validation and duplicate checking
- Password strength requirements (minimum 6 characters)
- User logout functionality
- Role-based system setup (Admin/User roles)
- Product management interface for admin users
- Edit and delete product operations (admin-only)

**Technologies:** PHP, MySQL, HTML5, CSS3, Form Validation

**Key Files:**
- register.php - User registration and validation
- logout.php - Session termination
- edit_product.php - Product editing interface
- delete_product.php - Product deletion handler
- improved_products.php - Enhanced product management

---

### Week 4: Security Enhancement and Reporting
**Objectives:** Strengthen security measures and implement business analytics

**Features Implemented:**
- Password hashing using bcrypt algorithm
- Password reset functionality with email verification
- OTP-based account recovery system
- Admin reports page with analytics (total products, revenue calculations, top-rated products, low stock alerts, category breakdown)
- Advanced user management interface
- Password reset token system
- New password creation interface

**Technologies:** PHP, MySQL, Bcrypt Hashing, HTML5, CSS3

**Key Files:**
- hash.php - Password hashing utility
- reset_password.php - Password reset request handler
- new_password.php - New password creation
- reports.php - Business analytics dashboard
- users.php - User management interface
- logbook.md - Development documentation

---

### Week 5: Advanced Administration
**Objectives:** Enhance administrative capabilities and search functionality

**Features Implemented:**
- Comprehensive user management system (edit user details, delete accounts, role assignment)
- Advanced product search with filtering
- Permission validation system (role_check.php)
- Search product functionality
- Dashboard improvements
- User listing with role badges
- Admin-only access control implementation

**Technologies:** PHP, MySQL, Form Validation, HTML5, CSS3

**Key Files:**
- edit_user.php - User profile editing
- delete_user.php - User account deletion
- search_products.php - Product search engine
- role_check.php - Permission validation middleware
- users.php - User management dashboard
- style.css - Enhanced styling

---

### Week 6: E-Commerce and Ratings System
**Objectives:** Implement complete e-commerce functionality with customer feedback

**Features Implemented:**
- Order management system (order creation, tracking, status management)
- Product ratings and reviews system
- Enhanced search with advanced filters
- Order details viewing
- Customer purchase history
- Product rating display on listings
- Order summary and totals calculation

**Technologies:** PHP, MySQL, HTML5, CSS3, SQL Aggregation

**Key Files:**
- orders.php - Order management interface
- ratings.php - Rating and review system
- search_products.php - Advanced search functionality
- week6_schema.sql - Database schema updates
- style.css - UI refinements

---

### Week 7: Complete Platform and Final Optimization
**Objectives:** Complete the full-featured e-commerce platform with all features integrated

**Features Implemented:**
- Fully integrated order workflow
- Complete ratings and review system
- Comprehensive search and filtering
- Complete admin dashboard with all metrics
- User-friendly interface improvements
- Full CRUD operations across all modules
- Optimized database queries
- Complete user authentication flow

**Additional Enhancements:**
- Improved error handling
- Better form validation messages
- Enhanced responsive design
- Optimized database performance
- Complete documentation

**Technologies:** PHP, MySQL, HTML5, CSS3, JavaScript, SQL

**Key Files:**
- orders.php - Complete order system
- products.php - Full product management
- ratings.php - Review system
- search_products.php - Search engine
- reports.php - Analytics dashboard
- users.php - User management
- dashboard.php - Main dashboard
- week7_schema.sql - Final schema updates

---

## Database Architecture

### Core Tables

**users**
- id (Primary Key)
- username (Unique)
- email (Unique)
- password (Hashed with bcrypt)
- role (ENUM: admin, user)
- phone
- created_at (Timestamp)

**products**
- id (Primary Key)
- name
- brand
- category
- price (Decimal)
- stock (Inventory)
- rating (Average rating)

**orders**
- id (Primary Key)
- user_id (Foreign Key)
- order_date
- total_amount
- status (pending, completed, cancelled)

**order_items**
- id (Primary Key)
- order_id (Foreign Key)
- product_id (Foreign Key)
- quantity
- price

**ratings**
- id (Primary Key)
- product_id (Foreign Key)
- user_id (Foreign Key)
- rating_value
- review_text
- created_at

---

## Project Structure

```
electronics-store/
├── database_schema.sql          # Main database schema
├── README.md                     # Project documentation
├── .gitignore                    # Git ignore rules
│
├── week1/                        # Week 1: Foundation
│   ├── index.php
│   ├── db_connect.php
│   ├── products.php
│   ├── Week1db.sql
│   └── screenshots/
│
├── week2/                        # Week 2: Authentication
│   ├── index.php
│   ├── login.php
│   ├── dashboard.php
│   ├── sidebar.php
│   ├── products.php
│   ├── db_connect.php
│   ├── style.css
│   └── screenshots/
│
├── week3/                        # Week 3: User Registration
│   ├── register.php
│   ├── logout.php
│   ├── edit_product.php
│   ├── delete_product.php
│   ├── improved_products.php
│   ├── reports.php
│   └── screenshots/
│
├── week4/                        # Week 4: Security and Reporting
│   ├── hash.php
│   ├── reset_password.php
│   ├── new_password.php
│   ├── users.php
│   ├── reports.php
│   ├── logbook.md
│   └── screenshots/
│
├── week5/                        # Week 5: Advanced Admin
│   ├── edit_user.php
│   ├── delete_user.php
│   ├── search_products.php
│   ├── role_check.php
│   ├── users.php
│   └── screenshots/
│
├── week6/                        # Week 6: E-Commerce
│   ├── orders.php
│   ├── ratings.php
│   ├── search_products.php
│   ├── week6_schema.sql
│   └── screenshots/
│
└── week7/                        # Week 7: Complete Platform
    ├── orders.php
    ├── ratings.php
    ├── search_products.php
    ├── reports.php
    ├── users.php
    ├── week6_schema.sql
    ├── week7_schema.sql
    └── screenshots/
```

---

## Installation and Setup

### Prerequisites

- XAMPP (or equivalent PHP/MySQL environment)
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Edge, Safari)
- Git (for version control)

### Step-by-Step Installation

1. Clone the Repository
   ```bash
   git clone https://github.com/Benjamin-Carson/Electronics-store.git
   cd electronics-store
   ```

2. Place in XAMPP Directory
   ```bash
   Copy the folder to: C:\xampp\htdocs\
   ```

3. Import Database Schema
   ```bash
   mysql -u root -p < database_schema.sql
   ```

4. Update Database Credentials (if needed)
   - Edit db_connect.php in each week folder
   - Update host, user, password, and database name

5. Start Services
   - Start Apache and MySQL from XAMPP Control Panel
   - Navigate to: http://localhost/electronics-store/week7/

6. Access the Application
   - Initial login or create new account
   - Admin account for testing (if applicable)

---

## Core Features and Functionality

### Authentication and Security
- Secure user login with session management
- User registration with email validation
- Password hashing using bcrypt algorithm
- Password reset with token verification
- OTP-based account recovery
- Role-based access control (RBAC)
- SQL injection prevention via prepared statements

### Product Management
- Browse electronics catalog
- Search products by name, brand, or category
- View product details and specifications
- Product ratings and customer reviews
- Inventory tracking and stock management
- Admin product CRUD operations
- Category-wise product organization

### Order Processing
- Shopping cart functionality
- Order creation and confirmation
- Order history tracking
- Order status management
- Order totals calculation
- Invoice generation capability

### Admin Dashboard
- Business analytics and reporting
- Revenue calculations
- Top-selling products identification
- Low stock alerts
- User management interface
- Customer analytics
- Category performance analysis

### User Management
- User profile management
- Role assignment (Admin/User)
- User account deletion
- User listing and filtering
- Permission verification

---

## Security Implementation

### Password Security
- Bcrypt hashing algorithm for password storage
- Minimum password length requirements
- Password reset with token-based verification
- Secure password comparison using PHP functions

### Database Security
- Prepared statements to prevent SQL injection
- Input validation and sanitization
- SQL error handling and logging

### Session Security
- Session-based user authentication
- Automatic session timeout
- Role-based permission checks
- CSRF protection considerations

### Access Control
- Role-based authorization checks
- Admin-only page restrictions
- User permission validation
- Login requirement enforcement

---

## Usage Guide

### For Regular Users

1. Registration
   - Navigate to registration page
   - Enter username, email, password
   - Submit to create account

2. Login
   - Enter credentials
   - Click login button
   - Access dashboard upon success

3. Shopping
   - Browse products from dashboard
   - Use search to find specific items
   - View product ratings and reviews
   - Place orders

4. Account Management
   - View profile information
   - Update account details
   - View order history
   - Leave product ratings

### For Admin Users

1. User Management
   - View all registered users
   - Edit user roles
   - Delete user accounts
   - Search users

2. Product Management
   - Add new products
   - Edit product information
   - Delete obsolete products
   - Monitor inventory levels

3. Order Management
   - View all orders
   - Update order status
   - Process order fulfillment
   - Generate order reports

4. Analytics
   - View sales reports
   - Analyze revenue metrics
   - Identify top products
   - Monitor inventory levels
   - Track user growth

---

## Development Best Practices Implemented

- Model-View-Controller (MVC) architecture principles
- DRY (Don't Repeat Yourself) code methodology
- Proper separation of concerns
- Consistent naming conventions
- Comprehensive error handling
- Input validation on all forms
- Secure password management
- Database indexing optimization
- Prepared statement usage throughout
- Code comments and documentation

---

## Performance Optimization

- Efficient database queries
- Indexed database fields
- Optimized CSS with backdrop filters
- Minimal asset loading
- Proper error handling to prevent crashes
- Database connection pooling potential
- Query result caching opportunity

---

## Future Enhancement Possibilities

- Payment gateway integration (Stripe, PayPal)
- Email notification system
- Advanced analytics with charts
- Inventory management automation
- Customer loyalty program
- Mobile app development
- API development for third-party integration
- Automated backup system
- Real-time order tracking
- Customer support ticket system

---

## File Manifest

### Root Level
- README.md - This documentation file
- database_schema.sql - Main database schema
- .gitignore - Git configuration file

### Common Files (All Weeks)
- index.php - Application entry point
- db_connect.php - Database connection handler
- login.php - User authentication
- dashboard.php - Main dashboard interface
- sidebar.php - Navigation menu
- style.css - CSS styling
- logout.php - Session termination

### Special Files
- hash.php (Week 4+) - Password hashing utility
- role_check.php (Week 5+) - Permission validation
- search_products.php (Week 5+) - Search functionality
- register.php (Week 3+) - User registration
- users.php (Week 4+) - User management
- reports.php (Week 4+) - Analytics dashboard
- orders.php (Week 6+) - Order management
- ratings.php (Week 6+) - Review system

---

## Screenshots and Documentation

Each week folder includes a screenshots directory containing:
- User interface demonstrations
- Feature workflows
- Dashboard views
- Form interfaces
- Data management screens

---

## Version History

- Week 1 - Database and basic structure
- Week 2 - Authentication system
- Week 3 - User registration and roles
- Week 4 - Security and analytics
- Week 5 - Advanced administration
- Week 6 - E-commerce features
- Week 7 - Complete platform release

---

## Author and Credit

**Developer:** Benjamin Carson

**Project Type:** Full-stack E-Commerce Application

**Duration:** 7-week iterative development cycle

**Status:** Production Ready

---

## License

Private Project - All Rights Reserved

---

## Support and Contact

For questions, issues, or contributions, please contact the development team or create an issue in the GitHub repository.

---

## Acknowledgments

This project demonstrates comprehensive web development practices including:
- Database design and optimization
- Secure authentication mechanisms
- Modern UI/UX principles
- Business logic implementation
- Admin functionality
- E-commerce best practices

---

**Last Updated:** June 2026

**Repository:** https://github.com/Benjamin-Carson/Electronics-store