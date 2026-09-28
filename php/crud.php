<?php
require 'db.php';

$table  = $_GET['table']  ?? '';
$action = $_GET['action'] ?? 'read';
$id     = $_GET['id']     ?? '';
$search = $_GET['q']      ?? '';

if (!array_key_exists($table, $TABLES)) {
    die('Unknown table: ' . htmlspecialchars($table));
}

$columns = $TABLES[$table];
$pk      = $columns[0];
$message = isset($_GET['msg']) ? $_GET['msg'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = [];
    foreach ($columns as $c) {
        $values[$c] = isset($_POST[$c]) ? trim($_POST[$c]) : '';
    }

    if ($action === 'create') {
        $cols = implode(', ', $columns);
        $vals = implode(', ', array_map(function ($v) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $v) . "'";
        }, $values));
        $message = mysqli_query($conn, "INSERT INTO $table ($cols) VALUES ($vals)")
            ? 'Created successfully.'
            : 'Create failed: ' . mysqli_error($conn);
        header('Location: crud.php?table=' . urlencode($table) . '&action=read&msg=' . urlencode($message));
        exit;
    }

    if ($action === 'update') {
        $id = (int)$values[$pk];
        $sets = [];
        foreach ($columns as $c) {
            if ($c === $pk) continue;
            $sets[] = "$c = '" . mysqli_real_escape_string($conn, $values[$c]) . "'";
        }
        $message = mysqli_query($conn, "UPDATE $table SET " . implode(', ', $sets) . " WHERE $pk = $id")
            ? 'Updated successfully.'
            : 'Update failed: ' . mysqli_error($conn);
        header('Location: crud.php?table=' . urlencode($table) . '&action=read&msg=' . urlencode($message));
        exit;
    }
}

if ($action === 'delete') {
    $id = (int)$id;
    $message = mysqli_query($conn, "DELETE FROM $table WHERE $pk = $id")
        ? 'Deleted successfully.'
        : 'Delete failed: ' . mysqli_error($conn);
    $action = 'read';
}

$row = null;
if ($action === 'update') {
    $r = mysqli_query($conn, "SELECT * FROM $table WHERE $pk = " . (int)$id);
    $row = mysqli_fetch_assoc($r);
    if (!$row) die('Record not found.');
}

$result = null;
if ($action === 'read') {
    $sql = "SELECT * FROM $table";
    if ($search !== '') {
        $like = '%' . mysqli_real_escape_string($conn, $search) . '%';
        $conds = [];
        foreach ($columns as $c) $conds[] = "$c LIKE '$like'";
        $sql .= ' WHERE ' . implode(' OR ', $conds);
    }
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo ucfirst($action); ?> - <?php echo $table; ?></title>
<style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 6px 10px; text-align: left; }
    th { background: #f2f2f2; }
    input { padding: 6px; margin: 4px 0; width: 100%; box-sizing: border-box; }
    form { max-width: 420px; }
    label { font-weight: bold; }
    .msg { color: green; font-weight: bold; }
    .topbar { margin-bottom: 16px; }
    .topbar a { margin-right: 12px; }
</style>
</head>
<body>
<div class="topbar">
    <a href="index.php">&larr; Home</a>
    <a href="crud.php?table=<?php echo $table; ?>&action=read">Read <?php echo $table; ?></a>
    <a href="crud.php?table=<?php echo $table; ?>&action=create">Create <?php echo $table; ?></a>
</div>
<h1><?php echo ucfirst($action); ?> - <?php echo $table; ?></h1>

<?php if ($message): ?>
    <p class="msg"><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>

<?php if ($action === 'read'): ?>

    <form method="GET" action="crud.php" style="max-width: 420px;">
        <input type="hidden" name="table" value="<?php echo $table; ?>">
        <input type="hidden" name="action" value="read">
        <label>Search (any column)</label>
        <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>

    <table>
        <tr>
            <?php foreach ($columns as $c) echo "<th>$c</th>"; ?>
            <th>Actions</th>
        </tr>
        <?php if (mysqli_num_rows($result) === 0): ?>
            <tr><td colspan="<?php echo count($columns) + 1; ?>">No records found.</td></tr>
        <?php endif; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <?php foreach ($columns as $c): ?>
                <td><?php echo htmlspecialchars($row[$c]); ?></td>
            <?php endforeach; ?>
            <td>
                <a href="crud.php?table=<?php echo $table; ?>&action=update&id=<?php echo $row[$pk]; ?>">Update</a>
                <a href="crud.php?table=<?php echo $table; ?>&action=delete&id=<?php echo $row[$pk]; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

<?php elseif ($action === 'create' || $action === 'update'): ?>

    <form method="POST" action="crud.php">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <input type="hidden" name="table" value="<?php echo $table; ?>">
        <?php foreach ($columns as $c): ?>
            <?php if ($action === 'update' && $c === $pk): ?>
                <input type="hidden" name="<?php echo $pk; ?>" value="<?php echo $row[$pk]; ?>">
            <?php else: ?>
                <label><?php echo $c; ?></label>
                <input type="text" name="<?php echo $c; ?>"
                       value="<?php echo $action === 'update' ? htmlspecialchars($row[$c]) : ''; ?>">
            <?php endif; ?>
        <?php endforeach; ?>
        <input type="submit" value="<?php echo $action === 'create' ? 'Create' : 'Update'; ?>">
    </form>

<?php endif; ?>
</body>
</html>
