<?php
session_start();
include_once './bdd/connexion.php';
function parseToXML($htmlStr) {
  $xmlStr=str_replace('<','&lt;',$htmlStr);
  $xmlStr=str_replace('>','&gt;',$xmlStr);
  $xmlStr=str_replace('"','&quot;',$xmlStr);
  $xmlStr=str_replace("'",'&#39;',$xmlStr);
  $xmlStr=str_replace("&",'&amp;',$xmlStr);
  return $xmlStr;
}
$type_recherche = htmlspecialchars($_GET['type_r']);
$type_filter = htmlspecialchars($_GET['type_f']);
$text = htmlspecialchars($_GET['text']);
$categorie = htmlspecialchars($_GET['categorie']);
$profession = htmlspecialchars($_GET['profession']);
$ville = htmlspecialchars($_GET['ville']);
$commune = htmlspecialchars($_GET['commune']);
header("Content-type: text/xml");
echo "<?xml version='1.0' ?>";
echo '<markers>';
if ($type_recherche == 'tout') {
  if ($text != '') {
    $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs WHERE type_user = 'professionnel' AND (nom_entrp_user LIKE '%$text%' OR categorie_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR description_user LIKE '%$text%' OR ville_user LIKE '%$text%' OR commune_user LIKE '%$text%') LIMIT 6");
    $get_boutique_query = $conn->prepare("SELECT * FROM boutiques WHERE type_user IS NOT NULL AND (nom_btq LIKE '%$text%' OR categorie_btq LIKE '%$text%' OR sous_categorie_btq LIKE '%$text%' OR description_btq LIKE '%$text%' OR ville_btq LIKE '%$text%' OR commune_btq LIKE '%$text%') LIMIT 4");
    if ($get_professionnel_query->execute() && $get_boutique_query->execute()) {
      $ind=0;
      while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)){
        echo '<marker ';
        echo 'type="user" ';
        echo 'id="' . $get_professionnel_row['id_user'] . '" ';
        echo 'nom="' . parseToXML($get_professionnel_row['nom_entrp_user']) . '" ';
        echo 'address="' . parseToXML($get_professionnel_row['adresse_user']) . '" ';
        echo 'latitude="' . $get_professionnel_row['latitude_user'] . '" ';
        echo 'longitude="' . $get_professionnel_row['longitude_user'] . '" ';
        echo 'image="' . $get_professionnel_row['couverture_user'] . '" ';
        echo '/>';
        $ind = $ind + 1;
      }
      while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)){
        echo '<marker ';
        echo 'type="boutique" ';
        echo 'id="' . $get_boutique_row['id_btq'] . '" ';
        echo 'nom="' . parseToXML($get_boutique_row['nom_btq']) . '" ';
        echo 'address="' . parseToXML($get_boutique_row['adresse_btq']) . '" ';
        echo 'latitude="' . $get_boutique_row['latitude_btq'] . '" ';
        echo 'longitude="' . $get_boutique_row['longitude_btq'] . '" ';
        echo 'image="' . $get_boutique_row['couverture_btq'] . '" ';
        echo '/>';
        $ind = $ind + 1;
      }
    }
    else{
      echo 0;
    }
  }
}
else if ($type_recherche == 'professionnel') {
  if ($type_filter == 'text') {
    if ($text != '') {
      $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs WHERE type_user = 'professionnel' AND (nom_entrp_user LIKE '%$text%' OR profession_user LIKE '%$text%' OR description_user LIKE '%$text%' OR ville_user LIKE '%$text%' OR commune_user LIKE '%$text%')");
      if ($get_professionnel_query->execute()) {
        $ind=0;
        while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)){
          echo '<marker ';
          echo 'type="user" ';
          echo 'id="' . $get_professionnel_row['id_user'] . '" ';
          echo 'nom="' . parseToXML($get_professionnel_row['nom_entrp_user']) . '" ';
          echo 'address="' . parseToXML($get_professionnel_row['adresse_user']) . '" ';
          echo 'latitude="' . $get_professionnel_row['latitude_user'] . '" ';
          echo 'longitude="' . $get_professionnel_row['longitude_user'] . '" ';
          echo 'image="' . $get_professionnel_row['couverture_user'] . '" ';
          echo '/>';
          $ind = $ind + 1;
        }
      }
      else{
        echo 0;
      }
    }
  }
  else if ($type_filter == 'filter') {
    if (!empty($categorie) || !empty($profession) || !empty($ville) || !empty($commune)) {
        $where_professionnel = "WHERE type_user = 'professionnel' AND ";
        if(!empty($categorie)){
          $where_professionnel .= "categorie_user = '$categorie' AND ";
        }
        if(!empty($profession)){
          $where_professionnel .= "profession_user = '$profession' AND ";
        }
        if(!empty($ville)){
          $where_professionnel .= "ville_user = '$ville' AND ";
        }
        if(!empty($commune)){
          $where_professionnel .= "commune_user = '$commune' AND ";
        }
        $where_professionnel .= "ORDER BY id_user DESC";
        $word = "AND ORDER";
        if(strpos($where_professionnel, $word) !== false){
          $where_professionnel_final = str_replace($word,"ORDER",$where_professionnel);
        } else {
          $where_professionnel_final = $where_professionnel;
        }
        $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs $where_professionnel_final");
    }
    else{
      $get_professionnel_query = $conn->prepare("SELECT * FROM utilisateurs WHERE type_user = 'professionnel' ORDER BY id_user DESC");
    }
    if ($get_professionnel_query->execute()) {
      $ind=0;
      while ($get_professionnel_row = $get_professionnel_query->fetch(PDO::FETCH_ASSOC)){
        echo '<marker ';
        echo 'type="user" ';
        echo 'id="' . $get_professionnel_row['id_user'] . '" ';
        echo 'nom="' . parseToXML($get_professionnel_row['nom_entrp_user']) . '" ';
        echo 'address="' . parseToXML($get_professionnel_row['adresse_user']) . '" ';
        echo 'latitude="' . $get_professionnel_row['latitude_user'] . '" ';
        echo 'longitude="' . $get_professionnel_row['longitude_user'] . '" ';
        echo 'image="' . $get_professionnel_row['couverture_user'] . '" ';
        echo '/>';
        $ind = $ind + 1;
      }
    }
    else{
      echo 0;
    }
  }
}
else if ($type_recherche == 'boutique') {
  if ($type_filter == 'text') {
    if ($text != '') {
      $get_boutique_query = $conn->prepare("SELECT * FROM boutiques WHERE type_user IS NOT NULL AND (nom_btq LIKE '%$text%' OR categorie_btq LIKE '%$text%' OR sous_categorie_btq LIKE '%$text%' OR description_btq LIKE '%$text%' OR ville_btq LIKE '%$text%' OR commune_btq LIKE '%$text%') ORDER BY id_btq DESC");
      if ($get_boutique_query->execute()) {
        $ind=0;
        while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
          echo '<marker ';
          echo 'type="boutique" ';
          echo 'id="' . $get_boutique_row['id_btq'] . '" ';
          echo 'nom="' . parseToXML($get_boutique_row['nom_btq']) . '" ';
          echo 'address="' . parseToXML($get_boutique_row['adresse_btq']) . '" ';
          echo 'latitude="' . $get_boutique_row['latitude_btq'] . '" ';
          echo 'longitude="' . $get_boutique_row['longitude_btq'] . '" ';
          echo 'image="' . $get_boutique_row['couverture_btq'] . '" ';
          echo '/>';
          $ind = $ind + 1;
        }
      }
      else{
        echo 0;
      }
    }
  }
  else if ($type_filter == 'filter') {
    if (!empty($categorie) || !empty($profession) || !empty($ville) || !empty($commune)) {
      $where_boutique = "WHERE type_user IS NOT NULL AND ";
      if(!empty($categorie)){
        $where_boutique .= "categorie_btq = '$categorie' AND ";
      }
      if(!empty($profession)){
        $where_boutique .= "sous_categorie_btq = '$profession' AND ";
      }
      if(!empty($ville)){
        $where_boutique .= "ville_btq = '$ville' AND ";
      }
      if(!empty($commune)){
        $where_boutique .= "commune_btq = '$commune' AND ";
      }
      $where_boutique .= "ORDER BY id_btq DESC";
      $word = "AND ORDER";
      if(strpos($where_boutique, $word) !== false){
        $where_boutique_final = str_replace($word,"ORDER",$where_boutique);
      } else {
        $where_boutique_final = $where_boutique;
      }
      $get_boutique_query = $conn->prepare("SELECT * FROM boutiques $where_boutique_final");
    }
    else{
      $get_boutique_query = $conn->prepare("SELECT * FROM boutiques WHERE type_user IS NOT NULL");
    }
    if ($get_boutique_query->execute()) {
      $ind=0;
      while ($get_boutique_row = $get_boutique_query->fetch(PDO::FETCH_ASSOC)) {
        echo '<marker ';
        echo 'type="boutique" ';
        echo 'id="' . $get_boutique_row['id_btq'] . '" ';
        echo 'nom="' . parseToXML($get_boutique_row['nom_btq']) . '" ';
        echo 'address="' . parseToXML($get_boutique_row['adresse_btq']) . '" ';
        echo 'latitude="' . $get_boutique_row['latitude_btq'] . '" ';
        echo 'longitude="' . $get_boutique_row['longitude_btq'] . '" ';
        echo 'image="' . $get_boutique_row['couverture_btq'] . '" ';
        echo '/>';
        $ind = $ind + 1;
      }
    }
    else{
      echo 0;
    }
  }
}
echo '</markers>';
?>