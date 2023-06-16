<?php
include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';

//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();
$rcat1=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();

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
$resultnew= $obitem->viewAllItems();

$resultimage=$obitem->viewItemImage($item_id);
$rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
$resultitem=$obitem->viewAnItem($item_id);
$rowitem = $resultitem->fetch(PDO::FETCH_BOTH);
$status=0;
if($rowimage['ii_name']!=""){
    $status=1;
    //echo $rowimage['ii_name'];
}

//To get lastes items
$rli=$obitem->getLatestItems();

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

	<?php include '../Templates/mainnavigation.php'; ?>
		
		

	</header>
	
	<!-- Banner -->

	<div class="banner">
		<div class="banner_background" style="background-image:url(images/banner_background.jpg)"></div>
		<div class="container fill_height">
			<div class="row fill_height">
                            
				<div class="col-lg-5 offset-lg-4 fill_height">
					<div class="banner_content">
						<h1 class="banner_text">
                                                    
                                                    
                                                    <?php echo $rowitem['cat_name']; ?></h1>
						<div class="banner_price"><?php echo $rowitem['sc_name']; ?></div>
						<div class="banner_product_name"><?php echo $rowitem['item_name']; ?></div>
						<div class="button banner_button"><a href="viewitem.php?item_id=<?php echo $rowitem['item_id']; ?>">View Now</a></div>
					</div>
                                    
				</div>
                            <div >
                                                        <?php if($status==1){ ?>
                                                        <img 
                                                            src="../../Apps/images/item_images/<?php echo $rowimage['ii_name']; ?>" alt="" height="300px" width="290px">
                                                        <?php } ?>
                                                    </div>
                            
			</div>
		</div>
	</div>

	

	


	


	<!-- Adverts -->

	<div class="adverts">
		<div class="container">
			<div class="row">
                           <?php while($rowli = $rli->fetch(PDO::FETCH_BOTH)){
                               $rimage=$obitem->viewItemImage($rowli['item_id']);
                               $roimage=$rimage->fetch(PDO::FETCH_BOTH);
                               $s=0;
                               if($roimage['ii_name']!=""){
                                   $s=1;
                               }
                               
                               ?>
				<div class="col-lg-4 advert_col">
					
					<!-- Advert Item -->

					<div class="advert d-flex flex-row align-items-center justify-content-start">
						<div class="advert_content">
							<div class="advert_title"><a href="#"><?php echo $rowli['item_name']; ?></a></div>
							<div class="advert_text"><?php echo $rowli['cat_name']; ?></div>
                                                        <div class="advert_text"><?php echo $rowli['sc_name']; ?></div>
                                                        <div class="advert_text">Rs.<?php echo $rowli['item_price']; ?></div>
                                                        <div class="advert_title">
                                                            <a href="viewitem.php?item_id=<?php echo $rowli['item_id']; ?>">
                                                                <button type="button" class="btn btn-primary">View</button></a></div>
                                                </div>
						<div class="ml-auto"><div class="advert_image">
                                                        <?php if($s==1){ ?>
                                                        <img height="150px" width="160px"
                                                            src="../../Apps/images/item_images/<?php echo $roimage['ii_name']; ?>" alt="">
                                                        <?php } ?>
                                                    </div></div>
					</div>
				</div>
                           <?php } ?>
				

			</div>
		</div>
	</div>

	<!-- Trends -->

	

	<!-- Reviews -->

<!--	<div class="reviews">
		<div class="container">
			<div class="row">
				<div class="col">
					
					<div class="reviews_title_container">
						<h3 class="reviews_title">Latest Reviews</h3>
						<div class="reviews_all ml-auto"><a href="#">view all <span>reviews</span></a></div>
					</div>

					<div class="reviews_slider_container">
						
						 Reviews Slider 
						<div class="owl-carousel owl-theme reviews_slider">
							
							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
                                                                    <div><div class="review_image"><img src="images/desha/stones_row.PNG" alt=""></div></div>
                                                                      <div><div class="review_image"><img src="images/desha/stones_row.PNG" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Roberto Sanchez</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										</div>
								</div>
							</div>

							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
                                                                    <div><div class="review_image"><img src="images/desha/egypt.PNG" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Brandon Flowers</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										<div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>
									</div>
								</div>
							</div>

							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
									<div><div class="review_image"><img src="images/review_3.jpg" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Emilia Clarke</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										<div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>
									</div>
								</div>
							</div>

							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
									<div><div class="review_image"><img src="images/review_1.jpg" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Roberto Sanchez</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										<div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>
									</div>
								</div>
							</div>

							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
									<div><div class="review_image"><img src="images/review_2.jpg" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Brandon Flowers</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										<div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>
									</div>
								</div>
							</div>

							 Reviews Slider Item 
							<div class="owl-item">
								<div class="review d-flex flex-row align-items-start justify-content-start">
									<div><div class="review_image"><img src="images/review_3.jpg" alt=""></div></div>
									<div class="review_content">
										<div class="review_name">Emilia Clarke</div>
										<div class="review_rating_container">
											<div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>
											<div class="review_time">2 day ago</div>
										</div>
										<div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>
									</div>
								</div>
							</div>

						</div>
						<div class="reviews_dots"></div>
					</div>
				</div>
			</div>
		</div>
	</div>-->

	<!-- Recently Viewed -->

	<div class="viewed">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="viewed_title_container">
						<h3 class="viewed_title">Recently Viewed</h3>
						<div class="viewed_nav_container">
							<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
							<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
						</div>
					</div>

					<div class="viewed_slider_container">
						
						

						<div class="owl-carousel owl-theme viewed_slider">
							
							
							<div class="owl-item">
                                                            <img src="images/desha/stones_row.PNG" height="250px" alt="">
<!--								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
                                                                    <div class="viewed_image"><img src="images/desha/stones_row.PNG" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225<span>$300</span></div>
										<div class="viewed_name"><a href="#">Beoplay H7</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>

							
							<div class="owl-item">
                                                            <img src="images/desha/egypt.PNG" height="250px" alt="">
<!--								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_2.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$379</div>
										<div class="viewed_name"><a href="#">LUNA Smartphone</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>

							
							<div class="owl-item">
                                                            <img src="images/desha/Capture1.PNG" height="250px" alt="">
<!--								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_3.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225</div>
										<div class="viewed_name"><a href="#">Samsung J730F...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>

							
							<div class="owl-item">
                                                              <img src="images/desha/Capture.PNG" height="250px" alt="">
<!--								<div class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_4.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$379</div>
										<div class="viewed_name"><a href="#">Huawei MediaPad...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>

							
							<div class="owl-item">
                                                            <img src="images/desha/Capture2.PNG" height="250px" alt="">
<!--								<div class="viewed_item discount d-flex flex-column align-items-center justify-content-center text-center">
									
                                                                    <div class="viewed_image"><img src="images/view_5.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$225<span>$300</span></div>
										<div class="viewed_name"><a href="#">Sony PS4 Slim</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>

							
							<div class="owl-item">
                                                             <img src="images/desha/Capture3.PNG" height="250px" alt="">
<!--								<div class="viewed_item d-flex flex-column align-items-center justify-content-center text-center">
									<div class="viewed_image"><img src="images/view_6.jpg" alt=""></div>
									<div class="viewed_content text-center">
										<div class="viewed_price">$375</div>
										<div class="viewed_name"><a href="#">Speedlink...</a></div>
									</div>
									<ul class="item_marks">
										<li class="item_mark item_discount">-25%</li>
										<li class="item_mark item_new">new</li>
									</ul>
								</div>-->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Brands -->

	<div class="brands">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="brands_slider_container">
						
						<!-- Brands Slider -->

						<div class="owl-carousel owl-theme brands_slider">
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><img src="images/desha/down1.jpg" alt="" width="100px" height="100px"></a></div></div>
                                                        <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><h4>Statues & Sculptures</h4></a></div></div>
                                                        <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=7"><img src="images/desha/down2.jpg" alt="" width="100px" height="100px"></a></div></div>
                                                        <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=7"><h4 style="color: brown">Water Fountains</h4></a></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><img src="images/desha/down1.jpg" alt="" width="100px" height="100px"></a></div></div>
                                                        <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><h4>Statues & Sculptures</h4></a></div></div>
							<div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=7"><img src="images/desha/down2.jpg" alt="" width="100px" height="100px"></a></div></div>
                                                        <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=7"><h4 style="color: brown">Water Fountains</h4></a></div></div>

						</div>
						
						<!-- Brands Slider Navigation -->
						<div class="brands_nav brands_prev"><i class="fas fa-chevron-left"></i></div>
						<div class="brands_nav brands_next"><i class="fas fa-chevron-right"></i></div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Newsletter -->

<!--	<div class="newsletter">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
						<div class="newsletter_title_container">
							<div class="newsletter_icon"><img src="images/send.png" alt=""></div>
							<div class="newsletter_title">Sign up for Newsletter</div>
							<div class="newsletter_text"><p>...and receive %20 coupon for first shopping.</p></div>
						</div>
						<div class="newsletter_content clearfix">
							<form action="#" class="newsletter_form">
								<input type="email" class="newsletter_input" required="required" placeholder="Enter your email address">
								<button class="newsletter_button">Subscribe</button>
							</form>
							<div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>-->

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