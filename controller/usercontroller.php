<?php
include '../common/dbconnection.php';
include "../model/usermodel.php";
include "../model/loginmodel.php";
$obu=new user();
$action=$_REQUEST['action'];
switch ($action){
    case "add":
        $arr=$_POST;
        
        $user_id=$obu->addUser($arr);
        $msg="not";
        $oblogin=new login();
        
        if($user_id){ //If user has been added then
            $user_pwd= sha1('123');
            $oblogin->addLogin($_POST['user_email'], $user_pwd, $user_id);      
            if($_FILES['user_image']['name']!=""){ //If image is not empty
                $user_image=$_FILES['user_image']['name']; //Name of the image
                $user_tmp=$_FILES['user_image']['tmp_name']; //Temp location
                $user_image_new=time()."_".$user_id."_".$user_image;
                $r=$obu->updateUserImage($user_id, $user_image_new, $user_tmp);
                //print_r($r);                             
            }
             $msg="";  
        }       
        $msg1= base64_encode("A record has $msg been added");
        header("Location:../view/adduser.php?msg=$msg1");        
        break;
    case "update":
        $arr=$_POST;
        $user_id=$_REQUEST['user_id'];
        
        //To call updateUser method
        $result=$obu->updateUser($arr, $user_id);
        if($result){
            $msg="A record has been updated";
            $status="success";
            
            if($_FILES['user_image']['name']!=""){ //If image is not empty
                
                //To remove previous image
            $resultuser=$obu->viewAUser($user_id);
            $rowuser=$resultuser->fetch(PDO::FETCH_BOTH);
            $user_pimage=$rowuser['user_image'];
            $oldpath="../images/user_images/".$user_pimage;
            unlink($oldpath);
                
                
                $user_image=$_FILES['user_image']['name']; //Name of the image
                $user_tmp=$_FILES['user_image']['tmp_name']; //Temp location
                $user_image_new=time()."_".$user_id."_".$user_image;
                $r=$obu->updateUserImage($user_id, $user_image_new, $user_tmp);
                //print_r($r); 
                
                
            }
            
             
            
            
            
        }else{
            $msg="A record has not been updated";
            $status="danger";
        }
        //echo $msg;
        header("Location:../view/updateuser.php?user_id=$user_id&msg=$msg&status=$status");
        break;
        
        case "ACDAC":
        $user_id=$_REQUEST['user_id'];
        $status=$_REQUEST['status'];
        if($status){
                        $user_status="Deactive";
        }else{
        $user_status="Active";
        }
       
        $r=$obu->updateUserStatus($user_status, $user_id);
        $last_visited_url=$_SERVER['HTTP_REFERER'];//To get last visited page
        $arrurl=explode("/",$last_visited_url);//Create an array
        $count=count($arrurl);//Get count
        $url=$arrurl[$count-1];//Get page name
        //echo $url
        $uri= explode("?", $url);//explode is using to devide the url by the ?
        //echo $uri[0]
           if ($uri[0]  =="searchuser.php" ){
             echo $search=$_REQUEST['search'] ; 
               echo $page=$_REQUEST['page'];
               header("Location:../view/searchuser.php?search=$search&page=$page");
           }else{
              header("Location:$last_visited_url"); 
           }
        
        break;
        
        
}


?>

