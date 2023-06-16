<?php
date_default_timezone_set("Asia/Colombo");
$m_id=12;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/categorymodel.php';
include '../model/brandmodel.php';
include '../common/functions.php';
include '../model/featuremodel.php';
include '../model/itemmodel.php';
include '../model/stockmodel.php';
include '../model/productionmodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$obf=new feature();
$color_id=$_GET['color_id'];
$size_id=$_GET['size_id'];

$resultc = $obf->displayAFeature($_GET['color_id']);
    $results = $obf->displayAFeature($_GET['size_id']);
    $rowc = $resultc->fetch(PDO::FETCH_BOTH);
    $rows = $results->fetch(PDO::FETCH_BOTH);

$item_id=$_REQUEST['item_id'];
echo $item_id; 
$obitem=new item();
$resultitem=$obitem->viewAnItem($item_id);
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);

$obstock=new stock;
$resultsq = $obstock->checkStockBalance($item_id,$_GET['color_id'], $_GET['size_id']);
$rowsq = $resultsq->fetch(PDO::FETCH_BOTH);
$obpro=new production();
$resultrm=$obpro->viewRM($item_id,$color_id,$size_id);
$rowrm=$resultrm->fetch(PDO::FETCH_BOTH);

$resultimage=$obitem->viewItemImage($item_id);
$rowimage=$resultimage->fetch(PDO::FETCH_BOTH);
if($rowimage['ii_name']==""){
    $path="../images/Product.png";
}else{
    $path='../images/item_images/'.$rowimage['ii_name'];
}
if ($_REQUEST['uni_id']==0) {
    $uni_id = time()."_".date();
}else{
   $uni_id=$_REQUEST['uni_id'] ;
}


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
        
    
    
    </head>
    <body>
        <div id="main">
            <div style="padding-top: 0px" id="heading">
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
                            <li><a href="../view/stock.php">Stock</a></li>
                            <li class="active">Enter Production Quantity</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
               
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3  style="padding-top: 15px" class="alig">Production Quantity</h3>
                    </div>
                </div>
               <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
               <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" 
                     style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div class="container-fluid">
                            <form action="../controller/productioncontroller.php?action=additem&uni_id=<?php echo $uni_id; ?>" 
                                  method="post" enctype="multipart/form-data">
                             <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                             <div class="col-md-10 col-md-offset-2">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <img src="<?php echo $path; ?>" width="150px" height="150px" />
                                </div>
                            
                            
                            <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>   
                                <div class="row">
                               <div class="col-md-2"></div>
                               <div class="col-md-2"><p style="text-align: center">Color :</p></div>
                                <div class="col-md-3"><p style="text-align: center">
                                    <input type="hidden" name="color_id" value="<?php echo $color_id; ?>" />
                                                <?php echo $rowc['f_name']; ?>
                                    </p>   
                                </div>
                                
                               
                                </div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><p style="text-align: center">Size :</p></div>
                                <div class="col-md-3"><p style="text-align: center">
                                    <input type="hidden" name="size_id" value="<?php echo $size_id; ?>" />
                                                <?php echo $rows['f_name']; ?>
                                    </p>    
                                </div>
                                
                                </div>
                               <div class="clearfix">&nbsp;</div>  
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                               <div class="col-md-2"></div>
                               <div class="col-md-2"><p style="text-align: center">Available Quantity :</p></div>
                                <div class="col-md-3"><p style="text-align: center">
                                    <input type="hidden" name="qua" value="<?php echo $rowsq['qua']; ?>" />
                                      <?php echo $rowsq['qua']; ?>
                                    </p>
                                </div>
                                
                              
                            </div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-2"><p style="text-align: center">Required Quantity</p></div>
                                <div class="col-md-3"><p style="text-align: center">
                                    <input type="text" id="rqua" name="rqua" 
                                           class="form-control"
                                           onkeypress="return onlyNos(event,this)" onchange="displaycq(q)"/></p>
                                </div>
                                 
                               
                                <div class="col-md-2" align="right">
                                    <input type="submit" 
                                           class="btn btn-success" value="Submit" /></div>
                                <div class="col-md-2">
                                    <input type="reset" 
                           class="btn btn-danger" />                              
                                    
                                </div>                   
                                
                                 </div>
                            
                        </div>
                            </form>
                        </div>            
                        
                    </div>
                </div>                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script>
            //To check Integers and Dot
function onlyNos(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                }
                else if (e) {
                    var charCode = e.which;
                }
                else { return true; }
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=46) {
					// 31 is Unit Separator, 48 is Zero, 57 is Nine, 88 is Uppercase X
                    return false;
                }
                return true;
            }
            catch (err) {
                alert(err.Description);
            }
        }           
        
        function displaycq($_POST['rqua']) {
  var xhttp; 
 
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showcq").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../ajax/getrequantity.php?quantity="+$_POST['rqua'], true);
  xhttp.send();
}
  
            </script>
    
    
</html>