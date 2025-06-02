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
    $search = explode(";", $_POST["search"]);

    $name = mysqli_real_escape_string($link, $search[0]);
    $surname = mysqli_real_escape_string($link, $search[1]);
    $birth_date = mysqli_real_escape_string($link, $search[2]);
    $birth_place = mysqli_real_escape_string($link, $search[3]);

    $sql = "SELECT b.ISBN, b.title, b.publication_year, b.language
            FROM author a 
            INNER JOIN book_author ba ON ba.author_name = a.name 
                                      AND ba.author_surname = a.surname 
                                      AND ba.author_birth_date = a.birth_date
                                      AND ba.author_birth_place = a.birth_place
            INNER JOIN book b ON b.ISBN = ba.ISBN
            WHERE a.name = '$name'
              AND a.surname = '$surname'
              AND a.birth_date = '$birth_date'
              AND a.birth_place = '$birth_place'
            ORDER BY b.publication_year DESC";

    $query = mysqli_query($link, $sql);

    if (!$query) {
        die("Errore query: " . mysqli_error($link));
    }

    while ($row = mysqli_fetch_assoc($query)) {
        $books[] = $row;
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
    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>


    <div class="container">

    <h2>Autori e libri</h2>
        
    
        <form class="header" method="POST" action="">
            <div>        
                <label for="search">Seleziona Autore:</label><br>
                <select name="search" id="search" required>
                    <?php foreach($authors as $author): ?>
                        <option value="<?php echo $author["name"].";".$author["surname"].";".$author["birth_date"].";".$author["birth_place"];?>">
                            <?php echo $author["name"]." ".$author["surname"]." - ".$author["birth_date"]." - ".$author["birth_place"];?>                        
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button class="btn" type="submit">Cerca</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Titolo</th>
                    <th>Anno di pubblicazione</th>
                    <th>Lingua</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?> 
                    <tr>
                        <td><?php echo $book["ISBN"]?></td>
                        <td><?php echo $book["title"]?></td>
                        <td><?php echo $book["publication_year"]?></td>
                        <td><?php echo $book["language"]?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
