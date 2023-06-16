<?php

include '../common/sessionhandling.php';
include '../common/dbconnection.php';

include '../model/pomodel.php';


$obpo=new po();




$action=$_REQUEST['action'];

if($action=='add'){
   
    $item_id=$_REQUEST['item_id'];
    $color_id=$_REQUEST['color_id'];
    $size_id=$_REQUEST['size_id'];
    $rquan=$_REQUEST['rquan'];
    $uni_id =$_REQUEST['uni_id'];
    $cement=$_POST['cement'];
    $sand=$_POST['sand'];
    $bss=$_POST['bss'];
    $pop=$_POST['pop'];
    $limestone=$_POST['limestone'];
    $glue=$_POST['glue'];
    $cementa=$_POST['cementa'];
    $sanda=$_POST['sanda'];
    $bssa=$_POST['bssa'];
    $popa=$_POST['popa'];
    $limestonea=$_POST['limestonea'];
    $gluea=$_POST['gluea'];
    
    
   // $quantity=$_POST['qua'];
   // $totalprice=$_POST['cart_price'];
    
     $rorder=$obpo->checkOrderIn($uni_id);
    $nor=$rorder->rowcount();
     
   
    if($nor==0){
        $po_id=$obpo->addOrderIn("pending",$uni_id);
    }else{    
        $roworder=$rorder->fetch(PDO::FETCH_BOTH);
        $po_id=$roworder['po_id'];
        
    }
    $obpo->addTempCartIn($po_id, $item_id,$color_id, $size_id,$rquan,$cement,$sand,$bss,$pop,$limestone,$glue);
    $obpo->addAvailable($po_id,$cementa,$sanda,$bssa,$popa,$limestonea,$gluea);
    
   
    //echo $order_id;
    
    //To redirect to the cart
    //header("Location:../Pages/viewcart.php?order_id=$order_id");
   
        //$order_id=$oborder->addOrderIn($item_id, $quantity,$color_id, $size_id,"pending",$totalprice,$user_id);
        
        //$obstock->updatestockbalanceSub($item_id, $quan, $color_id, $size_id);
    //echo $order_id;
    
    //To redirect to the cart
   header("Location:../view/addapo.php?po_id=$po_id&item_id=$item_id&color_id=$color_id&size_id=$size_id&uni_id=$uni_id&rquan=$rquan");
    
}


 

if($action=='success'){
   // $sid;   
   // $dis=$_SESSION['dis'];
   // $totp=$_SESSION['totp'];
   // $rowcus=$_SESSION['rowcus'];
    
    
    $uni_id =$_REQUEST['uni_id'];
    $order_id =$_REQUEST['po_id'];
    $resulttot=$obpo->getTotal($order_id);
    $rowtot=$resulttot->fetch(PDO::FETCH_BOTH);
    $totc=$rowtot['totc'];
    $tots=$rowtot['tots'];
    $totb=$rowtot['totb'];
    $totp=$rowtot['totp'];
    $totl=$rowtot['totl'];
    $totg=$rowtot['totg'];
    
    
    $ppo_id=$obpo->addTotalPO($order_id,$totc,$tots,$totb,$totp,$totl,$totg);
    
    $obpo->updateOrderIn("ordered",$order_id);
  
//    $resultso=$oborder->viewCartIn($order_id);
//    while($rowo = $resultso->fetch(PDO::FETCH_BOTH)){
//        $item_id=$rowo['item_id'];
//      $color_id=$rowo['color_id'];
//      $size_id=$rowo['size_id'];
//      $quan= $rowo['qsum'];
//      $cart_price=$rowo['cart_price'];
//       $time_id=$rowo['time_id'];
//       
     $resulttota=$obpo->getTotalAvailable($order_id);
    $rowtota=$resulttota->fetch(PDO::FETCH_BOTH);
    $totca=$rowtota['totc'];
    $totsa=$rowtota['tots'];
    $totba=$rowtota['totb'];
    $totpa=$rowtota['totp'];
    $totla=$rowtota['totl'];
    $totga=$rowtota['totg'];

      $obpo->updatestockbalanceSubc($totca);
      $obpo->updatestockbalanceSubs($totsa);
      $obpo->updatestockbalanceSubb($totba);
      $obpo->updatestockbalanceSubp($totpa);
      $obpo->updatestockbalanceSubl($totla);
      $obpo->updatestockbalanceSubg($totga);
//      $oborder->addTCartIn($order_id, $item_id, $quan, $cart_price, $color_id, $size_id);
//      $oborder->deleteItemsFromTempCartIn($order_id);
//      ,$totba,$totpa,$totla,$totga 
//   }
   header("Location:../view/poinvoice.php?po_id=$order_id&uni_id=$uni_id");
   
   
   
    
    
    
    
    
}