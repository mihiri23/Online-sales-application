<?php
date_default_timezone_set("Asia/Colombo");
$m_id=1;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/categorymodel.php';
include '../common/functions.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}
$obcat=new category();
$resultcat=$obcat->displayAllCategory();

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
$('#h').hide();$('#i').hide();$('#j').hide();$('#k').hide();$('#l').hide();$('#m').hide();$('#n').hide();$('#o').hide();
$('#p').hide();$('#q').hide();$('#r').hide();$('#s').hide();$('#t').hide();$('#u').hide();

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
        if($('#h').is(":hidden")){
            $('#h').show();            
        }
        if($('#i').is(":hidden")){
            $('#i').show();            
        }
        if($('#k').is(":hidden")){
            $('#k').show();            
        }
        if($('#l').is(":hidden")){
            $('#l').show();            
        }
         if($('#o').is(":hidden")){
            $('#o').show();            
        }
        if($('#p').is(":hidden")){
            $('#p').show();            
        }
        if($('#r').is(":hidden")){
            $('#r').show();            
        }
        if($('#s').is(":hidden")){
            $('#s').show();            
        }
         if($('#v').is(":hidden")){
            $('#v').show();            
        }
        
                }
                
                if(cat_id==2){
        $('#b').hide(); $('#c').hide();$('#f').hide(); $('#g').hide(); $('#i').hide(); $('#j').hide(); $('#m').hide();
        $('#n').hide(); $('#p').hide(); $('#q').hide(); $('#t').hide();$('#u').hide();
        
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
        if($('#d').is(":hidden")){
            $('#d').show();            
        } 
        if($('#e').is(":hidden")){
            $('#e').show();            
        } 
         if($('#h').is(":hidden")){
            $('#h').show();            
        }           
        if($('#k').is(":hidden")){
            $('#k').show();            
        } 
        if($('#l').is(":hidden")){
            $('#l').show();            
        } 
         if($('#o').is(":hidden")){
            $('#o').show();            
        }           
        if($('#r').is(":hidden")){
            $('#r').show();            
        } 
        if($('#s').is(":hidden")){
            $('#s').show();            
        } 
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
         
                }
                
                if(cat_id==3){
        $('#d').hide(); $('#e').hide();$('#f').hide();$('#g').hide();$('#k').hide();$('#l').hide(); $('#m').hide();
        $('#n').hide(); $('#r').hide(); $('#s').hide();$('#t').hide();$('#u').hide();
       
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
        if($('#b').is(":hidden")){
            $('#b').show();            
        } 
        if($('#c').is(":hidden")){
            $('#c').show();            
        } 
        if($('#h').is(":hidden")){
            $('#h').show();            
        }           
        if($('#i').is(":hidden")){
            $('#i').show();            
        } 
        if($('#j').is(":hidden")){
            $('#j').show();            
        } 
        if($('#o').is(":hidden")){
            $('#o').show();            
        }           
        if($('#p').is(":hidden")){
            $('#p').show();            
        } 
        if($('#q').is(":hidden")){
            $('#q').show();            
        } 
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
         
                }
                
                if(cat_id==4){  
        $('#b').hide();$('#e').hide();$('#f').hide();$('#g').hide();$('#i').hide();$('#l').hide(); $('#m').hide();
        $('#n').hide();$('#p').hide();$('#s').hide();$('#t').hide();$('#u').hide();
        
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#c').is(":hidden")){
            $('#c').show();            
        } 
        if($('#d').is(":hidden")){
            $('#d').show();            
        }
        if($('#h').is(":hidden")){
            $('#h').show();            
        }           
       if($('#j').is(":hidden")){
            $('#j').show();            
        } 
        if($('#k').is(":hidden")){
            $('#k').show();            
        }
        if($('#o').is(":hidden")){
            $('#o').show();            
        }           
       if($('#q').is(":hidden")){
            $('#q').show();            
        } 
        if($('#r').is(":hidden")){
            $('#r').show();            
        }
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
                if(cat_id==5){  
        $('#b').hide();$('#c').hide();$('#e').hide();$('#f').hide(); $('#g').hide();$('#i').hide();$('#j').hide(); $('#l').hide();
        $('#m').hide();$('#n').hide();$('#p').hide(); $('#q').hide();$('#s').hide(); $('#t').hide(); $('#u').hide();
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#d').is(":hidden")){
            $('#d').show();            
        }
         if($('#h').is(":hidden")){
            $('#h').show();            
        }           
       if($('#k').is(":hidden")){
            $('#k').show();            
        }
        if($('#o').is(":hidden")){
            $('#o').show();            
        }           
       if($('#r').is(":hidden")){
            $('#r').show();            
        }
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
                if(cat_id==6){  
        $('#c').hide();$('#d').hide(); $('#f').hide(); $('#g').hide();$('#j').hide(); $('#k').hide(); $('#m').hide();
        $('#n').hide();$('#q').hide(); $('#r').hide();$('#t').hide();$('#u').hide();
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#b').is(":hidden")){
            $('#b').show();            
        }
        if($('#e').is(":hidden")){
            $('#e').show();            
        }
        if($('#h').is(":hidden")){
            $('#h').show();            
        }           
       if($('#i').is(":hidden")){
            $('#i').show();            
        }
        if($('#l').is(":hidden")){
            $('#l').show();            
        }
        if($('#o').is(":hidden")){
            $('#o').show();            
        }           
       if($('#p').is(":hidden")){
            $('#p').show();            
        }
        if($('#s').is(":hidden")){
            $('#s').show();            
        }
           if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
                
                if(cat_id==7){  
        $('#c').hide();$('#d').hide(); $('#e').hide(); $('#f').hide(); $('#g').hide(); $('#j').hide(); $('#k').hide();
        $('#l').hide();$('#m').hide();$('#n').hide();$('#q').hide();$('#r').hide();$('#s').hide(); $('#t').hide();$('#u').hide();
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#b').is(":hidden")){
            $('#b').show();            
        }
        if($('#h').is(":hidden")){
            $('#h').show();            
        }           
       if($('#i').is(":hidden")){
            $('#i').show();            
        }
        if($('#o').is(":hidden")){
            $('#o').show();            
        }           
       if($('#p').is(":hidden")){
            $('#p').show();            
        }
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
        if(cat_id==8){  
        $('#a').hide();$('#b').hide();$('#c').hide();$('#d').hide(); $('#e').hide();$('#h').hide();$('#i').hide();  $('#j').hide();
        $('#k').hide(); $('#l').hide();$('#o').hide();$('#p').hide();$('#q').hide();$('#r').hide();$('#s').hide();
        if($('#f').is(":hidden")){
            $('#f').show();            
        }           
       if($('#g').is(":hidden")){
            $('#g').show();            
        }
        if($('#m').is(":hidden")){
            $('#m').show();            
        }           
       if($('#n').is(":hidden")){
            $('#n').show();            
        }
        if($('#t').is(":hidden")){
            $('#t').show();            
        }           
       if($('#u').is(":hidden")){
            $('#u').show();            
        }
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
                
                }
        if(cat_id==9){  
        $('#b').hide();$('#c').hide();$('#e').hide();  $('#f').hide();$('#g').hide();$('#i').hide(); $('#j').hide();$('#l').hide(); 
        $('#m').hide();$('#n').hide();$('#p').hide();$('#q').hide();$('#s').hide();  $('#t').hide();$('#u').hide();
        if($('#a').is(":hidden")){
            $('#a').show();            
        }           
       if($('#d').is(":hidden")){
            $('#d').show();            
        }
         if($('#h').is(":hidden")){
            $('#h').show();            
        }           
       if($('#k').is(":hidden")){
            $('#k').show();            
        }
         if($('#o').is(":hidden")){
            $('#o').show();            
        }           
       if($('#r').is(":hidden")){
            $('#r').show();            
        }
          if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
                
                if(cat_id==10){
        $('#a').hide();$('#b').hide();$('#c').hide();$('#d').hide();$('#e').hide();$('#f').hide(); $('#h').hide();$('#i').hide();
        $('#j').hide();$('#k').hide(); $('#l').hide();$('#m').hide();$('#o').hide(); $('#p').hide(); $('#q').hide();
        $('#r').hide();$('#s').hide();$('#t').hide();    
        if($('#g').is(":hidden")){
            $('#g').show();            
        }  
        if($('#n').is(":hidden")){
            $('#n').show();            
        } 
        if($('#u').is(":hidden")){
            $('#u').show();            
        } 
         if($('#v').is(":hidden")){
            $('#v').show();            
        }
                }
                if(cat_id==11){
        $('#a').hide();$('#b').hide();$('#c').hide();$('#d').hide();$('#e').hide();$('#f').hide();$('#g').hide();$('#h').hide();
        $('#i').hide(); $('#j').hide();$('#k').hide();$('#l').hide();$('#m').hide();$('#n').hide();$('#o').hide();
        $('#p').hide();$('#q').hide();$('#r').hide();$('#s').hide();$('#t').hide(); $('#u').hide(); $('#v').hide(); 
        
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
                        <li class="active">Add Item</li></div>
                    </ol>                    
                    </div>
                </div>
        </div>
        <div style="height: 40px"><?php include '../common/itemtab.php';?></div>        
            <div class="clearfix"></div>            
            <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                            <h3 class="alig">Add Item</h3>
                    </div>
                </div>
            <div class="row" style="height:20px; background:linear-gradient(#ffffff);" ></div>            
            <div id="contents">              
                <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" style="padding-left: 30px">
                    <div class="row">
                        <div class="container-fluid"><form action="../controller/itemcontroller.php?action=add" method="post" enctype="multipart/form-data">
                            <div class="col-md-12 col-sm-6">
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-1"style="text-align: right">Category</div>                                
                                <div class="col-md-3">
                                    <select id="cat_id" name="cat_id" class="form-control " onchange="displaySC(this.value),hideFields(this.value)">
                                        <option value=" ">"Select a Category"</option>
                                        <?php while($rowcat=$resultcat->fetch(PDO::FETCH_BOTH)){ ?>
                                        <option value="<?php echo $rowcat['cat_id']; ?>">
                                        <?php echo $rowcat['cat_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    
                                </div>
                                 
                               <div class="col-md-2" style="text-align: right">Sub Category</div>
                                <div class="col-md-3">
                                    <span id="showsubcategory">
                                    <select id="sc_id" name="sc_id" class="form-control">
                                        <option value="">"Select a Sub Category"</option>                                  
                                    </select>
                                    </span>  
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                                
                            </div>
                            
                             <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="col-md-6 col-md-offset-3">
                            
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-4">Item Name</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_name" name="item_name" class="form-control" />
                                    
                                </div>
                              </div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="row"> 
                                <div class="col-md-4">Item Images</div>
                                <div class="col-md-6">
                                    <input type="file" id="item_image" name="item_image[]" multiple class="form-control" />                                  
                                </div>                                                              
                             </div>
                             <div id="v">
                             <div class="clearfix">&nbsp;</div>
                            
                             <div class="row"> 
                                <div class="col-md-4">Item Colours</div>
                                <div class="col-md-2">
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="cement" checked> Cement <br>  
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="Black"> Black <br>
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="Gold"> Gold <br>
                                </div>
                                <div class="col-md-2">  
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="Maroon"> Maroon <br>
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value=White"> White <br>
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="yellow">yellow <br>
                                </div>       
                                <div class="col-md-2">  
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="Multi"> Multi<br>
                                    <input type="checkbox" id="item_colours" name="item_colours[]" value="Other"> Other <br>
                                   
                                </div>       
                             </div>
                             </div>
                             <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                
                                <div class="col-md-4">Item Description</div>
                                <div class="col-md-8">
                                    <textarea id="item_des" name="item_des" class="form-control" />
                                    </textarea>
                                </div>
                              
                            </div>
                             
                              <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                             <p style="color: #8a8a8a" > Item Size-Large</p>
                             <div id="a">
                              <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row" >                                
                                <div class="col-md-4">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height" name="item_height" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                              <div id="b">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width" name="item_width" class="form-control" />                                    
                                </div>
                            </div>
                              </div>
                             <div id="c">
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-4">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length" name="item_length" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="d">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area" name="base_area" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="e">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter" name="diameter" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="f">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face" name="item_face" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="g">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size" name="item_size" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             
                             <div class="clearfix">&nbsp;</div>
                              <div class="row">                                
                                <div class="col-md-4">Item Price</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price" name="item_price" class="form-control" />                                    
                                </div>
                            </div>
                            
                              
                                                          
                             
                              <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                             <p style="color: #8a8a8a" > Item Size-Medium</p>
                             <div id="h">
                              <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row" >                                
                                <div class="col-md-4">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height_m" name="item_height_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                              <div id="i">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width_m" name="item_width_m" class="form-control" />                                    
                                </div>
                            </div>
                              </div>
                             <div id="j">
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-4">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length_m" name="item_length_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="k">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area_m" name="base_area_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="l">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter_m" name="diameter_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="m">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face_m" name="item_face_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="n">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size_m" name="item_size_m" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             
                             <div class="clearfix">&nbsp;</div>
                              <div class="row">                                
                                <div class="col-md-4">Item Price</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price_m" name="item_price_m" class="form-control" />                                    
                                </div>
                            </div>
                                         
                              <div class="clearfix">&nbsp;</div>  
                             <div class="clearfix">&nbsp;</div>
                             <p style="color: #8a8a8a" > Item Size-Small</p>
                             <div id="o">
                              <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row" >                                
                                <div class="col-md-4">Item Height</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_height_s" name="item_height_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                              <div id="p">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Width</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_width_s" name="item_width_s" class="form-control" />                                    
                                </div>
                            </div>
                              </div>
                             <div id="q">
                             <div class="clearfix">&nbsp;</div>
                             
                             <div class="row">                                
                                <div class="col-md-4">Item Length</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_length_s" name="item_length_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="r">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Base Area</div>
                                <div class="col-md-6">
                                    <input type="text" id="base_area_s" name="base_area_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="s">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Diameter</div>
                                <div class="col-md-6">
                                    <input type="text" id="diameter_s" name="diameter_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="t">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Face Type</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_face_s" name="item_face_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             <div id="u">
                             <div class="clearfix">&nbsp;</div>
                             <div class="row">                                
                                <div class="col-md-4">Item Size</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_size_s" name="item_size_s" class="form-control" />                                    
                                </div>
                            </div>
                             </div>
                             
                             <div class="clearfix">&nbsp;</div>
                              <div class="row">                                
                                <div class="col-md-4">Item Price</div>
                                <div class="col-md-6">
                                    <input type="text" id="item_price_s" name="item_price_s" class="form-control" />                                    
                                </div>
                            </div>
                            
                             
                              <div class="clearfix">&nbsp;</div>
                              <div class="clearfix">&nbsp;</div>
                             <div class="row">
                                <div class="col-md-1">&nbsp;</div>
                               
                                <div class="col-md-5" align="right">
                                    <input type="submit" class="btn btn-primary" />
                                    
                                </div>
                                
                                
                                <div class="col-md-5">
                                     <input type="reset" class="btn btn-warning" />
                                    
                                </div>
                                <div class="col-md-1">&nbsp;</div>
                                
                                
                            </div>
                             <div class="clearfix">&nbsp;</div>
                             <div class="clearfix">&nbsp;</div>
                             
                             
                           
                    </div>
                              </form>
                        </div>
                    </div>
                </div>                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    
</html>