<?php
include_once('../../config/connessione.php');

$sql = "SELECT u.serial_number, u.name, u.surname, c.code, b.title, l.start_date, DATE_ADD(l.start_date, INTERVAL 30 DAY) AS end_date, l.return_date
        FROM loan l 
        INNER JOIN user u ON u.serial_number = l.serial_number 
        INNER JOIN copy c ON c.code = l.copy_code
        INNER JOIN book b ON b.ISBN = c.ISBN
        WHERE l.return_date IS NULL
        ORDER BY l.start_date DESC";

$result = mysqli_query($link, $sql);

$loans = array();

while ($row = mysqli_fetch_assoc($result)) {
    $loans[] = $row; // Aggiunge ogni riga come nuovo elemento dell'array
}

mysqli_close($link); 
?>



<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            background-color: transparent !important; 
        }

        th {    
            background-color: #f4f4f4 !important;
        }
    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>

    <div class="container">
        <div class="header">
            <h2>Prestiti Attivi</h2>
            <a href="insert.php">Nuovo</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Matricola</th>
                    <th>Nome e Cognome</th>
                    <th>Codice Copia</th>
                    <th>Titolo</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Opzioni</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?> 
                    <tr>
                        <td><?php echo $loan["serial_number"]?></td>
                        <td><?php echo $loan["name"] . " " . $loan["surname"]?></td>
                        <td><?php echo $loan["code"]?></td>
                        <td><?php echo $loan["title"]?></td>
                        <td><?php echo explode(" ",$loan["start_date"])[0]?></td>
                        <td><?php echo explode(" ",$loan["end_date"])[0]?></td>
                        <td>
                            <form method='POST' action='delete.php' style='display:inline;'>
                                <input type='hidden' name='serial_number' value='<?php echo $loan["serial_number"]; ?>'>
                                <input type='hidden' name='copy_code' value='<?php echo $loan["code"]; ?>'>
                                <input type='hidden' name='start_date' value='<?php echo $loan["start_date"]; ?>'>                               
                                <button class='btn btn-delete' type='submit'>Elimina</button>
                            </form>
                            <form method='POST' action='return.php' style='display:inline;'>
                                <input type='hidden' name='serial_number' value='<?php echo $loan["serial_number"]; ?>'>
                                <input type='hidden' name='copy_code' value='<?php echo $loan["code"]; ?>'>
                                <input type='hidden' name='start_date' value='<?php echo $loan["start_date"]; ?>'>                               
                                <button class='btn btn-return' type='submit'>Riconsegna</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
