<?php 
session_start();
include_once './bdd/connexion.php'; 
$user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['user']);
$user_session_query->execute();
$row = $user_session_query->fetch(PDO::FETCH_ASSOC);

$id_user = htmlspecialchars($_POST['id_user']);
$id_pub = htmlspecialchars($_POST['id_pub']);
$id = htmlspecialchars($_POST['id']);

$publication_comment_query = $conn->prepare("SELECT * FROM commentaire_publication WHERE id_pub = '$id_pub' ORDER BY id_c DESC"); 
$publication_comment_query->execute();

if ($publication_comment_query->rowCount() > 0) {
while($publication_comment_row = $publication_comment_query->fetch(PDO::FETCH_ASSOC)){
$publication_comment_user_query = $conn->prepare("SELECT img_user,nom_user FROM utilisateurs WHERE id_user = '{$publication_comment_row["id_user"]}'");
$publication_comment_user_query->execute();
$publication_comment_user_row = $publication_comment_user_query->fetch(PDO::FETCH_ASSOC);
?>
<div class="publicaiton-comment">
<?php if ($publication_comment_user_row['img_user'] != '') { ?>
    <img src="./<?php echo $publication_comment_user_row['img_user'] ?>" alt="">
<?php }else if($publication_comment_user_row['img_user'] == ''){ ?>
    <img src="./boutique-logo/logo.png" alt="">
<?php } ?>
    <div>
        <h4><?php echo $publication_comment_user_row['nom_user'] ?></h4>
        <p><?php echo $publication_comment_row['commentaire_text'] ?></p>
    </div>
</div>
<?php } ?>
<?php } else { 
    '<p style="font-size:.85rem; text-align:center;">Accun Commentaire</p>';
} ?>
<input type="hidden" id="id_pub" value="<?php echo $id_pub ?>">
