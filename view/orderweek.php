<?php
$m_id = 11;
include '../common/sessionhandling.php';
$role_id = $userInfo['role_id'];
include '../common/dbconnection.php';
include '../Model/usermodel.php';
include '../Model/logmodel.php';
include '../Model/ordermodel.php';
include '../common/functions.php';

$countm = checkModuleRole($m_id, $role_id);
if ($countm == 0) {// to check user privilages
    $msg = base64_encode("You don't have permission to access");
    header("Location:../view/login.php?msg=$msg");
}
$oborder=new order;
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
      data.addColumn('number', "Number of Orders");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        <?php for($i=0;$i<=30; $i++){ 
            $date=date('Y-m-d' , strtotime($cdate. " -$i days"));
            $r=$oborder->OrderFrequency($date);
            $n=$r->rowCount();
        ?>
        ["<?php echo $date; ?>", <?php echo $n; ?>],
                
        <?php } ?>
        ]);

      var materialOptions = {
        chart: {
          title: 'Internal Order Frequency for Current Month',          
        },        
        width: 1000,
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

   

    
        </script>
         <script>
            google.charts.load('current', {'packages':['line', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div1');

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', "Number of Orders");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        <?php for($i=0;$i<=30; $i++){ 
            $date=date('Y-m-d' , strtotime($cdate. " -$i days"));
            $r=$oborder->OnlineOrderFrequency($date);
            $n=$r->rowCount();
        ?>
        ["<?php echo $date; ?>", <?php echo $n; ?>],
                
        <?php } ?>
        ]);

      var materialOptions = {
        chart: {
          title: 'Online Order Frequency for Current Month',          
        },        
        width: 1000,
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

   

    
        </script>
          <script>
            google.charts.load('current', {'packages':['line', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div2');

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', "Number of Orders");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        <?php for($i=0;$i<=6; $i++){ 
            $date=date('Y-m-d' , strtotime($cdate. " -$i days"));
            $r=$oborder->OrderFrequency($date);
            $n=$r->rowCount();
        ?>
        ["<?php echo $date; ?>", <?php echo $n; ?>],
                
        <?php } ?>
        ]);

      var materialOptions = {
        chart: {
          title: 'Internal Order Frequency for Current Week',          
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

   

    
        </script>
           <script>
            google.charts.load('current', {'packages':['line', 'corechart']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var button = document.getElementById('change-chart');
      var chartDiv = document.getElementById('chart_div3');

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Date');
      data.addColumn('number', "Number of Orders");
      //data.addColumn('number', "Average Hours of Daylight");

      data.addRows([
        <?php for($i=0;$i<=6; $i++){ 
            $date=date('Y-m-d' , strtotime($cdate. " -$i days"));
            $r=$oborder->OnlineOrderFrequency($date);
            $n=$r->rowCount();
        ?>
        ["<?php echo $date; ?>", <?php echo $n; ?>],
                
        <?php } ?>
        ]);

      var materialOptions = {
        chart: {
          title: 'Online Order Frequency for Current week',          
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
                        <li ><a href="../view/report.php">Reports</a></li>
                        <li class="active">Reports for current Month & Week</li></div>
                    </ol>                    
                    </div>
                </div>
            </div>
               
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    
                                
                                                  
                        
                        <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>
                      <div class="col-md-offset-2">
                          
                                    <div id="chart_div1"></div>                                
                                    
                           </div> 
                         <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>
                           
                           <div class="col-md-offset-2">
                          
                                    <div id="chart_div"></div>                                
                                    
                           </div> 
                         <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>
                           
                           <div class="col-md-offset-3">
                          
                                    <div id="chart_div3"></div>                                
                                    
                           </div> 
                         <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>
                           
                           <div class="col-md-offset-3">
                          
                                    <div id="chart_div2"></div>                                
                                    
                           </div> 
                     
                    <div class="row" style="height:50px; background:linear-gradient(#dfdfdf,#ffffff);" ></div>                                         
            
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
