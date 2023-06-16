<?php
$m_id = 7;
include '../common/sessionhandling.php';
$role_id = $userInfo['role_id'];
include '../common/dbconnection.php';
include '../Model/usermodel.php';
include '../Model/logmodel.php';
include '../common/functions.php';

$countm = checkModuleRole($m_id, $role_id);
if ($countm == 0) {// to check user privilages
    $msg = base64_encode("You don't have permission to access");
    header("Location:../view/login.php?msg=$msg");
}

$obuser = new user();
$result = $obuser->ViewNewUsers();

$oblog=new log();
$obuser=new user();
$ru=$obuser->viewAllUser();
$nou=$ru->rowCount();

$ocuser=new user();
$rn=$ocuser->DisplayNewUsers();
$dnu=$rn->rowCount();

$rau=$obuser->viewUserByStatus("Active");
$noau=$rau->rowCount();

$rdu=$obuser->viewUserByStatus("Deactive");
$nodu=$rdu->rowCount();     

$cdate=date("Y-m-d");
$fdate=date('Y-m-d', strtotime($cdate. '- 7 days'));

$ro=$obuser->viewUserRole("1");
$dro=$ro->rowCount();

$ra=$obuser->viewUserRole("2");
$dra=$ra->rowCount();

$rm=$obuser->viewUserRole("3");
$drm=$rm->rowCount();

$rs=$obuser->viewUserRole("4");
$drs=$rs->rowCount();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>DTC</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="../css/style.css" type="text/css" />
        <link rel="stylesheet" href="../plugins/font-awesome-4.7.0/css/font-awesome.min.css" type="text/css" />
        
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>        

        <script>
            google.charts.load('current', {'packages':['line', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div');

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', "Number of Logins");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        <?php for($i=0;$i<=6; $i++){ 
            $date=date('Y-m-d' , strtotime($cdate. " -$i days"));
            $r=$oblog->countlogFrequency($date);
            $n=$r->rowCount();
        ?>
        ["<?php echo $date; ?>", <?php echo $n; ?>],
                
        <?php } ?>
        ]);

      var materialOptions = {
        chart: {
          title: 'Login Frequency for Current Week',          
        },        
        width: 700,
        height: 350,
        series: {
          // Gives each series an axis name that matches the Y-axis below.
          0: {axis: 'Temps'},
          1: {axis: 'Daylight'}
        },
        axes: {
          // Adds labels to each axis; they don't have to match the axis names.
          y: {
            Temps: {label: 'Frequency'},
            Daylight: {label: 'Login'}
          }
        }
      };

      var classicOptions = {
        title: 'Average Temperatures and Daylight in Iceland Throughout the Year',
        width: 900,
        height: 500,
        // Gives each series an axis that matches the vAxes number below.
        series: {
          0: {targetAxisIndex: 0},
          1: {targetAxisIndex: 1}
        },
        vAxes: {
          // Adds titles to each axis.
          0: {title: 'Temps (Celsius)'},
          1: {title: 'Daylight'}
        },
        hAxis: {
          ticks: [new Date(2014, 0), new Date(2014, 1), new Date(2014, 2), new Date(2014, 3),
                  new Date(2014, 4),  new Date(2014, 5), new Date(2014, 6), new Date(2014, 7),
                  new Date(2014, 8), new Date(2014, 9), new Date(2014, 10), new Date(2014, 11)
                 ]
        },
        vAxis: {
          viewWindow: {
            max: 30
          }
        }
      };

      function drawMaterialChart() {
        var materialChart = new google.charts.Line(chartDiv);
        materialChart.draw(data, materialOptions);
        button.innerText = 'Change to Classic';
        button.onclick = drawClassicChart;
      }

      function drawClassicChart() {
        var classicChart = new google.visualization.LineChart(chartDiv);
        classicChart.draw(data, classicOptions);
        button.innerText = 'Change to Material';
        button.onclick = drawMaterialChart;
      }

      drawMaterialChart();

    }
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawPieChart);

    function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
          ['Role', 'Users per Role'],
          ['Owner',     <?php echo $dro;?>],
          ['Admin',     <?php echo $dra;?>],
          ['Manager', <?php echo $drm;?>],
          ['Staff', <?php echo $drs;?>],
        ]);

        var options = {
          title: 'Users according to Roles',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }

    
        </script>
        
        
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php
                include '../common/header.php';
                ?>
            </div>
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                        <img src="<?php echo $iname; ?>" class="style1" />
                        <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                    <ol class="breadcrumb">
                        <li ><a href="../view/dashboard.php">Dashboard</a></li>
                        <li class="active">User Home</li></div>
                    </ol>                    
                    </div>
                </div>
            </div>
                <?php include '../common/usertab.php';?>
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    
                    <div class="col-md-12 col-sm-6">                  
                                                  
                            <div class="row paddingu" >
                                <div class="col-lg-3">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <i class="fa fa-user" style="font-size: 40px"></i>
                                            <h4>User Registration :
                                                <span class="badge"><?php echo $nou;?></span>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            <i class="fa fa-user-circle-o" style="font-size: 40px"></i>
                                            <h4>Number of Active Users :
                                                <span class="badge"><?php echo $noau;?></span>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3">
                                    <div class="panel panel-danger">
                                        <div class="panel-heading">
                                            <i class="fa fa-user-o" style="font-size: 40px"></i>
                                            <h4>Number of Deactive Users :
                                                <span class="badge"><?php echo $nodu;?></span>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-lg-3">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <i class="fa fa-user-o" style="font-size: 40px"></i>
                                            <h4>Recently Registered Users :
                                                <span class="badge"><?php echo $dnu;?></span>
                                            </h4>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                            </div>
                        <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>
                       <div class="row paddingu" >
                            <div class="col-md-5 col-sm-12">                        
                                <!--<div class="container-fluid">-->
                                    <div class="panel panel-success">
                                    <div class="panel-heading">User Roles</div>
                                    <div class="panel-body">
                                    <div id="piechart_3d" style="width: 500px; height: 350px;"></div>                                
                                    </div>
                                    </div>
                                
                            </div>
                           
                           <div class="col-md-7 col-sm-12">                        
                                <!--<div class="container-fluid">-->
                                    <div class="panel panel-info">
                                    <div class="panel-heading">Login Frequency</div>
                                    <div class="panel-body">
                                    <div id="chart_div"></div>                                
                                    </div>
                                    </div>
                                
                            </div>
                       </div>
                    <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>                                         
            <div style="text-align: center">
                <?php
                if (isset($_GET['msg'])) {
                    echo base64_decode($_GET['msg']);
                }
                ?>
            </div>
                <div class="row paddingn" >                               
                    <div class="col-md-12 col-sm-6">
                        <div class="panel panel-info">
                                    <div class="panel-heading">Recently Registered Users</div>
                                    <div class="panel-body"> 
                                        <table class="table table-responsive table-striped" style="width: 1400px; text-align: center"   >
                                            <tr>
                            <th>&nbsp;</th>
                            <th style="text-align: center" >User Id</th>
                            <th style="text-align: center" >User Name</th>                            
                            <th style="text-align: center" >Role</th>
                            <th style="text-align: center" >Gender</th>
                            <th style="text-align: center" >Date of Joined</th>
                            
                        </tr>

                        <?php
                        while ($row = $result->fetch(PDO::FETCH_BOTH)) {
                            if ($row['user_image'] == "") {
                                $uimage = "../images/bt9.png";
                            } else {
                                $uimage = "../images/user_images/" . $row['user_image'];
                            }
                            
                            ?>

                            <tr>                                
                                <td>   <img src="<?php echo $uimage; ?>" class="style1" /> </td>
                                <td><?php echo $row['user_id']; ?></td>
                                <td> <?php echo $row['user_fname'] . " " . $row['user_lname']; ?></td>
                                <td><?php echo $row['role_name']; ?></td>  
                                <td><?php echo $row['user_gender']; ?></td>
                                <td><?php echo $row['user_doj']; ?></td>
                                
                            </tr>
                        <?php } ?>

                    </table>
                    
                </div>
            </div>
                    
                        </div>
                    </div>
                </div>
            </div>
            <div id="footer">
                <?php
                include '../common/footer.php';
                ?>
            </div>
        </div>
    </body>
</html>
