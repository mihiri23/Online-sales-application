<?php
date_default_timezone_set("Asia/Colombo");
$m_id=5;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';


include '../common/functions.php';


include '../model/rawstockmodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$item_id=$_GET['item_id'];
$obraw=new rawstock();
$resultitem=$obraw->viewAnItem($item_id);
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);


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
                            <li><a href="../view/rawstock.php">Stock</a></li>
                            <li><a href="../view/addrawstock.php">Add Stock</a></li>
                            <li class="active">Add a Stock</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
               
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3  style="padding-top: 15px" class="alig">Add a Stock</h3>
                    </div>
                </div>
               <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
               <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" 
                     style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div class="container-fluid">
                            <form action="../controller/rawstockcontroller.php?action=add" 
                                  method="post" enctype="multipart/form-data">
                             <input type="hidden" name="item_id" value="<?php echo $item_id; ?>" />
                            <div class="row">
                                
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2">Item Name :</div>
                                <div class="col-md-3">
                                    <?php echo $rowitem['item_name']; ?>
                                </div>
                                <div class="col-md-2"> Details </div>
                                 <div class="col-md-3">
                                 <?php echo $rowitem['item_des']; ?>
                                 </div>
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                                
                                <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2">Unit Price :</div>
                                <div class="col-md-3">
                                    <input type="text" id="uprice" name="uprice" 
                                           class="form-control"
                                           onkeypress="return onlyNos(event,this)"/>
                                </div>
                                <div class="col-md-2">Price :</div>
                                <div class="col-md-3">
                                    <input type="text" id="price" name="price" 
                                           class="form-control"
                                           onkeypress="return onlyNos(event,this)"/>
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>                                
                                <div class="col-md-1">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2">Quantity :</div>
                                <div class="col-md-3">
                                    <input type="text" id="quan" name="quan" 
                                           class="form-control" />
                                    
                                </div>
                                <div class="col-md-2">Upload a File :</div>
                                <div class="col-md-3">
                                    <input type="file" id="textfile" name="textfile" 
                                           
                                           class="form-control" />
                                </div>
                                <div class="col-md-1">&nbsp;</div>
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
                           class="btn btn-info" />                              
                                    
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
            
            </script>
    
    
</html>