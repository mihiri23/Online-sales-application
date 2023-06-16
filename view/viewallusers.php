<?php
$m_id = 7;
include '../common/sessionhandling.php';
$role_id = $userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/usermodel.php';
include '../common/functions.php';

$countm = checkModuleRole($m_id, $role_id);
if ($countm == 0) {// to check user privilages
    $msg = base64_encode("You don't have permission to access");
    header("Location:../view/login.php?msg=$msg");
}



//start 
$obuser = new user();
$resultn = $obuser->ViewUserByRole("1");
$nor = $resultn->rowCount(); //echo how many users
$nop = ceil($nor / 5); //to get how much pages are needed

$obuser = new user();
$resultn = $obuser->ViewUserByRole("2");
$nor = $resultn->rowCount(); //echo how many users
$nopa = ceil($nor / 5); //to get how much pages are needed

$obuser = new user();
$resultn = $obuser->ViewUserByRole("3");
$nor = $resultn->rowCount(); //echo how many users
$nopb = ceil($nor / 5); //to get how much pages are needed

$obuser = new user();
$resultn = $obuser->ViewUserByRole("4");
$nor = $resultn->rowCount(); //echo how many users
$nopc = ceil($nor / 5); //to get how much pages are needed

$obuser = new user();
$resultn = $obuser->ViewUserByRole("");
$nor = $resultn->rowCount(); //echo how many users
$nopd = ceil($nor / 5); //to get how much pages are needed



if (!isset($_GET['page']) || $_GET['page'] == 1) {
    $start = 0;
    $page=1;
}
else{
    $page=$_GET['page'];
    $start=$page*5-5; //ex page 2 = 2*5-5 = must load until 10 
}
$limit=5;
$result=$obuser->viewUserRoleLimited($start, $limit,"1");
$resulta=$obuser->viewUserRoleLimited($start, $limit,"2");
$resultb=$obuser->viewUserRoleLimited($start, $limit,"3");
$resultc=$obuser->viewUserRoleLimited($start, $limit,"4");
$resultd=$obuser->viewUserRoleLimited($start, $limit,"");
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="../css/style.css"/>

    </head>
    <body>
        <div id="main">
            <div id="heading">

                <?php include '../common/header.php'; ?>

            </div>

            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                        <img src="<?php echo $iname; ?>" class="style1" />
                        <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                    <ol class="breadcrumb">
                        <li ><a href="../view/dashboard.php">Dashboard</a></li>
                        <li ><a href="../view/User.php">User Home</a></li>
                        <li class="active">View All Users</li></div>
                    </ol>                    
                    </div>
                </div>
        </div>
        <?php include '../common/usertab.php';?>
        <div class="clearfix"></div>
         <div class="row">
                    <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">All Users</h3>
                    </div>
                </div>
        <div class="row" style="height:20px; background:linear-gradient(#ffffff);" ></div>
        <div id="content">            
           
            <div style="text-align: center">
                <?php
                if (isset($_GET['msg'])) {
                    echo base64_decode($_GET['msg']);
                }
                ?>
            </div>
            
            <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Owners</div>
                                    <div class="panel-body"> 
                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center">                                                    
                            <?php include '../common/tr.php'; ?>                            
                            <?php
                            while ($row = $result->fetch(PDO::FETCH_BOTH)) {
                                if ($row['user_image'] == "") {
                                    $uimage = "../images/bt9.png";
                                } else {
                                    $uimage = "../images/user_images/" . $row['user_image'];
                                }
                                if ($row['user_status'] == "Active") {
                                    $status = 1;
                                    $sname = "Deactivate"; //label
                                    $style = "danger"; //button style
                                } else {
                                    $status = 0;
                                    $sname = "Activate";
                                    $style = "default";
                            }
                            ?>
                        <?php include '../common/trinphp.php'; ?>                            
                        <?php } ?>
                    </table>
                            <nav>
                        <ul class="pagination pagination-sm" style="font-weight: bold ; padding-left: 550px;">
                            <?php for($i=1;$i<=$nop;$i++){ ?> 
                            <li>
                                <a href="../view/viewallusers.php?page=<?php echo $i; ?>"><?php echo $i ?></a>
                            </li><?php } ?>
                            
                        </ul></nav>
                </div>
                </div>
                    
                </div>
            </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
            
            <!--Admin Table-->
            
            <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Admin users</div>
                                    <div class="panel-body"> 
                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center">                                                    
                            <?php include '../common/tr.php'; ?>                            
                            <?php
                            while ($row = $resulta->fetch(PDO::FETCH_BOTH)) {
                                if ($row['user_image'] == "") {
                                    $uimage = "../images/bt9.png";
                                } else {
                                    $uimage = "../images/user_images/" . $row['user_image'];
                                }
                                if ($row['user_status'] == "Active") {
                                    $status = 1;
                                    $sname = "Deactivate"; //label
                                    $style = "danger"; //button style
                                } else {
                                    $status = 0;
                                    $sname = "Activate";
                                    $style = "default";
                            }
                            ?>
                        <?php include '../common/trinphp.php'; ?>                            
                        <?php } ?>
                    </table>
                            <nav>
                        <ul class="pagination pagination-sm" style="font-weight: bold ; padding-left: 550px;">
                            <?php for($i=1;$i<=$nopa;$i++){ ?> 
                            <li>
                                <a href="../view/viewallusers.php?page=<?php echo $i; ?>"><?php echo $i ?></a>
                            </li><?php } ?>
                            
                        </ul></nav>
                </div>
                </div>
                    
                </div>
            </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
            
            <!--Manager Table-->
            
            <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Managers</div>
                                    <div class="panel-body"> 
                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center">                                                    
                            <?php include '../common/tr.php'; ?>                            
                            <?php
                            while ($row = $resultb->fetch(PDO::FETCH_BOTH)) {
                                if ($row['user_image'] == "") {
                                    $uimage = "../images/bt9.png";
                                } else {
                                    $uimage = "../images/user_images/" . $row['user_image'];
                                }
                                if ($row['user_status'] == "Active") {
                                    $status = 1;
                                    $sname = "Deactivate"; //label
                                    $style = "danger"; //button style
                                } else {
                                    $status = 0;
                                    $sname = "Activate";
                                    $style = "default";
                            }
                            ?>
                        <?php include '../common/trinphp.php'; ?>                            
                        <?php } ?>
                    </table>
                            <nav>
                        <ul class="pagination pagination-sm" style="font-weight: bold ; padding-left: 550px;">
                            <?php for($i=1;$i<=$nopb;$i++){ ?> 
                            <li>
                                <a href="../view/viewallusers.php?page=<?php echo $i; ?>"><?php echo $i ?></a>
                            </li><?php } ?>
                            
                        </ul></nav>
                </div>
                </div>
                    
                </div>
            </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
            
            <!--Staff Table-->
            
            <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Staff</div>
                                    <div class="panel-body"> 
                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center">                                                    
                            <?php include '../common/tr.php'; ?>                            
                            <?php
                            while ($row = $resultc->fetch(PDO::FETCH_BOTH)) {
                                if ($row['user_image'] == "") {
                                    $uimage = "../images/bt9.png";
                                } else {
                                    $uimage = "../images/user_images/" . $row['user_image'];
                                }
                                if ($row['user_status'] == "Active") {
                                    $status = 1;
                                    $sname = "Deactivate"; //label
                                    $style = "danger"; //button style
                                } else {
                                    $status = 0;
                                    $sname = "Activate";
                                    $style = "default";
                            }
                            ?>
                        <?php include '../common/trinphp.php'; ?>                            
                        <?php } ?>
                    </table>
                            <nav>
                        <ul class="pagination pagination-sm" style="font-weight: bold ; padding-left: 550px;">
                            <?php for($i=1;$i<=$nopc;$i++){ ?> 
                            <li>
                                <a href="../view/viewallusers.php?page=<?php echo $i; ?>"><?php echo $i ?></a>
                            </li><?php } ?>
                            
                        </ul></nav>
                </div>
                </div>
                    
                </div>
            </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
            
            <!--Others Table-->
            
            <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Other users</div>
                                    <div class="panel-body"> 
                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center">                                                    
                            <?php include '../common/tr.php'; ?>                            
                            <?php
                            while ($row = $resultd->fetch(PDO::FETCH_BOTH)) {
                                if ($row['user_image'] == "") {
                                    $uimage = "../images/bt9.png";
                                } else {
                                    $uimage = "../images/user_images/" . $row['user_image'];
                                }
                                if ($row['user_status'] == "Active") {
                                    $status = 1;
                                    $sname = "Deactivate"; //label
                                    $style = "danger"; //button style
                                } else {
                                    $status = 0;
                                    $sname = "Activate";
                                    $style = "default";
                            }
                            ?>
                        <?php include '../common/trinphp.php'; ?>                            
                        <?php } ?>
                    </table>
                            <nav>
                        <ul class="pagination pagination-sm" style="font-weight: bold ; padding-left: 550px;">
                            <?php for($i=1;$i<=$nopd;$i++){ ?> 
                            <li>
                                <a href="../view/viewallusers.php?page=<?php echo $i; ?>"><?php echo $i ?></a>
                            </li><?php } ?>
                            
                        </ul></nav>
                </div>
                </div>
                    
                </div>
            </div>
            
        </div>
        <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
        <div id="footer" ><?php include '../common/footer.php'; ?></div>

    </div>
</body>
<script>
    function confirmation(str){
        var r =confirm("DO you want to "+str+" user ?");// To confirm the AC or DAC
        if(!r){
            return false;
        }
    }
    </script>
</html>
