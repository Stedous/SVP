<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Formulář hlášení poruchy</title>
</head>
<body>
    <form action="submit.php" method="post">
        SAP číslo vozidla:
        <select name="sap_cislo">
        <?php
            include 'db.php'; // Připojení k databázi

            $sql = "SELECT sap_cislo FROM vozidla";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['sap_cislo']) . '">' . htmlspecialchars($row['sap_cislo']) . '</option>';
                }
            } else {
                echo '<option value="">Žádná vozidla nejsou k dispozici</option>';
            }
            $conn->close();
            ?>
        </select><br><br>
        Místo poruchy: 
        <select name="misto_poruchy">
            <option value="motor">Motor</option>
            <option value="prevodovka">Převodovka</option>
            <option value="podvozek">Podvozek</option>
        </select><br><br>
        Popis poruchy: <textarea name="popis"></textarea><br><br>
        <input type="submit" value="Odeslat">
    </form>
</body>
</html>

