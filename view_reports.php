<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

$sql = "SELECT id, sap_cislo, spz, misto_zavady, popis, username, created_at FROM hlaseni";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlášení závad</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Hlášení závad</h1>
    <table border="1">
        <tr>
            <th>SAP číslo</th>
            <th>SPZ</th>
            <th>Místo závady</th>
            <th>Popis</th>
            <th>Uživatel</th>
            <th>Datum</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['sap_cislo']); ?></td>
            <td><?php echo htmlspecialchars($row['spz']); ?></td>
            <td><?php echo htmlspecialchars($row['misto_zavady']); ?></td>
            <td><?php echo htmlspecialchars($row['popis']); ?></td>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

<?php
$conn->close();
?>



