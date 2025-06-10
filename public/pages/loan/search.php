<?php
include_once('../../config/connessione.php');

$start_date = $_GET['start_date'] ?? '';
$return_date = $_GET['end_date'] ?? '';
$loans = [];
$error = '';
$noLoansMessage = '';
if ($start_date && !$return_date) {
    $error = "Inserisci anche la data di fine prestito.";
}elseif ($start_date && $return_date) {
    if ($return_date < $start_date) {
        $error = "La data di fine non può essere precedente alla data di inizio.";
    } else {
        // Ricerca tra intervallo date valido
        $stmt = $link->prepare("
            SELECT u.serial_number, u.name, u.surname, b.title, c.code, 
                   l.start_date, DATE_ADD(l.start_date, INTERVAL 30 DAY) AS end_date,
                   l.return_date
            FROM loan l
            JOIN user u ON l.serial_number = u.serial_number
            JOIN copy c ON l.copy_code = c.code
            JOIN book b ON c.ISBN = b.ISBN
            WHERE l.start_date between ? AND ?
        ");
        $stmt->bind_param("ss", $start_date, $return_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $loans[] = $row;
            }
        }

        if (empty($loans)) {
            $noLoansMessage = "Nessun prestito nel range di date inserito.";
        }
    }
} else {
    // Prestiti attivi che scadranno in futuro
    $result = $link->query("
        SELECT u.serial_number, u.name, u.surname, b.title, c.code, 
               l.start_date, l.return_date,
               DATE_ADD(l.start_date, INTERVAL 30 DAY) AS end_date, l.return_date
        FROM loan l
        JOIN user u ON l.serial_number = u.serial_number    
        JOIN copy c ON l.copy_code = c.code
        JOIN book b ON c.ISBN = b.ISBN
        WHERE l.return_date IS NULL
        AND DATE_ADD(l.start_date, INTERVAL 30 DAY) >= CURDATE()
        ORDER BY end_date ASC
    ");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $loans[] = $row;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Ricerca Prestiti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="../../assets/style/global.css">
    <style>
        .input-container{
            display: flex;
            flex-direction: row; 
            justify-content: start; 
            align-items: center; 
            gap: 30px;
        }

        form button{
            width: 85px;
            height: 30px; 
        }

        td{background-color: transparent}
    </style>
</head>
<body>
<?php include '../../common/navbar.php'; ?>
<div class="container">
    <h1>Ricerca Prestiti per Data</h1>
    <form method="GET" class="header">
        <div class="input-container">
            <div>
                <label for="start_date">Data Inizio Prestito:</label>
                <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
            </div>

            <div>
                <label for="end_date">Data Fine Prestito:</label>
                <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
            </div> 
        </div>
        
        <button type="submit" class="btn btn-success">Cerca</button>
    </form>
    <?php if ($error): ?>
     <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if ($noLoansMessage): ?>
      <p style="color: darkorange; font-weight: bold;"><?= htmlspecialchars($noLoansMessage) ?></p>
    <?php endif; ?>


    <table>
        <thead>
            <tr>
                <th>Serial Number</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Titolo Libro</th>
                <th>Codice Copia</th>
                <th>Data Inizio</th>
                <th>Data Fine Prestito</th>
                <th>Data Restituzione</th>
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
                        <td><?= explode(" ", $loan['end_date'])[0] ?></td>           
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
