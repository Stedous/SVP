<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vozidlo_id = $_POST['vozidlo_id'];
    $target_dir = "uploads/";
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $unique_name = pathinfo($file_name, PATHINFO_FILENAME) . "_" . time() . "." . $file_extension;
    $target_file = $target_dir . $unique_name;
    $uploadOk = 1;

    // Ověření, zda adresář existuje, pokud ne, vytvoříme ho
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Kontrola, zda je soubor skutečně obrázek nebo dokument
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false || in_array($file_extension, ['pdf', 'doc', 'docx'])) {
        $uploadOk = 1;
    } else {
        echo "Soubor není platný obrázek nebo dokument.";
        $uploadOk = 0;
    }

    // Ověření velikosti souboru (limit: 5MB)
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        echo "Soubor je příliš velký.";
        $uploadOk = 0;
    }

    // Povolené formáty souborů
    if (!in_array($file_extension, ['jpg', 'png', 'jpeg', 'gif', 'pdf', 'doc', 'docx'])) {
        echo "Povolené formáty jsou JPG, JPEG, PNG, GIF, PDF, DOC, DOCX.";
        $uploadOk = 0;
    }

    // Kontrola $uploadOk, zda došlo k chybě
    if ($uploadOk == 0) {
        echo "Soubor nebyl nahrán.";
    // Pokud je vše v pořádku, nahraj soubor
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO dokumenty (vozidlo_id, file_path) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $vozidlo_id, $target_file);
            $stmt->execute();
            $stmt->close();

            echo "Soubor ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " byl úspěšně nahrán.";
        } else {
            echo "Došlo k chybě při nahrávání souboru.";
        }
    }
}

$sql = "SELECT id, sap_cislo, spz FROM vozidla";
$result = $conn->query($sql);
$conn->close();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nahrání dokumentu</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Nahrání dokumentu</h1>
    <form action="upload_document.php" method="post" enctype="multipart/form-data">
        Vozidlo:
        <select name="vozidlo_id" required>
            <?php while($row = $result->fetch_assoc()): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['sap_cislo'] . " - " . $row['spz']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>
        Vyberte soubor k nahrání:
        <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
        <input type="submit" value="Nahrát soubor" name="submit">
    </form>
    <a href="dashboard.php">Zpět na dashboard</a>
</body>
</html>
