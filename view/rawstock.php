<?php
date_default_timezone_set("Asia/Colombo");
$m_id = 5;
include '../common/sessionhandling.php';
$role_id = $userInfo['role_id'];
include '../common/dbconnection.php';

include '../common/functions.php';
include '../model/rawstockmodel.php';
include '../model/featuremodel.php';
$countm = checkModuleRole($m_id, $role_id);
if ($countm == 0) {  //To check user previleges
    $msg = base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");
}


$obraw = new rawstock();
$result = $obraw->viewallstockbalance();
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

        <link href="../css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">
        <link href="../css/semantic.min.css" rel="stylesheet">
        <link href="../css/dataTables.semanticui.min.css" rel="stylesheet">
        <link href="../css/buttons.semanticui.min.css" rel="stylesheet">



        <script src="../JQuery/jquery-1.12.4.js"></script>
        <script src="../js/jquery.dataTables.min.js"></script>
        <script src="../js/dataTables.bootstrap4.min.js"></script>


        <script src="../js/dataTables.semanticui.min.js"></script>
        <script src="../js/dataTables.buttons.min.js"></script>
        <script src="../js/pdfmake.min.js"></script>
        <script src="../js/vfs_fonts.js"></script>
        <script src="../js/buttons.html5.min.js"></script>    
        <script src="../js/jszip.min.js"></script>
        <script src="../js/buttons.semanticui.min.js"></script>    
        <script src="../js/buttons.colVis.min.js"></script>
        <script src="../js/buttons.print.min.js"></script>

        <script>

            $(document).ready(function () {
                var table = $('#example').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'print', 'csv', 'colvis']
                });

                table.buttons().container()
                        .appendTo($('div.eight.column:eq(0)', table.table().container()));
            });
        </script>



    </head>
    <body>
        <div id="main">
            <div style="padding-top: 15px" id="heading">
                <?php include '../common/header.php'; ?>

            </div>

            <div id="navi" style="background: linear-gradient(darkgrey,#ffffff);">
                <div class="row" style="padding-top: 5px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />

                        <?php echo $userInfo['role_name']; ?>

                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li class="active">Stock</li>
                        </ol>

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    <div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h2 style="padding-top: 15px" class="alig">Raw Material Stock </h2>
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>

                <div class="row container-fluid" style="padding-left: 30px">

                    <div class="row container" style="padding-left: 30px">
                        <div class="col-md-6">
                            <p>
                                <a href="../view/addrawstock.php">
                                    <button type="button" class="btn btn-primary">
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                        Add to the stock
                                    </button>
                                </a>
                            </p>
                        </div>

                    </div>

                    <div class="clearfix">&nbsp;</div>
                    <div class="container-fluid" style="padding-left: 30px" style="padding-right: 30px">
                        <div style="text-align: center" class="alert alert-info">
                            <?php
                            if (isset($_GET['msg'])) {
                                echo base64_decode($_GET['msg']);
                            }
                            ?>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="row container-fluid"  style="padding-left: 30px">
                        <div class="col-md-12 col-sm-6">  <table class="ui celled table" id="example" >
                                <thead>
                                    <tr>

                                        <th>Item ID</th>
                                        <th>Item Name</th>

                                        <th>Received Quantity </th>
                                        <th>Available Quantity </th>
<!--                                        <th>&nbsp; </th>-->

                                    </tr>   
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch(PDO::FETCH_BOTH)) {
                                        $resultitem = $obraw->viewAnItem($row['item_id']);
                                        $rowitem = $resultitem->fetch(PDO::FETCH_BOTH);

                                        $item_id = $row['item_id'];

                                        $resultsq = $obraw->getStockQuantity($item_id, $color_id, $size_id);
                                        $rowsq = $resultsq->fetch(PDO::FETCH_BOTH);
                                        ?>
                                        <tr <?php
                                        if ($row['qua'] < 50) {
                                            echo "class='alert alert-danger'";
                                        }
                                        ?>>
                                            <td><?php echo $row['item_id']; ?></td>
                                            <td><?php echo $rowitem['item_name']; ?></td>


                                            <td><?php echo $rowsq['sq']; ?> </td>
                                            <td><?php echo $row['qua']; ?></td>
<!--                                            <td><a href="../view/stockdetails.php?item_id=<?php //echo $item_id; ?>">Stock Details</a></td>               -->


                                        </tr>
                                    <?php } ?>
                                </tbody> 
                            </table>




                        </div>
                    </div>                
                </div>
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script>

        function confirmation(str, str1) {
            var r = confirm("Do you want to " + str + " " + str1 + "?");
            if (!r) {
                return false;
            }
        }

    </script>


</html>