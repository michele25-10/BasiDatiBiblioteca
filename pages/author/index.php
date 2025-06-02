<?php
include_once('../../config/connessione.php');

$sql = "SELECT name, surname, birth_date, birth_place FROM author WHERE 1=1";
$result = mysqli_query($link, $sql);
$authors = [];
while ($row = mysqli_fetch_assoc($result)) {
    $authors[] = $row;
}

$books = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? '';
    $surname = $_POST["surname"] ?? '';
    $birth_date = $_POST["birth_date"] ?? '';
    $birth_place = $_POST["birth_place"] ?? '';

    $conditions = [];
    $params = [];
    $types = '';

    // Costruisci dinamicamente condizioni e parametri
    if ($name !== '') {
        $conditions[] = "name LIKE ?";
        $params[] = "%$name%";
        $types .= 's';  // 's' per stringa
    }
    if ($surname !== '') {
        $conditions[] = "surname LIKE ?";
        $params[] = "%$surname%";
        $types .= 's';
    }
    if ($birth_date !== '') {
        $conditions[] = "birth_date = ?";
        $params[] = $birth_date;
        $types .= 's'; 
    }
    if ($birth_place !== '') {
        $conditions[] = "birth_place LIKE ?";
        $params[] = "%$birth_place%";
        $types .= 's';
    }

    $sql = "SELECT name, surname, birth_date, birth_place FROM author";

    if (count($conditions) > 0) {
        $sql .= " WHERE " . implode(" AND ", $conditions);
    }

    $stmt = mysqli_prepare($link, $sql);
    if ($stmt === false) {
        die("Errore nella preparazione della query: " . mysqli_error($link));
    }

    if (count($params) > 0) {
        // mysqli_stmt_bind_param richiede parametri passati per riferimento
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $authors = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $authors[] = $row;
    }

    mysqli_stmt_close($stmt);
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

        .container-btn{
            display: flex;
            align-items: center; 
            justify-content: center;
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
    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>


    <div class="container">

    <h2>Lista Autori</h2>
        
    
        <form class="header" method="POST" action="">
            <div>
                <label for="name">Nome:</label><br>
                <input type="text" id="name" name="name">
            </div>

            <div>
                <label for="surname">Cognome:</label><br>
                <input type="text" id="surname" name="surname">
            </div>

            <div>
                <label for="birth_date">Data di Nascita:</label><br>
                <input type="date" id="birth_date" name="birth_date">
            </div>

            <div>
                <label for="birth_place">Luogo di Nascita:</label><br>
                <input type="text" id="birth_place" name="birth_place">
            </div>
            <div class="container-btn">
                <button class="btn" type="submit">Cerca</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Data di Nascita</th>
                    <th>Luogo di Nascita</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $author): ?> 
                    <tr>
                        <td><?php echo $author["name"]?></td>
                        <td><?php echo $author["surname"]?></td>
                        <td><?php echo $author["birth_date"]?></td>
                        <td><?php echo $author["birth_place"]?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
