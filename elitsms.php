<?php
$files_arr = htmlspecialchars($_GET['id']);
echo json_encode($files_arr);
?>