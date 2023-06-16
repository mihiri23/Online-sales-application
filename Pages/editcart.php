<?php
include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';
include '../../Apps/model/featuremodel.php';

$item_id=$_REQUEST['item_id'];
$order_id=$_REQUEST['order_id'];
  $qsum=$_REQUEST['qsum'];    
 // $cpsum=$_REQUEST['totalprice'];   
$color_id=$_REQUEST['color_id'];
$size_id=$_REQUEST['size_id'];    
//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();
$rcat1=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();


$obitem=new item();
$resultnew= $obitem->viewAllItems();
$resultimage=$obitem->viewItemImage($item_id);
$rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
$resultitem=$obitem->viewAnItem($item_id);
$rowitem = $resultitem->fetch(PDO::FETCH_BOTH);
$status=0;
if($rowimage['ii_name']!=""){
    $status=1;
    $item_image=$rowimage['ii_name'];
}

$obf=new feature();
$resultfc=$obf->displayFeatures($item_id, 1);
$resultfs=$obf->displayFeatures($item_id, 2);
$rcolor=$obf->displayColor($color_id);
$rowcolor = $rcolor->fetch(PDO::FETCH_BOTH);
$rsize=$obf->displayColor($size_id);
$rowsize = $rsize->fetch(PDO::FETCH_BOTH);
$nofc=$resultfc->rowcount();
$nofs=$resultfs->rowcount();
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
                <div class="col-md-8 offset-md-2">
                    <form action="../Controllers/Controllers.php?action=updatecart&item_id=<?php echo $item_id; ?>&order_id=<?php echo $order_id; ?>" method="post">
                    <table  
                        class="table table-bordered"
                        style="width: 100%"
                        >
                        <tr style="background-color: gray"><th colspan="2"><?php echo $rowitem['item_name']; ?></th></tr>
                        <tr><th colspan="2" style="text-align: center">
                            <?php
                            if($status==1){                     
                                ?>
                     <img src="../../Apps/images/item_images/<?php echo $item_image; ?>" 
                                     width="300" />        
                           <?php
                            }
                            ?>
                            </th></tr>
                        <tr><td width="50%">Category :</td><td><?php echo $rowitem['cat_name']; ?></td></tr>
                        <tr><td width="50%">Sub Category :</td><td><?php echo $rowitem['sc_name']; ?></td></tr>
                        <?php if($nofc){ ?>        
                        <tr>
                            <td width="50%">Color :</td><td>
                                        <select name="color_id" class="form-control" id="color_id">
                                            <option value=""><?php echo $rowcolor['f_name']; ?></option>
                                            <?php 
                                        while($rowfc=$resultfc->fetch(PDO::FETCH_BOTH)){ ?>
                                            <option value="<?php echo $rowfc['f_id']; ?>">
                                                <?php echo $rowfc['f_name']; ?>
                                            </option>
                                        <?php } ?>                                          
                                        </select>
                            </td></tr>
                        <?php } ?>
                                        
                           <?php if($nofs){ ?>  
                        <tr><td width="50%">Size :</td><td>
                                <select name="size_id" id='size_id' class="form-control" 
                                        onchange='displayQuantity(document.getElementById("color_id").value,
                                                    this.value,"<?php echo $item_id; ?>"),
                                            displayAv(document.getElementById("color_id").value,this.value,
                                                    "<?php echo $item_id; ?>")'>
                                            <option value=""><?php echo $rowsize['f_name']; ?></option>
                                            <?php 
                                        while($rowfs=$resultfs->fetch(PDO::FETCH_BOTH)){ ?>
                                            <option value="<?php echo $rowfs['f_id']; ?>">
                                                <?php echo $rowfs['f_name']; ?>
                                            </option>
                                        <?php } ?>
                                        </select>
                                    </td></tr>
                           <?php } ?>
                        <tr><td width="50%">Quantity :</td><td>
                                <div id="showq">
                                    <?php echo $qsum; ?> 
                                </div>
                                        
                                        
                            </td></tr>
                                <tr><td width="50%">Availability :</td><td>
                            <div id="showa">
                                    
                                </div>
                                        
                                        
                            </td></tr>
                        <tr><td width="50%">Price :</td><td>
                                <div id='showp'>
                                    
                                </div>
                            </td></tr>
                        <tr><td colspan="2" align="center"><button type="submit" name="up" value="Update"
                                                    class="btn btn-primary">
                                                       Update Cart
                                </button></td></tr>
                        
                    </table>
                    </form>
<!--                    <table  
                        class="table table-bordered"
                        style="width: 100%"
                        >
                        <tr style="background-color: gray">
                            <th colspan="2">Your Rating</th></tr>
                       
                        <tr><td width="30%">Rating</td><td>....</td></tr>
                        <tr><td width="30%">Comments :</td><td>....</td></tr>
                        
                        
                    </table>
                     <table  
                        class="table table-bordered"
                        style="width: 100%"
                        >
                        <tr style="background-color: gray">
                            <th colspan="2">Rating and Feedback</th></tr>
                       
                        <tr><td width="30%">Rating</td><td>....</td></tr>
                        <tr>
                            <td colspan="2">&nbsp;</td></tr>
                        
                        
                    </table>-->
                    
                    
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