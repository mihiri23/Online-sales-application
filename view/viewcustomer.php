 <?php
 $m_id=2; //the user on module table
 
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
//include '../model/usermodel.php';  //user queries
include '../common/functions.php';


$role_id=$userInfo['role_id'];

$countm= checkModuleRole($m_id, $role_id);

if ($countm=0){ // check user priviledges
   $msg= base64_encode("You dont have permission to access.") ;
   header("Location:../view/login.php?msg=$msg");
   
}

$cus_id=$_REQUEST['cus_id'];
include '../model/customerinmodel.php';
$obcus=new customerin();
$resultuser=$obcus->viewACustomer($cus_id);
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

include '../model/districtmodel.php';
$dis_id=$rowuser['dis_id'];
$obdis=new district();
$resultdis=$obdis->displayDistrict($dis_id);
$rowdis=$resultdis->fetch(PDO::FETCH_BOTH);



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
        
        <script>
        function displayDistrict(str) {
            var xhttp; 
            if (str == "") {
              document.getElementById("showdistrict").innerHTML = "";
              return;
            }
            xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
               // document.getElementById("displayDistrict").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
              if (this.readyState == 4 && this.status == 200) { // be ready for the reply and 200 for success
              document.getElementById("showdistrict").innerHTML = this.responseText;
              }
            };
            xhttp.open("GET", "../ajax/getDistrict.php?q="+str, true); //ajax page
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
               // document.getElementById("displayCity").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
              if (this.readyState == 4 && this.status == 200) { // be ready for the reply and 200 for success
              document.getElementById("showcity").innerHTML = this.responseText;
              }
            };
            xhttp.open("GET", "../ajax/getCity.php?q="+str, true); //ajax page
            xhttp.send();
          }
        </script>
        
    </head>
    <body>
        <div id="main">
            <div style="padding-top:px" id="heading">
                <?php include '../common/header.php'; ?>

            </div>
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">            
                <div class="row" style="padding-top:  px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />

                        <?php echo $userInfo['role_name']; ?>

                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li><a href="../view/customer.php">All Customers</a></li>
                            <li class="active">View Customer</li>
                        </ol>

                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">View Customer</h3>
                    </div>
                </div>
                <div class="row" style="height:25px; background:linear-gradient(#ffffff);" ></div> 
                
                
                <div class="row">
                  <div class="col-md-6 col-md-offset-3">
                      <div class="row">
                          <center>
                          <div class="col-md-12">
                              <?php
                              if($rowuser['user_image']==""){
                                  $user_image="../images/user.png";
                              }else{
                              $user_image="../images/user_images/".$rowuser['user_image'];
                              }
                              ?>
                              <img src="<?php echo $user_image; ?>" width="100" height="100"  style="border-radius: 250px ; border: 2px lightgray solid "/>
                              <hr style="border-top: 2px solid lightgray" />
                          </div>
                              
                          </center>
                          
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="row">
                          <div class="col-md-6">Customer Name</div>
                          <div class="col-md-6">
                              <?php echo $rowuser['cus_name'];?>
                          </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      
                      <div class="row">
                          <div class="col-md-6">Customer City</div>
                          <div class="col-md-6">
                              <?php echo $rowuser['cus_city'];?>
                          </div>
                      </div>
                     <div class="clearfix">&nbsp;</div> 
                      <div class="row">
                          <div class="col-md-6">Address</div>
                          <div class="col-md-6">
                             <?php echo $rowuser['cus_add'];?>
                          </div>
                      </div>
                      
                      <div class="clearfix">&nbsp;</div>
                      
                      <div class="row">
                          <div class="col-md-6">Telephone Number</div>
                          <div class="col-md-6">
                             <?php echo $rowuser['cus_tel'];?>
                          </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                     
                      
                     
                      <div class="clearfix">&nbsp;</div>
                      <div class="row">
                           <div class="col-md-12 col-sm-6">
                          <a href="../view/updatecustomer.php?cus_id=<?php echo $rowuser['cus_id']; ?>">
                                        <button type="button" class="btn btn-sm btn-info"> Edit Customer </button></a>    
                           </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="clearfix">&nbsp;</div>
                  </div>
              </div>
                
               
                
         
               
              </div>  
               
        </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
    
    <script type='text/javascript' src="../plugins/jQuery/jQuery-2.1.4.min.js">
  </script>
  
  <!-- External JS for validation -->
  <script type="text/javascript" src="../js/validation.js">
    </script> 
</html>
