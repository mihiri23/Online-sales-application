<?php
include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';
$sc_id = $_REQUEST['sc_id'];

//To display all categories
$obcat = new category();
$rcat = $obcat->displayAllCategory();
$rcat1 = $obcat->displayAllCategory();

$obsc = new subCategory();
$rsc = $obsc->displayFSC();

$obstock = new stock();
$rstock = $obstock->viewStockItems();
$rowstock = $rstock->fetchall();
//print_r($rowstock);
$arr = array();
foreach ($rowstock as $val) {
    array_push($arr, $val['item_id']);
}
shuffle($arr);
$item_id = $arr[0];
$obitem = new item();
$resultnew= $obitem->viewAllItems();
$resultimage = $obitem->viewItemImage($item_id);
$rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
$resultitem = $obitem->viewAnItem($item_id);
$rowitem = $resultitem->fetch(PDO::FETCH_BOTH);

$status=0;
if($rowimage['ii_name']!=""){
$status=1;
//echo $rowimage['ii_name'];
}

//To get lastes items
$rli=$obitem->viewAllItems();

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
                            <?php if ($status == 1) { ?>
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
                        <?php
                        while ($rowli = $rli->fetch(PDO::FETCH_BOTH)) {
                            $rimage = $obitem->viewItemImage($rowli['item_id']);
                            $roimage = $rimage->fetch(PDO::FETCH_BOTH);
                            $s = 0;
                            if ($roimage['ii_name'] != "") {
                                $s = 1;
                            }
                             // To get category id
                            
                                    $cat_id = $rowli['cat_id'];// To get subcategory id
                                    // To call displayCategory method
                                    $resultacat = $obcat->displayCategory($cat_id);
                                    $resultsc = $obsc->displaySC($sc_id);// To call displaySubCategory method
                                    $rowacat = $resultacat->fetch(PDO::FETCH_BOTH);//To display categories
                                    $rowsc = $resultsc->fetch(PDO::FETCH_BOTH)//To display sub categories
                            
                            ?>
                            <div class="col-lg-4 advert_col">

                                <!-- Advert Item -->

                                <div class="advert d-flex flex-row align-items-center justify-content-start">
                                    <div class="advert_content">
                                        <div class="advert_title"><a href="#"><?php echo $rowli['item_name']; ?></a></div>
                                        <div class="advert_text"><?php echo $rowacat['cat_name']; ?></div>
                                        <div class="advert_text"><?php echo $rowsc['sc_name']; ?></div>
                                        <div class="advert_text">Rs.<?php echo $rowli['item_price']; ?></div>
                                        <div class="advert_title">
                                            <a href="viewitem.php?item_id=<?php echo $rowli['item_id']; ?>">
                                                <button type="button" class="btn btn-primary">View</button></a></div>
                                    </div>
                                    <div class="ml-auto"><div class="advert_image">
                                            <?php if ($s == 1) { ?>
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

      

            <!-- Recently Viewed -->

            <!-- Brands -->

            <div class="brands">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="brands_slider_container">

                                <!-- Brands Slider -->

                                <div class="owl-carousel owl-theme brands_slider">

                                    <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><img src="images/desha/down1.jpg" alt="" width="300px" height="100px"></a></div></div>
                                    <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=6"><h4>Statues & Sculptures</h4></a></div></div>
                                    <div class="owl-item"><div class="brands_item d-flex flex-column justify-content-center"><a href="../pages/viewsubcatitems.php?sc_id=7"><img src="images/desha/down2.jpg" alt="" width="300px" height="100px"></a></div></div>
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