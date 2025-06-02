<?php
    include_once('../../config/connessione.php');

    $serial_number = mysqli_real_escape_string($link, $_POST["serial_number"]);
    $copy_code = mysqli_real_escape_string($link, $_POST["copy_code"]);
    $start_date = mysqli_real_escape_string($link, $_POST["start_date"]);

    $sql = "UPDATE loan set return_date = NOW()  
            WHERE serial_number = '$serial_number' 
            AND copy_code = '$copy_code' 
            AND start_date = '$start_date'";

    $query = mysqli_query($link, $sql); 

    if (!$query) {
        $error = "Si è verificato un errore: " . mysqli_error($link); 
    } else {
        header("Location: index.php");
        exit;
    }

    mysqli_close($link); 
?> 

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="../../assets/style/global.css">
</head>
<body>
    <?php include '../../common/navbar.php'; ?>

    <div class="container">
            <p class="error-daneger"><?php echo $error; ?></p>
        </form>
    </div>
</body>
</html>
