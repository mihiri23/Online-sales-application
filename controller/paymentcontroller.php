<?php

include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/ordermodel.php';
include '../model/customermodel.php';
include '../model/payment.php';
include '../model/stockmodel.php';


$oborder=new order();
$obcus=new customer();
$obpay = new payment();
$obstock=new stock();
$user_id=$userInfo['user_id'];

$cus_id=$_REQUEST['cus_id'];
$uni_id=$_REQUEST['uni_id'];
$action=$_REQUEST['action'];

if($action=='addcart'){
    $cus_id=$_REQUEST['cus_id'];
    $item_id=$_REQUEST['item_id'];
    $color_id=$_POST['color_id'];
    $size_id=$_POST['size_id'];
    $quantity=$_POST['qua'];
    $totalprice=$_POST['cart_price'];
    
    $rorder=$oborder->checkOrderIn($uni_id);
    $nor=$rorder->rowcount();
     
   
    if($nor==0){
        $order_id=$oborder->addOrderIn($cus_id,"pending",$uni_id,$user_id);
    }else{    
        $roworder=$rorder->fetch(PDO::FETCH_BOTH);
        $order_id=$roworder['order_id'];
    }
    $oborder->addTempCartIn($order_id, $item_id, $quantity, $totalprice, $color_id, $size_id);
    //echo $order_id;
    
    //To redirect to the cart
    //header("Location:../Pages/viewcart.php?order_id=$order_id");
   
        //$order_id=$oborder->addOrderIn($item_id, $quantity,$color_id, $size_id,"pending",$totalprice,$user_id);
        
        //$obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
    //echo $order_id;
    
    //To redirect to the cart
   header("Location:../view/addaorder.php?order_id=$order_id&item_id=$item_id&cus_id=$cus_id&uni_id=$uni_id");
    
}

if($action=='success1'){
    $order_id=$_GET['order_id'];
     $resultsid = $oborder->checkOrderIn($order_id);
   // $rowsid = $resultsid->fetch(PDO::FETCH_BOTH);
    //$order_id = $rowsid['order_id'];
  
   
    
    $pay_id=$obpay->addPaymentIn($order_id,$tot ,$totp, $dis);
    
    $oborder->updateOrderIn("Paid", $totp,$order_id);
    
    
   $resultso=$oborder->viewOrderIn($order_id);
   while($rowo = $resultso->fetch(PDO::FETCH_BOTH)){
        $item_id=$rowo['item_id'];
      $color_id=$rowo['color_id'];
      $size_id=$rowo['size_id'];
      $quan= $rowo['qsum'];
      $cart_price=$rowo['total_price'];
       
      
      $obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
      
      
       
   }
   
   
   
   header("Location:../view/invoice.php?order_id=$order_id");
}

if($action=='success'){
   // $sid;   
   // $dis=$_SESSION['dis'];
   // $totp=$_SESSION['totp'];
   // $rowcus=$_SESSION['rowcus'];
    $cus_id=$_REQUEST['cus_id'];
    
    
    $order_id =$_REQUEST['order_id'];
    $resulttot=$oborder->getTotalCartPriceIn($order_id);
    $rowtot=$resulttot->fetch(PDO::FETCH_BOTH);
    $tot=$rowtot['tot'];
    function getDisscout($tot){
    if($tot>=40000){
        return .10;
    }else if($tot>30000){
        return 0.75;
    }else if($tot>20000){
        return 0.05;
    }else{
        return 0;
    }
}

 $discount= getDisscout($tot);
 $dis=$tot*$discount;
 $totp=$tot-$dis;
    
    $pay_id=$obpay->addPaymentIn( $order_id,$cus_id,$totp,$dis);
    
    $oborder->updateOrderIn("Paid",$tot,$order_id);
  
    $resultso=$oborder->viewCartIn($order_id);
    while($rowo = $resultso->fetch(PDO::FETCH_BOTH)){
        $item_id=$rowo['item_id'];
      $color_id=$rowo['color_id'];
      $size_id=$rowo['size_id'];
      $quan= $rowo['qsum'];
      $cart_price=$rowo['cart_price'];
       $time_id=$rowo['time_id'];
      
      $obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
      $oborder->addTCartIn($order_id, $item_id, $quan, $cart_price, $color_id, $size_id);
      $oborder->deleteItemsFromTempCartIn($order_id);
       
   }
   
  header("Location:../view/invoice.php?order_id=$order_id&cus_id=$cus_id");
   
   
   
    
    
    
    
    
}