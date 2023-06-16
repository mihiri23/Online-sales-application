<?php
include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';
include '../../Apps/model/featuremodel.php';
include '../../Apps/model/ordermodel.php';
include '../../Apps/model/payment.php';

//$order_id=$_REQUEST['order_id'];
//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();

$obitem=new item();
$resultnew= $obitem->viewAllItem();

$oborder=new order();
$obstock=new stock();
$obpay=new payment();


$order_id=$_REQUEST['order_id'];
//To get total price
$resulttot=$oborder->getTotalCartPrice1($order_id);
$rowtot=$resulttot->fetch(PDO::FETCH_BOTH);
$rowcus=$_SESSION['rowcus'];
//print_r($rowcus);


$resultpay=$obpay->viewPayment($order_id);
$rowpay=$resultpay->fetch(PDO::FETCH_BOTH);


if($noc==0){
    $u="signup.php";
    $status=1;
}else{
    $u="checkout.php";
    $status=0;
}



function getDisscout($tot){
    if($tot>=40000){
        return .10;
    }else if($tot>30000){
        return 0.75;
    }else if($tot>20000){
        return 0.05;
    }else{
        return 0;
    }
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


<script>
function printDiv(divID) {
         
var prtContent = document.getElementById(divID);
var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
WinPrint.document.write(prtContent.innerHTML);
WinPrint.document.close();
WinPrint.focus();
WinPrint.print();
WinPrint.close();
       

          
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
                <div class="col-md-8 offset-md-2">
                    <div id="printd">
                    <h4 style="text-align: center; color: #004085">
                        Invoice</h4>
                    <br>
                    <table  border="1" width="100%">
                        <tr>
                            <th width="25%">Invoice No :</th>
                            <td width="25%"><?php echo $rowpay['pay_id']; ?></td>
                            <th>Customer Name :</th>
                            <td><?php echo $rowcus['cus_name']; ?></td>
                        </tr>
                         <tr>
                             <th >Date</th>
                             <td><?php echo $rowpay['pay_date']; ?></td>
                           
                            <th>Customer Email :</th>
                            <td><?php echo $rowcus['cus_email']; ?></td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr >
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                             <th>Color</th>
                              <th>Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Price</th>
                                     
                        </tr>                        
                        <?php
                        $resultcart = $oborder->viewCart1($order_id);
                        while ($rowcart = $resultcart->fetch(PDO::FETCH_BOTH)) {
                            //print_r($rowcart);
                            $item_id=$rowcart['item_id'];
                            $resultimage = $obitem->viewItemImage($item_id);
                            $rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
                            $resultitem = $obitem->viewAnItem($item_id);
                            $rowitem = $resultitem->fetch(PDO::FETCH_BOTH);
                            $status = 0;
                            if ($rowimage['ii_name'] != "") {
                                $status = 1;
                                $item_image = $rowimage['ii_name'];
                            }
                            $obf = new feature();
                            $resultfc = $obf->displayAFeature($rowcart['color_id']);
                            $rowfc = $resultfc->fetch(PDO::FETCH_BOTH);
                            $resultfs = $obf->displayAFeature($rowcart['size_id']);
                            $rowfs = $resultfs->fetch(PDO::FETCH_BOTH);
                            $nofc=$resultfc->rowcount();
                            $nofs=$resultfs->rowcount();
$resultp=$obstock->viewStockPrice
        ($item_id, $rowcart['color_id'], $rowcart['size_id']);
        $rowp=$resultp->fetch(PDO::FETCH_BOTH);
                            
                        ?>
                        
                        <tr >
                            <td><?php echo $rowitem['item_name']; ?></td>
                            <td><?php echo $rowitem['cat_name']; ?></td>
                            <td><?php echo $rowitem['sc_name']; ?></td>
                            <td><?php echo $rowfc['f_name']; ?></td>
                            <td><?php echo $rowfs['f_name']; ?></td>
                            <td><?php echo $rowcart['qsum']; ?></td>
                            <td><?php echo $rowp['stock_price']; ?></td>
                            <td><?php echo $rowcart['cpsum']; ?></td>
                            
                          
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="7"><b> Price</b></td>
                            <td><b><?php echo $tot=$rowtot['tot']; ?></b></td>
                           
                        </tr>
                        <tr>
                            <td colspan="7"><b>Discount</b></td>
                            <td><b><?php 
                            
                            echo $rowpay['discount'];
                            ?></b></td>
                           
                        </tr>
                        <tr>
                            <td colspan="7"><b>Total Price</b></td>
                            <td><b><?php echo $rowpay['pay_amount'] ?></b></td>
                           
                        </tr>
                    </table>
                    </div>
                    <h3>
                        
                        <a href="invoicepdf.php?order_id=<?php echo $order_id ?>">
                            <button type="button" class="btn btn-danger" onclick="printDiv(printd)">
                            Print
                            </button></a>
                          
                    <a href="invoicepdf.php?order_id=<?php echo $order_id ?>">
                        <button class="btn btn-danger">
                           Generate PDF
                            </button></a>
                        
      
                        
                    </h3>
                    
                    
                    
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