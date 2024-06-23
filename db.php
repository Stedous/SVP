<?php
// nastaveni pripojení k databázi
$servername ="localhost";
$username = "root";
$password ="";
$dbname = "svp";

// vytvoreni pripojeni k databazi
$conn = new mysqli($servername, $username, $password, $dbname);

// kontrol připojení
if($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}
?>