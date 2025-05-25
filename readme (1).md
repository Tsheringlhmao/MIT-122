# Daily Expense Tracker - Installation Manual

## Project Description

The Daily Expense Tracker is a browser-based financial management application designed to help users manage their day-to-day expenses and lending activities. Developed using PHP, MySQL, HTML5, CSS3, JavaScript, and Bootstrap, it includes features such as user authentication, dashboard summaries, interactive financial analytics, and exportable PDF/CSV reporting. The system is secure, mobile-responsive, and suitable for both academic and personal finance tracking.

---

## System Requirements

* PHP 7.4 or higher
* MySQL 5.7 or higher
* Apache web server (e.g., XAMPP, WAMP, MAMP, or LAMP stack)
* Compatible browser (Chrome, Firefox, Edge, Safari)
* FPDF Library for PDF export functionality

---

## Folder Structure

```
/daily_expense_tracker
├── auth/               # Login, signup, logout pages
├── config/             # Database connection
├── includes/           # Reusable header and footer files
├── pages/              # Dashboard, expense, lending, report, analytics
├── scripts/            # Data processors and handlers
├── assets/
│   ├── css/            # Stylesheets
│   ├── images/         # Icons and logo
│   └── js/             # JavaScript files
├── libs/               # FPDF library
├── sql/                # Database schema file
├── faq.php             # FAQ page
├── terms.php           # Terms and Conditions
├── privacy.php         # Privacy Policy
└── index.php           # Login entry point
```

---

## Installation Steps

### Step 1: Install Local Server

Install a local server environment such as XAMPP, WAMP, or MAMP. Launch Apache and MySQL services from the control panel.

### Step 2: Place Project in Web Root

Copy the `daily_expense_tracker` folder into your web server root directory:

* For XAMPP on Windows: `C:/xampp/htdocs/`
* For MAMP on macOS: `/Applications/MAMP/htdocs/`

### Step 3: Create the Database

1. Open your browser and go to: `http://localhost/phpmyadmin`
2. Click on **New** and create a database named `expense_tracker_db`
3. Import the SQL schema file located at `sql/expense_tracker_db.sql`
4. Click **Go** to execute the import

### Step 4: Configure Database Connection

Open `config/db_connect.php` and update the database credentials as required:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'expense_tracker_db');
define('DB_USER', 'root'); // Or your database username
define('DB_PASS', '');     // Or your database password
```

### Step 5: Install FPDF Library

Download the FPDF library from [http://www.fpdf.org](http://www.fpdf.org) and place the `fpdf.php` file into the `scripts/libs/` directory.

### Step 6: Launch the Application

In your browser, navigate to:

```
http://localhost/daily_expense_tracker/
```

You can now register a new user account and begin using the system.

---

## Optional Demo User

If your database was seeded with a test account, you may log in using:

* Email: [demo@tracker.com](mailto:demo@tracker.com)
* Password: demo123

Otherwise, use the Sign Up page to create a new account.

---

## Notes

* Ensure Apache and MySQL services are running before use.
* The application is session-based and restricts unauthenticated access.
* Reports can be generated in PDF (via FPDF) or CSV formats.
* Compatible across mobile, tablet, and desktop devices with a responsive layout.

For assistance, contact your instructor or the project maintainer.
