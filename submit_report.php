<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sap_cislo = $_POST['sap_cislo'];
    $misto_poruchy = $_POST['misto_poruchy'];
    $popis = $_POST['popis'];

    // Zjištění SPZ z databáze na základě SAP čísla
    $sql = "SELECT spz FROM vozidla WHERE sap_cislo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sap_cislo);
    $stmt->execute();
    $stmt->bind_result($spz);
    $stmt->fetch();
    $stmt->close();

    // Uložení hlášení do databáze
    $sql = "INSERT INTO hlaseni (sap_cislo, spz, misto_poruchy, popis) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $sap_cislo, $spz, $misto_poruchy, $popis);
    $stmt->execute();
    $stmt->close();

    echo "Hlášení bylo úspěšně odesláno!";
    echo "<br><a href='dashboard.php'>Zpět na dashboard</a>";
}

$conn->close();
?>
