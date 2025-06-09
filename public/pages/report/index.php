<?php
    include_once('../../config/connessione.php');

    $sql = "SELECT publication_year, count(ISBN) as count FROM book GROUP BY publication_year";
    $result = mysqli_query($link, $sql);
    $books = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    $sql = "SELECT a.name, a.surname, a.birth_date, a.birth_place, count(ba.ISBN) as count_book
            FROM author a
            INNER JOIN book_author ba on ba.author_name=a.name 
                AND ba.author_surname=a.surname
                AND ba.author_birth_date=a.birth_date
                AND ba.author_birth_place=a.birth_place
            GROUP BY a.name, a.surname, a.birth_date, a.birth_place";
    $result = mysqli_query($link, $sql);
    $authors = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $authors[] = $row;
    }


    if (!empty($_GET["start_date"]) && !empty($_GET["end_date"])){
        $start_date = mysqli_real_escape_string($link, $_GET["start_date"]);
        $end_date = mysqli_real_escape_string($link, $_GET["end_date"]);
        
        $sql = "SELECT c.department_name, COUNT(*) AS count_loan
                    FROM loan l
                    INNER JOIN copy c ON c.code = l.copy_code
                    WHERE l.start_date BETWEEN '$start_date' AND '$end_date'
                    GROUP BY c.department_name";

        $query = mysqli_query($link, $sql);
        $loans = array(); 
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
    </style>
</head>
<body>
    <?php include '../../common/navbar.php'; ?>


    <div class="container">
        <h2>Statistiche</h2>

        <h3>Numero di libri pubblicati l'anno</h3>
        <table>
            <thead>
                <tr>
                    <th>Anno di pubblicazione</th>
                    <th>Conteggio dei libri</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?> 
                    <tr>
                        <td><?php echo $book["publication_year"]?></td>
                        <td><?php echo $book["count"]?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <hr/>

        <h3>Numero di prestiti effettuati suddivisi per succursale</h3>

        <form class="header" method="GET" action="">
            <div>
                <label for="start_date">Data di inizio:</label><br>
                <input type="date" id="start_date" name="start_date" 
                    value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>">
            </div>
            <div>
                <label for="end_date">Data di fine:</label><br>
                <input type="date" id="end_date" name="end_date" 
                    value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>">
            </div>
            <button class="btn" type="submit">Cerca</button>
        </form>


        <table>
            <thead>
                <tr>
                    <th>Nome del dipartimento</th>
                    <th>Conteggio dei prestiti</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?> 
                    <tr>
                        <td><?php echo $loan["department_name"]?></td>
                        <td><?php echo $loan["count_loan"]?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        
        <hr/>

        <h3>Numero di libri pubblicati per autore:</h3>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Data di nascita</th>
                    <th>Luogo di nascita</th>
                    <th>Numero di libri pubblicati</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($authors as $author): ?> 
                    <tr>
                        <td><?php echo $author["name"]?></td>
                        <td><?php echo $author["surname"]?></td>
                        <td><?php echo $author["birth_date"]?></td>
                        <td><?php echo $author["birth_place"]?></td>
                        <td><?php echo $author["count_book"]?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    
    </div>
</body>
</html>
