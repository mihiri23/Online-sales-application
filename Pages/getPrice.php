<?php
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/stockmodel.php';
$obstock=new stock();
$item_id=$_GET['item_id'];
$color_id=$_GET['color'];
$size_id=$_GET['size'];
$quantity=$_GET['quantity'];
$resultp=$obstock->viewStockPrice($item_id, $color_id, $size_id);
$rowp=$resultp->fetch(PDO::FETCH_BOTH);
if($quantity!=""){
echo $Tot=$rowp['stock_price']*$quantity;
}
?>
<INPUT type="hidden" value="<?php echo $Tot; ?>" name="cart_price" />