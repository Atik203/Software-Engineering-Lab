<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CRUD Reusable Kit - Home</title>
<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; max-width: 700px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
    a { color: #0056b3; }
</style>
</head>
<body>
<h1>CRUD Reusable Kit</h1>
<p>Connected to database <strong><?php echo $DB['name']; ?></strong> @ <?php echo $DB['host'] . ':' . $DB['port']; ?></p>

<h2>Generic CRUD APIs</h2>
<p>Every table listed in <code>config.php</code> gets Create, Read, Update, Delete automatically.</p>
<table>
    <tr>
        <th>Table</th>
        <th>Columns</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($TABLES as $t => $cols): ?>
    <tr>
        <td><?php echo $t; ?></td>
        <td><?php echo implode(', ', $cols); ?></td>
        <td>
            <a href="crud.php?table=<?php echo $t; ?>&action=read">Read</a> |
            <a href="crud.php?table=<?php echo $t; ?>&action=create">Create</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Practice Sample (Fall2025_CW - lab manual)</h2>
<p><a href="practice/index.php">Read Teachers | Read Courses | Assign Teacher To Course</a></p>

<h2>Extra Tools</h2>
<p><a href="setup.php">Create Database &amp; Tables From PHP</a> (no phpMyAdmin needed)</p>
<p><a href="php.md">PHP Quick Reference</a> (exam cheat sheet)</p>
</body>
</html>
