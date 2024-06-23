<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'administrator') {
    header('Location: login.html');
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);
    if ($stmt->execute()) {
        echo "Uživatel byl úspěšně zaregistrován.";
    } else {
        echo "Chyba při registraci uživatele: " . $stmt->error;
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
    <title>Registrace uživatele</title>
    <link rel="stylesheet" href="styles.css"> <!-- Původní styl -->
</head>
<body>
    <div class="container">
        <h1>Registrace uživatele</h1>
        <form action="register_user.php" method="post">
            Uživatelské jméno: <input type="text" name="username" required><br><br>
            Heslo: <input type="password" name="password" required><br><br>
            Role:
            <select name="role" required>
                <option value="administrator">Administrator</option>
                <option value="ridic">Řidič</option>
            </select><br><br>
            <input type="submit" value="Registrovat">
        </form>
    </div>
</body>
</html>


