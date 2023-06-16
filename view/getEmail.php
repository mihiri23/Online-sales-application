<?php

include '../common/dbconnection.php';
include '../model/loginmodel.php';

$oblogin=new login();
$email=$_GET['q'];

$patemail='/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z]{2,6})+$/';
if(preg_match($patemail,$email)){

$n=$oblogin->checkEmail($email);
    if($n==1){
        echo "<i class='text-danger'>Not available</span>";
        $status=1;
    }else{
        echo "<i class='text-success'>Avaliable</i>";
        $status=0;
    }

}else{
    echo "<i class='text-danger'>Invalid Email Address</i>";
    $status=1;
}
?>
<input type="hidden" name="hid" id="hid" value="<?php echo $status; ?>" />

