<?php

if(!isset($_SESSION)){
    session_start();
}

include '../../Apps/common/dbconnection.php';
include '../../Apps/model/ordermodel.php';
include '../../Apps/model/customermodel.php';
include '../../Apps/model/payment.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/notificationmodel.php';

$oborder=new order();
$obcus=new customerin();
$obpay = new payment();
$obstock=new stock();
$obnot=new notification();


$sid=$_SESSION['sid'];
$action=$_REQUEST['action'];

if($action=='addcart'){
    
    $item_id=$_REQUEST['item_id'];
    $color_id=$_POST['color_id'];
    $size_id=$_POST['size_id'];
    $quantity=$_POST['qua'];
    $cart_price=$_POST['cart_price'];
    
    $rorder=$oborder->checkOrder($sid);
    $nor=$rorder->rowcount();
     
   
    if($nor==0){
        $order_id=$oborder->addOrder("pending",$sid);
    }else{    
        $roworder=$rorder->fetch(PDO::FETCH_BOTH);
        $order_id=$roworder['order_id'];
    }
    $oborder->addTempCart($order_id, $item_id, $quantity, $cart_price, $color_id, $size_id);
    //echo $order_id;
    
    //To redirect to the cart
    header("Location:../Pages/viewcart.php?order_id=$order_id");
    
}

if($action=="signin"){
    $cus_email=$_POST['cus_email'];//To get customer email
    $cus_pwd=sha1($_POST['cus_pwd']);//To get customer password
    $rcus=$obcus->checkCusLoging($cus_email, $cus_pwd);//check the email & password with the customer table
    $nor=$rcus->rowcount();//to check whether previously
    
    $url=$_SESSION['url'];
    
    if($nor){
       $arr= explode("/", $url);
       $page=$arr[(count($arr)-1)];
       if($page=="signup.php"){
           $url="../Pages/index.php";
       }
       $rowcus=$rcus->fetch(PDO::FETCH_BOTH);
       $_SESSION['rowcus']=$rowcus;
      header("Location:$url");
    }else{
       $msg="Invalid customer email or password";
       header("Location:../Pages/signup.php?msg=$msg");
    }
}

if($action=="signup"){
     $arr=$_POST;
     $cus_email=$_POST['cus_email'];
      $cus_pwd=$_POST['cus_pwd'];
     $resultcus=$obcus->checkCusEmail($cus_email);
     $nor=$resultcus->rowcount();
     
     if($nor==0){
        $cus_id=$obcus->addCustomer($arr);
     
        if($cus_id){
    $rcus=$obcus->checkCusLoging($cus_email, $cus_pwd);
     $rowcus=$rcus->fetch(PDO::FETCH_BOTH);
       $_SESSION['rowcus']=$rowcus;
    $url=$_SESSION['url'];
    
 
       $arr= explode("/", $url);
       $page=$arr[(count($arr)-1)];
       if($page=="signup.php"){
           $url="../Pages/index.php";
       }
       
      header("Location:$url");
    }else{
       $msg="Can not be added";
       header("Location:../Pages/signup.php?msg=$msg");
    }
        
     }else{
         $msg="Existing customer email";
      header("Location:../Pages/signup.php?msg=$msg");
     }
}


if($action=='signout'){
    unset($_SESSION['sid']);
    unset($_SESSION['rowcus']);    
    header("Location:../Pages/index.php");
}

if($action=='success'){
    $sid;   
    $dis=$_SESSION['dis'];
    $totp=$_SESSION['totp'];
    $rowcus=$_SESSION['rowcus'];
    $cus_id=$rowcus['cus_id'];
    
    $resultsid = $oborder->checkOrder($sid);
    $rowsid = $resultsid->fetch(PDO::FETCH_BOTH);
    $order_id = $rowsid['order_id'];

    
    
    $pay_id=$obpay->addPayment($cus_id, $order_id, $totp, $dis);
    
    $oborder->updateOrder("Paid", $totp,$cus_id, $order_id);
    
    //for email
    $html="Order ID:".$order_id."Customer Name:".$rowcus['cus_name'];
    require_once '../php_mailer/PHPMailer/PHPMailerAutoload.php';
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth=true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Username='dukeerjenorge@gmail.com';
    $mail->Password='rehanaRox_12J';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->From="info@sos.info";
    $mail->FromName='SOS';
    $mail->addAddress($rowcus['cus_email'], $rowcus['cus_name']);
    //$mail->AddCC("gihan798114@gmail.com");
    // $mail->addAttachment('images/logo_single.jpg');
    //$mail->addAttachment('Ceylon_Government_Railways_logo.jpg');
    $mail->isHTML(true);
    //$mail->AddEmbeddedImage('../../images/Ceylon_Government_Railways_logo.gif', 'logoimg', 'logo.gif'); 
    //$mail->AddEmbeddedImage('../../images/sintameng2.PNG', 'logoimg1', 'sintameng2.PNG'); 
    //$mail->AddEmbeddedImage('../../images/Government_of_Sri_Lanka.png', 'logoimg2', 'logo.gif'); 
    $mail->Subject="ORDER CONFIRMATIONN";
    $mail->Body= $html;
    $mail->AltBody = $html;

   if($mail->send()){
           $m="Yes";
           $er="";
   }else{
            $m="No";
           $er=$mail->ErrorInfo;
   }
    

   
   
   $resultso=$oborder->viewCart($order_id);
   while($rowo = $resultso->fetch(PDO::FETCH_BOTH)){
        $item_id=$rowo['item_id'];
      $color_id=$rowo['color_id'];
      $size_id=$rowo['size_id'];
      $quan= $rowo['qsum'];
      $cart_price=$rowo['cart_price'];
       $time_id=$rowo['time_id'];
      
      $obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
      $oborder->addTCart($order_id, $item_id, $quan, $cart_price, $color_id, $size_id);
      $oborder->deleteItemsFromTempCart($order_id);
       
   }
   $user_id="";
   $not_id=$obnot->addNoticationAuto($html, "Email Notification", 0, "Ind");
   $obnot->addNoticationUser($not_id, $user_id, $cus_id, $m, $er);
   
   
   
    
   unset($_SESSION['dis']);
   unset($_SESSION['sid']);
   unset($_SESSION['totp']);

  header("Location:../Pages/invoice.php?order_id=$order_id");
   
   
   
   
   
}
