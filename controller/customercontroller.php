<?php

include '../common/dbconnection.php';
include '../model/customerinmodel.php';

$action =$_REQUEST['action'];
$obcus = new customerin();
switch ($action) {
    case "add":
        $arr=$_POST;
        
        $cus_id=$obcus->addCustomer($arr);
       
        $msg1= base64_encode("A record has been added");
          header("Location:../view/customer.php?msg=$msg1");  
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