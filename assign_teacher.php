<?php
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $course_id = $_POST['course_id'];

    if ($teacher_id !== "" && $course_id !== "") {
        $teacher_id = (int)$teacher_id;
        $course_id = (int)$course_id;

        $sql = "UPDATE Teacher SET course_id = $course_id WHERE teacher_id = $teacher_id";

        if (mysqli_query($conn, $sql) && mysqli_affected_rows($conn) > 0) {
            $message = "Teacher assigned to course successfully.";
        } else {
            $message = "Assignment failed. Check that the teacher ID exists.";
        }
    } else {
        $message = "Please fill in both teacher ID and course ID.";
    }
}

$teachers = mysqli_query($conn, "SELECT teacher_id, name FROM Teacher");
$courses = mysqli_query($conn, "SELECT course_id, title FROM Course");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Teacher To Course</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { max-width: 400px; }
        label { display: block; margin-top: 10px; }
        select, input[type=submit] { margin-top: 5px; padding: 6px; width: 100%; }
        .msg { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Assign Teacher To Course</h1>

    <?php if ($message): ?>
        <p class="msg"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST" action="assign_teacher.php">
        <label>Teacher</label>
        <select name="teacher_id" required>
            <option value="">-- Select Teacher --</option>
            <?php while ($t = mysqli_fetch_assoc($teachers)): ?>
                <option value="<?php echo $t['teacher_id']; ?>">
                    <?php echo $t['name'] . " (ID: " . $t['teacher_id'] . ")"; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Course</label>
        <select name="course_id" required>
            <option value="">-- Select Course --</option>
            <?php while ($c = mysqli_fetch_assoc($courses)): ?>
                <option value="<?php echo $c['course_id']; ?>">
                    <?php echo $c['title'] . " (ID: " . $c['course_id'] . ")"; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="submit" value="Assign">
    </form>

    <p><a href="index.php">&larr; Back to Home</a></p>
</body>
</html>
