<?php
$m_id=1;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../common/functions.php';
include '../model/categorymodel.php';

$countm=checkModuleRole($m_id,$role_id);
if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}
//To get all provinces
$obcat=new category();//To create an object based on province class 
//To call a method for getting all provinces
$resultcategories=$obcat->displayAllCategory();

//To get user ID from user.php
$item_id=$_REQUEST['item_id'];
include '../model/itemmodel.php';
//To get the specific user's details
$obi=new item();
$resultitem=$obi->viewAItem($item_id);
//To assign user details into an array
$rowitem=$resultitem->fetch(PDO::FETCH_BOTH);
//echo $item_id;
//To get province details

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
    <script>
function displaySC(str) {
  var xhttp; 
  if (str == "") {
    document.getElementById("showsubcategory").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("showsubcategory").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../ajax/getSubCategory.php?q="+str, true);
  xhttp.send();
}

$(document).ready(function (){
$('#a').hide();//Height
$('#b').hide();//Width 
$('#c').hide();//Lengh
$('#d').hide();//Base area
$('#e').hide();//Diameter
$('#f').hide();//face
$('#g').hide();//size
});

function hideFields(cat_id){

   if(cat_id==1){
       if($('#a').is(":hidden")){
            $('#a').show();            
        }   
        if($('#b').is(":hidden")){
            $('#b').show();            
        } 
        if($('#d').is(":hidden")){
            $('#d').show();            
        } 
        if($('#e').is(":hidden")){
            $('#e').show();            
        }
                }
                
                if(cat_id==2){
        $('#b').hide();
        $('#c').hide();
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
        if($('#d').is(":hidden")){
            $('#d').show();            
        } 
        if($('#e').is(":hidden")){
            $('#e').show();            
        } 
         
                }
                
                if(cat_id==3){
        $('#d').hide();
        $('#e').hide();
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
        if($('#b').is(":hidden")){
            $('#b').show();            
        } 
        if($('#c').is(":hidden")){
            $('#c').show();            
        } 
         
                }
                
                if(cat_id==4){  
        $('#b').hide();
        $('#e').hide();
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#c').is(":hidden")){
            $('#c').show();            
        } 
        if($('#d').is(":hidden")){
            $('#d').show();            
        }
         
                }
                if(cat_id==5){  
        $('#b').hide();
        $('#c').hide();
        $('#e').hide();
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#d').is(":hidden")){
            $('#d').show();            
        }
         
                }
                if(cat_id==6){  
        $('#c').hide();
        $('#d').hide(); 
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#b').is(":hidden")){
            $('#b').show();            
        }
        if($('#e').is(":hidden")){
            $('#e').show();            
        }
         
                }
                
                if(cat_id==7){  
        $('#c').hide();
        $('#d').hide();
        $('#e').hide(); 
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#b').is(":hidden")){
            $('#b').show();            
        }
                }
        if(cat_id==8){  
        $('#a').hide();
        $('#b').hide();
        $('#c').hide();
        $('#d').hide();
        $('#e').hide();
        if($('#f').is(":hidden")){
            $('#f').show();            
        }           
       if($('#g').is(":hidden")){
            $('#g').show();            
        }
                
                }
        if(cat_id==9){  
        $('#b').hide();
        $('#c').hide();
        $('#e').hide(); 
        $('#f').hide();//face
        $('#g').hide();//size
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#d').is(":hidden")){
            $('#d').show();            
        }
                }
                
                if(cat_id==10){
        $('#a').hide();
        $('#b').hide();
        $('#c').hide();
        $('#d').hide();
        $('#e').hide(); 
        $('#f').hide();       
        if($('#g').is(":hidden")){
            $('#g').show();            
        }           
       
                }
                if(cat_id==11){
        $('#a').hide();
        $('#b').hide();
        $('#c').hide();
        $('#d').hide();
        $('#e').hide(); 
        $('#f').hide();
        $('#g').hide();    
        
                }
}

       </script>
    
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
                        <li class="active">Update Item</li></div>
                    </ol>                    
                    </div>
                </div>           
              <div style="height: 40px"><?php include '../common/itemtab.php';?></div>        
            <div class="clearfix"></div>
            <div class="row" style="height:20px; background:linear-gradient(#ffffff);"></div>  
            <div id="contents">
                <div class="row">
                    <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">Update Item</h3>
                    </div>
                </div>
            <div class="row" style="height:20px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
                <div class="row">
                    <div class="col-md-12 col-sm-6" 
                         style="text-align: center">
                           <?php 
                           if(isset($_REQUEST['msg'])){
                               echo "<span class='text text-".$_REQUEST['status']."'>".$_REQUEST['msg']."</span>";
                           }
                           ?>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <form method="post" action="../controller/itemcontroller.php?action=update&item_id=<?php echo $item_id ?>" enctype="multipart/form-data" >                
                     
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <div class="col-md-6"><p>Item Name</p></div>
                            <div class="col-md-6">
                                <input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control"
                                       value="<?php echo $rowitem['item_name']; ?>" />                                
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6"><p>Category</p></div>
                            <div class="col-md-6">
                                <select name="cat_id" id="cat_id" 
                                    class="form-control" onchange="displaySC(this.value)">
                                    <option value="">Select a category</option>
                                        <?php while($rowcategory=$resultcategories->fetch(PDO::FETCH_BOTH)){ ?>
                                        <option value="<?php echo $rowcategory['cat_id']; ?>"
                                        <?php
                                        if($rowcategory['cat_id']==$rowsc['cat_id']){
                                        echo "SELECTED";
                                        }
                                        ?>
                                        >
                                        <?php echo $rowcategory['cat_name']; ?>
                                        </option>
                                        <?php } ?>                                
                                </select> 
                                
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p>Sub Category</p></div>
                            <div class="col-md-6">
                                <!-- To load/show all districts in a selected province -->
                                <span id="showsubcategory">
                                <select name="sc_id" id="sc_id" class="form-control">
                                    <option value="">Select a Sub category</option>
                                        <?php 
                                        $resultdis=$obsc->displaySCPerCat($rowsc['cat_id']);
                                        while($rowdis=$resultdis->fetch(PDO::FETCH_BOTH)){ ?>
                                        <option value="<?php echo $rowdis['sc_id']; ?>"
                                                <?php
                                                if($rowdis['sc_id']==$sc_id){
                                                echo "SELECTED";
                                                   }
                                                ?>
                                                >
                                                <?php echo $rowdis['sc_name']; ?>
                                        </option>
                                        <?php } ?> 
                                </select>
                                </span>
                            </div>
                        </div>
                         
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6"><p>Item Images</p></div>
                            <div class="col-md-6">
                                <input type="file" name="item_image[]" id="item_image" multiple class="form-control" onchange="readURL(this)" />                               
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
                                <img id="image_view" src="<?php echo $path; ?>" height="40" width="40" />
                                
                            <?php } ?>
                              
                            </div>
                            
                        </div>
                        
                        <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                
                                <div class="col-md-5">Item Description</div>
                                <div class="col-md-7">
                                    <textarea id="item_des" name="item_des" class="form-control">
                                             <?php echo $rowitem['item_des'];?>
                                    </textarea>
                                    
                                </div>
                              
                            </div>
                        <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height" name="item_height" class="form-control" 
                                           placeholder="Item Height" value="<?php echo $rowitem['item_height']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width" name="item_width" class="form-control" 
                                           placeholder="Item width" value="<?php echo $rowitem['item_width']; ?>"/>                                    
                                </div>
                            </div>
                       <?php } ?>
                       <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-6">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length" name="item_length" class="form-control" 
                                           placeholder="Item Length" value="<?php echo $rowitem['item_length']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area" name="base_area" class="form-control" 
                                           placeholder="Base Area" value="<?php echo $rowitem['base_area']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter" name="diameter" class="form-control"
                                           placeholder="Diameter" value="<?php echo $rowitem['diameter']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==8 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face" name="item_face" class="form-control"
                                           placeholder="Item Face Type" value="<?php echo $rowitem['item_face']; ?>"/>                                    
                                </div>
                            </div>
                        
                        <?php } ?>
                             <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size" name="item_size" class="form-control" 
                                           placeholder="Item Size" value="<?php echo $rowitem['item_size']; ?>"/>                                    
                                </div>
                            </div>
                             <?php } ?>                 
                             <div class="clearfix">&nbsp;</div>
                        <div class="row">                                
                            <div class="col-md-6"><p>Item Price</p></div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price" name="item_price"  placeholder="Item price" value="<?php echo $rowitem['item_price']; ?>" class="form-control" />                                    
                                </div>
                        </div> 
                             <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                             
                           <p style="color: #8a8a8a" > Item Size-Medium</p>
                           
                           <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height_m" name="item_height_m" class="form-control" 
                                           placeholder="Item Height" value="<?php echo $rowitem['item_height_m']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width_m" name="item_width_m" class="form-control" 
                                           placeholder="Item width" value="<?php echo $rowitem['item_width_m']; ?>"/>                                    
                                </div>
                            </div>
                       <?php } ?>
                       <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-6">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length_m" name="item_length_m" class="form-control" 
                                           placeholder="Item Length" value="<?php echo $rowitem['item_length_m']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area_m" name="base_area_m" class="form-control" 
                                           placeholder="Base Area" value="<?php echo $rowitem['base_area_m']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter_m" name="diameter_m" class="form-control"
                                           placeholder="Diameter" value="<?php echo $rowitem['diameter_m']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==8 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face_m" name="item_face_m" class="form-control"
                                           placeholder="Item Face Type" value="<?php echo $rowitem['item_face_m']; ?>"/>                                    
                                </div>
                            </div>
                        
                        <?php } ?>
                             <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size_m" name="item_size_m" class="form-control" 
                                           placeholder="Item Size" value="<?php echo $rowitem['item_size_m']; ?>"/>                                    
                                </div>
                            </div>
                             <?php } ?>                 
                             <div class="clearfix">&nbsp;</div>
                        <div class="row">                                
                            <div class="col-md-6"><p>Item Price</p></div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price_m" name="item_price_m"  placeholder="Item price" value="<?php echo $rowitem['item_price_m']; ?>" class="form-control" />                                    
                                </div>
                        </div>
                             <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                             
                           <p style="color: #8a8a8a" > Item Size-Small</p>
                           
                           <?php if($rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height_s" name="item_height_s" class="form-control" 
                                           placeholder="Item Height" value="<?php echo $rowitem['item_height_s']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=2 && $rowitem['cat_id']!=4 && $rowitem['cat_id']!=5 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=9 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width_s" name="item_width_s" class="form-control" 
                                           placeholder="Item width" value="<?php echo $rowitem['item_width_s']; ?>"/>                                    
                                </div>
                            </div>
                       <?php } ?>
                       <?php if($rowitem['cat_id']==3 || $rowitem['cat_id']==4 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-6">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length_s" name="item_length_s" class="form-control" 
                                           placeholder="Item Length" value="<?php echo $rowitem['item_length_s']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']!=3 && $rowitem['cat_id']!=6 && $rowitem['cat_id']!=7 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=8 && $rowitem['cat_id']!=10 && $rowitem['cat_id']!=11){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area_s" name="base_area_s" class="form-control" 
                                           placeholder="Base Area" value="<?php echo $rowitem['base_area_s']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==1 || $rowitem['cat_id']==6 || $rowitem['cat_id']==2){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter_s" name="diameter_s" class="form-control"
                                           placeholder="Diameter" value="<?php echo $rowitem['diameter_s']; ?>"/>                                    
                                </div>
                            </div>
                        <?php } ?>
                        <?php if($rowitem['cat_id']==8 ){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face_s" name="item_face_s" class="form-control"
                                           placeholder="Item Face Type" value="<?php echo $rowitem['item_face_s']; ?>"/>                                    
                                </div>
                            </div>
                        
                        <?php } ?>
                             <?php if($rowitem['cat_id']==8 || $rowitem['cat_id']==10){ ?>
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-6">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size_s" name="item_size_s" class="form-control" 
                                           placeholder="Item Size" value="<?php echo $rowitem['item_size_s']; ?>"/>                                    
                                </div>
                            </div>
                             <?php } ?>                 
                             <div class="clearfix">&nbsp;</div>
                        <div class="row">                                
                            <div class="col-md-6"><p>Item Price</p></div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price_s" name="item_price_s"  placeholder="Item price" value="<?php echo $rowitem['item_price_s']; ?>" class="form-control" />                                    
                                </div>
                        </div> 
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            
                            <div class="row">
                            <div class="col-md-6"><p>
                                    <input type="submit" name="up" value="Update" class="btn btn-primary" />  
                                      
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
                </form>         
                              
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
    <script type="text/javascript" src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- External JS for validation -->
   
</html>
