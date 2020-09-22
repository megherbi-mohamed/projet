<?php
session_start();
if (isset($_SESSION['user'])) {
    session_unset();
    session_destroy();
    ob_start();
    header("location: index.php");
}
if (isset($_SESSION['btq'])) {
    session_unset();
    session_destroy();
    ob_start();
    header("location: gestion-boutique-connexion.php");
}
?>