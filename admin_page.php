<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

$sql = "SELECT id, username, role FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa uživatelů</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Správa uživatelů</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Uživatelské jméno</th>
            <th>Role</th>
            <th>Akce</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td><a href="delete_user.php?id=<?php echo $row['id']; ?>">Smazat</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Zpět na dashboard</a><br>
    <a href="logout.php">Odhlásit se</a>
</body>
</html>

<?php
$conn->close();
?>

