<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/stockmodel.php';
$obstock=new stock();//TO call stock class in the model
//To add stock
$user_id=$userInfo['user_id'];

$action= strtolower($_REQUEST['action']);
switch ($action){
    case "add":
        $arr=$_POST;
        
        $textfile=$_FILES['textfile']['name'];
        $textfiletmp=$_FILES['textfile']['tmp_name'];
        $stock_id=$obstock->addstock($arr, $user_id, $textfile);
        //print_r($arr);
        //To add size id to stock-feature table
        if($_POST['size_id']!=""){
            $f_id=$_POST['size_id'];
            $obstock->addstockfeature($stock_id, $f_id);
        }
         //To add size id to stock-feature table
        if($_POST['color_id']!=""){
            $f_id=$_POST['color_id'];
            $obstock->addstockfeature($stock_id, $f_id);
        }
        //To check stock balance of a item with selected color and size
        $rstock=$obstock->checkstockbalance($_POST['item_id'],$_POST['color_id'],$_POST['size_id']);
        $nos=$rstock->rowCount();
        //To add stock for a new item
        if($nos==0){
        $obstock->addstockbalance($_POST['item_id'], $_POST['quan'],$_POST['color_id'],$_POST['size_id']);
        $msg="An Item quantity has been added";
        
        }else{
            //To update quantity of a available item
            $obstock->updatestockbalance($_POST['item_id'], $_POST['quan'],$_POST['color_id'],$_POST['size_id']);
         $msg="An Item quantity has been updated";
            
        }
               
              $msg=base64_encode($msg);
          header("Location:../view/stock.php?msg=$msg"); 
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

