<?php
include_once('../../config/connessione.php');

$start_date = $_GET['start_date'] ?? '';
$return_date = $_GET['return_date'] ?? '';
$loans = [];

if ($start_date && $return_date) {
    // Ricerca tra intervallo date
    $stmt = $link->prepare("
        SELECT u.serial_number, u.name, u.surname, b.title, c.code, 
               l.start_date, l.return_date
        FROM loan l
        JOIN user u ON l.serial_number = u.serial_number
        JOIN copy c ON l.copy_code = c.code
        JOIN book b ON c.ISBN = b.ISBN
        WHERE l.start_date >= ? AND l.return_date <= ?
    ");
    $stmt->bind_param("ss", $start_date, $return_date);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Prestiti attivi che scadranno in futuro
    $result = $link->query("
        SELECT u.serial_number, u.name, u.surname, b.title, c.code, 
               l.start_date, l.return_date,
               DATE_ADD(l.start_date, INTERVAL 30 DAY) AS due_date
        FROM loan l
        JOIN user u ON l.serial_number = u.serial_number
        JOIN copy c ON l.copy_code = c.code
        JOIN book b ON c.ISBN = b.ISBN
        WHERE l.return_date IS NULL
        AND DATE_ADD(l.start_date, INTERVAL 30 DAY) >= CURDATE()
        ORDER BY due_date ASC
    ");
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $loans[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricerca Prestiti</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
    <style>
    .form-container {
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .form-container label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .form-container input[type="date"] {
        width: 300px;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }

    .form-container button {
        background-color: #28a745;
        color: white;
        padding: 14px 28px;
        font-size: 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-container button:hover {
        background-color: #218838;
    }
</style>

</head>
<body>
<?php include '../../common/navbar.php'; ?>
<div class="container">
    <h1>Ricerca Prestiti per Data</h1>

    <form method="GET" class="form-container">
        <label for="start_date">Data Inizio Prestito:</label>
        <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">

        <label for="end_date">Data Fine Prestito:</label>
        <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">

        <br><br>
        <button type="submit">Cerca</button>
    </form>
</div>
    <table>
        <thead>
            <tr>
                <th>Serial Number</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Titolo Libro</th>
                <th>Codice Copia</th>
                <th>Data Inizio</th>
                <th>Data Ritorno</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($loans)): ?>
                <?php foreach ($loans as $loan): ?>
                    <tr>
                        <td><?= htmlspecialchars($loan['serial_number']) ?></td>
                        <td><?= htmlspecialchars($loan['name']) ?></td>
                        <td><?= htmlspecialchars($loan['surname']) ?></td>
                        <td><?= htmlspecialchars($loan['title']) ?></td>
                        <td><?= htmlspecialchars($loan['code']) ?></td>
                        <td><?= explode(" ", $loan['start_date'])[0] ?></td>
                        <td><?= $loan['return_date'] ? explode(" ", $loan['return_date'])[0] : '—' ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">Nessun prestito trovato.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>