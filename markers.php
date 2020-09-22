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
  $rech_user_query = "SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession, dscrp_user AS dscrp FROM utilisateurs WHERE type_user = 'professionnel' AND nom_entrp_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR dscrp_user LIKE '%$text%' OR ville LIKE '%$text%' 
  UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession, dscrp_btq AS dscrp FROM boutiques WHERE nom_btq LIKE '%$text%' OR sous_categorie LIKE '%$text%' OR dscrp_btq LIKE '%$text%' OR ville_btq LIKE '%$text%'";
  $rech_user_result = mysqli_query($conn, $rech_user_query);
}
else{
  $rech_user_query = "SELECT id_user AS id, type_user, nom_entrp_user AS nom, couverture_user AS img, ville AS ville, latitude_user AS latitude, longitude_user AS longitude, adresse_user AS adresse, profession_user AS profession, dscrp_user AS dscrp FROM utilisateurs WHERE type_user = 'professionnel' 
  UNION SELECT id_btq AS id, type_user, nom_btq AS nom, couverture_btq AS img, ville_btq AS ville, latitude_btq AS latitude, longitude_btq AS longitude, adresse_btq AS adresse, sous_categorie AS profession, dscrp_btq AS dscrp FROM boutiques";
  $rech_user_result = mysqli_query($conn, $rech_user_query);
} 

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
  echo 'id="' . $rech_user_row['id'] . '" ';
  echo 'nom="' . parseToXML($rech_user_row['nom']) . '" ';
  echo 'address="' . parseToXML($rech_user_row['adresse']) . '" ';
  echo 'latitude="' . $rech_user_row['latitude'] . '" ';
  echo 'longitude="' . $rech_user_row['longitude'] . '" ';
  echo 'image="' . $rech_user_row['img'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}
// End XML file
echo '</markers>';

?>