<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $username, $hashed_password, $role);
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            echo "Přihlášení úspěšné. Role: " . $role; // Debugging
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Neplatné heslo.";
        }
    } else {
        echo "Neplatné přihlašovací údaje.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Přihlášení</h1>
    <form action="login.php" method="post">
        Uživatelské jméno: <input type="text" name="username" required><br><br>
        Heslo: <input type="password" name="password" required><br><br>
        <input type="submit" value="Přihlásit se">
    </form>
</body>
</html>




