<?php
require 'db.php';

$sql = "SELECT t.teacher_id, t.name, c.course_id, c.title
        FROM Teacher t
        LEFT JOIN Course c ON t.course_id = c.course_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Teachers</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; max-width: 600px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Read Teachers</h1>
    <table>
        <tr>
            <th>Teacher ID</th>
            <th>Name</th>
            <th>Course ID</th>
            <th>Course Title</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['teacher_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['course_id'] ?? '-'; ?></td>
            <td><?php echo $row['title'] ?? '-'; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="index.php">&larr; Back to Home</a></p>
</body>
</html>
