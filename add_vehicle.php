<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sap_cislo = $_POST['sap_cislo'] ?? '';
    $spz = $_POST['spz'] ?? '';
    $typ_nakupu = $_POST['typ_nakupu'] ?? '';
    $datum_zacatku = $_POST['datum_zacatku'] ?? NULL;
    $datum_konce = $_POST['datum_konce'] ?? NULL;
    $pocet_km = $_POST['pocet_km'] ?? NULL;

    // Validace povinných polí
    if ($sap_cislo === '' || $spz === '' || $typ_nakupu === '') {
        echo "Všechna povinná pole musí být vyplněna.";
        exit();
    }

    // Přizpůsobení hodnot pro databázi
    if ($typ_nakupu === 'operativni_leasing' && ($datum_zacatku === NULL || $datum_konce === NULL || $pocet_km === NULL)) {
        echo "Pro operativní leasing musí být vyplněna data a počet km.";
        exit();
    } elseif ($typ_nakupu === 'leasing' && ($datum_zacatku === NULL || $datum_konce === NULL)) {
        echo "Pro leasing musí být vyplněna data začátku a konce.";
        exit();
    } elseif ($typ_nakupu === 'hotovost' && $datum_zacatku === NULL) {
        echo "Pro nákup v hotovosti musí být vyplněno datum nákupu.";
        exit();
    }

    // Vložení nového vozidla do databáze
    $sql = "INSERT INTO vozidla (sap_cislo, spz, typ_nakupu, datum_zacatku, datum_konce, pocet_km) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $sap_cislo, $spz, $typ_nakupu, $datum_zacatku, $datum_konce, $pocet_km);
    $stmt->execute();
    $stmt->close();

    echo "Vozidlo bylo úspěšně přidáno!";
    echo "<br><a href='dashboard.php'>Zpět na dashboard</a>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přidání vozidla</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Přidání vozidla</h1>
    <form action="add_vehicle.php" method="post">
        SAP číslo: <input type="text" name="sap_cislo" required><br><br>
        SPZ: <input type="text" name="spz" required><br><br>
        Typ nákupu:
        <select name="typ_nakupu" required>
            <option value="operativni_leasing">Operativní leasing</option>
            <option value="leasing">Leasing</option>
            <option value="hotovost">Hotovost</option>
        </select><br><br>
        Datum začátku: <input type="date" name="datum_zacatku"><br><br>
        Datum konce: <input type="date" name="datum_konce"><br><br>
        Počet km: <input type="number" name="pocet_km"><br><br>
        <input type="submit" value="Přidat vozidlo">
    </form>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

