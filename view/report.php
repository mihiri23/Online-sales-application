<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/usermodel.php';
include '../model/logmodel.php';

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
                            <li class="active">Reports</li>
                        </ol>
                        
                       
                        
                    </div>
                    
                </div>
                
            </div>
           
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                  <?php include '../common/modules.php'; ?>
                    <div class="col-md-9 col-sm-8">
                        <h3 style="padding-left: 300px">Reports</h3>
                    <div class="clearfix">&nbsp;</div>
                        <div class="container-fluid">
                            
                            <div class="row">
                                <div class="col-lg-6 col-md-offset-2 " style="background:  linear-gradient(lightgray,#ffffff)">
                               <div class="clearfix">&nbsp;</div>
                                    <h4><p> <a href="orderdaterange.php" style="color: brown">
                                                Online Order Details Report by Date Range
                                                            </a></p></h4>
                                                 <div class="clearfix">&nbsp;</div>
                                                <h4><p><a href="orderindaterange.php" style="color: #794b02">
                                                Internal Order Details Report by Date Range
                                                        </a></p></h4>
                                                 <div class="clearfix">&nbsp;</div>
                                                 <h4><p><a href="ordermonth.php" style="color: #4f20b5">
                                                Current Year Online Order Details by Month
                                                         </a></p></h4>
                                                 <div class="clearfix">&nbsp;</div>
                                                  <h4><p><a href="orderinmonth.php" style="color: #9FAFD1">
                                                Current Year Internal Order Details by Month
                                                         </a></p></h4>
                                                 <div class="clearfix">&nbsp;</div>
                                                 <h4><p><a href="orderweek.php">
                                                Order Details Report for Current Month & Week
                                                         </a></p></h4>
                                        
                                   
                                    
                                    
                                    
                                </div>
                                
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
