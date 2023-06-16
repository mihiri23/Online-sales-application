<?php
$m_id=1;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../common/functions.php';
include '../model/itemmodel.php';
$countm=checkModuleRole($m_id,$role_id);
if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$item_id=$_REQUEST['item_id'];
$obi=new item();
$resultitem=$obi->viewAItem($item_id);
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);


include '../model/categorymodel.php';
$cat_id=$rowitem['cat_id'];
$obc=new Category();
$resultc=$obc->viewCategory($cat_id);
$rowc=$resultc->fetch(PDO::FETCH_BOTH);

include '../model/scmodel.php';
$sc_id=$rowitem['sc_id'];
$obsc=new subCategory();
$resultsc=$obsc->viewSC($sc_id);
$rowsc=$resultsc->fetch(PDO::FETCH_BOTH);


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
    <script src="../JQuery/jquery-3.2.1.min.js"></script>
    
    
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                
            </div>
                        
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                        <img src="<?php echo $iname; ?>" class="style1" />
                        <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                    <ol class="breadcrumb">
                        <li ><a href="../view/dashboard.php">Dashboard</a></li>
                        <li ><a href="../view/itemhome.php">Item Home</a></li>
                        <li ><a href="../view/item.php">View All Items</a></li>
                        <li class="active">View Item</li></div>
                    </ol>                    
                    </div>
                </div>           
              <div style="height: 40px"><?php include '../common/itemtab.php';?></div>                   
            <div class="clearfix"></div>
            <div id="contents">
                
                <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">View Item</h3>
                    </div>
                </div>
            <div class="row" style="height:40px; background:linear-gradient(#ffffff);" ></div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="row">
                            <div >
                                
                                 <?php
                               
                                 $resultimage=$obi->viewItemImage($item_id);
                                 $noi=$resultimage->rowCount();
                                 if($noi){
                                    $all=array();
                                    while($rowall=$resultimage->fetch(PDO::FETCH_BOTH)){
                                    //echo $rowall['ii_name'];
                                         array_push($all, $rowall['ii_name']);
                                    }
                                    //var_dump($all);
                                    
                                    
                                } else{                                    
                                   $path="../images/order.png";
                                }                             
                                   foreach($all as $v){
                                    $im=$v;
                                    
                                    $path='../images/item_images/'.$im;
                                    ?>
                                <img src="<?php echo $path; ?>" height="150" width="150" />
                                
                            <?php } ?>
                                
                                
                            </div>
                            <div class="col-md-6">
                                &nbsp;
                                &nbsp;
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            
                            <div class="col-md-6"><p>Item Name</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_name']; ?>
                            </div>
                          
                        </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Category</p></div>
                            <div class="col-md-6">
                                <?php echo $rowc['cat_name']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Sub Category</p></div>
                            <div class="col-md-6">
                                <?php echo $rowsc['sc_name']; ?>
                            </div>
                        </div>
                         
                           <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Item Description</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_des']; ?>
                            </div>
                        </div>
                           <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                           <p style="color: #8a8a8a" > Item Size-Large</p>
                           <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Item Height</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_height']; ?>
                            </div>
                            
                        </div>
                             <?php } ?>
                              <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
           
                            <div class="col-md-6"><p>Item Width</p></div>
                            <div class="col-md-6">
                            <?php echo $rowitem['item_width']; ?>
                            </div>
            
                        </div>
                               <?php } ?>
                               <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                          <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                             <div class="col-md-6"><p>Item Length</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_length']; ?>
                            </div>
                        </div>
                          <?php } ?>
                          <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Base Area</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['base_area']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Diameter</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['diameter']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 ){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Face Type</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_face']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Item Size</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_size']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Item Price</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_price']; ?>
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                           <p style="color: #8a8a8a" > Item Size-Medium</p>
                           <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                           
                            <div class="col-md-6"><p>Item Height</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_height_m']; ?>
                            </div>
                            
                        </div>
                          <?php } ?>
                             <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
           
                            <div class="col-md-6"><p>Item Width</p></div>
                            <div class="col-md-6">
                            <?php echo $rowitem['item_width_m']; ?>
                            </div>
            
                        </div>
                               <?php } ?>
                               <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                          <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                             <div class="col-md-6"><p>Item Length</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_length_m']; ?>
                            </div>
                        </div>
                          <?php } ?>
                          <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Base Area</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['base_area_m']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Diameter</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['diameter_m']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 ){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Face Type</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_face_m']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Item Size</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_size_m']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Item Price</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_price_m']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                           <p style="color: #8a8a8a" > Item Size-Small</p>
                           <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                           
                            <div class="col-md-6"><p>Item Height</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_height_s']; ?>
                            </div>
                            
                        </div>
                          <?php } ?>
                              <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                               <div class="clearfix">&nbsp;</div>
                         <div class="row">
           
                            <div class="col-md-6"><p>Item Width</p></div>
                            <div class="col-md-6">
                            <?php echo $rowitem['item_width_s']; ?>
                            </div>
            
                        </div>
                               <?php } ?>
                               <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                          <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                             <div class="col-md-6"><p>Item Length</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_length_s']; ?>
                            </div>
                        </div>
                          <?php } ?>
                          <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Base Area</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['base_area_s']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Diameter</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['diameter_s']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 ){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Face Type</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_face_s']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                         <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p>Item Size</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_size_s']; ?>
                            </div>
                        </div>
                         <?php } ?>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Item Price</p></div>
                            <div class="col-md-6">
                                <?php echo $rowitem['item_price_s']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                                 <div class="col-md-6"><p>
                                         <a href="../view/updateitem.php?item_id=<?php echo $rowitem['item_id']; ?> ">
                                        <button type="button" class="btn btn-sm btn-primary">Update</button>
                                    </a>
                               <?php
                               $arr=array("rating","stock","cart","feedback") ;                               
                               $count=0;
                               foreach ($arr as $v){
                                   $count+= checkDelete($v,"item_id", $item_id);
                               }
                                 if($count==0){ ?>    
                                    <a href="../controller/itemcontroller.php?item_id=<?php echo $rowitem['item_id']; ?>&action=delete">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="return confirmation('Delete','A Item')">
                                       Delete
                                    </button>
                                    </a> 
                                    <?php } ?>                                                                                  
                                                                          
                                 </p></div>
                            <div class="col-md-6">
                                &nbsp;
                            </div>
                        </div>
                          <div class="clearfix">&nbsp;</div>
                    </div>                    
                </div>
                        
                              
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script>
    function confirmation(str,str1){
        var r =confirm("DO you want to "+str+" "+str1+"?");// To confirm the AC or DAC
        if(!r){
            return false;
        }
    }
    </script>
    <script type="text/javascript" src="../plugins/jQuery/jQuery-2.1.4.min.js">
    </script>
    <!-- External JS for validation -->
    <script src="../js/validation.js"></script>
</html>
