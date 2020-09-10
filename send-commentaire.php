<?php
session_start();
include_once './bdd/connexion.php';
$commentaire= $_POST['commentaire'];
$date = date("Y-m-d H:i:s");
if ($commentaire !== '') {
    $insrt_commentaire_query = "INSERT INTO commentaires (id_user,id_user_cmnt,commentaire,date_cmnt) VALUE ({$_SESSION['user-info']},'{$_SESSION['user']}','$commentaire','$date')";
    if(mysqli_query($conn,$insrt_commentaire_query)){
        $cmnt_query = "SELECT * FROM commentaires WHERE id_cmnt IN (SELECT max(id_cmnt) FROM commentaires WHERE id_user={$_SESSION['user-info']})";
        $cmnt_result = mysqli_query($conn, $cmnt_query);
        $cmnt_row = mysqli_fetch_assoc($cmnt_result);

        $id_user_cmnt_query = "SELECT nom_user FROM utilisateurs WHERE id_user = '{$cmnt_row['id_user_cmnt']}'";
        $id_user_cmnt_result = mysqli_query($conn, $id_user_cmnt_query);
        $id_user_cmnt_row = mysqli_fetch_assoc($id_user_cmnt_result);

        echo "<div class='commentaires'>
                <p>".$cmnt_row['commentaire']."</p>
                <p>".$cmnt_row['date_cmnt']."<span>".$id_user_cmnt_row['nom_user']."</span></p>
              </div>";
    }else{
        echo 0;
    }
}
?>