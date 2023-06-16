<?php
 $m_id=2;
 include '../common/sessionhandling.php';
 $role_id=$userInfo['role_id'];
 include '../common/dbconnection.php';
// include '../model/customerinmodel.php';
 include '../common/functions.php';
 include '../model/provincemodel.php';
 include '../model/rolemodel.php';

 $countm=checkModuleRole($m_id, $role_id);
 if($countm==0){ //to check user previlages
     $msg=base64_encode("You dont have permission to access");
     header("Location:../view/login.php?msg=$msg");
 }

$cus_id=$_REQUEST['cus_id'];
include '../model/customerinmodel.php';
$obcus=new customerin();
$resultuser=$obcus->viewACustomer($cus_id);
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

$obpro=new province();
 $resultprovinces=$obpro->displayProvinces();
 
 $obrole=new role();
 $resultrole=$obrole->displayRoles();
// $maxdate=date('Y-m-d', strtotime(' -18 year'));
// $maxdate=date('Y-m-d', strtotime(' -60 year'));
 
 //To get Province deails
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
                            <li class="active">Edit Customer</li>
                        </ol>

                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">Edit Customer</h3>
                    </div>
                </div>
                <div class="row" style="height:25px; background:linear-gradient(#ffffff);" ></div> 
                <div class="clearfix">&nbsp;</div>
              <div class="row">
                  <center>
                  <div class="col-md-12 col-sm-6">
                      <?php
                      if(isset($_REQUEST['msg'])){
                          echo "<span class='text text-".$_REQUEST['status']."'>".$_REQUEST['msg']."</span>";
                      }
                      ?>
                      
                  </div>
                  </center>
              </div>
                
                  
              <form method="post" action="../controller/customercontroller.php?action=update&cus_id=<?php echo $cus_id?>" enctype="multipart/form-data">
              <div class="row">
                  <div class="col-md-6 col-md-offset-3">
                      <div class="row">
                          <div class="col-md-6">Customer Name</div>
                          <div class="col-md-6">
                              <input type="text" name="cus_name" id="cus_name" placeholder="Customer Name" class="form-control" value="<?php echo $rowuser['cus_name'];?>" />
                              <div id="uferror" class="error">*</div>
                          </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="row">
                          <div class="col-md-6">Customer City</div>
                          <div class="col-md-6">
                              <input type="text" name="cus_city" id="cus_city" placeholder="City" class="form-control" value="<?php echo $rowuser['cus_city'];?>" />
                              <div id="ulerror" class="error">*</div>
                          </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      
                      <div class="row">
                          <div class="col-md-6">Address</div>
                          <div class="col-md-6">
                              <textarea name="cus_add" id="cus_add" class="form-control" ><?php echo $rowuser['cus_add'];?></textarea>
                          </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="row">
                          <div class="col-md-6">Telephone Number</div>
                          <div class="col-md-6">
                              <input type="text" name="cus_tel" id="cus_tel" placeholder="Telephone No" class="form-control" value="<?php echo $rowuser['cus_tel'];?>"/>
                              <div id="uterror" class="error"></div>
                          </div>
                      </div>
                      
                      <div class="clearfix">&nbsp;</div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="row">
                          
                          <div class="col-md-12" style="text-align: center">
                              <input type="submit" name="up" value="Edit Details" class="btn btn-info"/>
                              
                          </div>
                      </div>
                      
                  </div>
              </div>
              </form>
               
              </div>  
            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
        </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
    
    <script type='text/javascript' src="../plugins/jQuery/jQuery-2.1.4.min.js">
  </script>
  
  <!-- External JS for validation -->
  <script type="text/javascript" src="../js/validationcus.js">
    </script> 
</html>
