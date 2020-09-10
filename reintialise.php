<?php 
    include_once './bdd/connexion.php';
    $type_query = "DELETE FROM recherches WHERE id = 1";
    mysqli_query($conn, $type_query);

    $type_query = "INSERT INTO recherches (id,typer,ville,profession,sexe) VALUES (1,'','','','')";
    mysqli_query($conn, $type_query);
?>