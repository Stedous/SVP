<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

// Získání role uživatele
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'none';
echo "Role: " . $role . "<br>"; // Debugging


?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Dashboard</h1>
    
    <?php if ($role == 'administrator'): ?>
        <!-- Administrátorské možnosti -->
        <a href="manage_vehicles.php">Spravovat vozidla</a><br>
        <a href="view_reports.php">Zobrazit hlášení</a><br>
        <a href="register_user.php">Registrovat uživatele</a><br>
    <?php elseif ($role == 'ridic'): ?>
        <!-- Možnosti pro řidiče -->
        <a href="report_issue.php">Nahlásit závadu</a><br>
    <?php else: ?>
        <!-- Možnosti pro nedefinované role nebo chyby -->
        <p>Nepodařilo se načíst roli uživatele.</p>
    <?php endif; ?>
    
    <a href="logout.php">Odhlásit se</a>
</body>
</html>
