<?php
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/stockmodel.php';
$obstock=new stock();
$item_id=$_GET['item_id'];
$color_id=$_GET['color'];
$size_id=$_GET['size'];
$resultstock=$obstock->viewStockQuantity($item_id, $color_id, $size_id);
$nor=$resultstock->rowcount();
$rowstock=$resultstock->fetch(PDO::FETCH_BOTH);
$status="";
$class="";
if($nor<=0 || $rowstock['qua']==0){
   $status="Not Available";
     $class="danger";
}else{
    $status="Available";
     $class="success";
}

?>
<div class="alert alert-<?php echo $class; ?>"><?php echo $status; ?></div>

