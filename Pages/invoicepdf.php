<?php 

include '../Templates/session.php';
include '../../Apps/common/dbconnection.php';
include '../../Apps/model/categorymodel.php';
include '../../Apps/model/scmodel.php';
include '../../Apps/model/stockmodel.php';
include '../../Apps/model/itemmodel.php';
include '../../Apps/model/featuremodel.php';
include '../../Apps/model/ordermodel.php';
include '../../Apps/model/payment.php';

//$order_id=$_REQUEST['order_id'];
//To display all categories
$obcat=new category();
$rcat=$obcat->displayAllCategory();

$obsc=new subCategory();
$rsc=$obsc->displayFSC();

$obitem=new item();

$oborder=new order();
$obstock=new stock();
$obpay=new payment();


$order_id=$_REQUEST['order_id'];
//To get total price
$resulttot=$oborder->getTotalCartPrice1($order_id);
$rowtot=$resulttot->fetch(PDO::FETCH_BOTH);
$rowcus=$_SESSION['rowcus'];
//print_r($rowcus);


$resultpay=$obpay->viewPayment($order_id);
$rowpay=$resultpay->fetch(PDO::FETCH_BOTH);


if($noc==0){
    $u="signup.php";
    $status=1;
}else{
    $u="checkout.php";
    $status=0;
}



function getDisscout($tot){
    if($tot>=40000){
        return .10;
    }else if($tot>30000){
        return 0.75;
    }else if($tot>20000){
        return 0.05;
    }else{
        return 0;
    }
}



include_once '../../Apps/dompdf/dompdf_config.inc.php';

$html='<h4 style="text-align: center; color: #004085">
    Invoice</h4>';
$html.='<br>
                    <table  border="1" width="100%">
                        <tr>
                            <th width="25%">Invoice No :</th>
                            <td width="25%">'.$rowpay['pay_id'].'</td>
                            <th>Customer Name :</th>
                            <td>'.$rowcus['cus_name'].'</td>
                        </tr>
                         <tr>
                             <th >Date</th>
                             <td>'.$rowpay['pay_date'].'</td>
                           
                            <th>Customer Email :</th>
                            <td>'.$rowcus['cus_email'].'</td>
                        </tr>
                    </table>';
$html.='<table border="1" width="100%">
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                             <th>Color</th>
                              <th>Size</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Price</th>
                                     
                        </tr>';                        
                       $resultcart = $oborder->viewCart1($order_id);
                        while ($rowcart = $resultcart->fetch(PDO::FETCH_BOTH)) {
                            $item_id=$rowcart['item_id'];
                            $resultimage = $obitem->viewItemImage($item_id);
                            $rowimage = $resultimage->fetch(PDO::FETCH_BOTH);
                            $resultitem = $obitem->viewAnItem($item_id);
                            $rowitem = $resultitem->fetch(PDO::FETCH_BOTH);
                            $status = 0;
                            if ($rowimage['ii_name'] != "") {
                                $status = 1;
                                $item_image = $rowimage['ii_name'];
                            }
                            $obf = new feature();
                            $resultfc = $obf->displayAFeature($rowcart['color_id']);
                            $rowfc = $resultfc->fetch(PDO::FETCH_BOTH);
                            $resultfs = $obf->displayAFeature($rowcart['size_id']);
                            $rowfs = $resultfs->fetch(PDO::FETCH_BOTH);
                            $nofc=$resultfc->rowcount();
                            $nofs=$resultfs->rowcount();
$resultp=$obstock->viewStockPrice
        ($item_id, $rowcart['color_id'], $rowcart['size_id']);
        $rowp=$resultp->fetch(PDO::FETCH_BOTH);
                            
                                           
                        $html.='<tr>
                            <td>'.$rowitem['item_name'].'</td>
                            <td>'.$rowitem['cat_name'].'</td>
                            <td>'.$rowitem['sc_name'].'</td>
                            <td>'.$rowfc['f_name'].'</td>
                            <td>'.$rowfs['f_name'].'</td>
                            <td>'.$rowcart['qsum'].'</td>
                            <td>'.$rowp['stock_price'].'</td>
                            <td>'.$rowcart['cpsum'].'</td>             
                           </tr>';
                        }
                        $html.='<tr>
                            <td colspan="7"><b> Price</b></td>
                            <td><b>'.$tot=$rowtot['tot'].'</b></td>
                           
                        </tr>
                        <tr>
                            <td colspan="7"><b>Discount</b></td>
                            <td><b>'.$rowpay['discount'].'</b></td>
                           
                        </tr>
                        <tr>
                            <td colspan="7"><b>Total Price</b></td>
                            <td><b>'.$rowpay['pay_amount'] .'</b></td>
                           
                        </tr>
                    </table>';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("invoice.pdf",
array("Attachment" => false));
exit(0); 
?>

