<?php
session_start();
include_once './bdd/connexion.php';
$date = date("Y-m-d H:i:s");
$reply_commentaire = $_POST['reply_commentaire'];
$id_commentaire = $_POST['id_commentaire'];
if ($reply_commentaire !== '') {
    $insrt_reply_query = "INSERT INTO replys (id_cmnt,reply_commentaire,temp_reply,id_user) VALUE ('$id_commentaire','$reply_commentaire','$date',{$_SESSION['user']})";
    if(mysqli_query($conn,$insrt_reply_query)){
        $cmnt_query = "SELECT * FROM commentaires WHERE id_cmnt= '$id_commentaire' AND id_user={$_SESSION['user']}";
        $cmnt_result = mysqli_query($conn, $cmnt_query);
        $cmnt_row = mysqli_fetch_assoc($cmnt_result);

        $id_user_cmnt_query = "SELECT nom_user FROM utilisateurs WHERE id_user = '{$cmnt_row['id_user_cmnt']}'";
        $id_user_cmnt_result = mysqli_query($conn, $id_user_cmnt_query);
        $id_user_cmnt_row = mysqli_fetch_assoc($id_user_cmnt_result);

        $reply_query = "SELECT * FROM replys WHERE id_reply IN (SELECT max(id_reply) FROM replys WHERE id_user = {$_SESSION['user']} AND id_cmnt = {$cmnt_row['id_cmnt']})";
        $reply_result = mysqli_query($conn, $reply_query);
        $reply_row = mysqli_fetch_assoc($reply_result);

        echo "<div class='replys'>
                <p>".$reply_row['reply_commentaire']."</p>
                <p>".$reply_row['temp_reply']."</p>
              </div>";
    }else{
        echo 0;
    }
}
?>