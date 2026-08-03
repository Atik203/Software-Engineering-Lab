<?php
require 'db.php';

$sql = "SELECT course_id, title FROM Course";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Courses</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        table { border-collapse: collapse; width: 100%; max-width: 600px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Read Courses</h1>
    <table>
        <tr>
            <th>Course ID</th>
            <th>Title</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['course_id']; ?></td>
            <td><?php echo $row['title']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="index.php">&larr; Back to Home</a></p>
</body>
</html>
