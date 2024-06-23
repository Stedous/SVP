<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

// Získání seznamu všech vozidel, která mají nahrané dokumenty
$sql = "SELECT DISTINCT v.id, v.sap_cislo, v.spz FROM vozidla v JOIN dokumenty d ON v.id = d.vozidlo_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumenty vozidel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Dokumenty vozidel</h1>
    <table border="1">
        <tr>
            <th>SAP číslo</th>
            <th>SPZ</th>
            <th>Akce</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['sap_cislo']); ?></td>
            <td><?php echo htmlspecialchars($row['spz']); ?></td>
            <td><a href="view_documents.php?vozidlo_id=<?php echo htmlspecialchars($row['id']); ?>">Zobrazit dokumenty</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

<?php
$conn->close();
?>

