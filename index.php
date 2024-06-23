<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa vozového parku</title>
    <link rel="stylesheet" href="index.css"> <!-- Specifický styl pro úvodní stránku -->
</head>
<body>
    <div class="intro-container">
        <div class="intro-form">
            <h1>Vítejte ve správě vozového parku</h1>
            <form action="login.php" method="post">
                <input type="text" name="username" placeholder="Uživatelské jméno" required><br>
                <input type="password" name="password" placeholder="Heslo" required><br>
                <input type="submit" value="Přihlásit se">
            </form>
            <a href="register_user.php">Registrace</a> <!-- Odkaz na registrační stránku -->
        </div>
    </div>
</body>
</html>



