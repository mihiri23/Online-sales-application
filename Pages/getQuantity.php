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
?>
<input type="number" id='qua' name="qua" min="1" class="form-control" 
   <?php if($nor<=0 || $rowstock['qua']==0) echo "disabled"; ?>    
       max="<?php echo $rowstock['qua']; ?>"
 onkeyup='displayPrice(document.getElementById("color_id").value,
             document.getElementById("size_id").value,this.value,
             "<?php echo $item_id; ?>")' />
