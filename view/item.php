<?php
date_default_timezone_set("Asia/Colombo");
$m_id = 1;
include '../common/sessionhandling.php';
$role_id = $userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/itemmodel.php';
include '../model/categorymodel.php';
include '../model/scmodel.php';
include '../common/functions.php';
$countm = checkModuleRole($m_id, $role_id);

if ($countm == 0) {  //To check user previleges
    $msg = base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");
}
$obitem = new item();
$result = $obitem->viewAllItem();

$obcat = new category();
$resultcat = $obcat->displayAllCategory();

$obsc = new subCategory()
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
        <script src="../JQuery/jquery-3.2.1.min.js"></script>
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
                    "sScrollX": "105% ",
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '12%'},
                        {sWidth: '12%'},
                        {sWidth: '12%'},
                        {sWidth: '22%'},
                        {sWidth: '11%'},
                        {sWidth: '11%'},
                        {sWidth: '18%'}]
                });

                table.buttons().container()
                        .appendTo($('div.twelve.column:eq(0)', table.table().container()));
            });
        </script>

    </head>
    <body>
        <div id="main">
            <div style="padding-top: 15px" id="heading">
                <?php include '../common/header.php'; ?>

            </div>
            <div id="navi" style="background: linear-gradient(darkgray,#ffffff);">            
                <div class="row" style="padding-top: 5 px">
                    <div class="col-md-4 col-sm-6 paddinga" >
                        <img src="<?php echo $iname; ?>" class="style1" />

                        <?php echo $userInfo['role_name']; ?>

                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li class="active">View All Items</li>
                        </ol>

                    </div>
                </div>
            </div>
            <?php include '../common/itemtab.php'; ?>
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    <div   class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h2  style="padding-top: 15px" class="alig">All Items</h2>
                    </div>
                </div>
                <div class="row" style="height:1px; background:linear-gradient(#ffffff);" ></div>
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
                <div class="row container-fluid" style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <table class="ui celled table" id="example">
                            <thead>
                                <tr>

                                    <th>Item Id</th>
                                    <th>Item Name</th>                              
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Item Images</th>
                                   <!-- <th>Item Height</th>
                                    <th>Item Weight</th>
                                    <th>Item Length</th>
                                    <th>Base Area</th>  -->                              
                                    <th>Item Price-Large</th>
                                    <th>Item Price-Medium</th>
                                    <th>Item Price-Small</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>


                                </tr>   
                            </thead>
                            <tbody>
                                <?php
                                while ($row = $result->fetch(PDO::FETCH_BOTH)) {

                                    $arr = array("rating", "stock", "cart", "feedback");
                                    $item_id = $row['item_id'];
                                    $count = 0;
                                    foreach ($arr as $v) {
                                        $count += checkDelete($v, "item_id", $item_id);
                                    }
                                    $resultimage = $obitem->viewItemImage($item_id);
                                    $noi = $resultimage->rowCount();
                                    if ($noi) {
                                        $all = array();
                                        while ($rowall = $resultimage->fetch(PDO::FETCH_BOTH)) {
                                            //echo $rowall['ii_name'];
                                            array_push($all, $rowall['ii_name']);
                                        }
                                        //var_dump($all);                                    
                                    } else {

                                        $path = "../images/order.png";
                                    }

                                    $cat_id = $row['cat_id'];// To get category id
                                    $sc_id = $row['sc_id'];// To get subcategory id
                                    // To call displayCategory method
                                    $resultacat = $obcat->displayCategory($cat_id);
                                    $resultsc = $obsc->displaySC($sc_id);// To call displaySubCategory method
                                    $rowacat = $resultacat->fetch(PDO::FETCH_BOTH);//To display categories
                                    $rowsc = $resultsc->fetch(PDO::FETCH_BOTH)//To display sub categories
                                            
                                    ?>
                                    <tr >
                                        <td><?php echo $row['item_id']; //To display item id?></td>                               
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td><?php echo $rowacat['cat_name']; ?></td>
                                        <td><?php echo $rowsc['sc_name']; ?></td>
                                        <td>
                                            <?php
                                            foreach ($all as $v) {
                                                $im = $v;//To get first image from all the images

                                                $path = '../images/item_images/' . $im;
                                                ?>
                                                <img src="<?php echo $path; ?>" height="60" />

                                            <?php } ?>
                                        </td>
                                        <td> <?php echo $row['item_price'];//To display item price ?></td>
                                        <td><?php echo $row['item_price_m']; ?></td>                               
                                        <td><?php echo $row['item_price_s']; ?></td>
                                        <td><div style="font-size: 14px;text-align: center; background: linear-gradient(#ffffff,darkgray);padding-top: 5px;"><a href="../view/viewitem.php?item_id=<?php echo $row['item_id']; ?>"><p>view full details</p></a>

                                            </div></td>
                                        <td>

                                            <a href="../view/updateitem.php?item_id=<?php echo $row['item_id']; ?>">
                                                <button type="button" 
                                                        class="btn btn-sm btn-success">Update
                                                </button>
                                            </a>
                                            <?php if ($count == 0) { ?>
                                                <a href="../controller/itemcontroller.php?item_id=<?php echo $row['item_id']; ?>&action=delete">
                                                    <button type="button" 
                                                            class="btn btn-danger btn-sm" onclick="return confirmation('Delete', 'A Stock')">
                                                        Delete
                                                    </button>
                                                </a> 
                                            <?php } ?>   
                                        </td>


                                    </tr>
                                     <?php } ?>
                               
                            </tbody>
                        </table>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
    <script>
        function confirmation(str, str1) {
            var r = confirm("DO you want to " + str + " " + str1 + "?");// To confirm the AC or DAC
            if (!r) {
                return false;
            }
        }
    </script>
</html>