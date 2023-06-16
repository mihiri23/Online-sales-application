<?php
session_start(); //start a session
date_default_timezone_set("Asia/colombo");
include '../model/loginmodel.php';
include '../model/logmodel.php';
include '../common/dbconnection.php';
include '../common/functions.php';
$con=$GLOBALS['con'];
//Validate Email and password in DB
$user_email=$_POST['txtEmail'];
$user_pwd=sha1($_POST['txtPassword']); //One way encrption
$oblogin=new login(); //To create an object
$r=$oblogin->userlogin($user_email, $user_pwd);
$nor=$r->rowCount();
if($nor){
    $row=$r->fetch(PDO::FETCH_BOTH);
    
    $log_status="login";
    $log_ip= get_ip_address();
    $user_id=$row['user_id'];
    $time_id=time(); //Time Stamp
    $session_id=$time_id."_".$user_id;
    $oblog=new log();
    $oblog->addlog($log_status, $log_ip, $user_id,$session_id); //Insert data into log table
    array_push($row, $session_id);
    var_dump($row);
    $_SESSION['userInfo']=$row;
    //var_dump($row);
   header("Location:../view/dashboard.php"); //Redirection     
}else{
    
    $msg=base64_encode("Invalid Email or Password"); //Encode the message
    header("Location:../view/login.php?msg=$msg"); //Redirection     
    
}


?>
