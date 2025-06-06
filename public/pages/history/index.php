<?php
include_once('../../config/connessione.php');

$sql = "SELECT serial_number, name, surname FROM user WHERE 1=1 ORDER BY name, surname ASC";
$result = mysqli_query($link, $sql);
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $serial_number = mysqli_real_escape_string($link, $_GET["serial_number"]);
    
    $sql = "SELECT u.serial_number, u.name, u.surname, c.code, b.title, l.start_date, 
                    DATE_ADD(l.start_date, INTERVAL 30 DAY) AS end_date, l.return_date,
                    CASE
                        WHEN l.return_date IS NOT NULL THEN '#d4edda' 
                        WHEN NOW() > DATE_ADD(l.start_date, INTERVAL 30 DAY) THEN '#f8d7da' 
                        ELSE 'transparent'
                    END AS bg_row
                FROM loan l 
                INNER JOIN user u ON u.serial_number = l.serial_number 
                INNER JOIN copy c ON c.code = l.copy_code
                INNER JOIN book b ON b.ISBN = c.ISBN
                WHERE u.serial_number='$serial_number'
                ORDER BY l.start_date DESC";

    $query = mysqli_query($link, $sql);
    $loan = array(); 
    while ($row = mysqli_fetch_assoc($query)) {
        $loans[] = $row;
    }
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header button{
            text-decoration: none;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    
        .legend {
        margin-top: 20px;
        padding: 10px;
        }

        .legend ul {
            list-style: none;
            padding: 0;
        }

        .legend li {
            margin: 5px 0;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .legend .box {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .legend .red {
            background-color: #f8d7da;
        }

        .legend .green {
            background-color: #d4edda;
        }

        .legend .transparent {
            background-color: transparent;
            border: 1px dashed #ccc;
        }

    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>


    <div class="container">

    <h2>Autori e libri</h2>
        
    
        <form class="header" method="GET" action="">
            <div>        
                <label for="search">Seleziona Autore:</label><br>
                <select name="serial_number" id="search" required>
                    <?php foreach($users as $user): ?>
                        <option value="<?php echo $user["serial_number"]; ?>" 
                            <?php if (!empty($_GET["serial_number"]) && $_GET["serial_number"] == $user["serial_number"]) echo "selected"; ?>>
                            <?php echo $user["serial_number"] . " - " . $user["name"] . " " . $user["surname"]; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn" type="submit">Cerca</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Matricola</th>
                    <th>Nome e Cognome</th>
                    <th>Codice Copia</th>
                    <th>Titolo</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Data Restituzione</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?> 
                    <tr style="background-color: <?php echo $loan["bg_row"]?>">
                        <td><?php echo $loan["serial_number"]?></td>
                        <td><?php echo $loan["name"] . " " . $loan["surname"]?></td>
                        <td><?php echo $loan["code"]?></td>
                        <td><?php echo $loan["title"]?></td>
                        <td><?php echo explode(" ",$loan["start_date"])[0]?></td>
                        <td><?php echo explode(" ",$loan["end_date"])[0]?></td>
                        <td><?php echo $loan["return_date"] ?? '';?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    
    <div class="legend">
        <h4>Legenda colori:</h4>
        <ul>    
            <li><span class="box red"></span> Prestito scaduto e non restituito</li>
            <li><span class="box green"></span> Prestito restituito</li>
            <li><span class="box transparent"></span> Prestito attivo entro i 30 giorni</li>
        </ul>
    </div>

    </div>
</body>
</html>
