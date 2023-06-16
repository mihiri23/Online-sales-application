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
$rquan=$_REQUEST['rquan'];

$resultc = $obf->displayAFeature($_GET['color_id']);
    $results = $obf->displayAFeature($_GET['size_id']);
    $rowc = $resultc->fetch(PDO::FETCH_BOTH);
    $rows = $results->fetch(PDO::FETCH_BOTH);

$item_id=$_REQUEST['item_id']; 
$obitem=new item();
$resultitem=$obitem->viewAnItem($item_id);
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);

$obstock=NEW stock;
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

$uni_id = $_REQUEST['uni_id'];

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
                            <li class="active">Calculate Quantity</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
               
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3  style="padding-top: 15px" class="alig">Calculate Raw Material Quantity</h3>
                    </div>
                </div>
               <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
               <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" 
                     style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div class="container-fluid">
                            
                             <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                             
                             <div class="row" >
                              <div class="col-md-1"></div>
                              <div class="col-md-2">
                                    <img src="<?php echo $path; ?>" width="120" />
                                </div>   
                              <div class="col-md-1"><h4 style="padding-top: 20px; color: brown;">Color :</h4></div>
                                <div class="col-md-2" style="padding-top: 20px "><h4 style="color: brown;">
                                    <input type="hidden" name="color_id" value="<?php echo $color_id; ?>" />
                                                <?php echo $rowc['f_name']; ?>
                                    </h4>  
                                </div>
                              <div class="col-md-1"><h4 style="padding-top: 20px; color: brown; ">Size :</h4></div>
                                <div class="col-md-2" style="padding-top: 20px "><h4 style="color: brown;">
                                    <input type="hidden" name="size_id" value="<?php echo $size_id; ?>" />
                                                <?php echo $rows['f_name']; ?>
                                    </h4>      
                                </div>
                              <div class="col-md-1"><h4 style="padding-top: 20px; color: brown; ">Available Quantity :</h4></div>
                                <div class="col-md-2" style="padding-top: 20px "><h4 style="color: brown;">
                                    <input type="hidden" name="qua" value="<?php echo $rowsq['qua']; ?>" />
                                      <?php echo $rowsq['qua']; ?>
                                     </h4>    
                                </div>
                             </div>
                             <div class="clearfix">&nbsp;</div>
                              <hr style="border-top: 2px solid lightgray" />
                             <div class="clearfix">&nbsp;</div>
                              <div class=row>
                             <div class="col-md-6 col-md-offset-1 ">
                                 <div class="row">
                                    
                                     <div class="col-md-5" style="color: #003399"><h4>
                                             Raw Material Quantity for  :<?php echo " ". $rowrm['quantity']."  "; ?>items</h4>
                                     </div>
                                    </div>
                                 <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">Cement (50kg bags) :</div>
                                <div class="col-md-1">
                                    
                                                <?php echo $rowrm['cement(50kg_bag)']; ?>
                                       
                                </div>
                                 <div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">Sand(cubes) :</div>
                                 <div class="col-md-1">
                                    
                                                <?php echo $rowrm['sand(cube)']; ?>
                                       
                                </div>
                                 <div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">Black Small Stones(cubes) :</div>
                                 <div class="col-md-1">
                                    
                                                <?php echo $rowrm['bss(cube)']; ?>
                                       
                                </div>
                                 <div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">Plaster of Paris(kg) :</div>
                                 <div class="col-md-1">
                                    
                                                <?php echo $rowrm['pop(kg)']; ?>
                                       
                                </div>
                                 <div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">LimeStone(kg) :</div>
                                 <div class="col-md-1">
                                    
                                                <?php echo $rowrm['limestone(kg)']; ?>
                                       
                                </div>
                                 <div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                 <div class="col-md-4">Glue(1L bottles) :</div>
                                 <div class="col-md-1">
                                    
                                                <?php echo $rowrm['glue(bottle)']; ?>
                                       
                                </div>
                             </div>
                                  <div class="col-md-5 " ><h4 style="color: #003399">
                                     
                                     
                                     Available Raw Material Quantity
                                    
                                      </h4><div class="clearfix">&nbsp;</div>
                                  <div class="clearfix">&nbsp;</div>
                                  
                                   <div class="col-md-4">Cement (50kg bags) :</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(1);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                
                                    ?>
                                </div>
                                     
                                 <div class="clearfix">&nbsp;</div>
                                     <div class="clearfix">&nbsp;</div>
                                   <div class="col-md-5">Sand (cubes) :</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(2);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm1=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                    ?>
                                </div> 
                                   
                                   <div class="clearfix">&nbsp;</div>
                                     <div class="clearfix">&nbsp;</div>
                                   <div class="col-md-5">Black Small Stones (cubes) :</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(3);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm2=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                    ?>
                                </div> 
                                  
                                   <div class="clearfix">&nbsp;</div>
                                     <div class="clearfix">&nbsp;</div>
                                   <div class="col-md-5">Plaster of Paris(kg):</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(4);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm3=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                    ?>
                                </div> 
                                    <div class="clearfix">&nbsp;</div>
                                     <div class="clearfix">&nbsp;</div>
                                   <div class="col-md-4">LimeStone(kg)</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(5);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm4=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                    ?>
                                </div> 
                                    <div class="clearfix">&nbsp;</div>
                                     <div class="clearfix">&nbsp;</div>
                                   <div class="col-md-4">Glue(1l bottles):</div>
                                   <div class="col-md-1">
                                       
                                    <?php
                                $resultarm=$obpro->viewAvailableRM(6);
                                $rowarm=$resultarm->fetch(PDO::FETCH_BOTH);
                                $arm5=$rowarm['qua'];
                                echo $rowarm['qua']; 
                                    ?>
                                </div> 
                              </div>
                              </div>
                            <div class="clearfix">&nbsp;</div>
                            <hr style="border-top: 2px solid lightgray" />
                            <div class="clearfix">&nbsp;</div>
                               <div class="row"> 
                                    <div class="col-md-8 col-md-offset-4">
                            <div class="col-md-3">Required Item Quantity</div>
                                <div class="col-md-1">
                                    <?php echo $rquan; ?>
                                </div>
                            <div class="col-md-2">
                                <a href="../view/addproduction.php?item_id=<?php echo $item_id; ?>&color_id=<?php echo $color_id; ?>&size_id=<?php echo $size_id; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-primary">Edit
                                    </button>
                            </a></div>
                                    </div>
                               </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-1"  >
                                     <div class="row">
                                    
                                     <div class="col-md-5" style="color: #003399">
                                         <h4>
                                             Required Raw Material Quantity</h4>
                                     </div>
                                    </div>
                                 <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">Cement (50kg bags) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['cement(50kg_bag)'];
                             $pq=$rowrm['quantity'];
                             $rq=($c/$pq)*$rquan;
                             echo $rq;
                             
                             ?>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">Sand (cubes) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['sand(cube)'];
                             $pq=$rowrm['quantity'];
                             $rq1=($c/$pq)*$rquan;
                             echo $rq1;
                             ?>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">Black Small Stones(cubes) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['bss(cube)'];
                             $pq=$rowrm['quantity'];
                             $rq2=($c/$pq)*$rquan;
                             echo $rq2;
                             ?>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">Plaster of Paris(kg) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['pop(kg)'];
                             $pq=$rowrm['quantity'];
                             $rq3=($c/$pq)*$rquan;
                             echo $rq3;
                             ?>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">limestone(kg) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['limestone(kg)'];
                             $pq=$rowrm['quantity'];
                             $rq4=($c/$pq)*$rquan;
                             echo $rq4;
                             ?>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="col-md-4">Glue(1L bottles) :</div>
                                <div class="col-md-1">
                             <?php  $c  =$rowrm['glue(bottle)'];
                             $pq=$rowrm['quantity'];
                             $rq5=($c/$pq)*$rquan;
                             echo $rq5;
                             ?>
                                </div>
                            
                            
                                </div>
                                <div class="col-md-5">
                                    <div class="row" style="color: #003399"><h4>
                                            Raw Material Quantity for Order</h4>
                                     </div>
                                    <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                                    <div class="col-md-4">Cement (50kg bags) :</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq<=$arm) {
                                                              $rqua=$rq;
                                                           echo Available;  
                                                           $p="Available";
                                                          }else{
                                                              $oq=$rq-$arm;
                                                              echo $oq;
                                                               $p=$oq;
                                                               $pstr="Cement (50kg bags) :";
                                                          }
                             ?>
                                </div>
                                    <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="col-md-4">Sand(cubes) :</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq1<=$arm1) {
                                                               $rqua1=$rq1;
                                                           echo Available;  
                                                            $p1="Available";
                                                          }else{
                                                              $oq=$rq1-$arm1;
                                                              echo $oq;
                                                                $p1=$oq;
                                                                $pstr1="Sand(cubes) :";
                                                          }
                             ?>
                                </div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="col-md-5">Black Small Stones(cubes) :</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq2<=$arm2) {
                                                               $rqua2=$rq2;
                                                           echo Available;
                                                            $p2="Available";
                                                          }else{
                                                              $oq=$rq2-$arm2;
                                                              echo $oq;
                                                                $p2=$oq;
                                                                $pstr2="Black Small Stones(cubes) :";
                                                          }
                             ?>
                                </div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                                    <div class="col-md-5">Plaster of Paris(kg):</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq3<=$arm3) {
                                                               $rqua3=$rq3;
                                                           echo Available;
                                                           $p3="Available";
                                                          }else{
                                                              $oq=$rq3-$arm3;
                                                              echo $oq;
                                                               $p3=$oq;
                                                               $pstr3="Plaster of Paris(kg):";
                                                          }
                             ?>
                                </div>
                                    <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="col-md-5">LimeStone(kg) :</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq4<=$arm4) {
                                                               $rqua4=$rq4;
                                                           echo Available;  
                                                            $p4="Available";
                                                          }else{
                                                              $oq=$rq4-$arm4;
                                                              echo $oq;
                                                                 $p4=$oq;
                                                                 $pstr4="LimeStone(kg) :";
                                                          }
                             ?>
                                </div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="col-md-5">Glue(1L bottles) :</div>
                                <div class="col-md-1">
                             <?php  
                                                          if ($rq5<=$arm5) {
                                                               $rqua5=$rq5;
                                                           echo Available; 
                                                           $p5="Available";
                                                          }else{
                                                              $oq=$rq5-$arm5;
                                                              echo $oq;
                                                               $p5=$oq;
                                                               $pstr5="Glue(1L bottles) :";
                                                          }
                             ?>
                                </div>
                             
                             
                                    </div> 
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <hr style="border-top: 2px solid lightgray" />
                                <div class="clearfix">&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h4 style="text-decoration: underline; text-decoration: bold" >Raw Material Quantity for Order  !!!</h4>
                                            </div></div>
                                          <?php
                            if($p!=="Available"){?>
                                         <?php $a=$p ?>
                                <div class="col-md-4">
                           <?php echo $pstr;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p;?></div>
                            <?php }?>
                                        
                                        
                                          <?php
                            if($p1!=="Available"){?>
                                        <?php $a1=$p1 ?>
                                <div class="col-md-4">
                           <?php echo $pstr1;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p1;?></div>
                            <?php }?>
                                        
                                       
                                         <?php
                            if($p2!=="Available"){?>
                                         <?php $a2=$p2 ?>
                                <div class="col-md-4">
                           <?php echo $pstr2;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p2;?></div>
                            <?php }?>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix">&nbsp;</div>
                                         <?php
                            if($p3!=="Available"){?>
                                        <?php $a3=$p3 ?>
                                <div class="col-md-4">
                           <?php echo $pstr3;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p3;?></div>
                            <?php }?>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix">&nbsp;</div>
                                         <?php
                            if($p4!=="Available"){?>
                                          <?php $a4=$p4 ?>
                                <div class="col-md-4">
                           <?php echo $pstr4;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p4;?></div>
                            <?php }?>
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="clearfix">&nbsp;</div>
                                         <?php
                            if($p5!=="Available"){?>
                                        <?php $a5=$p5 ?>
                                <div class="col-md-4">
                           <?php echo $pstr5;?></div>
                                        <div class="col-md-6">
                           <?php echo  $p5;?></div>
                            <?php }?>
                                    </div>
                                </div>
                                <form action="../controller/pachasecontroller.php?action=add&uni_id=<?php echo $uni_id; ?>&item_id=<?php echo $item_id; ?>&color_id=<?php echo $color_id; ?>&size_id=<?php echo $size_id; ?>&rquan=<?php echo $rquan; ?>"  method="post" enctype="multipart/form-data">
                             <input type="hidden" name="cement" value="<?php echo $a; ?>" />
                             <input type="hidden" name="sand" value="<?php echo $a1; ?>" />
                             <input type="hidden" name="bss" value="<?php echo $a2; ?>" />
                             <input type="hidden" name="pop" value="<?php echo $a3; ?>" />
                             <input type="hidden" name="limestone" value="<?php echo $a4; ?>" />
                             <input type="hidden" name="glue" value="<?php echo $a5; ?>" />
                             
                             
                             
                             <input type="hidden" name="cementa" value="<?php echo $rqua; ?>" />
                             <input type="hidden" name="sanda" value="<?php echo $rqua1; ?>" />
                             <input type="hidden" name="bssa" value="<?php echo $rqua2; ?>" />
                             <input type="hidden" name="popa" value="<?php echo $rqua3; ?>" />
                             <input type="hidden" name="limestonea" value="<?php echo $rqua4; ?>" />
                             <input type="hidden" name="gluea" value="<?php echo $rqua5; ?>" />
                             
                            
                            <div class="clearfix">&nbsp;</div>
                            
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-5" align="right">
                                    <input type="submit" 
                                           class="btn btn-success" value="Save" /></div>
                                <div class="col-md-5">
                                    <input type="reset" 
                           class="btn btn-danger" />                              
                                    
                                </div>                   
                                
                                <div class="col-md-1">&nbsp;</div>
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