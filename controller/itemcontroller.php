<?php
include '../common/dbconnection.php';
include '../model/itemmodel.php';
$obitem=new item();

$action= strtolower($_REQUEST['action']);
switch ($action){
    case "add":
        $arr=$_POST;
        $arrimagename=$_FILES['item_image']['name'];
        $arrimagetmp=$_FILES['item_image']['tmp_name'];
        $item_id=$obitem->addItem($arr);
        //echo $item_id;
        //print_r($arrimagename);
        //print_r($arrimagetmp);
        //print_r($arr);
        
        if($arrimagename[0]!=""){
        foreach ($arrimagename as $k=>$v){
            $imagen= uniqid()."_".$v;
            $imaget=$arrimagetmp[$k];//$k=index of image, $v=image name
        //2 nd $k represents image temparary location of $k
            $r=$obitem->addImage($imagen, $item_id);
            if($r){
                $destination="../images/item_images/".$imagen;
                move_uploaded_file($imaget, $destination);
                }
            } 
        }       
                 
        $msg= base64_encode("A record has been added");
        header("Location:../view/item.php?msg=$msg");
        break;
        
    case "delete":
        $item_id=$_REQUEST['item_id'];
        $r=$obitem->deleteAnItem($item_id) ; 
        if($r){
           $msg= "Record $item_id has been deleted";
        }else{
          $msg= "Record has $item_id not been deleted";
        }
        $msg= base64_encode($msg);
        header("Location:../view/item.php?msg=$msg");
        break;
        
    case "update":
        $arr=$_POST;
        $item_id=$_REQUEST['item_id'];
                //To call updateItem method
        $result=$obitem->updateItem($arr,$item_id);
        if($result){
            $msg="A record has been updated";
            $status="success";
           
        }else{
            $msg="A record has not been updated";
            $status="danger";
        }
        //echo $msg;
        header("Location:../view/updateitem.php?item_id=$item_id&msg=$msg&status=$status");
        break;
        
}

?>

