<?php
require __DIR__ . '/config.php';

$conn = mysqli_connect($DB['host'], $DB['user'], $DB['pass'], '', $DB['port']);
if (!$conn) die('Connection failed: ' . mysqli_connect_error());

function col_type($name) {
    if (preg_match('/amount|price/i', $name)) return 'DECIMAL(10,2)';
    if (preg_match('/date|birth/i', $name)) return 'DATE';
    if (preg_match('/id|code|credit|batch|stock|semester/i', $name)) return 'INT';
    return 'VARCHAR(100)';
}

$log = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = $DB['name'];
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $db");
    mysqli_select_db($conn, $db);
    $log[] = "Database '$db' ready.";

    foreach ($TABLES as $table => $cols) {
        $defs = [];
        foreach ($cols as $i => $c) {
            $type = col_type($c);
            if ($i === 0) {
                $type = strtolower($c) === 'id' ? 'INT PRIMARY KEY AUTO_INCREMENT' : 'INT PRIMARY KEY';
            }
            $defs[] = "$c $type";
        }
        $sql = "CREATE TABLE IF NOT EXISTS $table (" . implode(', ', $defs) . ")";
        $ok = mysqli_query($conn, $sql);
        $log[] = ($ok ? 'OK   ' : 'FAIL ') . "CREATE TABLE $table" . ($ok ? '' : ' -> ' . mysqli_error($conn));
    }

    $tables = mysqli_query($conn, "SHOW TABLES");
    $existing = [];
    while ($row = mysqli_fetch_array($tables)) $existing[] = $row[0];
    $log[] = 'Tables in database: ' . (implode(', ', $existing));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create Database From PHP</title>
<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    pre { background: #f5f5f5; padding: 12px; border-radius: 4px; }
    input { padding: 8px 16px; font-size: 15px; cursor: pointer; }
</style>
</head>
<body>
<h1>Create Database From PHP</h1>
<p>This page creates the database <strong><?php echo $DB['name']; ?></strong> and every
table listed in <code>config.php</code> using pure PHP (no phpMyAdmin).</p>

<p>Tables that will be created:</p>
<ul>
    <?php foreach ($TABLES as $t => $cols): ?>
        <li><code><?php echo $t; ?></code> (<?php echo implode(', ', $cols); ?>)</li>
    <?php endforeach; ?>
</ul>

<form method="POST">
    <input type="submit" value="Create Database &amp; Tables">
</form>

<?php if ($log): ?>
    <h2>Result</h2>
    <pre><?php echo implode("\n", $log); ?></pre>
<?php endif; ?>

<p><a href="index.php">&larr; Back to Home</a></p>
</body>
</html>
