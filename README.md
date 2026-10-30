# 📚 BookSaw — Bookstore Management System

A database-driven bookstore web application developed using **PHP, MySQL, Bootstrap 5, HTML5, and CSS3**. This project demonstrates backend development, database integration, CRUD operations, and responsive web design.

![PHP](https://img.shields.io/badge/PHP-Backend-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.1-7952B3?logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-Markup-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-Styling-1572B6?logo=css3&logoColor=white)

## 📌 Table of Contents

- [Project Overview](#-project-overview)
- [Features](#-features)
- [Technology Stack](#-technology-stack)
- [Project Architecture](#-project-architecture)
- [Project Structure](#-project-structure)
- [Installation and Setup](#-installation-and-setup)
- [How to Use](#-how-to-use)
- [Database Structure](#-database-structure)
- [Project Links](#-project-links)
- [Screenshots](#-screenshots)
- [Challenges and Solutions](#-challenges-and-solutions)
- [Skills Demonstrated](#-skills-demonstrated)
- [Future Improvements](#-future-improvements)
- [Contributing](#-contributing)
- [License](#-license)

## 🎯 Project Overview

**BookSaw** is a PHP-based bookstore web application designed to demonstrate practical web development and database management skills.

The application connects to a MySQL database named `book` to store and retrieve bookstore information. PHP handles server-side processing, while Bootstrap and custom CSS provide the user interface.

The project includes book browsing, category management, book administration, and customer feedback functionality.

### Project Objectives

- Develop a database-driven web application.
- Implement CRUD operations using PHP and MySQL.
- Display book information dynamically.
- Organize books by category.
- Create responsive and user-friendly web pages.
- Practice debugging and database management.

## ✨ Features

### Customer-Facing Features

- **Book Catalog:** Display books retrieved from the database.
- **Category Filtering:** Browse books by category.
- **Book Information:** Display book names, descriptions, prices, and images.
- **About Page:** Present bookstore information.
- **Contact Page:** Collect customer messages through a contact form.

### Administrative Features

- **Category Management:** Add, view, and edit book categories.
- **Book Management:** Add and edit book records, including descriptions, prices, categories, and images.
- **Feedback Management:** View and delete customer feedback records.
- **Database Integration:** Perform database operations using PHP and MySQLi.
- **Form Processing:** Handle form submissions through PHP.

*Note: Ensure that each feature listed above is implemented and working in your current version.*

## 🛠️ Technology Stack

| Technology | Purpose |
|---|---|
| PHP | Backend development and server-side processing |
| MySQL | Relational database management |
| MySQLi | PHP database connectivity |
| HTML5 | Web page structure |
| CSS3 | Styling and layouts |
| Bootstrap 5.3.1 | Responsive UI components |
| JavaScript | Client-side interactions where implemented |
| XAMPP | Local development environment |
| Git and GitHub | Version control and source code hosting |

## 🏗️ Project Architecture

```text
              User / Administrator
                       |
                       v
                  Web Browser
              HTML + CSS + Bootstrap
                       |
                       v
                   PHP Backend
              Forms and Application Logic
                       |
                       v
                MySQL Database
                 Database: book
                       |
             +---------+---------+
             |         |         |
             v         v         v
           book    categories   contact
             |         |         |
             +---------+---------+
                       |
                       v
                Dynamic HTML Output
                       |
                       v
                  Web Browser
```

### Application Workflow

1. The user opens a page in the browser.
2. PHP executes the requested page.
3. The application retrieves or updates data through MySQLi.
4. MySQL processes the database query.
5. PHP generates the page content.
6. The browser displays the result.

## 📁 Project Structure

The following is a representative structure. Ensure the filenames match your actual repository.


BookSaw/
├── index.php
├── books.php
├── about.php
├── contactus.php
├── login.php
├── connected.php
├── category.php
├── add_category.php
├── edit_category.php
├── add_book.php
├── edit_book.php
├── feedback.php
├── css/
│   ├── normalize.css
│   ├── vendor.css
│   └── style.css
├── icomoon/
├── images/
├── js/
├── screenshots/
│   ├── books.jpg
│   ├── home.png
│   ├── categories.png
│   └── book-management.png
├── database.sql
└── README.md
```

## ⚙️ Installation and Setup

### Prerequisites

- XAMPP
- A modern web browser
- Git (optional)

### Step 1: Clone the Repository

Run this command in your terminal:

```bash
git clone https://github.com/DiyuBhimani/-BookSaw-PHP-Project-.git
```

Alternatively, open the repository on GitHub and select **Code → Download ZIP**.

### Step 2: Move the Project to XAMPP

Extract the project into:

```text
C:\xampp\htdocs\BookSaw
```

Ensure that the PHP files and asset folders are inside the project directory.

### Step 3: Start XAMPP

1. Open the XAMPP Control Panel.
2. Start Apache.
3. Start MySQL.

### Step 4: Set Up the Database

1. Open [phpMyAdmin](http://localhost/phpmyadmin).
2. Create a database named `book`.
3. Select the `book` database.
4. Import `database.sql` if it is included in the repository.
5. Confirm that the required tables exist.

Expected table names:

- `book`
- `categories`
- `contact`

If you already have these tables, do not create duplicate tables.

### Step 5: Configure the Database Connection

Open `connected.php` and verify the connection settings.

Example for a default local XAMPP setup:


<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "book"
);

if ($conn->connect_error) {
    error_log("Database connection failed.");
    exit("Unable to connect to the database.");
}

$conn->set_charset("utf8mb4");

?>
```

**Important:** Your existing PHP pages must use the same connection variable. If your project uses `$con` instead of `$conn`, retain the variable name expected by your code.

The empty password is only an example for a default local XAMPP installation. Never publish production credentials in your GitHub repository.

### Step 6: Run the Application

Open the following URL in your browser:

```text
http://localhost/BookSaw/
```

To open the Books page directly:

```text
http://localhost/BookSaw/books.php
```

The application should now run locally on your computer.

## 🚀 How to Use

### Browse Books

1. Open the home page.
2. Navigate to the Books page.
3. View the available book listings.
4. Select a category to filter books.

### Manage Categories

1. Open the category management page.
2. Add a category.
3. Edit an existing category.
4. Verify the changes.

### Manage Books

1. Open the book management page.
2. Enter the book name, description, price, and category.
3. Upload an image if supported.
4. Save the record and verify the result.

### Manage Feedback

1. Open the contact page.
2. Submit a test message.
3. Verify that the message is stored in the database.
4. View or delete the record through the feedback management page, if implemented.

## 🗄️ Database Structure

**Database name: `book`**

| Table | Description |
|---|---|
| `book` | Stores book information, including names, prices, images, and category identifiers |
| `categories` | Stores book categories |
| `contact` | Stores customer contact or feedback messages |

### Database Relationship

```text
categories
    |
    | One category can contain multiple books
    |
    +----------< book

contact
    |
    +------------ Customer messages
```

The `c_id` field in the `book` table associates a book with a category in the `categories` table. The exact columns and constraints depend on your database schema.

## 🔗 Project Links

- **GitHub Repository:** [View BookSaw Source Code](https://github.com/DiyuBhimani/-BookSaw-PHP-Project-)
- **Screenshots:** Browse the [`screenshots`](screenshots/) folder.
- **Local Application:** Run the project using XAMPP by following the installation instructions above.

**Live Demo:** Not currently available. The project runs locally using XAMPP.

## 📸 Screenshots

Screenshots showcase the actual application interface while running locally.

### Books Page

![BookSaw Books Page](screenshots/books.jpg)

### Home Page

![BookSaw Home Page](screenshots/home.png)

### Category Management

![BookSaw Category Management](screenshots/categories.png)

### Book Management

![BookSaw Book Management](screenshots/book-management.png)

**Note:** Upload the actual screenshot files to the `screenshots/` directory in your repository. Ensure the filenames and extensions match the Markdown image paths exactly.

## 🧩 Challenges and Solutions

The following are relevant development areas. Keep the descriptions that accurately reflect your work.

| Challenge | Approach |
|---|---|
| PHP and MySQL connectivity | Configured a MySQLi connection to the `book` database |
| Dynamic book listings | Retrieved database records and displayed them using PHP |
| Category organization | Used category identifiers to associate books with categories |
| Form handling | Processed form submissions through PHP |
| Image management | Used image paths and upload handling where implemented |
| Consistent styling | Combined Bootstrap components with custom CSS |
| Local development | Used XAMPP to run PHP and MySQL locally |

### Recommended Security Practices

- Use prepared statements for queries involving user input.
- Validate form data on the server.
- Escape HTML output where appropriate.
- Validate uploaded image types and sizes.
- Protect administrative pages with authentication and authorization.
- Keep private credentials out of GitHub.

## 💡 Skills Demonstrated

- **Backend Development:** PHP, server-side scripting, CRUD operations, and form processing.
- **Database Management:** MySQL, SQL queries, MySQLi connectivity, and relational data.
- **Frontend Development:** HTML5, CSS3, Bootstrap 5, and responsive layouts.
- **Problem Solving:** Debugging, troubleshooting, and frontend-backend integration.
- **Development Tools:** XAMPP, Git, GitHub, and browser testing.
- **Documentation:** Markdown, setup instructions, and project organization.

## 🔮 Future Improvements

- Add secure login and role-based access control.
- Implement book search, sorting, and pagination.
- Use prepared statements consistently.
- Improve image upload validation and error handling.
- Add automated tests for important workflows.
- Introduce shopping cart and order management functionality.
- Improve accessibility and mobile responsiveness.
- Deploy the application to a PHP/MySQL hosting service.
- Add an entity-relationship diagram and sample database export.

## 🤝 Contributing

Suggestions and improvements are welcome.

1. Fork the repository.
2. Create a feature branch:

   ```bash
   git checkout -b feature/your-feature
   ```

3. Implement and test your changes.
4. Commit your changes:

   ```bash
   git add .
   git commit -m "Describe your changes"
   ```

5. Push your branch and open a pull request.

Please do not commit passwords, private information, or unrelated files.

## 📄 License

No license has been specified for this project yet.

If you plan to publish the project as open source, choose an appropriate license and add a `LICENSE` file. The MIT License is one common option for projects that permit broad reuse under its terms.

Until a license is added, do not assume that others have permission to reuse or redistribute the code.

---

## 👩‍💻 Project Summary

- **Project Name:** BookSaw — Bookstore Management System
- **Project Type:** PHP and MySQL web application
- **Database:** `book`
- **Backend:** PHP and MySQLi
- **Frontend:** HTML5, CSS3, Bootstrap 5
- **Development Environment:** XAMPP
- **Repository:** [DiyuBhimani / BookSaw PHP Project](https://github.com/DiyuBhimani/-BookSaw-PHP-Project-)

This project demonstrates practical experience in web development, database integration, CRUD operations, responsive UI design, and application troubleshooting.
