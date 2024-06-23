<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vozidlo = $_POST['vozidlo'];
    list($sap_cislo, $spz) = explode(' - ', $vozidlo);
    $misto_zavady = $_POST['misto_zavady'];
    $popis = $_POST['popis'];
    $username = $_SESSION['username'];

    $sql = "INSERT INTO hlaseni (sap_cislo, spz, misto_poruchy, popis, misto_zavady, username) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $sap_cislo, $spz, $misto_zavady, $popis, $misto_zavady, $username);
    $stmt->execute();
    $stmt->close();

    echo "Hlášení bylo úspěšně odesláno.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hlášení odesláno</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Hlášení bylo odesláno</h1>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>

