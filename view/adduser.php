<?php
$m_id=7;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../common/functions.php';
include '../model/provincemodel.php';
include '../model/rolemodel.php';
$countm=checkModuleRole($m_id,$role_id);
if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}
$obpro=new province();
$resultprovinces=$obpro->displayProvinces();
$obrole=new role();
$resultrole=$obrole->displayRoles();
$maxdate=date('Y-m-d', strtotime(' -18 year'));
$mindate=date('Y-m-d', strtotime(' -60 year'));

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
                        <li ><a href="../view/User.php">User Home</a></li>
                        <li class="active">Add user</li></div>
                    </ol>                    
                    </div>
                </div>
        </div>
        <div style="height: 40px"><?php include '../common/usertab.php';?></div>        
            <div class="clearfix"></div>            
            <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">Add User</h3>
                    </div>
                </div>
            <div class="row" style="height:20px; background:linear-gradient(#ffffff);" ></div>
            <div id="contents" >
                
                <form method="post" action="../controller/usercontroller.php?action=add" 
                      enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <div class="col-md-6"><p>First Name</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_fname" id="user_fname"
                                       placeholder="User First Name" 
                                       class="form-control" />
                                <div id="uferror" class="error">*</div>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Last Name</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_lname" id="user_lname"
                                       placeholder="User last Name" 
                                       class="form-control" />
                                <div id="ulerror" class="error">*</div>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>DOB</p></div>
                            <div class="col-md-6">
                                <input type="date" name="user_dob" id="user_dob"
                                       placeholder="Date of Birth" 
                                       max="<?php echo date('Y-m-d'); ?>"
                                       class="form-control" 
                                        />
                                <div id="udoberror" class="error"></div>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Gender</p></div>
                            <div class="col-md-6">
                                <input type="radio" name="user_gender" 
                                       id="male" value="male"   
                                       class="" /> Male
                                <input type="radio" name="user_gender" 
                                       id="female" value="female"    
                                       class="" /> Female
                                <div id="ugerror" class="error">*</div>
                            </div>
                        </div>
                           <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Email</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_email" id="user_email"
                                       placeholder="User Email" 
                                       class="form-control" 
                                       onkeyup="checkEmail(this.value)" />
                                <span id="showEmail"></span>
                                <div id="ueerror" class="error">*</div>
                            </div>
                        </div>
                             <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Tel No</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_tel" id="user_tel"
                                       placeholder="User Telephone No" 
                                       class="form-control" />
                                <div id="uterror" class="error"></div>
                            </div>
                        </div>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>NIC</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_nic" id="user_nic"
                                       placeholder="NIC" 
                                       class="form-control" />
                                <div id="unerror" class="error"></div>
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>User Image</p></div>
                            <div class="col-md-6">
                                <input type="file" name="user_image" id="user_image"
                                     class="form-control" 
                                     onchange="readURL(this)" />
                                <div id="uierror" class="error"></div>
                                <img id="image_view" />
                            </div>
                        </div>
                            <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Address</p></div>
                            <div class="col-md-6">
                                <textarea name="user_address" id="user_address"  placeholder="Address" 
                                          class="form-control"></textarea>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Province</p></div>
                            <div class="col-md-6">
                                <select name="pro_id" id="pro_id" 
                                    class="form-control" onchange="displayDis(this.value)">
                                    <option value="">Select a Province</option>
    <?php while($rowprovince=$resultprovinces->fetch(PDO::FETCH_BOTH)){ ?>
               <option value="<?php echo $rowprovince['id']; ?>">
                   <?php echo $rowprovince['name_en']; ?>
               </option>
    <?php } ?>                                </select>
                                <div id="uperror" class="error">*</div>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>District</p></div>
                            <div class="col-md-6">
                                <!-- To load/show all districts in a selected province -->
                                <span id="showdistrict">
                                <select name="dis_id" id="dis_id" 
                                        class="form-control">
                                    <option value="">Select a District</option>
                                </select>
                                    
                                </span>
                                <div id="uderror" class="error">*</div>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>City</p></div>
                            <div class="col-md-6">
                                <!-- To load/show all districts in a selected province -->
                                <span id="showcity">
                                <select name="city_id" id="city_id" 
                                        class="form-control">
                                    <option value="">Select a City</option>
                                </select>
                                </span>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Role Name</p></div>
                            <div class="col-md-6">
                                <select name="role_id" id="role_id" 
                                        class="form-control">
                                    <option value="">Select a Role Name</option>
  <?php while($rowrole=$resultrole->fetch(PDO::FETCH_BOTH)){ ?>
               <option value="<?php echo $rowrole['role_id']; ?>">
                   <?php echo $rowrole['role_name']; ?>
               </option>
    <?php } ?>
                                </select>
                                <div id="urerror" class="error">*</div>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                                 <div class="col-md-6"><p>
                                         <input type="submit" name="sub" 
                                                value="Submit" class="btn btn-primary" />  
                                         <input type="reset" name="clear" 
                                                value="Clear" class="btn btn-primary" />  
                                 </p></div>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>
                    </div>                    
                </div>
                </form>         
                              
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script type="text/javascript" src="../plugins/jQuery/jQuery-2.1.4.min.js">
    </script>
    <!-- External JS for validation -->
    <script src="../js/validation.js"></script>
</html>
