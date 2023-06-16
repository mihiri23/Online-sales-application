<?php

include '../common/dbconnection.php';
include '../model/productionmodel.php';


$obpro = new production();
$action= strtolower($_REQUEST['action']);
switch ($action){
    case "add":
        $arr=$_POST;
        
        $result=$obpro->addproduction($arr);
       
//        $msg1= base64_encode("A record has been added");
//          header("Location:../view/customer.php?msg=$msg1"); 
        
        if($result){
              $msg="A record has been added";
              $status="success";
              
              
          }  else {
              $msg="A record has not been added";
              $status="danger";
          }
        
          $msg= base64_encode($msg);
         header("Location:../view/addproductionstock.php?msg=$msg&status=$status");
        break; 
        
    case "additem":
        $arra=$_POST;
      
        $pro_id=$obpro->new_production($arra);
        
        
       $result=$obpro->checkProduction($pro_id);
       $row=$result->fetch(PDO::FETCH_BOTH);
       $rquan=$row['rquan'];
        
       $item_id=$_REQUEST['item_id'];
       $color_id=$_REQUEST['color_id'];
       $size_id=$_REQUEST['size_id'];
       $uni_id=$_REQUEST['uni_id'];
   
        
        header("Location:../view/addproductiona.php?item_id=$item_id&color_id=$color_id&size_id=$size_id&rquan=$rquan&uni_id=$uni_id");
        break; 
        
        case "update":
          $arr=$_POST;
          $cus_id=$_REQUEST['cus_id'];
          
          //to call updateUser method
          $result=$obcus->updateCustomer($arr,$cus_id);
          if($result){
              $msg="A record has been updated";
              $status="success";
              
              
          }  else {
              $msg="A record has not been updated";
              $status="danger";
          }
          echo $msg;
         header("Location:../view/updatecustomer.php?cus_id=$cus_id&msg=$msg&status=$status");
          break;
         
          
         
} 
?>