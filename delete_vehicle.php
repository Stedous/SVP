<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

$id = $_GET['id'];

// Smazání vozidla z databáze
$sql = "DELETE FROM vozidla WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

$conn->close();

header('Location: manage_vehicles.php');
exit();
?>
