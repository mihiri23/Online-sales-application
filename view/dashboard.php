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

$user_id=$userInfo['user_id'];

$obuser=new user();
$resultuser=$obuser->viewAUser($user_id);
$rowuser=$resultuser->fetch(PDO::FETCH_BOTH);

include '../model/districtmodel.php';
$dis_id=$rowuser['dis_id'];
$obdis=new district();
$resultdis=$obdis->displayDistrict($dis_id);
$rowdis=$resultdis->fetch(PDO::FETCH_BOTH);
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
            <div style="padding-top: 2px" id="heading">
                <?php include '../common/header.php'; ?>
                
            </div>
                
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />
                        
                            <?php echo $userInfo['role_name']; ?>
                        
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li class="active">Dashboard</li>
                        </ol>
                        
                       
                        
                    </div>
                    
                </div>
                
            </div>
           
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    <h3 style="color: lightseagreen; font-weight: bold; text-align: center">Dashboard</h3><div class="clearfix">&nbsp;</div>
                  <?php include '../common/modules.php'; ?>
                    <div class="col-md-9 col-sm-8" style="background:linear-gradient(#ffffff,lightskyblue,#ffffff)">
                      <div class="col-md-6 col-md-offset-3">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-1">
                                <?php 
                               
                                if($rowuser['user_image']==""){
                                    $user_image="../images/user.png";
                                }else{
                                $user_image="../images/user_images/".$rowuser['user_image']; 
                                }
                                ?>
                                <img src="<?php echo $user_image; ?>" width="200"
                                     style="border-radius: 250px"/>
                            </div>
                            <div class="col-md-6">
                                &nbsp;
                                
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">First Name</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['user_fname']; ?>
                            </div>
                        </div>
                        <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">Last Name</p></div>
                            <div class="col-md-6 " style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['user_lname']; ?>
                            </div>
                        </div>
                      
                         
                       
                         
                           <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">Email</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['user_email']; ?>
                            </div>
                        </div>
                             <div class="clearfix">&nbsp;</div>
                         <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">Tel No</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['user_tel']; ?>
                            </div>
                        </div>
                               
                          <div class="clearfix">&nbsp;</div>
                         
                         <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">Address</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['user_add']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                        <div class="row">
                            <div class="col-md-6"><p style="color: brown; font-size: 20px">District</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowdis['dis_name']; ?>
                            </div>
                        </div>
                         <div class="clearfix">&nbsp;</div>
                        <div class="row">
                             <div class="col-md-6"><p style="color: brown; font-size: 20px">User Role</p></div>
                            <div class="col-md-6" style="color: #000;  font-size: 20px">
                                <?php echo $rowuser['role_name']; ?>
                            </div>
                        </div>
                     
                          <div class="clearfix">&nbsp;</div>
                    </div>   
                       
                    </div>
                    
                </div>
                
                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
</html>
