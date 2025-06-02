<?php
require_once __DIR__ . '/../../config/connessione.php';
include_once __DIR__ . '/../../common/navbar.php';

$messaggio = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $serial_number = $_POST['serial_number'] ?? '';
    $name = $_POST['name'] ?? '';
    $surname = $_POST['surname'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $address = $_POST['address'] ?? '';

    // Prepare statement
    $stmt = mysqli_prepare($link, "INSERT INTO user (serial_number, name, surname, telephone, address) VALUES (?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Errore prepare: " . mysqli_error($link));
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssss", $serial_number, $name, $surname, $telephone, $address);

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        $messaggio = "✅ Utente inserito correttamente!";
    } else {
        $messaggio = "❌ Errore execute: " . mysqli_stmt_error($stmt);
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Inserisci Utente</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="/assets/style/global.css">
</head>
<body>
    <?php include_once __DIR__ . '/../../common/navbar.php'; ?>

    <h2>Inserisci Nuovo Utente</h2>

    <?php if ($messaggio): ?>
        <p><strong><?= htmlspecialchars($messaggio) ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" maxlength="6" required>

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>

        <label for="surname">Cognome:</label>
        <input type="text" id="surname" name="surname" required>

        <label for="telephone">Telefono:</label>
        <input type="text" id="telephone" name="telephone" required>

        <label for="address">Indirizzo:</label>
        <input type="text" id="address" name="address" required>

	<button type="submit" style="background-color: #28a745; color: #fff">Inserisci</button>
    </form>
</body>
</html>

