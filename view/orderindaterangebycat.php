<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/usermodel.php';
include '../model/logmodel.php';
include '../model/ordermodel.php';

$oborder=new order();
$oblog=new log();

$obuser=new user();
$ru=$obuser->viewAllUser();
$nou=$ru->rowCount();

$rau=$obuser->viewUserByStatus("Active");
$noau=$rau->rowCount();

$rdu=$obuser->viewUserByStatus("Deactive");
$nodu=$rdu->rowCount();
$cdate=date("Y-m-d");
$fdate=date('Y-m-d', strtotime($cdate. ' - 7 days'));


        $resultorder=$oborder->getOrderDetailsByDatesin(1);
       $nor=$resultorder->rowCount();
       
        $resultordera=$oborder->getOrderDetailsByDatesin(2);
       $nora=$resultordera->rowCount();
       
        $resultorderb=$oborder->getOrderDetailsByDatesin(3);
       $norb=$resultorderb->rowCount();
       
        $resultorderc=$oborder->getOrderDetailsByDatesin(4);
       $norc=$resultorderc->rowCount();
       
        $resultorderd=$oborder->getOrderDetailsByDatesin(5);
       $nord=$resultorderd->rowCount();
       
        $resultordere=$oborder->getOrderDetailsByDatesin(6);
       $nore=$resultordere->rowCount();
       
       
       
       
    


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
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        
        google.charts.load('current', {'packages':['line', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      //var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div');

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', "Number of Logins");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
          
          <?php for($i=0;$i<=6; $i++){ 
              $date=date('Y-m-d', strtotime($cdate. " - $i days"));
              
              $r=$oblog->countlogFrequency($date);
              $n=$r->rowCount();
              
              ?>
                      
        ["<?php echo $date; ?>",  <?php echo $n; ?>],
        
          <?php } ?>
      ]);

      var materialOptions = {
        chart: {
          title: 'Login Frequecy for Current Week'
        },
        width: 900,
        height: 500,
        series: {
          // Gives each series an axis name that matches the Y-axis below.
          0: {axis: 'Temps'},
          1: {axis: 'Daylight'}
        },
        axes: {
          // Adds labels to each axis; they don't have to match the axis names.
          y: {
            Temps: {label: 'Frequeny'},
            Daylight: {label: 'Login'}
          }
        }
      };



      function drawMaterialChart() {
        var materialChart = new google.charts.Line(chartDiv);
        materialChart.draw(data, materialOptions);
            }

     

      drawMaterialChart();

    }
        
        
        function getDateTo(t){
        
        document.getElementById('datet').innerHTML='<input type="date" name="to" class="form-control" min="'+t+'" />';
        }
        
        </script>
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                
            </div>
                
            <div id="navi" style="background: #f5f5f5">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />
                        
                            <?php echo $userInfo['role_name']; ?>
                        
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="dashboard.php">Dashboard</a></li>
                            <li><a href="report.php">Report</a></li>
                            <li><a href="">Internal Order by data range Report</a></li>
                        </ol>
                        
                       
                        
                    </div>
                    
                </div>
                
            </div>
           
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                  <?php include '../common/modules.php'; ?>
                    <div class="col-md-9 col-sm-8"><h3>Internal Order by Data Range Report</h3>
                    
                        <div class="container-fluid">
                            <div class="row">
                                <form action="orderindaterange.php" method="post">
                                <div class="col-md-4">
                                    From :
                                    <input type="date" name="from" 
                                           class="form-control"
                                           onchange="getDateTo(this.value)"
                                           required
                                           /> 
                                </div>
                                <div class="col-md-4">
                                    to :
                                    <span id="datet">
                                    <input type="date" name="to" disabled 
                                           class="form-control" /> 
                                    </span>
                                </div>
                                <div class="col-md-4">
                                  <br />
                                    <input type="submit" name="se" 
                                           value="Search"
                                           class="form-control btn btn-primary" 
                                         /> 
                                </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            
                            <?php if(isset($_POST['se'])) { ?> 
                            <div class="row">
                                <div class="col-md-6"> From : 
                                    <?php echo $_POST['from'] ?> To:
                              <?php echo $_POST['to']; ?>
                                </div>
                                <div class="col-md-6"> No of orders
                              <?php echo $nor; ?>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix">&nbsp;</div>
                            <div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                    </tr>
 <?php   while ($roworder = $resultorder->fetch(PDO::FETCH_BOTH)) {?>                                    
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
                            <div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                    </tr>
 <?php   while ($roworder = $resultorder->fetch(PDO::FETCH_BOTH)) {?>                                    
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
                            <div>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer Name</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                    </tr>
 <?php   while ($roworder = $resultorder->fetch(PDO::FETCH_BOTH)) {?>                                    
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
                        
                        <div class="container-fluid">
                            
                            
                            
                        </div>
                    
                    </div>
                    
                </div>
                
                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
</html>
