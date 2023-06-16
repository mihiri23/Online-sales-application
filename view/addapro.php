<?php
date_default_timezone_set("Asia/Colombo");
$m_id=3;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];

include '../common/dbconnection.php';
include '../model/categorymodel.php';
include '../model/scmodel.php';
include '../model/stockmodel.php';
include '../model/itemmodel.php';
include '../model/featuremodel.php';
include '../common/functions.php';
include '../model/ordermodel.php';
include '../model/payment.php';
include '../model/customerinmodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$item_id=$_REQUEST['item_id'];

$cus_id=$_REQUEST['cus_id'];
$uni_id=$_REQUEST['uni_id'];
//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();
$rcat1=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();


$obitem=new item();
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

$nofc=$resultfc->rowcount();
$nofs=$resultfs->rowcount();

$oborder=new order();
$obstock=new stock();
$obpay=new payment();

$resultsid=$oborder->checkOrderIn($uni_id);
$rowsid=$resultsid->fetch(PDO::FETCH_BOTH);
$order_id=$rowsid['order_id'];

$obcus=new customerin();
$resultcus=$obcus->viewACustomer($cus_id);
$rowcus=$resultcus->fetch(PDO::FETCH_BOTH);

//To get total price
$resulttot=$oborder->getTotalCartPriceIn($order_id);
$rowtot=$resulttot->fetch(PDO::FETCH_BOTH);

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
    
  <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" 
              type="text/css" />
        <link type="text/css" rel="stylesheet" href="../css/style.css" />
        <link href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
        <link href="../css/dataTables.bootstrap4.min.css" rel="stylesheet">
     <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
     <link href="../css/semantic.min.css" rel="stylesheet">
      <link href="../css/dataTables.semanticui.min.css" rel="stylesheet">
      <link href="../css/buttons.semanticui.min.css" rel="stylesheet">
  
      
    
  <script src="../JQuery/jquery-1.12.4.js"></script>
 <script src="../js/jquery.dataTables.min.js"></script>
 <script src="../js/dataTables.bootstrap4.min.js"></script>

   
<script src="../js/dataTables.semanticui.min.js"></script>
    <script src="../js/dataTables.buttons.min.js"></script>
    <script src="../js/pdfmake.min.js"></script>
    <script src="../js/vfs_fonts.js"></script>
    <script src="../js/buttons.html5.min.js"></script>
    
    <script src="../js/jszip.min.js"></script>
    <script src="../js/buttons.semanticui.min.js"></script>
    
    <script src="../js/buttons.colVis.min.js"></script>
<script src="../js/buttons.print.min.js"></script>
 
</head>

<body>

 <div id="main">
            
            <div style="padding-top: 15px" id="heading">
                <?php include '../common/header.php'; ?>
                
            </div>
                
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">
                <div class="row" style="padding-top: 5 px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />
                        
                            <?php echo $userInfo['role_name']; ?>
                        
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li><a href="../view/order.php">New Order</a></li>
                            <li class="active">Create Order</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
     
              <div class="clearfix"></div>
        <div id="contents">
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h2  style="padding-top: 15px" class="alig">Create Order</h2>
                    </div>
                </div>
                <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>
        
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <form action="../controller/paymentcontroller.php?action=addcart&item_id=<?php echo $item_id; ?>&cus_id=<?php echo $cus_id; ?>&uni_id=<?php echo $uni_id; ?>" method="post">
                    <table  
                        class="table table-bordered"
                        style="width: 90%"
                        >
                        <tr style="background-color: lightgray"><th colspan="2"><?php echo $rowitem['item_name']; ?></th></tr>
                        <tr><th colspan="2" style="text-align: center">
                            <?php
                            if($status==1){                     
                                ?>
                     <img src="../../Apps/images/item_images/<?php echo $item_image; ?>" hight="120"
                                     width="120" />        
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
                                            <option value="">Select a Color</option>
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
                                            <option value="">Select a Size</option>
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
                       
                      
                        
                        <tr><td colspan="2" align="center"><button type="Sumbit" 
                                                    class="btn btn-danger">
                                                      Add Item
                                </button></td></tr>
                        
                    </table>
                    </form>
                    
                    <div class="col-md-offset-4" >
                                <a href="../view/addorder.php?cus_id=<?php echo $cus_id; ?>&uni_id=<?php echo $uni_id; ?>&order_id=<?php echo $_REQUEST['order_id'];?>">
                                <button type="Sumbit" 
                                                    class="btn btn-primary">
                                                    Add New Item
                                </button></a>
                    </div>
                </div>
              
                <div class="col-md-6 ">
                  <table class="table table-bordered">
                      <tr style="background-color: lightgray; "><th colspan="4"><p style="text-align: center" >Order Details</</th></tr>
                        
                        <tr>
                            <th width="25%">Order No :</th>
                            <td width="25%"><?php echo $order_id; ?></td>
                            <th>Customer Id :</th>
                            <td><?php echo $cus_id; ?></td>
                            
                        </tr>
                         <tr>
                            <!-- <th colspan="2">&nbsp;</th>-->
                            <th>Date :</th>
                            <td><?php echo $rowsid['order_date']; ?></td>
                            <th>Customer Name :</th>
                            <td><?php echo $rowcus['cus_name']; ?></td>
                        </tr>
                    </table>
                 <table class="table table-bordered">
                        <tr>
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
                        $resultcart = $oborder->viewCartIn($order_id);
                        while ($rowcart = $resultcart->fetch(PDO::FETCH_BOTH)) {
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
                        
                        <tr>
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
                            $discount= getDisscout($tot);
                            echo $dis=$tot*$discount;
                            ?></b></td>
                           
                        </tr>
                        <tr>
                            <td colspan="7"><b>Total Price</b></td>
                            <td><b><?php echo $totp=$tot-$dis; ?></b></td>
                           
                        </tr>
                    </table>
                <h3>
                        
                        <a href="../controller/paymentcontroller.php?action=success&order_id=<?php echo $order_id; ?>&cus_id=<?php echo $cus_id?>">
                            <button class="btn btn-danger" type="button">
                           Add Payment
                            </button></a>
                        
      
                        
                    </h3>
                </div>
            </div>
        </div>
	


 <div class="clearfix">&nbsp;</div>
         <div class="clearfix">&nbsp;</div>

	<!-- Footer -->

	  <div id="footer"><?PHP include '../common/footer.php'; ?></div>

	
</div>
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
  xhttp.open("GET", "../ajax/getQuantity.php?color="+c+"&size="+s+"&item_id="+item_id, true);
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
  xhttp.open("GET", "../ajax/getAvailablity.php?color="+c+"&size="+s+"&item_id="+item_id, true);
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
  xhttp.open("GET", "../ajax/getPrice.php?color="+c+"&size="+s+"&quantity="+q+"&item_id="+item_id, true);
  xhttp.send();
}
    </script>

</body>

</html>