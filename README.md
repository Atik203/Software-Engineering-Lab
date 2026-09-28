# Software Engineering Lab

A structured collection of lab experiments, practice exercises, backend implementations, and automated testing suites for **Software Engineering Lab**.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Selenium](https://img.shields.io/badge/Selenium-43B02A?style=for-the-badge&logo=selenium&logoColor=white)
![Git](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white)

---

## Table of Contents

- [Overview](#overview)
- [Repository Structure](#repository-structure)
- [Modules & Contents](#modules--contents)
  - [1. Backend & Database (PHP & MySQL)](#1-backend--database-php--mysql)
  - [2. Automated Testing (Selenium)](#2-automated-testing-selenium)
  - [3. Version Control (Git Practices)](#3-version-control-git-practices)
- [Getting Started & Setup](#getting-started--setup)
  - [PHP & MySQL Setup (XAMPP)](#php--mysql-setup-xampp)
  - [Database Configuration & Port Settings](#database-configuration--port-settings)
  - [Selenium Testing Environment](#selenium-testing-environment)
- [How to Use the Dynamic CRUD Kit](#how-to-use-the-dynamic-crud-kit)
- [Lab Practices & Exam Preparation](#lab-practices--exam-preparation)
- [Author & License](#author--license)

---

## Overview

This repository contains academic laboratory coursework, practical implementations, and exam preparation resources for Software Engineering. It brings together three critical pillars of modern software engineering:

1. **Full-Stack Web Development & Data Persistence**: Building server-side dynamic web applications with PHP and relational database design with MySQL.
2. **Automated Quality Assurance & Software Testing**: Creating automated UI, functional, and regression test scripts using Selenium WebDriver.
3. **Version Control & Collaboration**: Hands-on Git workflows, repository management, branch merging, and conflict resolution.

---

## Repository Structure

```text
Software-Engineering-Lab/
│
├── README.md                  # Main repository documentation & guide
│
├── php/                       # PHP & MySQL lab implementations
│   ├── config.php             # Global database & dynamic table schema configuration
│   ├── db.php                 # MySQLi database connection handler
│   ├── crud.php               # Generic dynamic engine (Create, Read, Update, Delete)
│   ├── index.php              # Central dashboard listing all managed tables
│   ├── setup.php              # One-click browser setup script to create DB & tables
│   ├── database.sql           # SQL schemas, constraints, and seed data
│   ├── php.md                 # Comprehensive PHP quick-reference cheat sheet
│   ├── Git_Practice.md        # Complete Git lab practice tasks with verified solutions
│   └── practice/              # Lab manual & coursework task solutions
│       ├── index.php          # Practice module portal
│       ├── db.php             # Dedicated connection for coursework schema
│       ├── read_teachers.php  # Teacher records listing and search
│       ├── read_courses.php   # Course catalog listing
│       └── assign_teacher.php # Form and logic to assign instructors to courses
│
└── selenium/                  # Automated testing scripts & test cases
    └── (Test suites, WebDriver test scripts, test cases, and test reports)
```

---

## Modules & Contents

### 1. Backend & Database (PHP & MySQL)

The [`php/`](file:///d:/SE%20LAB/Software-Engineering-Lab/php) directory provides both a **reusable generic CRUD kit** and **specific lab manual coursework solutions**:

- **Dynamic CRUD Engine ([`crud.php`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/crud.php))**:
  - Handles `Create`, `Read`, `Update`, and `Delete` for **any** table without writing repetitive boilerplate code.
  - Automatically generates forms, input fields, search filters, and table views dynamically based on definitions in [`config.php`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/config.php).
  - Includes real-time keyword search (`LIKE %q%`).
- **Database Initialization**:
  - SQL dump file ([`database.sql`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/database.sql)) for importing via phpMyAdmin or MySQL CLI.
  - Pure PHP Web Installer ([`setup.php`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/setup.php)) to create the database and tables directly from code without phpMyAdmin.
- **Coursework Practice Tasks ([`php/practice/`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/practice))**:
  - Implementation of university lab questions (e.g., `Fall2025_CW`).
  - Read operations on teacher and course directories.
  - Relational mapping: Assigning teachers to designated courses with data validation.
- **Reference Cheatsheet ([`php/php.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/php.md))**:
  - Rapid reference guide covering PHP syntax, `mysqli_*` functions, superglobals (`$_POST`, `$_GET`, `$_SESSION`), sanitization, and SQL query syntax.

### 2. Automated Testing (Selenium)

The [`selenium/`](file:///d:/SE%20LAB/Software-Engineering-Lab/selenium) directory contains test automation suites and a dedicated **[Class Test (CT) Quick Reference Cheat Sheet](file:///d:/SE%20LAB/Software-Engineering-Lab/selenium/README.md)**:

- **Quick Reference Guide ([`selenium/README.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/selenium/README.md))**: Covers driver setup (Chrome/Edge), all 8 locator strategies, common exam traps (compound class names, attribute locators, Angular two-way binding vs form submission), dropdowns (`Select`), alerts/popups, and explicit waits.
- **Functional & UI Automation**: Writing scripts to automate browser interactions against web applications (such as student registration, login forms, and course management).
- **Element Locator Strategies**: Practice selecting DOM elements using `ID`, `Name`, `XPath`, `CSS Selector`, `Class Name`, and `Link Text`.
- **Form Automation & Validation**: Automating input typing, dropdown selection, radio button toggling, and button submission.
- **Assertions & Verification**: Validating page titles, expected text, alert popups, table rows, and database state updates post-submission.
- **Framework Integration**: Structuring test scripts with assertions and test runners (e.g., PyTest / unittest for Python, JUnit / TestNG for Java).

### 3. Version Control (Git Practices)

The [`Git_Practice.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/Git_Practice.md) file contains complete, step-by-step verified solutions to lab exam problems:

- Repository initialization (`git init`) and user configuration (`git config`).
- File staging, status checking, and atomic commits (`git add`, `git status`, `git commit`).
- Commit history navigation (`git log --oneline --graph`).
- Branching and merging workflows (`git branch`, `git checkout`, `git switch`, `git merge`).
- Merge conflict simulation and resolution.
- Undoing changes and working directory cleanup (`git restore`, `git reset`).

---

## Getting Started & Setup

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL / MariaDB + PHP)
- [Git](https://git-scm.com/)
- [Python 3.x](https://www.python.org/) or [Java JDK](https://www.oracle.com/java/) (for Selenium tests)
- Google Chrome / Mozilla Firefox and corresponding WebDrivers (or Selenium 4+ automated driver manager)

### PHP & MySQL Setup (XAMPP)

1. **Clone the repository**:
   ```bash
   git clone https://github.com/Atik203/Software-Engineering-Lab.git
   ```

2. **Deploy to web server**:
   Copy the `Software-Engineering-Lab` folder (or symlink it) to your XAMPP web root directory:
   ```text
   C:\xampp\htdocs\Software-Engineering-Lab
   ```
   *(or `G:\XAMPP\htdocs\Software-Engineering-Lab` depending on your XAMPP installation drive)*.

3. **Start services**:
   Open **XAMPP Control Panel** and start **Apache** and **MySQL**.

4. **Initialize Database**:
   - **Option A (Browser Setup)**: Open [`http://localhost/Software-Engineering-Lab/php/setup.php`](http://localhost/Software-Engineering-Lab/php/setup.php) and click **Create Database & Tables**.
   - **Option B (phpMyAdmin)**: Navigate to [`http://localhost/phpmyadmin`](http://localhost/phpmyadmin), create database or import [`php/database.sql`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/database.sql).

5. **Access Application**:
   - Dynamic CRUD Portal: [`http://localhost/Software-Engineering-Lab/php/index.php`](http://localhost/Software-Engineering-Lab/php/index.php)
   - Coursework Practice: [`http://localhost/Software-Engineering-Lab/php/practice/index.php`](http://localhost/Software-Engineering-Lab/php/practice/index.php)

### Database Configuration & Port Settings

Database credentials and port can be configured in [`php/config.php`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/config.php):

```php
$DB = [
    'host' => 'localhost',
    'port' => 3307,        // Default XAMPP port is 3306; adjust to 3307 if configured with an alternative port
    'user' => 'root',
    'pass' => '',
    'name' => 'SchoolMgmt', // Database name
];
```

> [!NOTE]
> If your local MySQL server runs on default port `3306`, update `'port' => 3306` in `config.php` and `practice/db.php`.

### Selenium Testing Environment

To run automated test scripts using Python:

1. **Install Selenium**:
   ```bash
   pip install selenium webdriver-manager
   ```

2. **Basic Test Execution Example**:
   ```python
   from selenium import webdriver
   from selenium.webdriver.common.by import By

   driver = webdriver.Chrome()
   driver.get("http://localhost/Software-Engineering-Lab/php/index.php")

   print("Page Title:", driver.title)
   assert "CRUD" in driver.title or len(driver.title) > 0

   driver.quit()
   ```

---

## How to Use the Dynamic CRUD Kit

The CRUD kit is designed to support **any** lab exam question with minimal modification:

1. **Define table schema in database**:
   Create the table via phpMyAdmin, SQL script, or `setup.php`.

2. **Register table in [`php/config.php`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/config.php)**:
   Add one line to the `$TABLES` array:
   ```php
   $TABLES = [
       'student' => ['id', 'dept', 'name', 'nid', 'birth', 'address'],
       'teacher' => ['id', 'dept', 'name', 'nid', 'birth', 'address'],
       'course'  => ['id', 'dept', 'title', 'credit', 'syllabus'],
       'payment' => ['payment_id', 'student_id', 'amount', 'date'],
       // Add new table: First column MUST be primary key
       'lab_exam' => ['exam_id', 'course_code', 'exam_date', 'total_marks'],
   ];
   ```

3. **Instant Functionality**:
   All 4 operations automatically become available on the home page:

   | Operation | Route | Description |
   | :--- | :--- | :--- |
   | **Create** | `crud.php?table=X&action=create` | Dynamically renders input fields and inserts record |
   | **Read** | `crud.php?table=X&action=read` | Displays tabular records with real-time keyword search |
   | **Update** | `crud.php?table=X&action=update&id=N` | Prefills existing data for editing |
   | **Delete** | `crud.php?table=X&action=delete&id=N` | Removes record with confirmation check |

---

## Lab Practices & Exam Preparation

| Topic | Relevant File / Guide | Key Concepts |
| :--- | :--- | :--- |
| **PHP & MySQL CRUD** | [`php/README.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/README.md) | Table registration, MySQLi queries, parameterized handlers |
| **PHP Exam Reference** | [`php/php.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/php.md) | Syntax cheat sheet, arrays, superglobals, form validation |
| **Git Command Line** | [`php/Git_Practice.md`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/Git_Practice.md) | Staging, committing, branching, merge conflict resolution |
| **Coursework Tasks** | [`php/practice/`](file:///d:/SE%20LAB/Software-Engineering-Lab/php/practice) | Relational queries, table joins, multi-step form handling |
| **Selenium Testing** | [`selenium/`](file:///d:/SE%20LAB/Software-Engineering-Lab/selenium) | Test automation, element locators, assertions, UI validation |

---

## Author & License

- **Repository**: [Software-Engineering-Lab](https://github.com/Atik203/Software-Engineering-Lab)
- **Author**: Atikur Rahaman
- **Purpose**: Academic coursework, laboratory exercises, and exam preparation.
