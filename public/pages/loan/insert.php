<?php
    include_once('../../config/connessione.php');

    $sql = "SELECT u.serial_number, u.name, u.surname 
                FROM user u 
                ORDER BY u.name, u.surname ASC";

    $result = mysqli_query($link, $sql);
    $users = array(); 
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row; // Aggiunge ogni riga come nuovo elemento dell'array
    }


    $sql = "SELECT c.code, c.ISBN, b.title, c.department_name
                FROM copy c
                INNER JOIN book b on b.ISBN=c.ISBN 
                WHERE NOT EXISTS (
                    SELECT 1 
                    FROM loan l 
                    WHERE l.copy_code = c.code
                )
                ORDER BY c.code ASC";

    $result = mysqli_query($link, $sql);
    $books = array(); 
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row; // Aggiunge ogni riga come nuovo elemento dell'array
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $serial_number = $_POST["serial_number_user"];
        $copy_code = $_POST["copy_code"];

        $error_insert = ""; 
        if(!isset($serial_number) || !isset($copy_code)) {
            $error_insert = "Errore di validazione"; 
            exit; 
        }

        $sql = "INSERT INTO loan(serial_number, copy_code)
                VALUES ('$serial_number', '$copy_code')";     

        $query = mysqli_query($link, $sql); 
        if(!$query){
            $error_insert = "Si è verificato un errore: " . mysqli_error($link); 
            exit; 
        } else {
            header("Location: index.php");
            exit;
        }

        mysqli_close($link); 
    }

    mysqli_close($link); 
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" href="../../assets/style/global.css">
</head>
<body>
    <?php include '../../common/navbar.php'; ?>

    <div class="container">
        <h1>Crea un nuovo prestito</h1>

        <form method="POST" action="">
            <label for="serial_number_user">Serial Number Utente:</label><br>
            <select name="serial_number_user" id="serial_number_user" required>
                <?php foreach($users as $value): ?>
                <option value="<?php echo $value["serial_number"];?>">
                    <?php echo $value["serial_number"] . " - " . $value["name"] . " " . $value["surname"];?>
                </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="copy_code">Copy Code:</label><br>
            <select name="copy_code" id="copy_code" required>
                <?php foreach($books as $value): ?>
                <option value="<?php echo $value["code"];?>">
                    <?php echo $value["code"] . " - " . $value["title"] . " - " . $value["department_name"];?>
                </option>
                <?php endforeach; ?>
            </select><br><br>

            <button type="submit" style="background-color: #28a745; color: #fff">Invia</button>

            <p class="error-daneger"><?php echo $error_insert; ?></p>
        </form>
    </div>
</body>
</html>
