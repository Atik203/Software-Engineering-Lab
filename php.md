# PHP Quick Reference (CT Cheat Sheet)

Everything you need to remember for the class test. If you know JavaScript, the
comparison table at the bottom is your fastest path back.

---

## 1. How PHP works

- PHP runs on the **server**, before the page is sent to the browser.
- The browser sends a **request** (page load, form submit, link click) -> PHP runs
  top to bottom -> prints HTML -> browser shows it.
- One request = one run. No "events" like JS; the request itself is the event.
- Files: a `.php` file is just HTML with `<?php ... ?>` blocks inside.

## 2. Tags and output

```php
<?php
echo "Hello";          // prints text
echo "Hello" . " " . "World";  // concat with dot
print "hi";            // same as echo (rarely used)
?>
<p>HTML is outside PHP tags</p>
<?= $x ?>              // SHORT FORM of echo $x; (very common)
```

Comments:
```php
// single line
# single line (same)
/* multi
   line */
```

## 3. Variables and types

- Every variable starts with `$` (no `let`/`var`/`const`).
- Types are automatic: strings, numbers, booleans, arrays.
- String quotes: `"..."` inserts variables, `'...'` does NOT.

```php
$name = "Rahim";              // string
$age = 21;                    // int
$gpa = 3.75;                  // float
$ok = true;                   // bool
echo "Name: $name";           // Name: Rahim  (double quotes work)
echo 'Name: $name';           // Name: $name  (single quotes do not)
```

## 4. Arrays

```php
$names = ["Rahim", "Karim", "Rima"];
echo $names[0];                    // Rahim

// ASSOCIATIVE array = JS object
$student = ["id" => 1, "dept" => "CSE", "name" => "Rahim"];
echo $student["dept"];             // CSE
$student["name"] = "Karim";        // update value
$student["address"] = "Dhaka";     // add new key

count($names);                     // 3 (like .length)
implode(", ", $names);             // "Rahim, Karim, Rima" (like .join)
isset($student["name"]);           // true (key exists?)
```

`mysqli_fetch_assoc()` returns rows exactly like the associative arrays above.

## 5. Operators

```php
$total = 10 + 5;      // + - * / %
$name = "A" . "B";    // concatenation (dot, NOT +)
$a == $b;             // loose equal (same as JS)
$a === $b;            // strict equal
&&  ||  !             // and / or / not
$x++;  $x--;          // increment / decrement
```

## 6. Conditions

```php
if ($age >= 18) {
    echo "Adult";
} elseif ($age >= 12) {
    echo "Teen";
} else {
    echo "Child";
}
```

## 7. Loops (two syntaxes)

Normal (use inside PHP blocks):
```php
for ($i = 0; $i < 5; $i++) { echo $i; }

foreach ($names as $n) { echo $n; }          // simple
foreach ($TABLES as $t => $cols) { ... }     // with key => value

while ($row = mysqli_fetch_assoc($result)) {
    echo $row["name"];
}
```

HTML-friendly (use when printing HTML inside a loop - same thing, different shape):
```php
<?php foreach ($names as $n): ?>
    <li><?= $n ?></li>
<?php endforeach; ?>

<?php if ($x > 5): ?>
    <p>Big</p>
<?php else: ?>
    <p>Small</p>
<?php endif; ?>
```

## 8. Functions

```php
function add($a, $b) {
    return $a + $b;
}
echo add(2, 3);   // 5

// default value
function greet($name = "Guest") { return "Hello $name"; }
```

## 9. Superglobals (getting data IN from the browser)

```php
$_GET["id"]    // from URL: crud.php?id=3
$_POST["name"] // from a submitted form <input name="name">
$_REQUEST      // either GET or POST
$_SERVER["REQUEST_METHOD"]  // "GET" or "POST" - HOW the request arrived
$_SESSION["x"] // data kept between requests (needs session_start())
$_FILES        // uploaded files
```

Form -> PHP flow:
```html
<form method="POST" action="crud.php">
    <input type="text" name="dept">
    <input type="submit">
</form>
```
```php
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept = $_POST["dept"];      // "dept" = the input's name
}
?>
```
Rule: `name` attribute in HTML = key in `$_POST` / `$_GET`.

## 10. MySQL with mysqli (the exam core)

### Connect
```php
// port needed when XAMPP MySQL is not on 3306 (this PC uses 3307)
$conn = mysqli_connect("localhost", "root", "", "SchoolMgmt", 3307);
if (!$conn) die("Connection failed: " . mysqli_connect_error());
```

### CREATE DATABASE / TABLE from PHP (if faculty asks)
```php
<?php
$conn = mysqli_connect("localhost", "root", "", "", 3307);   // no DB yet!
if (!$conn) die("Connection failed: " . mysqli_connect_error());

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS SchoolMgmt");

mysqli_select_db($conn, "SchoolMgmt");   // now use it

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS student (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept VARCHAR(50),
    name VARCHAR(100),
    nid VARCHAR(30),
    birth DATE,
    address VARCHAR(200)
)");

$r = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_array($r)) echo $row[0] . "<br>";
?>
```
Your folder already has this as `setup.php` - it reads the tables from
`config.php` and creates them all automatically.

### The 4 CRUD statements (memorize this table)

| Operation | SQL |
|-----------|-----|
| Create | `INSERT INTO student (id, dept, name) VALUES (1, 'CSE', 'Rahim')` |
| Read all | `SELECT * FROM student` |
| Read one | `SELECT * FROM student WHERE id = 1` |
| Read filtered | `SELECT * FROM student WHERE dept = 'CSE'` |
| Update | `UPDATE student SET dept = 'EEE' WHERE id = 1` |
| Delete | `DELETE FROM student WHERE id = 1` |

### Run a query and get rows
```php
$result = mysqli_query($conn, "SELECT * FROM student");
if (!$result) die(mysqli_error($conn));       // show the SQL error

while ($row = mysqli_fetch_assoc($result)) {  // one loop = one row
    echo $row["name"];
}
```
Helpers: `mysqli_num_rows($result)` (row count), `mysqli_affected_rows($conn)`
(rows changed by INSERT/UPDATE/DELETE), `mysqli_error($conn)` (last error).

### Escape user input (stops SQL injection)
```php
$name = mysqli_real_escape_string($conn, $_POST["name"]);
$sql = "INSERT INTO student (name) VALUES ('$name')";
```
Never put raw `$_POST`/`$_GET` values inside SQL strings.

## 11. A complete one-file CRUD example

```php
<?php
$conn = mysqli_connect("localhost", "root", "", "SchoolMgmt", 3307);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$action = isset($_GET["action"]) ? $_GET["action"] : "read";

if ($_SERVER["REQUEST_METHOD"] == "POST" && $action == "create") {
    $id = (int)$_POST["id"];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    mysqli_query($conn, "INSERT INTO student (id, name) VALUES ($id, '$name')");
    header("Location: ?action=read");   // redirect back to list
    exit;
}
if ($action == "delete") {
    $id = (int)$_GET["id"];
    mysqli_query($conn, "DELETE FROM student WHERE id = $id");
    header("Location: ?action=read");
    exit;
}
?>
<h1>Students</h1>
<form method="POST">
    <input type="hidden" name="action" value="create">
    ID: <input name="id"><br>
    Name: <input name="name"><br>
    <input type="submit" value="Add">
</form>
<table border="1">
<?php
$r = mysqli_query($conn, "SELECT * FROM student");
while ($row = mysqli_fetch_assoc($r)) {
    echo "<tr><td>{$row['id']}</td><td>{$row['name']}</td>
          <td><a href='?action=delete&id={$row['id']}'>Delete</a></td></tr>";
}
?>
</table>
```
Note the trick: the page is a list (read) AND a form (create) AND handles delete -
one file, branches on `$action`.

## 12. Gotchas checklist (exam favorites)

- `$` before every variable. Missing `$` = the #1 beginner error.
- `.` concatenates strings, NOT `+` (that's JS).
- `'...'` does not insert `$var` - use `"..."` or concatenation.
- `echo $row["name"]` - associative array keys in double quotes (or `{$row['name']}` inside a double-quoted string).
- Cast to int before using an id in SQL: `$id = (int)$_GET["id"];`
- `mysqli_fetch_assoc()` in a `while` loop reads one row each time; the loop
  ends when there are no rows left.
- Always `die(mysqli_error($conn))` after a query to see what went wrong.
- Form inputs need `name=...` or PHP never sees the value.
- `header("Location: ...")` must come before ANY output (even a space).
- Numbers vs strings don't matter much in SQL - MySQL converts automatically.

## 13. JS -> PHP comparison

| Concept | JavaScript | PHP |
|---------|-----------|-----|
| Variable | `let x = 5` | `$x = 5;` |
| Print to console/page | `console.log(x)` | `echo $x;` |
| String concat | `"a" + "b"` | `"a" . "b"` |
| Template string | `` `Hi ${name}` `` | `"Hi $name"` |
| Array | `[1, 2, 3]` | `[1, 2, 3]` |
| Object | `{id: 1}` | `["id" => 1]` (assoc array) |
| Object access | `obj.id` | `$arr["id"]` |
| Loop | `arr.forEach(x => ...)` | `foreach ($arr as $x) { ... }` |
| Key-value loop | `for (k in obj)` | `foreach ($arr as $k => $v)` |
| Join | `arr.join(", ")` | `implode(", ", $arr)` |
| Length | `arr.length` | `count($arr)` |
| If | `if (x === 1) {}` | `if ($x === 1) { }` |
| Function | `function f(a) {}` | `function f($a) { }` |
| Array method | `arr.push(x)` | `$arr[] = x;` |
| Error | `throw new Error(msg)` | `die(msg)` |
| Event handler | `onClick = () => {...}` | `if ($_SERVER["REQUEST_METHOD"] == "POST") { ... }` |

## 14. Exam-time workflow (with this folder)

1. Faculty gives table specs -> create DB/tables: phpMyAdmin Import (SQL tab)
   **or** run `setup.php` (creates everything from `config.php`).
2. Add the table to `$TABLES` in `config.php` (first column = primary key).
3. Open `http://localhost/crud/` - all 4 APIs are already there.
4. Be ready to explain the SQL behind each page (section 10 table).
