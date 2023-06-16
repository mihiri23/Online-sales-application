<?php
include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';
include '../../Apps/model/featuremodel.php';
include '../../Apps/model/ordermodel.php';
include '../../Apps/model/provincemodel.php';
if(isset($_REQUEST['status'])){
    $url="../Pages/checkout.php";
}else{
    $url=$_SERVER['HTTP_REFERER'];
}
$_SESSION['url']=$url;
//$order_id=$_REQUEST['order_id'];
//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();

$obpro=new province();
$resultprovinces=$obpro->displayProvinces();

$obitem=new item();
$resultnew= $obitem->viewAllItem();
$oborder=new order();
$obstock=new stock();

$resultsid=$oborder->checkOrder($sid);
$rowsid=$resultsid->fetch(PDO::FETCH_BOTH);
$order_id=$rowsid['order_id'];
//To get total price
$resulttot=$oborder->getTotalCartPrice($order_id);
$rowtot=$resulttot->fetch(PDO::FETCH_BOTH);


?>






<!DOCTYPE html>
<!-- Template is licensed under CC BY 3.0-->



<html lang="en">
<head>
<title>Deshapriya Trade Center</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="DTC Store project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="plugins/slick-1.8.0/slick.css">
<link rel="stylesheet" type="text/css" href="styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="styles/responsive.css">


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
  xhttp.open("GET", "../../Apps/ajax/getDistrict.php?q="+str, true);
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
  xhttp.open("GET", "../../Apps/ajax/getCity.php?q="+str, true);
  xhttp.send();
}
       </script>
       <script>
           function SignUp()
           {
               var p=f.cus_pwd.value;
               var cp=f.cus_rpwd.value;
               if(p!==cp){
                   alert("Password confirmation faild");
                   //f.cus_rpwds.focus();
                    return false;
           }
                }
       </script>
</head>

<body>

<div class="super_container">	
	<!-- Header -->
	<header class="header">

		<!-- Top Bar -->

		<?php include '../Templates/topbar.php'; ?>

		<!-- Header Main -->

		<?php include '../Templates/headermain.php'; ?>
		
		<!-- Main Navigation -->

	<?php include '../Templates/mainnavigationpage.php'; ?>
		
		

	</header>
        <div class="clearfix">&nbsp;</div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 style="text-align: center; color: #005cbf; padding-top: 15px" class="alig"> SignIn / SignUp</h3>
                    </div>
                <div class="col-md-10 offset-md-1">
                    <div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6">
                                <form method="post"
                                      action="../Controllers/Controllers.php?action=signin" >
                                <div><h4>Sign In</h4></div>
                                <div>Customer Email</div>
                                <div><input type="email" name="cus_email" required
                                            class="form-control"
                                            placeholder="Email Address"/>
                                </div>
                                <div>Customer Password</div>
                                <div><input type="password" name="cus_pwd" required
                                            class="form-control"
                                            placeholder="Password"/>
                                </div>
                                <div>&nbsp;</div>
                                <div><input type="submit" name="signin"
                                            value="SignIn" 
                                            class="btn btn-primary"/>
                                </div>
                                </form>
                                <div class="clearfix">&nbsp;</div>
                                <h4 style="color: #007bff" > Please Sign In ! If you are already signed up </h4>
                            </div>
                            <div class="col-md-6">
                                <form name="f" method="post"
                                 action="../Controllers/Controllers.php?action=signup" onsubmit="return SignUp()">
                                <div><h4>Sign Up</h4></div>
                                <div>Customer Name</div>
                                <div><input type="text" name="cus_name" required
                                            class="form-control"
                                            placeholder="Customer Name"/>
                                    <div id="uferror" class="error">*</div>
                                </div>
                                <div>Customer Email</div>
                                <div>
                                <input type="email" name="cus_email" id="cus_email"
                                       placeholder="Email Address" 
                                       class="form-control"   />
                               
                                <div id="ueerror" class="error">*</div>
                                </div>
                       
                                <div>Customer Password</div>
                                <div><input type="password" name="cus_pwd" required
                                            class="form-control"
                                            placeholder="Password"/>
                                </div>
                                <div id="uferror" class="error">*</div>
                                
                                <div>Confirm Customer Password</div>
                                <div><input type="password" name="cus_rpwd" required
                                            class="form-control"
                                            placeholder="Retype Password"/>
                                </div>
                                <div id="uferror" class="error">*</div>
                                
                                <div >Address</div>
                                <div ><textarea name="cus_address" id="cus_address" required placeholder="Address" 
                                          class="form-control"></textarea>
                                </div>
                                <div >Tel No</div>
                                <div ><input name="cus_tel" id="cus_tel" required placeholder="Tel no" 
                                          class="form-control" />
                                </div>
                                
                        
                                <div>Province</div>
                               <div >
                                <select name="pro_id" id="pro_id" required
                                    class="form-control" onchange="displayDis(this.value)">
                                    <option value="">Select a Province</option>
    <?php while($rowprovince=$resultprovinces->fetch(PDO::FETCH_BOTH)){ ?>
               <option value="<?php echo $rowprovince['id']; ?>">
                   <?php echo $rowprovince['name_en']; ?>
               </option>
    <?php } ?>                                </select></div>
                                 
                            <div ><p>District</p></div>
                            <div >
                                <!-- To load/show all districts in a selected province -->
                                <span id="showdistrict">
                                <select name="dis_id" id="dis_id" required
                                        class="form-control">
                                    <option value="">Select a District</option>
                                </select>
                                    
                                </span>
                                
                            </div>
                        
                         
                            <div ><p>City</p></div>
                            <div >
                                <!-- To load/show all districts in a selected province -->
                                <span id="showcity">
                                <select name="city_id" id="city_id" required 
                                        class="form-control">
                                    <option value="">Select a City</option>
                                </select>
                                </span>
                            </div>
                        
                       
                                
                                <div>&nbsp;</div>
                                <div><input type="submit" name="signup" 
                                            value="SignUp" 
                                            class="btn btn-primary"/>
                                </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>
                   
                    
                    
                    
                    
                </div>
            </div>
        </div>
	




	<!-- Footer -->

	<?php include '../Templates/footer.php'; ?>

	<!-- Copyright -->

	<?php include '../Templates/copyright.php'; ?>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="plugins/slick-1.8.0/slick.js"></script>
<script src="plugins/easing/easing.js"></script>
<script>
    function displayQuantity(c,s,item_id) {
  var xhttp; 
 
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showq").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "./getQuantity.php?color="+c+"&size="+s+"&item_id="+item_id, true);
  xhttp.send();
}

function displayAv(c,s,item_id) {
  var xhttp; 
 
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showa").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "./getAvailablity.php?color="+c+"&size="+s+"&item_id="+item_id, true);
  xhttp.send();
}

function displayPrice(c,s,q,item_id) {
  var xhttp; 
 
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showp").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "./getPrice.php?color="+c+"&size="+s+"&quantity="+q+"&item_id="+item_id, true);
  xhttp.send();
}
    </script>

</body>

</html>