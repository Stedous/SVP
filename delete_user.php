<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

$id = intval($_GET['id']);
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

header('Location: admin_page.php');
exit();
