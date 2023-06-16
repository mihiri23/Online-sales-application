<?php
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/brandmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';

//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();
$rcat1=$obcat->displayAllCategory();

$obbrand=new brand();
$rbrand=$obbrand->displayAllBrand();

$obstock=new stock();
$rstock=$obstock->viewStockItems();
$rowstock=$rstock->fetchall();
//print_r($rowstock);
$arr=array();
foreach ($rowstock as $val){
    array_push($arr, $val['item_id']);
}
shuffle($arr);
$item_id=$arr[0];
$obitem=new item();
$resultnew= $obitem->viewAllItem();
$resultimage=$obitem->viewItemImage($item_id);
$rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
$resultitem=$obitem->viewAnItem($item_id);
$rowitem = $resultitem->fetch(PDO::FETCH_BOTH);
$status=0;
if($rowimage['ii_name']!=""){
    $status=1;
    echo $rowimage['ii_name'];
}

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
	
        <div>
           
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
<script src="js/custom.js"></script>
</body>

</html>