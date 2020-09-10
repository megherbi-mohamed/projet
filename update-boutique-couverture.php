<?php
session_start();
include_once './bdd/connexion.php';

$id_btq = $_POST['id_btq'];
$data = $_POST['image'];
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';

$query = "UPDATE boutiques SET couverture_btq = 'boutique-couverture/$imageName' WHERE id_btq = '$id_btq'";
if(mysqli_query($conn, $query)){
    if(file_put_contents('boutique-couverture/'.$imageName, $data)){
        echo 'done';
    }else{
        echo 0;
    }
}

// $filename = $_FILES['file']['name'];
// $idBoutique = $_POST['id_boutique'];

// $randomImage = rand(1000000,5000000);
// $ImageName = str_replace(' ','-',strtolower($filename));
// $ImageType = $_FILES['file']['type'];
// $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
// $ImageExt = str_replace('.','',$ImageExt);
// $NewImageName = $idBoutique.'-'.$randomImage.'.'.$ImageExt;
// $ret[$NewImageName] = $NewImageName;

// /* Location */
// $location = "boutique-couverture/".$NewImageName;
// $uploadOk = 1;
// $imageFileType = pathinfo($location,PATHINFO_EXTENSION);

// /* Valid Extensions */
// $valid_extensions = array("jpg","jpeg","png");

// /* Check file extension */
// if( !in_array(strtolower($imageFileType),$valid_extensions)) {
//    $uploadOk = 0;
// }

// if($uploadOk == 0){
//    echo 0;
// }
// else{
//     $query = "UPDATE boutiques SET couverture_btq = '$location' WHERE id_btq = '$idBoutique'";
//     if(mysqli_query($conn, $query)){
//         if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
//             echo $location;
//         }else{
//             echo 0;
//         }
//     }
// }
?>