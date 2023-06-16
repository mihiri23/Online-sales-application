<?php
date_default_timezone_set("Asia/Colombo");
$m_id=8;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/itemmodel.php';
include '../model/categorymodel.php';
include '../model/scmodel.php';
include '../common/functions.php';
//include '../model/featuremodel.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}
$obitem=new item();
$result=$obitem->viewAllItem();

$obcat=new category();
$resultcat=$obcat->displayAllCategory();
$obsc=new subCategory();
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
    
<script>  
            
$(document).ready(function() {
    var table = $('#example').DataTable( {
        
    } );
 
    table.buttons().container()
        .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
} );

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

        </script>
    
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
                            <li class="active">Add Details</li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            
              <div class="clearfix"></div>
        <div id="contents">
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h2  style="padding-top: 15px" class="alig">Add Production Details</h2>
                    </div>
                </div>
            
            <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
<div class="clearfix">&nbsp;</div>
                <div class="container-fluid" style="padding-left: 30px" style="padding-right: 30px">
                    <div style="text-align: center" class="alert alert-info">
                        <?php
                        if (isset($_GET['msg'])) {
                            echo base64_decode($_GET['msg']);
                        }
                        ?>
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>
                <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
               
                
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-3" style="text-align:right">
                            Category:
                            </div>
                            <div class="col-md-8">
                            <select id="cat_id" name="cat_id" class="form-control " onchange="displaySC(this.value),displayItem(this.value,document.getElementById('sc_id').value)">
                                        <option value=" ">"Select a Category"</option>
                                        <?php while($rowcat=$resultcat->fetch(PDO::FETCH_BOTH)){ ?>
                                        <option value="<?php echo $rowcat['cat_id']; ?>">
                                        <?php echo $rowcat['cat_name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="col-md-3" style="text-align:right">
                            Sub Category:
                            </div>
                            <div class="col-md-8">
                            <span id="showsubcategory">
                            <select id="sc_id" name="sc_id" class="form-control" >
                                <option value="">"Select a Sub Category"</option>                                  
                            </select>
                            </span>    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="row container-fluid" style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <div id="display">
                        <table class="ui celled table" id="example">
                            <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th>Item Id</th>
                                <th>Item Name</th>
                                <th>Category</th>                                
                                <th>Sub Category</th>                                
                                <th>&nbsp;</th>
                              
                                 
                            </tr>   
                            </thead>
                            <tbody>
                            <?php while($row=$result->fetch(PDO::FETCH_BOTH)){ 
                               $arr=array("rating","stock","cart","feedback") ;
                               $item_id=$row['item_id'];
                               $count=0;
                               foreach ($arr as $v){
                                   $count+= checkDelete($v,"item_id", $item_id);
                               }
                                   
                                
                                $resultimage=$obitem->viewItemImage($item_id);
                                $noi=$resultimage->rowCount();
                                if($noi){
                                    $rowall=$resultimage->fetchAll();
                                    foreach($rowall as $k=>$v){
                                    $im=$v['ii_name'];
                                    }
                                    $path='../images/item_images/'.$im;
                                    
                                }else{
                                    
                                    $path="../images/Product.png";
                                }
                                $cat_id=$row['cat_id']; 
                                $sc_id=$row['sc_id'];                                
                                $resultacat=$obcat->displayCategory($cat_id);
                                $resultsc=$obsc->displaySC($sc_id);
                                $rowacat=$resultacat->fetch(PDO::FETCH_BOTH);
                                $rowsc=$resultsc->fetch(PDO::FETCH_BOTH)
                                ?>
                            <tr>
                                <td><img src="<?php echo $path; ?>" height="20" /></td>
                                <td><?php echo $row['item_id']; ?></td>                               
                                <td><?php echo $row['item_name'];?></td>
                                <td>
                                    <?php echo $rowacat['cat_name']; ?>
                                </td>
                                <td>
                                    <?php echo $rowsc['sc_name']; ?>
                                </td>
                                
                               
                                <td>
                                    <a href="../view/addproductiondetails.php?item_id=<?php echo $row['item_id']; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-primary">Add
                                    </button>
                                    </a>
      
                                </td>
                                
                                
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        </div>
                         
                        
                        
                    </div>
                </div>                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script>
        function displayItem(cat_id,sc_id) {
            //alert(cat_id+" "+sc_id);
        
 var xhttp; 
  if (cat_id== "" && sc_id== "") {
    document.getElementById("display").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
     // document.getElementById("showFun").innerHTML = '<img src="../images/loading.gif" alt="Please Wait" />';
    if (this.readyState == 4 && this.status == 200) {
    document.getElementById("display").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../ajax/getItemp.php?q1="+cat_id+"&q2="+sc_id, true);
  xhttp.send();
}
    
    function confirmation(str,str1){
        var r =confirm("DO you want to "+str+" "+str1+"?");// To confirm the AC or DAC
        if(!r){
            return false;
        }
    }
    </script>
</html>