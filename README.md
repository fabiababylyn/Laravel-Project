# Library Resource Management System (LRMS)

Laravel 12 + PHP 8.2+ + MySQL web application for a school library.

## Included modules
- Public landing page and searchable book catalog
- Student registration, login, logout, and role-based access
- Admin and librarian dashboard with database statistics
- Book CRUD with copy availability tracking
- Student/borrower management
- Borrowing transactions with date validation and copy locking
- Book return processing (automatically restores available copies)
- Automatic overdue status display based on due date
- Student borrowing history
- Date-filtered reports and popular-book summary
- Form validation and protected routes

## Requirements
- PHP 8.2 or newer
- Composer 2
- MySQL / MariaDB (XAMPP is fine)
- VS Code

## Installation in Windows / XAMPP
1. Extract this ZIP.
2. Open the extracted `LibraryResourceManagementSystem` folder in VS Code.
3. Start **Apache** and **MySQL** in XAMPP.
4. Open phpMyAdmin (`http://localhost/phpmyadmin`) and create a database named `library_resource_db` with `utf8mb4_unicode_ci` collation.
5. Open VS Code Terminal in the project folder and run:

   ```bash
   composer install
   ```

6. Copy `.env.example` to `.env`. In PowerShell:

   ```powershell
   Copy-Item .env.example .env
   ```

7. Confirm the database values in `.env`:

   ```env
   DB_DATABASE=library_resource_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

8. Run:

   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan serve
   ```

9. Open `http://127.0.0.1:8000`.

## Demo accounts (created by `migrate --seed`)
| Role | Email | Password |
|---|---|---|
| Admin | admin@library.test | Admin123! |
| Librarian | librarian@library.test | Librarian123! |
| Student | student@library.test | Student123! |

Change demo passwords before any real deployment. These are classroom demo credentials only.

## How to use
- Admin/Librarian: Dashboard → Books to add titles and copy counts.
- Admin/Librarian: Borrowers to create or maintain student borrower accounts.
- Admin/Librarian: Transactions → New Borrowing to issue a book.
- Admin/Librarian: Click **Mark Returned** to record a return and restore inventory.
- Admin/Librarian: Reports to view date-filtered transaction summaries.
- Student: Register or sign in, then use My Loans to see borrowing records.
- Anyone can view and search the public Book Catalog.

## Important project notes
- This ZIP contains the Laravel application source code and minimal Laravel configuration, not the Composer `vendor` folder. Run `composer install` after extraction.
- Laravel 12 is selected for compatibility with PHP 8.2+ and the requested Laravel 12/13 option.
- The proposal mentioned reCAPTCHA. It is not configured in this starter because it requires the group's Google reCAPTCHA site/secret keys and domain. The login, validation, session protection, and role middleware are included. Do not claim reCAPTCHA is active unless you configure and test it.
- For deployment, use a production database, HTTPS, `APP_DEBUG=false`, a strong unique `APP_KEY`, and change all demo passwords. Configure the host's document root to Laravel's `public` directory.
- This is a complete academic-project starter; test the full workflows on your own machine before submission. Online deployment depends on your hosting account and credentials.
