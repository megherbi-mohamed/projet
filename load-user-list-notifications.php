<?php 
session_start();
include_once './bdd/connexion.php';
$id_user = htmlspecialchars($_POST['id_user']);
$get_ntf_query = $conn->prepare("SELECT * FROM publications_notifications WHERE (id_recever_ntf = $id_user AND id_sender_ntf != $id_user) OR (id_sender_ntf IN (SELECT id_abn_user FROM abonnes WHERE id_user = $id_user) AND (type_ntf = 'publication' OR type_ntf = 'produit') AND id_recever_ntf IN (SELECT id_abn_user FROM abonnes WHERE id_user = $id_user)) ORDER BY id_ntf DESC LIMIT 10");
$get_ntf_query->execute();
if ($get_ntf_query->rowCount() > 0) {
$i=0;
while ($get_ntf_row = $get_ntf_query->fetch(PDO::FETCH_ASSOC)) {
$i++;
$get_sender_info_query = $conn->prepare("SELECT nom_user AS nom,img_user AS img FROM utilisateurs WHERE id_user = {$get_ntf_row['id_sender_ntf']} AND type_user IS NOT NULL 
                                        UNION SELECT nom_btq AS nom, logo_btq AS img FROM boutiques WHERE id_btq = {$get_ntf_row['id_sender_ntf']}");
$get_sender_info_query->execute();
$get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);

$get_pub_media_query =  $conn->prepare("SELECT media_url FROM publications_media WHERE id_pub = {$get_ntf_row['id_pub']} LIMIT 1");
$get_pub_media_query->execute();
$get_pub_media_row = $get_pub_media_query->fetch(PDO::FETCH_ASSOC);

$get_prd_media_query =  $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = {$get_ntf_row['id_pub']} LIMIT 1");
$get_prd_media_query->execute();
$get_prd_media_row = $get_prd_media_query->fetch(PDO::FETCH_ASSOC);

$new_ntf = '';
if ($get_ntf_row['etat_ntf'] == 1) {
    $new_ntf = 'background:#ecedee';
}
$new_ntf1 = '';
$id = ','.$id_user.',';
$vu_ntf = $get_ntf_row['vu_ntf'];
if (($get_ntf_row['type_ntf'] == 'publication' || $get_ntf_row['type_ntf'] == 'produit') && strpos($vu_ntf, $id) === false) {
    $new_ntf1 = 'background:#ecedee';
}
if ($get_ntf_row['type_ntf'] == 'like' || $get_ntf_row['type_ntf'] == 'commentaire') {
?>
<input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_ntf'] ?>">
<input type="hidden" id="id_pub_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_pub'] ?>">
<div class="notification" id="notification_<?php echo $i ?>" style="<?php echo $new_ntf ?>">
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div class="notification-message">
        <p><?php echo $get_sender_info_row['nom'].' '.$get_ntf_row['message_ntf']; ?></p>
        <span><?php echo $get_ntf_row['date_ntf'] ?></span>
    </div>
    <div class="notification-image">
        <img src="<?php echo $get_pub_media_row['media_url'] ?>" alt="">
    </div>
</div>
<?php } else if ($get_ntf_row['type_ntf'] == 'publication'){ ?>
<input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_ntf'] ?>">
<input type="hidden" id="id_pub_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_pub'] ?>">
<input type="hidden" id="id_user_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_sender_ntf'] ?>">
<div class="notification" id="notification_pub_<?php echo $i ?>" style="<?php echo $new_ntf1 ?>">
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div class="notification-message">
        <p><?php echo $get_sender_info_row['nom'].' '.$get_ntf_row['message_ntf']; ?></p>
        <span><?php echo $get_ntf_row['date_ntf'] ?></span>
    </div>
    <div class="notification-image">
        <img src="<?php echo $get_pub_media_row['media_url'] ?>" alt="">
    </div>
</div>
<?php } else if ($get_ntf_row['type_ntf'] == 'produit'){ ?>
<input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_ntf'] ?>">
<input type="hidden" id="id_prd_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_pub'] ?>">
<input type="hidden" id="id_btq_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_sender_ntf'] ?>">
<div class="notification" id="notification_prd_<?php echo $i ?>" style="<?php echo $new_ntf1 ?>">
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div class="notification-message">
        <p><?php echo $get_sender_info_row['nom'].' '.$get_ntf_row['message_ntf']; ?></p>
        <span><?php echo $get_ntf_row['date_ntf'] ?></span>
    </div>
    <div class="notification-image">
        <img src="<?php echo $get_prd_media_row['media_url'] ?>" alt="">
    </div>
</div>
<?php } else { ?>
<input type="hidden" id="id_abn_user_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_sender_ntf'] ?>">
<input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_ntf_row['id_ntf'] ?>">
<div class="notification" id="notification_abn_<?php echo $i ?>" style="grid-template-columns: 20% 80%; <?php echo $new_ntf ?>">
    <?php if ($get_sender_info_row['img'] == '') { ?>
    <img src="./images/profile.png" alt="">
    <?php }else{ ?>
    <img src="<?php echo $get_sender_info_row['img'] ?>" alt="">
    <?php } ?>
    <div class="notification-message">
        <p><?php echo $get_sender_info_row['nom'].' '.$get_ntf_row['message_ntf']; ?></p>
        <span><?php echo $get_ntf_row['date_ntf'] ?></span>
    </div>
</div>
<?php } ?>
<?php } ?>
<div style="color:#000;text-decoration:none;margin-top:10px;text-align:center;width:100%;font-size:.9rem;font-weight:bold">
    <a href="profile-parametres/notifications">Afficher toutes les notifications</a>
</div>
<?php 
} 
else{
    echo '<p style="font-size:.85rem; text-align:center;">Accune notification</p>';
}
?>
<script>
$('[id^="notification_"]').click(function(e){
    var pathName = window.location.pathname;
    var id = $(this).attr('id').split('_')[1];
    var fd = new FormData();
    var id_ntf = $('#id_ntf_'+id).val();
    fd.append('id_ntf',id_ntf);
    $.ajax({
        url: 'update-user-notification.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            if(response != 0){
                $('.user-new-ntf').load('load-user-new-ntf.php');
            }
        }
    });
    var idPub = $('#id_pub_ntf_'+id).val();
    var idUser = $('#id_user_porfile').val();
    if (pathName == '/projet/utilisateur/'+idUser){
        if (windowWidth < 768) { 
            $('.user-list-notifications').css('transform','');
            setTimeout(() => {
                var fd = new FormData();
                fd.append('id_user',idUser);
                fd.append('id_pub',idPub);
                $.ajax({
                    url: 'load-user-publication-notification.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('.user-profile-middle-container').empty();
                        $("#loader_publications").show();
                    },
                    success: function(response){
                        $('.user-profile-middle-container').append(response);
                    },
                    complete: function(){
                        $("#loader_publications").hide();
                        $("html, body").animate({ scrollTop: $(document).height() }, 2000); 
                    }
                });
            }, 400);
        }
        else{
            var fd = new FormData();
            fd.append('id_user',idUser);
            fd.append('id_pub',idPub);
            $.ajax({
                url: 'load-user-publication-notification.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.user-profile-middle-container').empty();
                    $("#loader_publications").show();
                },
                success: function(response){
                    $('.user-profile-middle-container').append(response);
                },
                complete: function(){
                    $("#loader_publications").hide();
                    $('.user-list-notifications').hide();
                }
            });
        }
    }
    else{
        if (windowWidth < 768) {
            $('.user-list-notifications').css('transform','');
            setTimeout(() => {
                window.location = 'utilisateur/'+idUser+'/'+idPub;
            }, 400);
        }
        else{
            window.location = 'utilisateur/'+idUser+'/'+idPub;
        }
    }
});

$('[id^="notification_abn_"]').click(function(e){
    var id = $(this).attr('id').split('_')[2];
    var idAbnUser = $('#id_abn_user_'+id).val();
    var fd = new FormData();
    var id_ntf = $('#id_ntf_'+id).val();
    fd.append('id_ntf',id_ntf);
    $.ajax({
        url: 'update-user-notification.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            if(response != 0){
                $('.user-new-ntf').load('load-user-new-ntf.php');
            }
        }
    });
    if (windowWidth < 768) {
        $('.user-list-notifications').css('transform','');
        setTimeout(() => {
            window.location = 'utilisateur/'+idAbnUser;
        }, 400);
    }
    else{
        window.location = 'utilisateur/'+idAbnUser;
    }
});

$('[id^="notification_pub_"]').click(function(e){
    var id = $(this).attr('id').split('_')[2];
    var idPub = $('#id_pub_ntf_'+id).val();
    var idUser = $('#id_user_ntf_'+id).val();
    var fd = new FormData();
    var id_ntf = $('#id_ntf_'+id).val();
    fd.append('id_ntf',id_ntf);
    $.ajax({
        url: 'update-user-notification.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            if(response != 0){
                $('.user-new-ntf').load('load-user-new-ntf.php');
            }
        }
    });
    if (windowWidth < 768) {
        $('.user-list-notifications').css('transform','');
        setTimeout(() => {
            window.location = 'utilisateur/'+idUser+'/'+idPub;
        }, 400);
    }
    else{
        window.location = 'utilisateur/'+idUser+'/'+idPub;
    }
});

$('[id^="notification_prd_"]').click(function(e){
    var id = $(this).attr('id').split('_')[2];
    var idPrd = $('#id_prd_ntf_'+id).val();
    var idBtq = $('#id_btq_ntf_'+id).val();
    var fd = new FormData();
    var id_ntf = $('#id_ntf_'+id).val();
    fd.append('id_ntf',id_ntf);
    $.ajax({
        url: 'update-user-notification.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            console.log(response);
            if(response != 0){
                $('.user-new-ntf').load('load-user-new-ntf.php');
            }
        }
    });
    if (windowWidth < 768) {
        $('.user-list-notifications').css('transform','');
        setTimeout(() => {
            window.location = 'boutique/'+idBtq+'/'+idPrd;
        }, 400);
    }
    else{
        window.location = 'boutique/'+idBtq+'/'+idPrd;
    }
});

</script>