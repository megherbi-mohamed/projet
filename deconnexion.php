<?php
    session_start();
     if (isset($_SESSION['user'])) {
        session_unset();
        session_destroy();
        ob_start();
        header("location: index.php");
    }
?>