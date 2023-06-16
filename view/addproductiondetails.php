<?php
date_default_timezone_set("Asia/Colombo");
$m_id=8;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/categorymodel.php';
include '../model/brandmodel.php';
include '../common/functions.php';
include '../model/featuremodel.php';
include '../model/itemmodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$obf=new feature();
$resultc=$obf->displayFeature(1);
$results=$obf->displayFeature(2);

$item_id=$_GET['item_id'];
$obitem=new item();
$resultitem=$obitem->viewAnItem($item_id);
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);

$resultimage=$obitem->viewItemImage($item_id);
$rowimage=$resultimage->fetch(PDO::FETCH_BOTH);
if($rowimage['ii_name']==""){
    $path="../images/Product.png";
}else{
    $path='../images/item_images/'.$rowimage['ii_name'];
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
                            <li><a href="../view/addproductionstock.php">Item Stock</a></li>
                            <li class="active">Add Production Details</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
               
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3  style="padding-top: 15px" class="alig">Add Production Details</h3>
                    </div>
                </div>
               <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
               <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" 
                     style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div class="container-fluid">
                            <form action="../controller/productioncontroller.php?action=add" 
                                  method="post" enctype="multipart/form-data">
                             <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                               
                                <div class="col-md-3">
                                    <img src="<?php echo $path; ?>" width="120" />
                                </div>
                                <div class="col-md-1" style="padding-top: 20px" ><h4>Color :</h4></div>
                                <div class="col-md-2" style="padding-top: 20px"  >
                                    <select id="color_id" name="color_id" 
                                            class="form-control">
                                        <option value="">Select a Color</option>
                                        <?php 
                                        while($rowc=$resultc->fetch(PDO::FETCH_BOTH)){ ?>
                                            <option value="<?php echo $rowc['f_id']; ?>">
                                                <?php echo $rowc['f_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-1" style="padding-top: 20px"><h4>Size :</h4></div>
                                <div class="col-md-2" style="padding-top: 20px">
                                    <select id="size_id" name="size_id" class="form-control">
                                        <option value="">Select a Size</option>
                                        <?php 
                                        while($rows=$results->fetch(PDO::FETCH_BOTH)){ ?>
                                            <option value="<?php echo $rows['f_id']; ?>">
                                                <?php echo $rows['f_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                                
                               <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="col-md-offset-1" >
                                
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2">Add details for :</div>
                                <div class="col-md-3">
                                    <input type="text" id="quan" name="quan" 
                                           class="form-control" />
                                    
                                </div>
                                <div class="col-md-1">Items</div>
                                </div>
                            <div class="clearfix">&nbsp;</div>
                                
                               <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                                <div class="col-md-6 col-md-offset-3">
                            
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Cement</div>
                                <div class="col-md-6">
                                    <input type="text" id="cement" name="cement" class="form-control" />
                                    
                                </div>
                              </div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Sand</div>
                                <div class="col-md-6">
                                    <input type="text" id="sand" name="sand" class="form-control" />
                                    
                                </div>
                              </div>
                               <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Black Small Stones</div>
                                <div class="col-md-6">
                                    <input type="text" id="bss" name="bss" class="form-control" />
                                    
                                </div>
                              </div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Plaster of Paris</div>
                                <div class="col-md-6">
                                    <input type="text" id="pop" name="pop" class="form-control" />
                                    
                                </div>
                              </div>
                               <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Lime Stone</div>
                                <div class="col-md-6">
                                    <input type="text" id="limestone" name="limestone" class="form-control" />
                                    
                                </div>
                              </div>
                                <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Glue </div>
                                <div class="col-md-6">
                                    <input type="text" id="glue" name="glue" class="form-control" />
                                    
                                </div>
                              </div>
                                 <div class="clearfix">&nbsp;</div>
                             
                                </div>
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
                             <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>
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
            
            </script>
    
    
</html>