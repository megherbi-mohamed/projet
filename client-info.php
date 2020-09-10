<input style="display:none" id="input_user_checkbox" type="checkbox">    
<input style="display:none" type="submit" id="check_btn">
<div style="display:none" id="listen_input_filename_image">
    <p style="display:none" id="listen_input_image">0</p>
</div>
<div style="display:none" id="listen_input_filename_video">
    <p style="display:none" id="listen_input_video">0</p>
</div>
<input style="display:none" type="file" id ="video" name="video" multiple="multiple" accept="video/*" />
<input style="display:none" id="but_upload_video" type="submit">
<input style="display:none" type="hidden" id="latitude_user" value="<?php echo $row['latitude_user']; ?>">
<input style="display:none" type="hidden" id="longitude_user" value="<?php echo $row['longitude_user']; ?>">

<div class="user-profile-left-centent">
    <div id="left_updated_img"> 
        <img id="user_img" src="<?php if($user_info_row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$user_info_row['img_user'];}?>" alt="logo">
        <p style="margin-top:5px" id="user_name"><?php echo $user_info_row['nom_user']?></p>
        <br>
        <form action="./utilisateur-info.php?id_user=<?php echo $_GET['id_user']; ?>" method="post">
            <button type="submit" name="send_message">Envoyer un message <i class="fab fa-facebook-messenger"></i></button>
        </form>
    </div>
    <?php 
        $num_ajt_ofr_query = "SELECT * FROM recrutements WHERE id_user = {$user_info_row['id_user']}";    
        $num_ajt_ofr_result = mysqli_query($conn,$num_ajt_ofr_query);
        $num_ajt_ofr = mysqli_num_rows($num_ajt_ofr_result);

        $num_trm_ofr_query = "SELECT * FROM recrutements WHERE id_user = {$user_info_row['id_user']} AND termine = 0";    
        $num_trm_ofr_result = mysqli_query($conn,$num_trm_ofr_query);
        $num_trm_ofr = mysqli_num_rows($num_trm_ofr_result);

        $num_encrs_ofr = $num_ajt_ofr - $num_trm_ofr;
    ?>
    <div class="user-offres-informations">
        <p>Offres ajoutés<span><?php echo $num_ajt_ofr; ?></span></p>
        <p>Offres terminés<span><?php echo $num_trm_ofr; ?></span></p>
        <p>Offres en cours<span><?php echo $num_encrs_ofr; ?></span></p>
        <p>Voire les offres en cours<a href="recrutements.php?ofr=<?php echo $user_info_row['id_user'] ?>">Voire ..</a></p>
    </div>
    <!-- <div id="user_informations">
        <p>Téléphone : <span><?php echo $user_info_row['tlph_user']; ?></span></p>
        <p>Ville : <span><?php echo $user_info_row['ville']; ?></span></p>
        <p>Pays : <span><?php echo $user_info_row['pays']; ?></span></p>
    </div> -->
</div>
<div class="user-profile-middle-centent">
    <div class="user-profile-middle-container">
        <div>
            <h4>Offres terminés</h4>
        </div>
        <?php
            $i = 0;
            $user_activity_query = "SELECT * FROM activites WHERE id_user_r = {$_GET['id_user']} ORDER BY id_activity DESC";
            $user_activity_result = mysqli_query($conn, $user_activity_query);
            while ($user_activity_row = mysqli_fetch_assoc($user_activity_result)) { 
            $i++;  
            ?>
            <div class="user-activity">
                <div class="user-activity-top">
                    <?php
                        $user_dmnd_details_query = "SELECT img_user FROM utilisateurs WHERE id_user = {$user_activity_row['id_user']}"; 
                        $user_dmnd_details_result = mysqli_query($conn, $user_dmnd_details_query);
                        $user_dmnd_details_row = mysqli_fetch_assoc($user_dmnd_details_result);
                    ?>
                    <img src="<?php if($user_dmnd_details_row['img_user']==''){echo'./images/profile.jpg';}else{echo './'.$user_dmnd_details_row['img_user'];}?>" alt="logo">
                </div>
                <div class="user-activity-middle" id="user_activity_middle_<?php echo $i; ?>">
                    <form class="modify-activity-form" id="modify_activity_<?php echo $i; ?>_form">
                        <input type="hidden" id="action_m_activity_<?php echo $i; ?>" value="modify_activity">
                        <input type="hidden" id="id_m_activity_<?php echo $i; ?>" value="<?php echo $user_activity_row['id_activity']; ?>">
                        <input type="text" id="modify_lieu_<?php echo $i; ?>" value="<?php echo $user_activity_row['lieu']; ?>">
                        <textarea id="modify_description_<?php echo $i; ?>" placeholder="Description ..."><?php echo $user_activity_row['description']; ?></textarea>
                    </form>
                    <?php $displayDescription = ''; if ($user_activity_row['description'] == '') { $displayDescription = 'display: none'; }?>
                    <p style="<?php echo $displayDescription ?>"><?php echo $user_activity_row['description']; ?></p>
                    <?php if ($user_activity_row['video'] != '') { ?>
                    <div class="user-activity-video" id="user_activity_video_<?php echo $i; ?>">
                        <video controls><source src="<?php echo $user_activity_row['video']; ?>" ></video>
                    </div>
                    <?php }else{ ?>
                        <?php 
                    $displayDiv = '';
                    $displayImg2 = 'display: none';
                    $displayImg3 = 'display: none';
                    $displayImg4 = 'display: none';
                    $displayFirstI = '';
                    if ($user_activity_row['image_1'] == ''){
                        $displayDiv = 'display: none';
                    }else{
                        if ($user_activity_row['image_2'] != '') {
                            $displayImg2 = '';
                        }else{$displayFirstI = 'display: none';}
                        if ($user_activity_row['image_3'] != '') {
                            $displayImg3 = '';
                        }
                        if ($user_activity_row['image_4'] != '') {
                            $displayImg4 = '';
                        }
                    } 
                    ?>
                    <div class="user-activity-images" id="user_activity_images_<?php echo $i; ?>">   
                        <div style="<?php echo $displayDiv ?>" id="div_<?php echo $i; ?>">
                            <img src="<?php echo $user_activity_row['image_1']; ?>" alt="">
                            <img style="<?php echo $displayImg2 ?>" src="<?php echo $user_activity_row['image_2']; ?>" alt="">
                            <img style="<?php echo $displayImg3 ?>" src="<?php echo $user_activity_row['image_3']; ?>" alt="">
                            <img style="<?php echo $displayImg4 ?>" src="<?php echo $user_activity_row['image_4']; ?>" alt="">
                        </div>
                        <i style="<?php echo $displayFirstI ?>" id="chevron_left_<?php echo $i; ?>" class="fas fa-chevron-left"></i>
                        <i style="<?php echo $displayFirstI ?>" id="chevron_right_<?php echo $i; ?>" class="fas fa-chevron-right"></i>
                    </div>
                    <div class="current-image" id="current_image_<?php echo $i; ?>">
                        <i style="<?php echo $displayFirstI ?>" class="fa fa-circle"></i>
                        <i style="<?php echo $displayImg2 ?>" class="far fa-circle"></i>
                        <i style="<?php echo $displayImg3 ?>" class="far fa-circle"></i>
                        <i style="<?php echo $displayImg4 ?>" class="far fa-circle"></i>
                    </div> 
                    <?php } ?>
                </div>
                <div class="user-activity-bottom" id="user_activity_bottom_<?php echo $i; ?>">
                    <?php 
                        $like_query = "SELECT id_like,id_user FROM jaime_activites WHERE id_activity =".$user_activity_row['id_activity'];
                        $like_result = mysqli_query($conn, $like_query);
                        $like_count = mysqli_num_rows($like_result);

                        $display_fas = '';
                        $display_far = '';
                        while ($like_row = mysqli_fetch_assoc($like_result)) {
                            if ($like_row['id_user'] == $row['id_user']) {
                                $display_fas = 'display :block';
                                $display_far = 'display :none';
                            }
                        }
                    ?>
                    <div>
                        <i style="<?php echo $display_fas; ?>" id="fas_<?php echo $i; ?>" class="fas fa-heart"></i>
                        <i style="<?php echo $display_far; ?>" id="far_<?php echo $i; ?>" class="far fa-heart"></i>
                        <span><?php echo $like_count; ?></span>
                    </div>
                    <p><?php echo $user_activity_row['lieu'].', le '. $user_activity_row['date']?></p>
                    <form class="like-activity-form" id="like_activity_form_<?php echo $i; ?>">
                        <input type="hidden" id="like_activity_<?php echo $i; ?>" value="<?php echo $user_activity_row['id_activity']; ?>">
                    </form>
                    <form class="dislike-activity-form" id="dislike_activity_form_<?php echo $i; ?>">
                        <input type="hidden" id="dislike_activity_<?php echo $i; ?>" value="<?php echo $user_activity_row['id_activity']; ?>">
                    </form>
                </div>
                <?php 
                    $user_rating_query = "SELECT * FROM user_rating WHERE id_user = {$user_activity_row['id_user']} AND id_user_r = {$user_activity_row['id_user_r']} AND id_activity = {$user_activity_row['id_activity']}"; 
                    $user_rating_result = mysqli_query($conn, $user_rating_query);
                    $user_rating_row = mysqli_fetch_assoc($user_rating_result);
                    $rapidite = $user_rating_row['rapidite'];
                    $travaille = $user_rating_row['travaille'];
                    $discipline = $user_rating_row['discipline'];
                    $cout = $user_rating_row['cout'];
                    $reputation = $user_rating_row['reputation'];
                    
                    $user_rating_details_query = "SELECT id_user,nom_user,img_user FROM utilisateurs WHERE id_user = {$user_rating_row['id_user']}"; 
                    $user_rating_details_result = mysqli_query($conn, $user_rating_details_query);
                    $user_rating_details_row = mysqli_fetch_assoc($user_rating_details_result);

                    if ($rapidite != 0 && $travaille != 0 && $discipline != 0 && $cout != 0 && $reputation != 0) {
                    
                    $total_r = ($rapidite+$travaille+$discipline+$cout+$reputation)/5;
                    $tr1 = 'far fa-star';$tr2 = 'far fa-star';$tr3 = 'far fa-star';$tr4 = 'far fa-star';$tr5 = 'far fa-star';
                    if ($total_r >= 20) {$tr1 = 'fas fa-star';}
                    if ($total_r >= 40) {$tr2 = 'fas fa-star';}
                    if ($total_r >= 60) {$tr3 = 'fas fa-star';}
                    if ($total_r >= 80) {$tr4 = 'fas fa-star';}
                    if ($total_r == 100) {$tr5 = 'fas fa-star';}
                ?>
                <div class="user-activite-rating">
                    <div class="activite-rating-top">
                        <p>Par <a href="./utilisateur-info.php?id_user=<?php echo $user_rating_details_row['id_user']?>"><?php echo $user_rating_details_row['nom_user']?></a> noté </p>
                        <div class="activite-rating">
                            <i class="<?php echo $tr1 ?>"></i>
                            <i class="<?php echo $tr2 ?>"></i>
                            <i class="<?php echo $tr3 ?>"></i>
                            <i class="<?php echo $tr4 ?>"></i>
                            <i class="<?php echo $tr5 ?>"></i>
                        </div>
                        <p id="show_rating_details_<?php echo $i; ?>">Voir plus</p>
                    </div>
                    <?php 
                        $t1 = 'far fa-star';$t2 = 'far fa-star';$t3 = 'far fa-star';$t4 = 'far fa-star';$t5 = 'far fa-star';
                        if ($travaille >= 20) {$t1 = 'fas fa-star';}
                        if ($travaille >= 40) {$t2 = 'fas fa-star';}
                        if ($travaille >= 60) {$t3 = 'fas fa-star';}
                        if ($travaille >= 80) {$t4 = 'fas fa-star';}
                        if ($travaille == 100) {$t5 = 'fas fa-star';}

                        $r1 = 'far fa-star';$r2 = 'far fa-star';$r3 = 'far fa-star';$r4 = 'far fa-star';$r5 = 'far fa-star';
                        if ($rapidite >= 20) {$r1 = 'fas fa-star';}
                        if ($rapidite >= 40) {$r2 = 'fas fa-star';}
                        if ($rapidite >= 60) {$r3 = 'fas fa-star';}
                        if ($rapidite >= 80) {$r4 = 'fas fa-star';}
                        if ($rapidite == 100) {$r5 = 'fas fa-star';}

                        $d1 = 'far fa-star';$d2 = 'far fa-star';$d3 = 'far fa-star';$d4 = 'far fa-star';$d5 = 'far fa-star';
                        if ($discipline >= 20) {$d1 = 'fas fa-star';}
                        if ($discipline >= 40) {$d2 = 'fas fa-star';}
                        if ($discipline >= 60) {$d3 = 'fas fa-star';}
                        if ($discipline >= 80) {$d4 = 'fas fa-star';}
                        if ($discipline == 100) {$d5 = 'fas fa-star';}

                        $c1 = 'far fa-star';$c2 = 'far fa-star';$c3 = 'far fa-star';$c4 = 'far fa-star';$c5 = 'far fa-star';
                        if ($cout >= 20) {$c1 = 'fas fa-star';}
                        if ($cout >= 40) {$c2 = 'fas fa-star';}
                        if ($cout >= 60) {$c3 = 'fas fa-star';}
                        if ($cout >= 80) {$c4 = 'fas fa-star';}
                        if ($cout == 100) {$c5 = 'fas fa-star';}

                        $rp1 = 'far fa-star';$rp2 = 'far fa-star';$rp3 = 'far fa-star';$rp4 = 'far fa-star';$rp5 = 'far fa-star';
                        if ($reputation >= 20) {$rp1 = 'fas fa-star';}
                        if ($reputation >= 40) {$rp2 = 'fas fa-star';}
                        if ($reputation >= 60) {$rp3 = 'fas fa-star';}
                        if ($reputation >= 80) {$rp4 = 'fas fa-star';}
                        if ($reputation == 100) {$rp5 = 'fas fa-star';}
                    ?>
                    <div class="activite-rating-bottom">
                        <div class="travaille-note">
                            <p>Qualité du travaille</p>
                            <div class="activite-rating-note">
                                <i class="far fa-star <?php echo $t1 ?>"></i>
                                <i class="far fa-star <?php echo $t2 ?>"></i>
                                <i class="far fa-star <?php echo $t3 ?>"></i>
                                <i class="far fa-star <?php echo $t4 ?>"></i>
                                <i class="far fa-star <?php echo $t5 ?>"></i>
                            </div>
                        </div>
                        <div class="travaille-note">
                            <p>Rapidité du travaille</p>
                            <div class="activite-rating-note">
                                <i class="far fa-star <?php echo $r1 ?>"></i>
                                <i class="far fa-star <?php echo $r2 ?>"></i>
                                <i class="far fa-star <?php echo $r3 ?>"></i>
                                <i class="far fa-star <?php echo $r4 ?>"></i>
                                <i class="far fa-star <?php echo $r5 ?>"></i>
                            </div>
                        </div>
                        <div class="travaille-note">
                            <p>Discipline</p>
                            <div class="activite-rating-note">
                                <i class="far fa-star <?php echo $d1 ?>"></i>
                                <i class="far fa-star <?php echo $d2 ?>"></i>
                                <i class="far fa-star <?php echo $d3 ?>"></i>
                                <i class="far fa-star <?php echo $d4 ?>"></i>
                                <i class="far fa-star <?php echo $d5 ?>"></i>
                            </div>
                        </div>
                        <div class="travaille-note">
                            <p>Cout</p>
                            <div class="activite-rating-note">
                                <i class="far fa-star <?php echo $c1 ?>"></i>
                                <i class="far fa-star <?php echo $c2 ?>"></i>
                                <i class="far fa-star <?php echo $c3 ?>"></i>
                                <i class="far fa-star <?php echo $c4 ?>"></i>
                                <i class="far fa-star <?php echo $c5 ?>"></i>
                            </div>
                        </div>
                        <div class="travaille-note">
                            <p>Reputation</p>
                            <div class="activite-rating-note">
                                <i class="far fa-star <?php echo $rp1 ?>"></i>
                                <i class="far fa-star <?php echo $rp2 ?>"></i>
                                <i class="far fa-star <?php echo $rp3 ?>"></i>
                                <i class="far fa-star <?php echo $rp4 ?>"></i>
                                <i class="far fa-star <?php echo $rp5 ?>"></i>
                            </div>
                        </div>
                        <?php 
                            $displayCommentaire = '';
                            if ($user_rating_row['commentaire'] == '') {
                                $displayCommentaire = 'display:none';
                            }
                        ?>
                        <div style="<?php echo $displayCommentaire ?>" class="rating-commentaire">
                            <img src="<?php echo './'.$user_info_row['img_user']; ?>" alt="">
                            <p><?php echo $user_rating_row['commentaire']; ?></p>
                        </div>
                    </div>
                </div>
                <?php }else{ ?>
                <div class="user-activite-rating">
                    <div class="activite-rating-top">
                        <p>En attente de notification par <a href="./utilisateur-info.php?id_user=<?php echo $user_info_row['id_user']?>"><?php echo $user_info_row['nom_user']?></a></p>
                        <p></p>
                    </div>
                </div>
                <?php } ?>   
            </div>     
        <?php } ?>
    </div>
</div>
<div class="user-profile-right-centent">
    <h4>Top travailleur chez <?php echo $user_info_row['nom_user'] ?></h4>
    <div class="top-travailleur-container">
        <?php 
            $first_top_ntf_query = "SELECT id_user FROM user_rating WHERE rapidite+travaille+cout+discipline+reputation=
            (SELECT MAX(rapidite+travaille+cout+discipline+reputation) FROM user_rating WHERE id_user_r = {$user_info_row['id_user']})";
            $first_top_ntf_result = mysqli_query($conn, $first_top_ntf_query);
            if (mysqli_num_rows($first_top_ntf_result) > 0) {
            $first_top_ntf_row = mysqli_fetch_assoc($first_top_ntf_result);

            $first_top_user_query = "SELECT id_user,nom_user,img_user,profession_user FROM utilisateurs WHERE id_user = {$first_top_ntf_row['id_user']}";
            $first_top_user_result = mysqli_query($conn, $first_top_user_query);
            $first_top_user_row = mysqli_fetch_assoc($first_top_user_result);

            $user_total_rating_query = "SELECT * FROM user_rating WHERE id_user =".$first_top_user_row['id_user']; 
            $user_total_rating_result = mysqli_query($conn, $user_total_rating_query);

            $tr = 0;$tt = 0;$tc = 0;$td = 0;$trp = 0;$n=1;
            while($user_total_rating_row=mysqli_fetch_assoc($user_total_rating_result)){
                
                $tnr = $user_total_rating_row['rapidite'];
                $tnt = $user_total_rating_row['travaille'];
                $tnd = $user_total_rating_row['discipline'];
                $tnc = $user_total_rating_row['cout'];
                $tnrp = $user_total_rating_row['reputation'];

                if ($tnr!=0 && $tnt!=0 && $tnd!=0 && $tnc!=0 && $tnrp!=0) {
                    $tr=$tr+$user_total_rating_row['rapidite'];
                    $tt=$tt+$user_total_rating_row['travaille'];
                    $tc=$tc+$user_total_rating_row['cout'];
                    $td=$td+$user_total_rating_row['discipline'];
                    $trp=$trp+$user_total_rating_row['reputation'];
                    $n++;
                }
            }
            
            $total_r = ($tr/$n+$tt/$n+$td/$n+$tc/$n+$trp/$n)/5;
            $tr1 = 'far fa-star';$tr2 = 'far fa-star';$tr3 = 'far fa-star';$tr4 = 'far fa-star';$tr5 = 'far fa-star';
            if ($total_r >= 20) {$tr1 = 'fas fa-star';}
            if ($total_r >= 40) {$tr2 = 'fas fa-star';}
            if ($total_r >= 60) {$tr3 = 'fas fa-star';}
            if ($total_r >= 80) {$tr4 = 'fas fa-star';}
            if ($total_r == 100) {$tr5 = 'fas fa-star';}
            
        ?>
        <a href="./utilisateur-info.php?id_user=<?php echo $first_top_user_row['id_user'] ?>">
            <div class="top-travailleur">
                <img src="<?php echo './'.$first_top_user_row['img_user'] ?>" alt="">
                <div class="top-travailleur-rating">
                <i class="<?php echo $tr1 ?>"></i>
                <i class="<?php echo $tr2 ?>"></i>
                <i class="<?php echo $tr3 ?>"></i>
                <i class="<?php echo $tr4 ?>"></i>
                <i class="<?php echo $tr5 ?>"></i>
                </div>
                <h5><?php echo $first_top_user_row['nom_user'].', '.$first_top_user_row['profession_user'] ?></h5>
            </div>
        </a>

        <?php 
            $second_top_ntf_query = "SELECT id_user FROM user_rating WHERE rapidite+travaille+cout+discipline+reputation=
            (SELECT MAX(rapidite+travaille+cout+discipline+reputation) FROM user_rating WHERE id_user != {$first_top_ntf_row['id_user']})";
            $second_top_ntf_result = mysqli_query($conn, $second_top_ntf_query);
            if (mysqli_num_rows($second_top_ntf_result) > 0) {
            $second_top_ntf_row = mysqli_fetch_assoc($second_top_ntf_result);

            $second_top_user_query = "SELECT id_user,nom_user,img_user,profession_user FROM utilisateurs WHERE id_user = {$second_top_ntf_row['id_user']}";
            $second_top_user_result = mysqli_query($conn, $second_top_user_query);
            $second_top_user_row = mysqli_fetch_assoc($second_top_user_result);
            
            $second_user_total_rating_query = "SELECT * FROM user_rating WHERE id_user =".$second_top_user_row['id_user']; 
            $second_user_total_rating_result = mysqli_query($conn, $second_user_total_rating_query);

            $str = 0;$stt = 0;$stc = 0;$std = 0;$strp = 0;$sn=1;
            while($second_user_total_rating_row=mysqli_fetch_assoc($second_user_total_rating_result)){
                
                $stnr = $second_user_total_rating_row['rapidite'];
                $stnt = $second_user_total_rating_row['travaille'];
                $stnd = $second_user_total_rating_row['discipline'];
                $stnc = $second_user_total_rating_row['cout'];
                $stnrp = $second_user_total_rating_row['reputation'];

                if ($stnr!=0 && $stnt!=0 && $stnd!=0 && $stnc!=0 && $stnrp!=0) {
                    $str=$str+$second_user_total_rating_row['rapidite'];
                    $stt=$stt+$second_user_total_rating_row['travaille'];
                    $stc=$stc+$second_user_total_rating_row['cout'];
                    $std=$std+$second_user_total_rating_row['discipline'];
                    $strp=$strp+$second_user_total_rating_row['reputation'];
                    $sn++;
                }
            }
            
            $stotal_r = ($str/$sn+$stt/$sn+$std/$sn+$stc/$sn+$strp/$sn)/5;
            $str1 = 'far fa-star';$str2 = 'far fa-star';$str3 = 'far fa-star';$str4 = 'far fa-star';$str5 = 'far fa-star';
            if ($stotal_r >= 20) {$str1 = 'fas fa-star';}
            if ($stotal_r >= 40) {$str2 = 'fas fa-star';}
            if ($stotal_r >= 60) {$str3 = 'fas fa-star';}
            if ($stotal_r >= 80) {$str4 = 'fas fa-star';}
            if ($stotal_r == 100) {$str5 = 'fas fa-star';}
        ?>
        <a href="./utilisateur-info.php?id_user=<?php echo $second_top_user_row['id_user'] ?>">
            <div class="top-travailleur">
                <img src="<?php echo './'.$second_top_user_row['img_user'] ?>" alt="">
                <div class="top-travailleur-rating">
                    <i class="<?php echo $str1 ?>"></i>
                    <i class="<?php echo $str2 ?>"></i>
                    <i class="<?php echo $str3 ?>"></i>
                    <i class="<?php echo $str4 ?>"></i>
                    <i class="<?php echo $str5 ?>"></i>
                </div>
                <h5><?php echo $second_top_user_row['nom_user'].', '.$second_top_user_row['profession_user'] ?></h5>
            </div>
        </a>
    </div>
    <div class="bottom-travailleur-container">
        <?php
            $travailleur_query = "SELECT id_user FROM user_rating WHERE id_user_r = {$user_info_row['id_user']} AND id_user != {$second_top_user_row['id_user']} AND id_user != {$first_top_user_row['id_user']}";
            $travailleur_result = mysqli_query($conn, $travailleur_query);
            while($travailleur_row = mysqli_fetch_assoc($travailleur_result)){

            $travailleur_user_query = "SELECT id_user,nom_user,img_user,profession_user FROM utilisateurs WHERE id_user = {$travailleur_row['id_user']}";
            $travailleur_user_result = mysqli_query($conn, $travailleur_user_query);
            $travailleur_user_row = mysqli_fetch_assoc($travailleur_user_result);

            $travailleur_total_rating_query = "SELECT * FROM user_rating WHERE id_user =".$second_top_user_row['id_user']; 
            $travailleur_total_rating_result = mysqli_query($conn, $second_user_total_rating_query);

            $btr = 0;$btt = 0;$btc = 0;$btd = 0;$btrp = 0;$bn=1;
            while($travailleur_total_rating_row=mysqli_fetch_assoc($travailleur_total_rating_result)){
                
                $btnr = $travailleur_total_rating_row['rapidite'];
                $btnt = $travailleur_total_rating_row['travaille'];
                $btnd = $travailleur_total_rating_row['discipline'];
                $btnc = $travailleur_total_rating_row['cout'];
                $btnrp = $travailleur_total_rating_row['reputation'];

                if ($btnr!=0 && $btnt!=0 && $btnd!=0 && $btnc!=0 && $btnrp!=0) {
                    $btr=$btr+$travailleur_total_rating_row['rapidite'];
                    $btt=$btt+$travailleur_total_rating_row['travaille'];
                    $btc=$btc+$travailleur_total_rating_row['cout'];
                    $btd=$btd+$travailleur_total_rating_row['discipline'];
                    $btrp=$btrp+$travailleur_total_rating_row['reputation'];
                    $bn++;
                }
            }
            
            $btotal_r = ($btr/$bn+$btt/$bn+$btd/$bn+$btc/$bn+$btrp/$bn)/5;
            $btr1 = 'far fa-star';$btr2 = 'far fa-star';$btr3 = 'far fa-star';$btr4 = 'far fa-star';$btr5 = 'far fa-star';
            if ($btotal_r >= 20) {$btr1 = 'fas fa-star';}
            if ($btotal_r >= 40) {$btr2 = 'fas fa-star';}
            if ($btotal_r >= 60) {$btr3 = 'fas fa-star';}
            if ($btotal_r >= 80) {$btr4 = 'fas fa-star';}
            if ($btotal_r == 100) {$btr5 = 'fas fa-star';}

        ?>
        <a href="<?php echo './'.$travailleur_user_row['id_user'] ?>">
            <div class="bottom-travailleur">
                <img src="./images/profile.jpg" alt="">
                <div class="bottom-travailleur-rating">
                    <i class="<?php echo $btr1 ?>"></i>
                    <i class="<?php echo $btr2 ?>"></i>
                    <i class="<?php echo $btr3 ?>"></i>
                    <i class="<?php echo $btr4 ?>"></i>
                    <i class="<?php echo $btr5 ?>"></i>
                </div>
                <h5><?php echo $travailleur_user_row['nom_user'].', '.$travailleur_user_row['profession_user']; ?></h5>
            </div>
        </a>
        <?php } ?>
    </div>
    <?php }} ?>
</div>