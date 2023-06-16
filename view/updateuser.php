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
//To get all provinces
$obpro=new province();//To create an object based on province class 
//To call a method for getting all provinces
$resultprovinces=$obpro->displayProvinces();
//To get all role names
$obrole=new role();
$resultrole=$obrole->displayRoles();
//To get user ID from user.php
$user_id=$_REQUEST['user_id'];
include '../model/usermodel.php';
//To get the specific user's details
$obu=new user();
$resultuser=$obu->viewAUser($user_id);
//To assign user details into an array
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

//To get province details
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
                        <li class="active">Update User</li></div>
                    </ol>                    
                    </div>
                </div>           
              <div style="height: 40px"><?php include '../common/usertab.php';?></div>        
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">Update User</h3>
                    </div>
                </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                    <div class="col-md-12 col-sm-6" 
                         style="text-align: center">
                           <?php 
                           if(isset($_REQUEST['msg'])){
                               echo "<span class='text text-".$_REQUEST['status']."'>".$_REQUEST['msg']."</span>";
                           }
                           ?>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <form method="post" action="../controller/usercontroller.php?action=update&user_id=<?php echo $user_id ?>" 
                      enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <div class="col-md-6"><p>First Name</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_fname" id="user_fname"
                                       placeholder="User First Name" 
                                       class="form-control" value="<?php echo $rowuser['user_fname']; ?>" />
                                <div id="uferror" class="error">*</div>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Last Name</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_lname" id="user_lname"
                                       placeholder="User last Name" value="<?php echo $rowuser['user_lname']; ?>"
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
                                       class="form-control" value="<?php echo $rowuser['user_dob']; ?>"
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
                                       class="" <?php echo ($rowuser['user_gender']=="male")?'checked':'' ?> /> Male
                                <input type="radio" name="user_gender" 
                                       id="female" value="female"    
                                       class="" <?php echo ($rowuser['user_gender']=="female")?'checked':'' ?> /> Female
                                <div id="ugerror" class="error">*</div>
                            </div>
                        </div>
                           <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Email</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_email" id="user_email"
                                       placeholder="User Email" 
                                       class="form-control" value="<?php echo $rowuser['user_email']; ?>"
                                       readonly/>
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
                                       class="form-control" value="<?php echo $rowuser['user_tel']; ?>" />
                                <div id="uterror" class="error"></div>
                            </div>
                        </div>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>NIC</p></div>
                            <div class="col-md-6">
                                <input type="text" name="user_nic" id="user_nic"
                                       placeholder="NIC" 
                                       class="form-control" value="<?php echo $rowuser['user_nic']; ?>" />
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
                                <?php 
                               
                                if($rowuser['user_image']==""){
                                    $user_image="../images/user.png";
                                }else{
                                $user_image="../images/user_images/".$rowuser['user_image']; 
                                }
                                ?>
                                <img id="image_view" src="<?php echo $user_image; ?>" style="width:100px" />
                            </div>
                        </div>
                            <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Address</p></div>
                            <div class="col-md-6">
                                <textarea name="user_address" id="user_address"
                                          class="form-control"><?php echo $rowuser['user_add']; ?></textarea>
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
               <option value="<?php echo $rowprovince['id']; ?>"
                       <?php
                       if($rowprovince['id']==$rowdis['pro_id']){
                           echo "SELECTED";
                       }
                       ?>
                       >
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
    <?php 
    $resultdp=$obdis->displayDistrictsPerPro($rowdis['pro_id']);
    while($rowdp=$resultdp->fetch(PDO::FETCH_BOTH)){ ?>
               <option value="<?php echo $rowdp['id']; ?>"
                       <?php
                       if($rowdp['id']==$dis_id){
                           echo "SELECTED";
                       }
                       ?>
                       >
                   <?php echo $rowdp['name_en']; ?>
               </option>
    <?php } ?>                      
                                    
                                    
                                
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
               <option value="<?php echo $rowrole['role_id']; ?>"
                       
                       <?php
                       if($rowrole['role_id']==$rowuser['role_id']){
                           echo "SELECTED";
                       }
                       ?>
                       
                       
                       >
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
                                         <input type="submit" name="up" 
                                                value="Update" class="btn btn-primary" />  
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
                </form>         
                              
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script type="text/javascript" src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- External JS for validation -->
    <script src="../js/validation.js"></script>
</html>
