<?php 
include_once './bdd/connexion.php'; 
$id_user = htmlspecialchars($_POST['id_user']);
$id_pub = htmlspecialchars($_POST['id_pub']);

$publication_comment_query = $conn->prepare("SELECT * FROM commentaire_publication WHERE id_pub = '$id_pub'"); 
$publication_comment_query->execute();

while($publication_comment_row = $publication_comment_query->fetch(PDO::FETCH_ASSOC)){
$publication_comment_user_query = $conn->prepare("SELECT img_user,nom_user FROM utilisateurs WHERE id_user = '{$publication_comment_row["id_user"]}'");
$publication_comment_user_query->execute();
$publication_comment_user_row = $publication_comment_user_query->fetch(PDO::FETCH_ASSOC);
?>
<?php if ($publication_comment_user_row['img_user'] != '') { ?>
    <img src="./<?php echo $publication_comment_user_row['img_user'] ?>" alt="">
<?php }else if($publication_comment_user_row['img_user'] == ''){ ?>
    <img src="./boutique-logo/logo.png" alt="">
<?php } ?>
<div>
    <h4><?php echo $publication_comment_user_row['nom_user'] ?></h4>
    <p><?php echo $publication_comment_row['commentaire_text'] ?></p>
</div>
<?php } ?>
</div>