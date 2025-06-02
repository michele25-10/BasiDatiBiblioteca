<?php 

    //connessione
    $link = mysqli_connect("127.0.0.1", "admin", "admin", "library");

    //controlla se è avvenuta la connessione al database:
    if(!$link) { 
        echo "Si è verificato un errore: Non riesco a collegarmi al database <br/>";
        echo "Codice errore: " . mysqli_connect_errno() . "<br/>";
        echo "Messaggio errore: " . mysqli_connect_errno(). "<br/>"; 
        exit; 
    }

?>