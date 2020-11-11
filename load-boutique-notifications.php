<?php
session_start();
include_once './bdd/connexion.php';
$id_session_btq = htmlspecialchars($_POST['id_btq']);
$get_session_btq_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session_btq' OR id_user_1 = '$id_session_btq' OR id_user_2 = '$id_session_btq' 
                                            OR id_user_3 = '$id_session_btq' OR id_user_4 = '$id_session_btq' OR id_user_5 = '$id_session_btq'");
$get_session_btq_query->execute();
$get_session_btq_row = $get_session_btq_query->fetch(PDO::FETCH_ASSOC);
$id_btq = $get_session_btq_row['id_user'];
// if (isset($_SESSION['user'])) {
    $id_session = htmlspecialchars($_SESSION['user']);
    $get_session_id_query = $conn->prepare("SELECT id_user FROM gerer_connexion WHERE id_user = '$id_session' OR id_user_1 = '$id_session' OR id_user_2 = '$id_session' 
                                            OR id_user_3 = '$id_session' OR id_user_4 = '$id_session' OR id_user_5 = '$id_session'");
    $get_session_id_query->execute();
    $get_session_id_row = $get_session_id_query->fetch(PDO::FETCH_ASSOC);
    $user_session_query = $conn->prepare("SELECT * FROM utilisateurs WHERE id_user = {$get_session_id_row['id_user']}");
    $user_session_query->execute();
    if ($user_session_query->rowCount() > 0) {
        $row = $user_session_query->fetch(PDO::FETCH_ASSOC);
        $id_user = $row['id_user'];
    }
    $get_btq_ntf_query = $conn->prepare("SELECT * FROM publications_notifications WHERE id_recever_ntf = $id_btq AND id_sender_ntf != $id_btq AND id_sender_ntf != $id_user ORDER BY id_ntf DESC");
// }
// else{
//     $get_btq_ntf_query = $conn->prepare("SELECT * FROM publications_notifications WHERE id_recever_ntf = $id_btq AND id_sender_ntf != $id_btq ORDER BY id_ntf DESC");
// }
$get_btq_ntf_query->execute();
$get_ntf_num = $get_btq_ntf_query->rowCount();
if ($get_ntf_num > 0) {
?>
<div class="boutique-notification">
    <?php 
    $i=0;
    while($get_btq_ntf_row = $get_btq_ntf_query->fetch(PDO::FETCH_ASSOC)){
    $i++;

    $get_sender_info_query = $conn->prepare("SELECT nom_user,img_user FROM utilisateurs WHERE id_user = {$get_btq_ntf_row['id_sender_ntf']}");
    $get_sender_info_query->execute();
    $get_sender_info_row = $get_sender_info_query->fetch(PDO::FETCH_ASSOC);
    
    $get_prd_media_query =  $conn->prepare("SELECT media_url FROM produits_media WHERE id_prd = {$get_btq_ntf_row['id_pub']} LIMIT 1");
    $get_prd_media_query->execute();
    $get_prd_media_row = $get_prd_media_query->fetch(PDO::FETCH_ASSOC);

    $new_ntf = '';
    if ($get_btq_ntf_row['etat_ntf'] == 1) {
        $new_ntf = 'background:#ecedee"';
    }
    ?>
    <?php 
    if ($get_btq_ntf_row['type_ntf'] == 'abonnement') {
    ?>
    <input type="hidden" id="id_abn_user_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_sender_ntf'] ?>">
    <input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_ntf'] ?>">
    <div class="notification-btq" id="notification_abn_<?php echo $i ?>">
        <div class="notification-btq-container" style="grid-template-columns: 20% 80%; <?php echo $new_ntf ?>">
            <?php if ($get_sender_info_row['img_user'] == '') { ?>
            <img src="./images/profile.png" alt="">
            <?php }else{ ?>
            <img src="<?php echo $get_sender_info_row['img_user'] ?>" alt="">
            <?php } ?>
            <div class="notification-btq-message">
                <p><?php echo $get_sender_info_row['nom_user'].' '.$get_btq_ntf_row['message_ntf']; ?></p>
                <span><?php echo $get_btq_ntf_row['date_ntf'] ?></span>
            </div>
        </div>
    </div>
    <?php } else if ($get_btq_ntf_row['type_ntf'] == 'commentaire') { ?>
    <input type="hidden" id="id_prd_ntf_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_pub'] ?>">
    <input type="hidden" id="id_ntf_<?php echo $i ?>" value="<?php echo $get_btq_ntf_row['id_ntf'] ?>">
    <div class="notification-btq" id="notification_cmnt_<?php echo $i ?>">
        <div class="notification-btq-container" id="notification_btq_container_<?php echo $i ?>" style="<?php echo $new_ntf ?>">
            <?php if ($get_sender_info_row['img_user'] == '') { ?>
            <img src="./images/profile.png" alt="">
            <?php }else{ ?>
            <img src="<?php echo $get_sender_info_row['img_user'] ?>" alt="">
            <?php } ?>
            <div class="notification-btq-message">
                <p><?php echo $get_sender_info_row['nom_user'].' '.$get_btq_ntf_row['message_ntf']; ?></p>
                <span><?php echo $get_btq_ntf_row['date_ntf'] ?></span>
            </div>
            <div class="notification-btq-image">
                <img src="<?php echo $get_prd_media_row['media_url'] ?>" alt="">
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<?php } else { ?>
<div class="empty-msg-ntf">
    <p>Vous n'avez auccune notification</p>
</div>
<?php } ?>
<script>
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
                $('.btq-new-ntf').load('load-btq-new-ntf.php?btq='+<?php echo $id_btq ?>);
                setTimeout(() => {
                    window.location = 'utilisateur/'+idAbnUser;
                }, 500);
            }
        }
    });
});
    
$('[id^="notification_cmnt_"]').click(function(e){
    var id = $(this).attr('id').split('_')[2];
    var idAbnUser = $('#id_abn_user_'+id).val();
    var idPrd = $('#id_prd_ntf_'+id).val();
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
            if(response != 0){
                $('.btq-new-ntf').load('load-btq-new-ntf.php?btq='+<?php echo $id_btq ?>);
                $('#notification_btq_container_'+id).css('background','#ffffff');
                laodProductContent(idPrd);
                setTimeout(() => {
                    $("#overview_product_button").removeClass('product-details-bottom-top-active');
                    $("#informations_product_button").removeClass('product-details-bottom-top-active');
                    $("#comment_product_button").addClass('product-details-bottom-top-active');

                    $("#overview_product").removeClass('product-details-bottom-bottom-active');
                    $("#informations_product").removeClass('product-details-bottom-bottom-active');
                    $("#comments_product").addClass('product-details-bottom-bottom-active');
                    $("#informations_product").css('display','');

                    $('.product-details').animate({
                        scrollTop: $(".product-details-bottom-top").offset().top
                    }, 1000);
                }, 500);
            }
        }
    });
});

function laodProductContent (idPrd) {
    var fd = new FormData();
    var idBtq = <?php echo $id_btq ?>;
    fd.append('id_btq',idBtq);
    fd.append('id_prd',idPrd);
    $.ajax({
        url: 'load-gb-product-content.php',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function(){
            $("body").addClass('body-after');
            if (windowWidth > 768) {
                $(".product-details").show();
            }else{
                $(".product-details").css('transform','translateX(0)');
            }
            $("#loader_product").show();
        },
        success: function(response){
            if(response != 0){
                $('.product-details-container').append(response);
            }
        },
        complete: function(){
            $("#loader_product").hide();
        }
    });
}
</script>