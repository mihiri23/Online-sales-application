 <?php
 date_default_timezone_set("Asia/Colombo");
 $m_id=9;
 
include '../common/sessionhandling.php';
include '../common/dbconnection.php';

include '../common/functions.php';
include '../model/rolemodel.php';

$role_id=$userInfo['role_id'];
$countm= checkModuleRole($m_id, $role_id);

if ($countm==0){ // check user priviledges
   $msg= base64_encode("You dont have permission to access.") ;
   header("Location:../view/login.php?msg=$msg");
   
}
$obrole=new role();
$resultrole=$obrole->displayRoles();
//echo $path;
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="../css/style.css" type="text/css"/>
   
   
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                <!-- to display name and image beside logout -->
            </div>
            <div id="navi" style="background: #f5f5f5">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                    <img class="style1" src="<?php echo $iname; ?>" />
                    <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li><a href="../view/notification.php">Notification Module</a></li>
                            <li class="active">Add a Notification</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    
                  
                    <div class="col-md-12 col-sm-6">
                        <h3 class="alig">Add a Notification</h3>
                    </div>
                </div>
                
                      
                <div class="clearfix">&nbsp;</div>
<!--                <div style="text-align: center" class="alert alert-danger">
                    <?php
                    if (isset($_GET['msg'])){
                        echo base64_decode($_GET['msg']);
                    }
                    ?>
                    
                </div>-->
                
                 <div class="clearfix">&nbsp;</div>
                   
                <div class="row container-fluid" style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div class="container-fluid">
                            <form action="../controller/notificationcontroller.php?action=add" method="post">
                               <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2">Type : </div>
                                <div class="col-md-3">
                                    <select id="type" name="type" class="form-control"
                                            required>
                                        <option value="">Select a Type</option>
                                        <option value="Email Notification">
                                            Email Notification</option>
                                        <option value="Special alerts">
                                            Special alerts</option>
                                        <option value="General alerts">
                                            General alerts</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">Message</div>
                                <div class="col-md-3">
                                    <textarea class="form-control" 
                                              required name="msg" id="msg"></textarea>
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row container-fluid">
     <?php while($rowrole=$resultrole->fetch(PDO::FETCH_BOTH)){ ?>
                                <div class="col-md-3">
                                    <input type="checkbox" name="role[]"
                                           value="<?php echo $rowrole['role_id']; ?>" />
                        <?php echo $rowrole['role_name']; ?>            
                                </div>
     <?php } ?>
                            </div>
                           
                            <div class="clearfix">&nbsp;</div>
                             
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-5" align="right">
                                    <input type="submit" class="btn btn-success" value="Save"/>
                                </div>
                                <div class="col-md-5">
                                    <input type="reset" class="btn btn-danger"/>
                                </div>
                                
                                
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            
                            </form>    
                              
                        </div>
                    
                  
                 </div>
                </div>
        </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
   
     <script>
            //To check Integers and Dot
function onlyNos(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
					// 31 is Unit Separator, 48 is Zero, 57 is Nine, 88 is Uppercase X, 46 is dot
                    return false;
                }
                return true;
            }
            catch (err) {
                alert(err.Description);
            }
        }           
            
            </script>
</html>
