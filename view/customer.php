 <?php
 $m_id=2;
 
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/customerinmodel.php';  //user queries
include '../common/functions.php';

$role_id=$userInfo['role_id'];

$countm= checkModuleRole($m_id, $role_id);

if ($countm==0){ // check user priviledges
   $msg= base64_encode("You dont have permission to access.") ;
   header("Location:../view/login.php?msg=$msg");
   
}

$obcus = new customerin(); //to create an object
$resultn= $obcus->viewAllCustomer();

$nor=$resultn->rowCount();
$nop= ceil($nor/5);

if (!isset($_GET['page']) || $_GET['page']==1 ){
    $start=0;
    $page=1;
}else{
    $page=$_GET['page'];
    $start=$page*5-5;  
}

$limit=5;
$result=$obcus->viewCustomerLimited($start, $limit);
$uni_id = time()."_".date();
?>


<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="../css/style.css" type="text/css"/>
    </head>
    <body>
        <div id="main">
            <div style="padding-top: px" id="heading">
                <?php include '../common/header.php'; ?>

            </div>
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">            
                <div class="row" style="padding-top:  px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />

                        <?php echo $userInfo['role_name']; ?>

                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li><a href="../view/order.php">Home Page</a></li>
                            <li class="active">Internal Customers</li>
                        </ol>

                    </div>
                </div>
            </div>
            
            
            <div id="contents">
                
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3  style="padding-top: 5px" class="alig"><b>Internal Customers</b></h3>
                    </div>
                </div>
                <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
                <div class="clearfix">&nbsp;</div>
                <div class="container-fluid" style="padding-left: 30px" style="padding-right: 30px">
                <div class="row container">
                    <div class="col-md-6">
                        <p> 
                            <a href="../view/addcustomer.php">
                            <button type="button" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i>
                                Add New Customer
                            </button>
                            </a>
                        </p>
                    </div>
                    
                     <div class="col-md-offset-1 col-md-5">
                      <p style="float: right">
                      <form action="searchcustomer.php" method="post">
                          <i class="glyphicon glyphicon-search"></i>
                          &nbsp;
                          <input type="text" name="search" id="search" placeholder="Enter a keyword" class="input-sm" size="40"/>
                          
                      <button type="submit" class="btn btn-primary">
                          <li class="glyphicon glyphicon-search"></li>
                          Search
                      </button>
                      </form>   
                      </p>
                  </div>
                </div>
                 <div class="container-fluid" style="padding-left: 30px" style="padding-right: 30px">
                <div style="text-align: center" >
                    <?php
                    if (isset($_GET['msg'])){
                        echo base64_decode($_GET['msg']);
                    }
                    ?>
                </div>   
                </div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                 <div class="row container-fluid" style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <table class="table table-responsive table-hover table-striped">
                            <tr>
                               
                                <th>Cus ID</th>
                                <th>Customer Name</th>
                                <th>City</th>
                                <th>Address</th>
                                <th>Telephone No</th>
                                <th>&nbsp;</th>
                            </tr>
                            
                            <?php while ($row=$result->fetch(PDO::FETCH_BOTH)){ 
                                
                                
                                
                                if ($row['user_status']=="Active"){
                                    $status=1; //active
                                    $sname="Deactive"; //Label
                                    $style="danger"; //Button style
                                }else{
                                    $status=0; //deactive
                                    $sname="Active";
                                    $style="success";
                                }
                                
                                ?>
                            <tr>
                                
                                <td><?php echo $row['cus_id']; ?></td>
                                <td><?php echo $row['cus_name']; ?></td>
                                <td><?php echo $row['cus_city']; ?></td>
                                <td><?php echo $row['cus_add']; ?></td>
                                <td><?php echo $row['cus_tel']; ?></td>
                                <td>
                                    <a href="../view/viewcustomer.php?cus_id=<?php echo $row['cus_id']; ?>">
                                        <button type="button" class="btn btn-sm btn-primary"> View </button></a>
                                        
                                        
                                    <a href="../view/addorder.php?cus_id=<?php echo $row['cus_id']; ?>&uni_id=<?php echo $uni_id; ?>">
                                        <button type="button" class="btn btn-sm btn-success"> Add Order </button></a>
                                        
                                                                     
                                </td> 
                            </tr>
                            <?php } ?>
                            
                            
                     </table>
                        <center>
                        <nav class="container">
                            <ul class="pagination pagination-sm">
                                <?php 
                                for($i=1;$i<=$nop;$i++){
                                ?>
                                <li><a href="../view/customer.php?page=<?php echo $i; ?>"> <?php echo $i; ?></a></li>
                                <?php } ?>                                
                            </ul>                            
                        </nav>
                        </center>
                 </div>
                
        </div>
                </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            </div> 
        </div>
    </body>
    <script>
      
      function confirmation(str){
          var r= confirm("Do you want to "+ str + " user?");  
          if (!r) {
              return false;
          }
    

      }
      
    </script>

</html>
