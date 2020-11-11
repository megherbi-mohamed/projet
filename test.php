<?php 
session_start();
include 'bdd/connexion.php';
// get online user 
$id_user = 1;
$get_btq_user_query = $conn->prepare("SELECT id_btq FROM boutiques WHERE id_createur = $id_user");
$get_btq_user_query->execute();
$reserved_session = array();
while ($get_btq_user_row = $get_btq_user_query->fetch(PDO::FETCH_ASSOC)) {
    $id_btq = $get_btq_user_row['id_btq'];
    $get_btq_sessions_query = $conn->prepare("SELECT * FROM gerer_connexion WHERE id_user = $id_btq");
    $get_btq_sessions_query->execute();
    $get_btq_sessions_row = $get_btq_sessions_query->fetch(PDO::FETCH_ASSOC);
    $session_btq_1 = $get_btq_sessions_row['id_user_1'];
    $session_btq_2 = $get_btq_sessions_row['id_user_2'];
    $session_btq_3 = $get_btq_sessions_row['id_user_3'];
    $session_btq_4 = $get_btq_sessions_row['id_user_4'];
    $session_btq_5 = $get_btq_sessions_row['id_user_5'];

    $get_reserved_session_query = $conn->prepare("SELECT session_usr FROM sessions_reserves WHERE 
    (session_btq = $session_btq_1 OR session_btq = $session_btq_2 OR
    session_btq = $session_btq_3 OR session_btq = $session_btq_4 OR
    session_btq = $session_btq_5) AND session_usr IS NOT NULL");
    $get_reserved_session_query->execute();
    while ($get_reserved_session_row = $get_reserved_session_query->fetch(PDO::FETCH_ASSOC)) {
        $session_usr = $get_reserved_session_row['session_usr'];
        array_push($reserved_session, $session_usr);
    }
}

print_r($reserved_session);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
// window.addEventListener('load', function() {

//   function updateOnlineStatus(event) {
//     var condition = navigator.onLine ? "online" : "offline";
//     if (condition == 'offline') {
        
//     }
//   }

//   window.addEventListener('online',  updateOnlineStatus);
//   window.addEventListener('offline', updateOnlineStatus);
// });

// window.onbeforeunload = function (event) {
//     var message = 'Important: Please click on \'Save\' button to leave this page.';
//     if (typeof event == 'undefined') {
//         event = window.event;
//     }
//     if (event) {
//         event.returnValue = message;
//     }
//     return message;
// };
// $.ajax({
//     url: 'test1.php',
//     success: function(response){
//     },
// });
// $(function () {
//     $("a").not('#lnkLogOut').click(function () {
//         window.onbeforeunload = null;
//     });
//     $(".btn").click(function () {
//         window.onbeforeunload = null;
// });

// };

</script>