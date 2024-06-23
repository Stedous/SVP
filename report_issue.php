<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

$sql = "SELECT sap_cislo, spz FROM vozidla";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlášení závady</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Hlášení závady</h1>
    <form action="submit.php" method="post">
        Vozidlo:
        <select name="vozidlo" required>
            <?php while($row = $result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['sap_cislo'] . ' - ' . $row['spz']); ?>">
                    <?php echo htmlspecialchars($row['sap_cislo'] . ' - ' . $row['spz']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>
        Místo závady:
        <select name="misto_zavady" required>
            <option value="motor">Motor</option>
            <option value="prevodovka">Převodovka</option>
            <option value="podvozek">Podvozek</option>
            <option value="sklo">Sklo</option>
            <option value="svetla">Světlá</option>
            <option value="elektricke_vybaveni">Elektrické vybavení</option>
            <option value="dvere">Dveře</option>
            <option value="spojka">Spojka</option>
        </select><br><br>
        Popis závady:
        <textarea name="popis" required></textarea><br><br>
        <input type="submit" value="Odeslat hlášení">
    </form>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

<?php
$conn->close();
?>



