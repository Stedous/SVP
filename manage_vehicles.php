<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

$sql = "SELECT id, sap_cislo, spz, typ_nakupu, datum_zacatku, datum_konce, pocet_km FROM vozidla";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa vozidel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Správa vozidel</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>SAP číslo</th>
            <th>SPZ</th>
            <th>Typ nákupu</th>
            <th>Datum začátku</th>
            <th>Datum konce</th>
            <th>Počet km</th>
            <th>Akce</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['sap_cislo']); ?></td>
                <td><?php echo htmlspecialchars($row['spz']); ?></td>
                <td><?php echo htmlspecialchars($row['typ_nakupu']); ?></td>
                <td><?php echo htmlspecialchars($row['datum_zacatku']); ?></td>
                <td><?php echo htmlspecialchars($row['datum_konce']); ?></td>
                <td><?php echo htmlspecialchars($row['pocet_km']); ?></td>
                <td>
                    <a href="edit_vehicle.php?id=<?php echo $row['id']; ?>">Upravit</a>
                    <a href="delete_vehicle.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Opravdu chcete toto vozidlo smazat?');">Smazat</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="add_vehicle.php">Přidat nové vozidlo</a><br>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

<?php
$conn->close();
?>




