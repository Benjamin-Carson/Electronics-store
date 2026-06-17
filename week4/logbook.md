# Week 4 - ElectroMart: User Management & Reports

## Student: [Your Name]

---

### Activities Carried Out

1. **User Registration System** — Created `register.php` with form validation:
   - Empty field check
   - Email format validation (`FILTER_VALIDATE_EMAIL`)
   - Password minimum length (6 chars)
   - Duplicate username/email check
   - Password hashing with `password_hash()` before storage

2. **Login System** — Updated `login.php` with:
   - Prepared statements to prevent SQL injection
   - Empty field validation on submit
   - `password_verify()` for secure password comparison
   - Session creation on success

3. **User Management** — Created `users.php` (admin-only):
   - Search by username
   - Role badges (Admin/User)
   - Edit and Delete user links

4. **Reports Page** — Created `reports.php` with metrics:
   - Total products count
   - Top brand
   - Total revenue (price × stock)
   - Top rated product
   - Low stock alerts
   - Category breakdown

5. **Password Reset** — Added `reset_password.php` and `new_password.php`:
   - Email reset flow with token
   - Phone OTP flow
   - Prepared statement updates

6. **Hash Generator** — `hash.php` for generating bcrypt hashes

---

### Validation Implemented

- **Login**: Empty field check, user existence check, password verification
- **Register**: Empty fields, email format, password length, duplicate user/email
- **All forms**: HTML5 `required` attribute on input fields
- **SQL Injection**: Prepared statements used throughout

---

### Database Connection

File: `db_connect.php`
- Host: localhost
- Database: electronics
- User: root
- Password: (empty)
- Method: MySQLi procedural

---

### Challenges Faced

- Password hashing mismatch between plaintext and bcrypt — resolved by using `password_verify()` consistently
- Foreign key constraints on delete — used `ON DELETE CASCADE`

---

### Folder Structure

```
week4/
├── add_product.php
├── dashboard.php
├── db_connect.php
├── delete_product.php
├── edit_product.php
├── hash.php
├── improved_products.php
├── index.php
├── login.php
├── logout.php
├── new_password.php
├── products.php
├── register.php
├── reports.php
├── reset_password.php
├── sidebar.php
├── users.php
└── screenshots/
    ├── login_form.png
    ├── form_validation.png
    ├── php_processing.png
    ├── folder_structure.png
    ├── db_connection.png
    └── code_snippets.png
```

---

### GitHub Commits

```
Week 4 - Initial commit: User management, reports, password reset
```

### Screenshots to Capture

1. `login_form.png` — Login page with username/password fields
2. `form_validation.png` — Error messages shown (empty fields, invalid password)
3. `php_processing.png` — Browser showing successful registration or login
4. `folder_structure.png` — File explorer showing week4 folder contents
5. `db_connection.png` — phpMyAdmin showing `electronics` database tables
6. `code_snippets.png` — VS Code showing login.php or register.php code
