<?php
// messagerie.php
if (isset($_SESSION['admin'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['admin'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $messagerie_msg_result = mysqli_query($conn,$msg_query);

    $msg_content_query = "SELECT * FROM messages  WHERE id_recever = {$row['id_user']} AND id_sender = {$_GET['user']}
                                                        OR id_recever = {$_GET['user']} AND id_sender = {$row['id_user']}";
    $msg_content_result = mysqli_query($conn,$msg_content_query);
}
if (isset($_SESSION['sous-admin'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['sous-admin'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $messagerie_msg_result = mysqli_query($conn,$msg_query);

    $msg_content_query = "SELECT * FROM messages  WHERE id_recever = {$row['id_user']} AND id_sender = {$_GET['user']}
                                                        OR id_recever = {$_GET['user']} AND id_sender = {$row['id_user']}";
    $msg_content_result = mysqli_query($conn,$msg_content_query);
}

// update message
$etat_msg_query = "UPDATE messages SET etat_msg = 0 WHERE id_recever = {$row['id_user']} AND id_sender = {$_GET['user']}";
mysqli_query($conn, $etat_msg_query);

// etat message from sender
$current_num_message_query = "SELECT * FROM messages WHERE id_recever = {$row['id_user']} AND id_sender = {$_GET['user']} AND etat_msg = 1";    
$current_num_message_result = mysqli_query($conn,$current_num_message_query);
$current_num_message = 0;
$current_message = 0;
while ($current_num_message_row = mysqli_fetch_assoc($current_num_message_result)) {
    $current_num_message++;
}
if ($current_num_message >= 1) {
    $current_message = 1;
}else{
    $current_message;
}

// notification.php
if (isset($_SESSION['admin'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['admin'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $messagerie_msg_result = mysqli_query($conn,$msg_query);

    $msg_content_query = "SELECT * FROM messages  WHERE id_recever = {$row['id_user']} AND id_sender = {$_SESSION['senderinfo']}
                                                        OR id_recever = {$_SESSION['senderinfo']} AND id_sender = {$row['id_user']}";
    $msg_content_result = mysqli_query($conn,$msg_content_query);
}
if (isset($_SESSION['sous-admin'])) {
    $cnx_user_query = "SELECT * FROM utilisateurs WHERE id_user=".$_SESSION['sous-admin'];
    $result = mysqli_query($conn, $cnx_user_query);
    $row = mysqli_fetch_assoc($result);

    $msg_query = "SELECT * FROM messages WHERE id_msg IN ( SELECT MAX(id_msg) FROM messages WHERE id_recever = {$row['id_user']} GROUP BY id_sender) ORDER BY id_msg DESC";
    $messagerie_msg_result = mysqli_query($conn,$msg_query);

    $msg_content_query = "SELECT * FROM messages  WHERE id_recever = {$row['id_user']} AND id_sender = {$_SESSION['senderinfo']}
                                                        OR id_recever = {$_SESSION['senderinfo']} AND id_sender = {$row['id_user']}";
    $msg_content_result = mysqli_query($conn,$msg_content_query);
}

// admin tableau de bord
$pre_user_query = "SELECT * FROM preutilisateurs";
$pre_user_result = mysqli_query($conn, $pre_user_query);
$pre_user_num = mysqli_num_rows($pre_user_result);

$pre_entrp_query = "SELECT * FROM preutilisateurs WHERE type_user = 'entreprise'";
$pre_entrp_result = mysqli_query($conn, $pre_entrp_query);
$entrp_num = mysqli_num_rows($pre_entrp_result);

$pre_grp_query = "SELECT * FROM preutilisateurs WHERE type_user = 'groupe'";
$pre_grp_result = mysqli_query($conn, $pre_grp_query);
$grp_num = mysqli_num_rows($pre_grp_result);

$pre_indv_query = "SELECT * FROM preutilisateurs WHERE type_user = 'individu'";
$pre_indv_result = mysqli_query($conn, $pre_indv_query);
$indv_num = mysqli_num_rows($pre_indv_result);

$entrp_query = "SELECT * FROM utilisateurs WHERE type_user = 'entreprise'";
$entrp_result = mysqli_query($conn, $entrp_query);

?>
<span id="user_num"><?php echo $pre_user_num; ?></span>
<span id="entrp_num"><?php echo $entrp_num; ?></span>
<span id="grp_num"><?php echo $grp_num; ?></span>
<span id="indv_num"><?php echo $indv_num; ?></span>

<span id="entreprises-accepter-entreprises">
    <table>
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Options</th>
        </tr>
        <?php 
            while ($pre_entrp_row = mysqli_fetch_assoc($pre_entrp_result)) {
        ?>
        <tr>
            <td><?php echo $pre_entrp_row['type_user']; ?></td>
            <td><?php echo $pre_entrp_row['nom_user']; ?></td>
            <td><?php echo $pre_entrp_row['email_user']; ?></td>
            <td>
                <form method="post" action="admin.php?entreprises&accepter-entreprises">
                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_entrp_row['id_user']; ?>">
                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</span>

<span id="groupes-accepter-groupes">
    <table>
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Options</th>
        </tr>
        <?php 
            while ($pre_grp_row = mysqli_fetch_assoc($pre_grp_result)) {
        ?>
        <tr>
            <td><?php echo $pre_grp_row['type_user']; ?></td>
            <td><?php echo $pre_grp_row['nom_user']; ?></td>
            <td><?php echo $pre_grp_row['email_user']; ?></td>
            <td>
                <form method="post" action="admin.php?groupes&accepter-groupes">
                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_grp_row['id_user']; ?>">
                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</span>

<span id="individus-accepter-individus">
    <table>
        <tr>
            <th>Type</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Options</th>
        </tr>
        <?php 
            while ($pre_indv_row = mysqli_fetch_assoc($pre_indv_result)) {
        ?>
        <tr>
            <td><?php echo $pre_indv_row['type_user']; ?></td>
            <td><?php echo $pre_indv_row['nom_user']; ?></td>
            <td><?php echo $pre_indv_row['email_user']; ?></td>
            <td>
                <form method="post" action="admin.php?individus&accepter-individus">
                    <input type="hidden" name="id_user" id="id_user" value="<?php echo $pre_indv_row['id_user']; ?>">
                    <input type="submit" name="accepter" id="accepter" value="Accepter">
                    <input type="submit" name="refuser" id="refuser" value="Refuser">
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</span>

<span id="promotions-options">
    <h4>Gerer les promotions</h4>
</span>

<span id="evenements-options">
    <h4>Gerer les evenements</h4>
</span>

<span id="recrutements-options">
    <h4>Gerer les recrutements</h4>
</span>

<!-- messagerie message -->
<span id="messagerie_message">
    <?php 
        while ($msg_content_row = mysqli_fetch_assoc($msg_content_result)) {
        if($msg_content_row['id_recever'] == $row['id_user']) { ?>
            <div class="messagerie-message-sender">
                <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
            </div>
        <?php }else{ ?>
            <div class="messagerie-message-recever">
                <p><?php echo $msg_content_row['message']; ?><span><?php echo $msg_content_row['temp_msg']; ?></span></p>
            </div>
    <?php }} ?>
</span>

<!-- logout when inactivity -->
<?php
if(time() - $_SESSION['timestamp'] > 900) { //subtract new timestamp from the old one
    echo"<script>alert('15 Minutes over!');</script>";
    unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
    $_SESSION['logged_in'] = false;
    header("Location: " . index.php); //redirect to index.php
    exit;
} else {
    $_SESSION['timestamp'] = time(); //set new timestamp
}
?>