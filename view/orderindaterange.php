<?php

include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/usermodel.php';
include '../model/logmodel.php';
include '../model/ordermodel.php';

$oblog=new log();


$obuser=new user();
$ru=$obuser->viewAllUser(); //result user
$nor=$ru->rowCount();
//echo $nor;

$rau=$obuser->viewUserByStatus("Active"); //result active user
$noau=$rau->rowCount();

$rdu=$obuser->viewUserByStatus("Deactive"); //result deactive user
$nodu=$rdu->rowCount();

//$cdate= date("Y-m-d");
//$fdate= date('Y-m-d', strtotime($cdate.'-7 days'));

$oborder =new order();


if(isset($_POST['se'])){
    if($_POST['from'] != "" && $_POST['to'] != "") {
        $from = $_POST['from'];
        $to = $_POST['to'];
        $resultorder = $oborder->getOrderDetailsByDatesIn($from, $to);
        $nor=$resultorder->rowCount();
    }else if($_POST['from']!="" && $_POST['to']==""){ //select only the date
        $from=$_POST['from'];
        $resultorder = $oborder->getOrderDetailsByDateIn($from);
        $nor=$resultorder->rowCount();
        
    }
    
    
}
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
        <link rel="stylesheet" href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css"/>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        
        
      
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                <!-- to display name and image beside logout -->
            </div>
            <div id="navi" style="background: #f5f5f5">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                    <img class="style1" src="<?php echo $iname; ?>" />
                    <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="report.php">Reports</a></li>
                            <li class="active">Internal Order by Date Range Report</li>
                            
                        </ol>
                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                   <?php include '../common/modules.php'; ?>
                    
                    <div class="col-md-9 col-sm-8"><h3>Internal Order by Date Range Report</h3>
                        <div class="clearfix">&nbsp;</div>
                            <div class="container-fluid">
                                <div class="row">
                                    <form action="orderindaterange.php" method="post">
                                    <div class="col-md-4">
                                        From :
                                        <input type="date" name="from" class="form-control" onchange="getDateTo(this.value)" required />
                                    </div>
                                    
                                    <div class="col-md-4">
                                        To :
                                        <span id="datet">
                                        <input type="date" name="to" class="form-control" />
                                        </span>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <br/>
                                        <input type="submit" name="se" value="search" class="form-control btn btn-success"/>
                                    </div>
                                    </form>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <!--to hide the table-->
                                <?php if(isset($_POST['se'])){ ?>
                                
                                <div class="row">
                                    <div class="col-md-6">From : <?php echo $_POST['from']; ?> To: <?php echo $_POST['to'] ?></div>
                                    <div class="col-md-6">No of Orders : <?php echo $nor ?></div>
                                
                                    <div>
                                    <div class="clearfix">&nbsp;</div>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Customer Name</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                        </tr>
                              <?php while($roworder = $resultorder->fetch(PDO::FETCH_BOTH)) {?>          
                                        <tr>
                                            <td><?php echo $roworder['order_id']; ?></td>
                                            <td><?php echo $roworder['order_date']; ?></td>
                                            <td><?php echo $roworder['cus_name']; ?></td>
                                            <td><?php echo $roworder['order_status']; ?></td>
                                            <td><?php echo $roworder['total_price']; ?></td>
                                            
                                        </tr>
                              <?php } ?>
                                    </table>
                                </div>
                                <?php } ?>
                            </div>
                           
                    </div>
                </div>
            </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
    
    <script>
//        can select a date greater than the from date
        function getDateTo(t){
            document.getElementById('datet').innerHTML='<input type="date" name="to" class="form-control" min="'+t+'"  />';
            
            
        }
    </script>
</html>
