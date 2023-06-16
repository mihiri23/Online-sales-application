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

$cus_id=$_REQUEST['cus_id'];
include '../../Apps/model/customermodel.php';
$obcus=new customer();
$resultuser=$obcus->viewCustomer($cus_id);
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

include '../../Apps/model/districtmodel.php';
$dis_id=$rowuser['dis_id'];
$city_id=$rowuser['city_id'];
$obdis=new district();
$resultdis=$obdis->displaycity($dis_id,$city_id);
$rowdis=$resultdis->fetch(PDO::FETCH_BOTH);


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
                            <h3 style="text-align: center; color: #005cbf; padding-top: 15px" class="alig">My Account</h3>
                    </div>
                
                <div class="col-md-10 offset-md-1">
                    <div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-4">
                                <?php
                              if($rowuser['user_image']==""){
                                  $user_image="./images/user.svg";
                              }else{
                              $user_image="../images/user_images/".$rowuser['user_image'];
                              }
                              ?>
                              <img src="<?php echo $user_image; ?>" width="230" height="230"  style="border-radius: 100px ; border: 5px lightslategrey solid "/>
                              <hr style="border-right: 10px solid lightgray" />
                            </div>
                            <div class="col-md-4">
                               
                                
                                <div>Customer Name:-</div><div class="clearfix">&nbsp;</div>
                                <div >Customer Email:-</div><div class="clearfix">&nbsp;</div>
                                
                                <div >Customer Address:-</div><div class="clearfix">&nbsp;</div>
                                <div > Telephone Number:-</div><div class="clearfix">&nbsp;</div>
                                <div >Customer Province:-</div><div class="clearfix">&nbsp;</div>
                                <div >Customer District:-</div><div class="clearfix">&nbsp;</div>
                                <div >Customer City:-</div>
                                <div>&nbsp;</div>
                                
                                <div class="clearfix">&nbsp;</div>
                                <h4 style="color: #007bff" >  </h4>
                            </div>
                            <div class="col-md-4">
                                
                               
                                
                                <div> <?php echo $rowuser['cus_name'];?>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div>
                               <?php echo $rowuser['cus_email'];?>
                                
                                </div>
                       <div class="clearfix">&nbsp;</div>
                                
                                <div><?php echo $rowuser['cus_address'];?>
                                </div><div class="clearfix">&nbsp;</div>
                               <div><?php echo $rowuser['cus_tel'];?>
                                </div><div class="clearfix">&nbsp;</div>
                                 <div>  <?php echo $rowdis['pro_name']; ?>
                                </div><div class="clearfix">&nbsp;</div>
                                <div>  <?php echo $rowdis['dis_name']; ?>
                                </div><div class="clearfix">&nbsp;</div>
                                <div>  <?php echo $rowdis['city_name']; ?>
                                </div><div class="clearfix">&nbsp;</div>
                                <div>&nbsp;</div>
<!--                                <div><a href="../Controllers/Controllers.php?cus_id=<?php // echo $cus_id; ?>"><input type="submit" name="edit" 
                                            value="Edit Details" 
                                            class="btn btn-primary"/></a>
                                </div>-->
                                
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