<?php
session_start();
include_once './bdd/connexion.php';

$filename = $_FILES['file']['name'];
$idProduct = $_POST['id_product'];
$randomImage = rand(1000000,5000000);
$ImageName = str_replace(' ','-',strtolower($filename));
$ImageType = $_FILES['file']['type'];
$ImageExt = substr($ImageName, strrpos($ImageName, '.'));
$ImageExt = str_replace('.','',$ImageExt);
$NewImageName = $idProduct.'-'.$randomImage.'.'.$ImageExt;
$ret[$NewImageName] = $NewImageName;

/* Location */
$location = "boutique-produit/".$NewImageName;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

/* Valid Extensions */
$valid_extensions = array("jpg","jpeg","png");

/* Check file extension */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo 0;
}
else{
    $numImg = $_POST['numMdl'];
    if ($numImg == 0) {
        $query = "UPDATE produit_boutique SET modele_1 = 'boutique-produit/$NewImageName' WHERE id_prd = '$idProduct'";
        if(mysqli_query($conn, $query)){
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                echo "
                    <div class='modele-preview'>
                        <img src='".$location."' alt=''>
                        <input type='text' id='prix_modele_1' placeholder='0.00 Da'>
                    </div>
                ";
            }else{
                echo 0;
            }
        }
    }
    else if ($numImg == 1) {
        $query = "UPDATE produit_boutique SET modele_2 = 'boutique-produit/$NewImageName' WHERE id_prd = '$idProduct'";
        if(mysqli_query($conn, $query)){
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                echo "
                    <div class='modele-preview'>
                        <img src='".$location."' alt=''>
                        <input type='text' id='prix_modele_2' placeholder='0.00 Da'>
                    </div>
                ";
            }else{
                echo 0;
            }
        }
    } 
    else if ($numImg == 2) {
        $query = "UPDATE produit_boutique SET modele_3 = 'boutique-produit/$NewImageName' WHERE id_prd = '$idProduct'";
        if(mysqli_query($conn, $query)){
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                echo "
                    <div class='modele-preview'>
                        <img src='".$location."' alt=''>
                        <input type='text' id='prix_modele_3' placeholder='0.00 Da'>
                    </div>
                ";
            }else{
                echo 0;
            }
        }
    }
    else if ($numImg == 3) {
        $query = "UPDATE produit_boutique SET modele_4 = 'boutique-produit/$NewImageName' WHERE id_prd = '$idProduct'";
        if(mysqli_query($conn, $query)){
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                echo "
                    <div class='modele-preview'>
                        <img src='".$location."' alt=''>
                        <input type='text' id='prix_modele_4' placeholder='0.00 Da'>
                    </div>
                ";
            }else{
                echo 0;
            }
        }
    }   
}
?>