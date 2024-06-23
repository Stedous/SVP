<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id'])) {
        echo "ID vozidla není definováno.";
        exit();
    }

    $id = $_POST['id'];
    $sap_cislo = $_POST['sap_cislo'];
    $spz = $_POST['spz'];
    $typ_nakupu = $_POST['typ_nakupu'];
    $datum_zacatku = $_POST['datum_zacatku'] ?: NULL;
    $datum_konce = $_POST['datum_konce'] ?: NULL;
    $pocet_km = $_POST['pocet_km'] ?: NULL;

    // Aktualizace vozidla v databázi
    $sql = "UPDATE vozidla SET sap_cislo = ?, spz = ?, typ_nakupu = ?, datum_zacatku = ?, datum_konce = ?, pocet_km = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $sap_cislo, $spz, $typ_nakupu, $datum_zacatku, $datum_konce, $pocet_km, $id);
    $stmt->execute();
    $stmt->close();

    echo "Vozidlo bylo úspěšně upraveno!";
    echo "<br><a href='manage_vehicles.php'>Zpět na správu vozidel</a>";
} else {
    if (!isset($_GET['id'])) {
        echo "ID vozidla není definováno.";
        exit();
    }

    $id = $_GET['id'];

    // Načtení dat vozidla z databáze
    $sql = "SELECT sap_cislo, spz, typ_nakupu, datum_zacatku, datum_konce, pocet_km FROM vozidla WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($sap_cislo, $spz, $typ_nakupu, $datum_zacatku, $datum_konce, $pocet_km);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Úprava vozidla</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Úprava vozidla</h1>
    <form action="edit_vehicle.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        SAP číslo: <input type="text" name="sap_cislo" value="<?php echo htmlspecialchars($sap_cislo); ?>" required><br><br>
        SPZ: <input type="text" name="spz" value="<?php echo htmlspecialchars($spz); ?>" required><br><br>
        Typ nákupu:
        <select name="typ_nakupu" required>
            <option value="operativni_leasing" <?php if ($typ_nakupu == 'operativni_leasing') echo 'selected'; ?>>Operativní leasing</option>
            <option value="leasing" <?php if ($typ_nakupu == 'leasing') echo 'selected'; ?>>Leasing</option>
            <option value="hotovost" <?php if ($typ_nakupu == 'hotovost') echo 'selected'; ?>>Hotovost</option>
        </select><br><br>
        Datum začátku: <input type="date" name="datum_zacatku" value="<?php echo htmlspecialchars($datum_zacatku); ?>"><br><br>
        Datum konce: <input type="date" name="datum_konce" value="<?php echo htmlspecialchars($datum_konce); ?>"><br><br>
        Počet km: <input type="number" name="pocet_km" value="<?php echo htmlspecialchars($pocet_km); ?>"><br><br>
        <input type="submit" value="Upravit vozidlo">
    </form>
    <a href="manage_vehicles.php">Zpět na správu vozidel</a>
</body>
</html>
