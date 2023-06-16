<?php
$m_id=7;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../common/functions.php';
$countm=checkModuleRole($m_id,$role_id);
if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$user_id=$_REQUEST['user_id'];
include '../model/usermodel.php';
$obu=new user();
$resultuser=$obu->viewAUser($user_id);
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

include '../model/districtmodel.php';
$dis_id=$rowuser['dis_id'];
$obdis=new district();
$resultdis=$obdis->displayDistrict($dis_id);
$rowdis=$resultdis->fetch(PDO::FETCH_BOTH);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" 
              type="text/css" />
        <link type="text/css" rel="stylesheet" href="../css/style.css" />
        <link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script>
function displayDis(str) {
  var xhttp; 
  if (str == "") {
    document.getElementById("showdistrict").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showdistrict").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../ajax/getDistrict.php?q="+str, true);
  xhttp.send();
}

function displayCities(str) {
  var xhttp; 
  if (str == "") {
    document.getElementById("showcity").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showcity").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../ajax/getCity.php?q="+str, true);
  xhttp.send();
}
       </script>
    
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
                        <li ><a href="../view/user.php">User Home</a></li>
                        <li ><a href="../view/viewallusers.php">View All Users</a></li>
                        <li class="active">View User</li></div>
                    </ol>                    
                    </div>
                </div>           
              <div style="height: 40px"><?php include '../common/usertab.php';?></div>                   
            <div class="clearfix"></div>
            <div id="contents">
                
                <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">View User</h3>
                    </div>
                </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-1">
                                <?php 
                               
                                if($rowuser['user_image']==""){
                                    $user_image="../images/user.png";
                                }else{
                                $user_image="../images/user_images/".$rowuser['user_image']; 
                                }
                                ?>
                                <img src="<?php echo $user_image; ?>" width="200"
                                     style="border-radius: 250px"/>
                            </div>
                            <div class="col-md-6">
                                &nbsp;
                                
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6"><p>First Name</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_fname']; ?>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Last Name</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_lname']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>DOB</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_dob']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Gender</p></div>
                            <div class="col-md-6">
                                <?php echo ucfirst($rowuser['user_gender']); ?>
                            </div>
                        </div>
                           <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Email</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_email']; ?>
                            </div>
                        </div>
                             <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Tel No</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_tel']; ?>
                            </div>
                        </div>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>NIC</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_nic']; ?>
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Address</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['user_add']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Province</p></div>
                            <div class="col-md-6">
                                <?php echo $rowdis['pro_name']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>District</p></div>
                            <div class="col-md-6">
                                <?php echo $rowdis['dis_name']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Role Name</p></div>
                            <div class="col-md-6">
                                <?php echo $rowuser['role_name']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                                 <div class="col-md-6"><p>
                                         <a href="../view/updateuser.php?user_id=<?php echo $rowuser['user_id']; ?> ">
                                        <button type="button" class="btn btn-sm btn-primary">Update</button>
                                    </a>
                                         <?php
                                         if($rowuser['user_status']=="Active"){
                                     $status=1;
                                     $sname="Deactivate";//Label
                                     $style="danger"; //Button style
                                 }else{
                                     $status=0;
                                     $sname="Activate";
                                     $style="default";
                                 }?>
                                         <a href="../controller/usercontroller.php?user_id=<?php echo $rowuser['user_id']; ?>&status=<?php echo $status; ?>&action=ACDAC&page=<?php echo $page; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-<?php echo $style; ?>" onclick="return confirmation('<?php echo $sname; ?>')">
                                        <?php echo $sname; ?>
                                    </button>
                                    </a>
                                 </p></div>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>
                    </div>                    
                </div>
                        
                              
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
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
    <script type="text/javascript" src="../plugins/jQuery/jQuery-2.1.4.min.js">
    </script>
    <!-- External JS for validation -->
    <script src="../js/validation.js"></script>
</html>
