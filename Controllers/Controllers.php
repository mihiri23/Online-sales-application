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

$oborder=new order();//To call order class
$obcus=new customer();//To call customer class
$obpay = new payment();//To call payment class
$obstock=new stock();//To call stock class
$obnot=new notification();//To call notification class

//To create session id for the customer
$sid=$_SESSION['sid'];
$action=$_REQUEST['action'];
//To add details for temp cart table and order table
if($action=='addcart'){
    
    $item_id=$_REQUEST['item_id'];//To get item id through url
    $color_id=$_POST['color_id'];
    $size_id=$_POST['size_id'];
    $quantity=$_POST['qua'];
    $cart_price=$_POST['cart_price'];
    //To check if there is order id for the session id
    $rorder=$oborder->checkOrder($sid);
    $nor=$rorder->rowcount();
     
   //if there is no order id for session id it will add as a new order
    if($nor==0){
        $order_id=$oborder->addOrder("pending",$sid);
    }else{    
        $roworder=$rorder->fetch(PDO::FETCH_BOTH);
        $order_id=$roworder['order_id'];//if there is order id for the session 
    }
    //To add items temporary to the cart
    $oborder->addTempCart($order_id, $item_id, $quantity, $cart_price, $color_id, $size_id);
    //echo $order_id;
    
    //To redirect to the cart
    header("Location:../Pages/viewcart.php?order_id=$order_id");
    
}
//To edit the cart
if($action=='updatecart'){
    $order_id=$_REQUEST['order_id'];
    $item_id=$_REQUEST['item_id'];
    $color_id=$_POST['color_id'];
    $size_id=$_POST['size_id'];
    $quantity=$_POST['qua'];
    $cart_price=$_POST['cart_price'];
    $oborder->UpdateTempCart($order_id, $item_id, $quantity, $cart_price, $color_id, $size_id);//to call update method
    //echo $order_id;
    
    //To redirect to the cart
    header("Location:../Pages/viewcart.php?order_id=$order_id");
    
}


if($action=="signin"){
    $cus_email=$_POST['cus_email'];//To get customer email
    $cus_pwd=($_POST['cus_pwd']);//To get customer password
    $rcus=$obcus->checkCusLoging($cus_email, $cus_pwd);//check the email & password with the customer table
    $nor=$rcus->rowcount();//to check whether previously
    
    $url=$_SESSION['url'];
    
    if($nor){
       $arr= explode("/", $url);
       $page=$arr[(count($arr)-1)];
       if($page=="signup.php"){
           $url="../Pages/index.php";//directed to the index page of the web site
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
     $resultcus=$obcus->checkCusEmail($cus_email);//to check whether the customer email is already in the database
     $nor=$resultcus->rowcount();
     
     if($nor==0){
        $cus_id=$obcus->addCustomer($arr);
     
        if($cus_id){
    $rcus=$obcus->checkCusLoging($cus_email, $cus_pwd);//to get the details of the customer according to their user name and password
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
    unset($_SESSION['sid']);//sesion willbe  destoyed
    unset($_SESSION['rowcus']);    
    header("Location:../Pages/index.php");
}
//pay and reduce from stock after pay
if($action=='success'){
    $sid;   
    $dis=$_SESSION['dis'];
    $totp=$_SESSION['totp'];
    $rowcus=$_SESSION['rowcus'];
    $cus_id=$rowcus['cus_id'];
    
    $resultsid = $oborder->checkOrder($sid);
    $rowsid = $resultsid->fetch(PDO::FETCH_BOTH);
    $order_id = $rowsid['order_id'];

    
    
    $pay_id=$obpay->addPayment($cus_id, $order_id, $totp, $dis); //add details to payment table
    
    $oborder->updateOrder("Paid", $totp,$cus_id, $order_id);//To update order table
    
    //for email
    $html="Order ID:".$order_id." "."and your Pay ID:".$pay_id;
   $html1=$rowcus['cus_name'];
    require_once '../php_mailer/PHPMailer/class.phpmailer.php';
    
//    $mail = new PHPMailer;
//    $mail->isSMTP();
//    $mail->SMTPAuth=true;
//    $mail->Host = 'smtp.gmail.com';
//    $mail->Username='deshapriyatradecenter@gmail.com';
//    $mail->Password='desha321';
//    $mail->SMTPSecure='ssl;';
//    $mail->Port=465;
//    $mail->From="Deshapriya Trade Center";
//    $mail->FromName='DTC';
//    $mail->addAddress($rowcus['cus_email'], $rowcus['cus_name']);
//    //$mail->AddCC("gihan798114@gmail.com");
//    // $mail->addAttachment('images/logo_single.jpg');
//    //$mail->addAttachment('Ceylon_Government_Railways_logo.jpg');
//    $mail->isHTML(true);
//    //$mail->AddEmbeddedImage('../../images/Ceylon_Government_Railways_logo.gif', 'logoimg', 'logo.gif'); 
//    //$mail->AddEmbeddedImage('../../images/sintameng2.PNG', 'logoimg1', 'sintameng2.PNG'); 
//    //$mail->AddEmbeddedImage('../../images/Government_of_Sri_Lanka.png', 'logoimg2', 'logo.gif'); 
//    $mail->Subject="ORDER CONFIRMATIONN";
//    $mail->Body= $html;
//    $mail->AltBody = $html;
//
//   if($mail->send()){
//           $m="Yes";
//           $er="";
//   }else{
//            $m="No";
//            $er=$mail->ErrorInfo;
//   }
  
   // require_once ("");
 $mail = new PHPMailer(); 
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled,  // Enable SMTP authentication
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail,  // Enable TLS encryption, `ssl` also accepted
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587, // TCP port to connect to
$mail->IsHTML(true);
$mail->Username = "deshapriyatradecenter@gmail.com";  // SMTP username
$mail->Password = "desha321";  // SMTP password
$mail->SetFrom("deshapriyatradecenter@gmail.com");
$mail->Subject = "Payment Details";//subject for email
$mail->Body ="Dear Customer :: $html1,<br/><br/>" //body of the email
                    ."We have received your payment.<br/>Your $html.<br/>Thank you for shopping with us.<br/>"
                    ."<br/>"
                    ."From,<br/>"
                    ."Deshapriya Trade Center.<br/>"
                    ."Showroom address: No. 93/B, Ambalammulla, Seeduwa.<br/>"
                    ."Contact Number: 011 2599626.";
$mail->AddAddress($rowcus['cus_email']);// Add a recipient
$mail->AddReplyTo('deshapriyatradecenter@gmail.com', 'Information');
 if($mail->send()){
         $m="Yes";
          $er="";
  }else{
            $m="No";
            $er=$mail->ErrorInfo;
   }
 echo $m;
   //to view item cart table
   $resultso=$oborder->viewCart($order_id);
   while($rowo = $resultso->fetch(PDO::FETCH_BOTH)){
        $item_id=$rowo['item_id'];
      $color_id=$rowo['color_id'];
      $size_id=$rowo['size_id'];
      $quan= $rowo['qsum'];
      $cart_price=$rowo['cart_price'];
       $time_id=$rowo['time_id'];
      //to reduce the stock
      $obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
      //add the ordered item to the cart from tempcart
      $oborder->addTCart($order_id, $item_id, $quan, $cart_price, $color_id, $size_id);
       //delete from the temp cart
      $oborder->deleteItemsFromTempCart($order_id);
     //do not delete  
   }
   $user_id="";
   //To add notification into notification table
   $not_id=$obnot->addNoticationAuto($html, "Email Notification", 0, "Ind");
   $obnot->addNoticationUser($not_id, $user_id, $cus_id, $m, $er);
   
   
   
    
   unset($_SESSION['dis']);
   unset($_SESSION['sid']);
   unset($_SESSION['totp']);

 header("Location:../Pages/invoice.php?order_id=$order_id");
   
   
   
   
   
}


 //require_once('../php_mailer/PHPMailer/class.phpmailer.php');
 // create a new object
class MyMails{
   
   public function mailTemplet($subject,$body,$receiverAddress){

}
}
?>
