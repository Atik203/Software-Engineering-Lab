# CRUD Reusable Kit (XAMPP + PHP + MySQL)

A ready-to-use CRUD system you can bring to the class test and adapt to **any** question
the faculty asks. Add a table in one file and all 4 CRUD operations (Create, Read,
Update, Delete) appear on the home page automatically.

## What's in this folder

| File | Purpose |
|------|---------|
| `config.php` | **The only file you edit** - database name, port, and table columns |
| `db.php` | Connection (uses `config.php`) - never edit |
| `crud.php` | Generic engine: handles create / read / update / delete for ANY table |
| `index.php` | Home page: lists every table + links to its CRUD pages |
| `database.sql` | Creates the sample databases + tables + sample data |
| `setup.php` | Creates the database + tables **from PHP** (no phpMyAdmin) - reads `config.php` |
| `php.md` | PHP quick-reference cheat sheet for the exam |
| `practice/` | The exact lab-manual sample (Fall2025_CW: Read Teachers, Read Courses, Assign Teacher To Course) |

## Setup (5 minutes)

1. Copy this `crud` folder into `G:\XAMPP\htdocs\` (already done).
2. Open XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open <http://localhost/phpmyadmin> and click **Import** -> choose `database.sql` -> **Go**.
   (Or paste the SQL into the **SQL** tab - useful practice for the exam.)
4. Open `config.php` and check the settings:
   - `'name' => 'SchoolMgmt'` - change to your exam database name if different
   - `'port' => 3307` - **this PC** runs XAMPP MySQL on port **3307** (another MySQL
     uses 3306). On a default XAMPP install the port is **3306**.
5. Open <http://localhost/crud/>

## How to reuse for ANY question

Faculty says: _"Create a database with tables X, Y"_, then asks for
`createStudent / readStudent / updateStudent / deleteStudent` etc.

1. Create the table in phpMyAdmin (Import tab, or SQL tab).
2. In `config.php` add one line to `$TABLES`:
   ```php
   'student' => ['id', 'dept', 'name', 'nid', 'birth', 'address'],
   ```
   First column **must be the primary key**.
3. Refresh the home page - **Read** and **Create** links appear. Update and Delete
   appear next to each row in the Read page.

That's it. One file to touch, works for every table.

## Which API maps to which SQL

| API | Page | SQL used |
|-----|------|----------|
| Create | `crud.php?table=X&action=create` | `INSERT INTO X (cols) VALUES (...)` |
| Read (all) | `crud.php?table=X&action=read` | `SELECT * FROM X` |
| Read (filtered) | add `&q=keyword` (search box) | `SELECT * FROM X WHERE col LIKE '%q%'` |
| Update | `crud.php?table=X&action=update&id=N` | `UPDATE X SET ... WHERE pk = N` |
| Delete | `crud.php?table=X&action=delete&id=N` | `DELETE FROM X WHERE pk = N` |

## Notes for the exam

- Tables are whitelisted in `config.php`, so there is no SQL injection risk even
  though values are escaped with `mysqli_real_escape_string`.
- The practice sample (`practice/`) uses its own `db.php` pointing to the
  `Fall2025_CW` database, with the port set to 3307 for this PC.
- If the exam PC has a fresh XAMPP, MySQL is on port **3306** - change it in
  `config.php` (and `practice/db.php`).
- Typical XAMPP root user: username `root`, password empty.
