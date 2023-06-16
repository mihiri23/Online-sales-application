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


$year=date("Y");
$arr1=array();
for($i=1;$i<=12;$i++){    
    $m=$year."-".sprintf("%02d",$i);
   $r=$oborder->getpayByMonth($m);
    $c=$r->rowCount();
    array_push($arr1, $c);    
}
$arr2=array("January","February","March","April","May","June","July","Augest","September","Octomer","November","Decembe");


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
  
    <script type="text/javascript" src="../fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="../fusioncharts/js/themes/fusioncharts.theme.zune.js"></script>
<script type="text/javascript" src="../fusioncharts/js/themes/fusioncharts.theme.carbon.js"></script>
<script type="text/javascript" src="../fusioncharts/js/themes/fusioncharts.theme.ocean.js"></script>
<script type="text/javascript" src="../fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
    
<script>
    FusionCharts.ready(function () {
    var revenueChart = new FusionCharts(
            {
        type: 'column2d',
        renderAt: 'chart1',
        width: '100%',
        height: '350',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Current Year order details",
                "subCaption": "Learner's Progress",
                "xAxisName": "Tests",
                "yAxisName": "Energy Points",
            
                "paletteColors": "#0075c2",
                "bgColor": "#ffffff",
                "borderAlpha": "20",
                "canvasBorderAlpha": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "placevaluesInside": "1",
                "rotatevalues": "1",
                "valueFontColor": "#ffffff",                
                "showXAxisLine": "1",
                "xAxisLineColor": "#999999",
                "divlineColor": "#999999",               
                "divLineIsDashed": "1",
                "showAlternateHGridColor": "0",
                "subcaptionFontBold": "0",
                "subcaptionFontSize": "14"
            },            
            "data": [    
                <?php foreach($arr1 as $k=>$v){ ?>
                {
                    "label": "<?php echo $arr2[$k]; ?>",
                    "value": "<?php echo $v; ?>"                    
                },
                <?php } ?>
            ],
            "trendlines": [
                {
                    "line": [
                        {
                            "startvalue": "4",
                            "color": "#1aaf5d",
                            "valueOnRight": "0",
                            "thickness":"2",
                            "displayvalue": "Start"
                        },
                        {
                    "startValue": "2",
                    "parentYAxis": "s",
                     "valueOnRight": "1",
                    "color": "#f2c500",
                     "thickness":"2",
                    "displayvalue": "Average"
                }
                    ]
                    
                }
            ]
            
        }
    }).render();
});
    
    
    
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
                            <li><a href=""> Current Year Order Details by Month</a></li>
                        </ol>
                        
                       
                        
                    </div>
                    
                </div>
                
            </div>
           
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                  <?php include '../common/modules.php'; ?>
                    <div class="col-md-9 col-sm-8">
                        <h3> Current Year Order Details by Month</h3>
                    
                        <div id="chart1">
                            
                            Here
                        </div>
                        
                        
                            
                   </div>
                         
                            
                            
                        </div>
                        
                    
                    
                    </div>
                    
                </div>
                
                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
</html>
