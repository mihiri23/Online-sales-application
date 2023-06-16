<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/notificationmodel.php';
include '../model/usermodel.php';
$obnot=new notification();
$obuser=new user();
$user_id=$userInfo['user_id'];

$action =strtolower($_REQUEST['action']);

switch ($action) {
    case "add":
        $arr=$_POST;        
      $type=$arr['type'];
      $msg=$arr['msg'];      
      $not_id=$obnot->addNoticationAuto($msg, $type, $user_id, "Added");
        $cus_id=0; $s="Yes"; $e="";
      foreach ($arr['role'] as $v){
         // echo $v;
          $resultusers=$obnot->getUsersBaseonRole($v);
          while($rowusers= $resultusers->fetch(PDO::FETCH_BOTH)) {
              $user_id=$rowusers['user_id'];
              $obnot->addNoticationUser($not_id, $user_id, $cus_id, $s, $e);
              //echo "<br />";
          }
          //echo "<br />";
      }
       header("Location:../view/notification.php"); 
      break;
        
       
} 
?>