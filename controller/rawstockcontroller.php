<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/rawstockmodel.php';
$obraw=new rawstock();

$user_id=$userInfo['user_id'];

$action= strtolower($_REQUEST['action']);
switch ($action){
    
    case "additem":
        $arr=$_POST;
        
        $item_id=$obraw->addItem($arr);
       
        $msg1= base64_encode("A record has been added");
        header("Location:../view/viewallraw.php?msg=$msg1");  
       
        break;  
        
    
    case "add":
        $arr=$_POST;
        
        $textfile=$_FILES['textfile']['name'];
        $textfiletmp=$_FILES['textfile']['tmp_name'];
        $stock_id=$obraw->addstock($arr, $user_id, $textfile);
        //print_r($arr);
        
        
        $rstock=$obraw->checkstockbalance($_POST['item_id']);
        $nos=$rstock->rowCount();
        echo $nos;
       if($nos==0){
    $obraw->addstockbalance($_POST['item_id'],$_POST['quan']);
     $msg="An Item quantity has been added";
      
     }else{
           $obraw->updatestockbalance($_POST['item_id'], $_POST['quan']);
         $msg="An Item quantity has been updated";
            
      }                        
            $msg=base64_encode($msg);
          header("Location:../view/rawstock.php?msg=$msg"); 
        break;
    case "delete":
        $item_id=$_REQUEST['item_id'];
        $r=$obitem->deleteAnItem($item_id);
        if($r){
            $msg="$item_id record has been deleted";
        } else {
            $msg="$item_id record has not been deleted";
        }
          $msg=base64_encode($msg);
          header("Location:../view/item.php?msg=$msg");
        break;
        
        
        
}


?>

