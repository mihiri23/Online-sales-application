<?php
date_default_timezone_set("Asia/Colombo");
$m_id=12;
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
include '../model/pomodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}




$uni_id=$_REQUEST['uni_id'];
$rquan=$_REQUEST['rquan'];
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
$obpo=new po;
$resultsid=$obpo->checkOrderIn($uni_id);
$rowsid=$resultsid->fetch(PDO::FETCH_BOTH);
//$order_id=$rowsid['po_id'];
$order_id=$_REQUEST['po_id'];
//echo  $order_id;
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
                            <li><a href="../view/stock.php">New Order</a></li>
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
               
              
                <div class="col-md-6 ">
                  <table class="table table-bordered">
                      <tr style="background-color: lightgray; "><th colspan="4"><p style="text-align: center" >Order Details</</th></tr>
                        
                        <tr>
                            <th width="25%">Purchase Order No:</th>
                            <td width="25%"><?php echo $order_id; ?></td>
                            <th>Date :</th>
                            <td><?php echo $rowsid['po_date']; ?></td>
                            
                        </tr>
                 
                    </table>
                 <table class="table table-bordered">
                        <tr>
                            <th>Item Name</th>
                            <th>Unit</th>
                             <th>Quantity</th>
                              
                        </tr>                        
                        <?php
                        $resultcart = $obpo->getTotal($order_id);
                        
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
                            
                            <td>
                                
                                
                               <?php
                               $o=$rowcart['totc'];
                               if ($o!=="0") {
                                   echo Cement;
                               }
                               ?>
                              
                                <?php
                                $o1=$rowcart['tots'];
                                if ($o1 !=="0"){
                                echo Sand ;
                                }
                                ?> 
                              
                                <?php
                               $o2=$rowcart['totb'];
                               if ($o2  !=="0") {
                                   echo Black." ". Small." ". Stones ;
                               }
                               ?>
                              
                                <?php
                                $o3=$rowcart['totp'];
                                if ($o3!=="0"){ 
                                 echo Plaster." ". of." ".Paris ;
                                }
                                ?>
                               <div class="clearfix">&nbsp;</div>
                                <?php
                                $o4=$rowcart['totl'];
                                if ($o4!=="0"){ 
                                echo Limestones;
                                }
                                ?>
                               <div class="clearfix">&nbsp;</div>
                                 <?php
                                 $o5=$rowcart['totg'];
                                 if ($o5!=="0"){ 
                                echo Glue;
                                 }
                                 ?></td>
                            
                            <td>
                                
                                
                               <?php
                               $o=$rowcart['totc'];
                               if ($o!=="0") {
                                    echo '50'.kg." ".bags;
                               }
                               ?>
                             
                                <?php
                                $o1=$rowcart['tots'];
                                if ($o1 !=="0"){
                                echo cubes ;
                                }
                                ?> 
                              
                                <?php
                               $o2=$rowcart['totb'];
                               if ($o2  !=="0") {
                                 echo cubes ; 
                               }
                               ?>
                              
                                <?php
                                $o3=$rowcart['totp'];
                                if ($o3!=="0"){ 
                                  echo kg;  
                                }
                                ?>
                               <div class="clearfix">&nbsp;</div>
                                <?php
                                $o4=$rowcart['totl'];
                                if ($o4!=="0"){ 
                                echo kg;
                                }
                                ?>
                              
                                <div class="clearfix">&nbsp;</div>
                                 <?php
                                 $o5=$rowcart['totg'];
                                 if ($o5!=="0"){ 
                                echo "1l bottles";
                                 }
                                 ?></td>
                            
                            <td>
                                
                                
                               <?php
                               $o=$rowcart['totc'];
                               if ($o!=="0") {
                                   echo $o;
                               }
                               ?>
                              
                                <?php
                                $o1=$rowcart['tots'];
                                if ($o1 !=="0"){
                                echo $o1;
                                }
                                ?> 
                              
                                <?php
                               $o2=$rowcart['totb'];
                               if ($o2!=="0") {
                                   echo $o2;
                               }
                               ?>
                              
                                <?php
                                $o3=$rowcart['totp'];
                                if ($o3!=="0"){ 
                                echo $o3;
                                }
                                ?>
                               <div class="clearfix">&nbsp;</div>
                                <?php
                                $o4=$rowcart['totl'];
                                if ($o4!=="0"){ 
                                echo $o4;
                                }
                                ?>
                               <div class="clearfix">&nbsp;</div>
                                 <?php
                                 $o5=$rowcart['totg'];
                                 if ($o5!=="0"){ 
                                echo $o5;
                                 }
                                 ?></td>
                           
                           
                        </tr>
                        <?php } ?>
                       
                    </table>
                <h3>
                        
                       
                        
                    <a href="../view/stock.php?">
                            <button class="btn btn-info" type="button">
                           New Order
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