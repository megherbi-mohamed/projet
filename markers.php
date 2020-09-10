<?php
session_start();
include_once './bdd/connexion.php';
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

// Select all the rows in the markers table



// if (isset($_GET['r'])) {
  $text = $_GET['r'];
  if ($text != '') {
    $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel' AND nom_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR dscrp_user LIKE '%$text%' OR ville LIKE '%$text%'";
    $rech_user_result = mysqli_query($conn, $rech_user_query);
  }
  else{
    $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel'";
    $rech_user_result = mysqli_query($conn, $rech_user_query);
  } 
// }
// else{
//   $rech_user_query = "SELECT * FROM utilisateurs WHERE type_user = 'professionnel'";
//   $rech_user_result = mysqli_query($conn, $rech_user_query);
// }

// if (isset($_GET['r'])) {
//   $text = $_GET['r'];
  if ($text != '') {
    $rech_btq_query = "SELECT * FROM boutiques WHERE nom_btq LIKE '%$text%' OR type_btq LIKE '%$text%' OR ville_btq LIKE '%$text%' OR dscrp_btq LIKE '%$text%'";
    $rech_btq_result = mysqli_query($conn, $rech_btq_query);
  }
  else{
    $rech_btq_query = "SELECT * FROM boutiques";
    $rech_btq_result = mysqli_query($conn, $rech_btq_query);
  }
// }
// else{
//   $rech_btq_query = "SELECT * FROM boutiques";
//   $rech_btq_result = mysqli_query($conn, $rech_btq_query);
// }

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($rech_user_row = mysqli_fetch_assoc($rech_user_result)){
  // Add to XML document node
  echo '<marker ';
  echo 'type="user" ';
  echo 'id="' . $rech_user_row['id_user'] . '" ';
  echo 'nom="' . parseToXML($rech_user_row['nom_user']) . '" ';
  echo 'address="' . parseToXML($rech_user_row['adresse_user']) . '" ';
  echo 'latitude="' . $rech_user_row['latitude_user'] . '" ';
  echo 'longitude="' . $rech_user_row['longitude_user'] . '" ';
  echo 'image="' . $rech_user_row['img_user'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}
while ($rech_btq_row = mysqli_fetch_assoc($rech_btq_result)){
  // Add to XML document node
  echo '<marker ';
  echo 'type="boutique" ';
  echo 'id="' . $rech_btq_row['id_btq'] . '" ';
  echo 'nom="' . parseToXML($rech_btq_row['nom_btq']) . '" ';
  echo 'address="' . parseToXML($rech_btq_row['adresse_btq']) . '" ';
  echo 'latitude="' . $rech_btq_row['latitude_btq'] . '" ';
  echo 'longitude="' . $rech_btq_row['longitude_btq'] . '" ';
  echo 'image="' . $rech_btq_row['logo_btq'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

?>