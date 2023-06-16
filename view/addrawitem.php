<?php
$m_id = 4; //the user on module table

include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/rawstockmodel.php';  //user queries
include '../common/functions.php';

$role_id = $userInfo['role_id'];

$countm = checkModuleRole($m_id, $role_id);
if ($countm = 0) { // check user priviledges
    $msg = base64_encode("You dont have permission to access.");
    header("Location:../view/login.php?msg=$msg");
}


//$maxdate=date('Y-m-d', strtotime(' -18 year'));
//$mindate=date('Y-m-d', strtotime(' -60 year'));
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
                            <li><a href="../view/viewallraw.php">View Raw Materials </a></li>
                            <li class="active">Add Item</li>
                        </ol>

                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    <<div class="col-md-12 col-sm-6" style="background: linear-gradient(lightgray,#ffffff)">
                        <h3 class="alig">Add Raw Material Item</h3>
                    </div>
                </div>
                <div class="row" style="height:25px; background:linear-gradient(#ffffff);" ></div> 
                 <div class="clearfix">&nbsp;</div>
                <form  action="../controller/rawstockcontroller.php?action=additem" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="row">
                                <div class="col-md-6"><p>Item Name</p></div>
                                <div class="col-md-6"><input type="text" name="item_name" id="item_name" placeholder="Item Name" class="form-control"/>
                                    
                                </div>
                            </div>

                            <div class="clearfix">&nbsp;</div>

                            <div class="row">
                                <div class="col-md-6"><p>Item Description</p></div>
                                <div class="col-md-6"><input type="text" name="item_des" id="item_des" placeholder="Item Description" class="form-control" />
                                 
                                </div>
                            </div>

                            <div class="clearfix">&nbsp;</div>

                            
                            
                            <div class="clearfix">&nbsp;</div>
                            <div class="clearfix">&nbsp;</div>
                            <div class="row">
                                <div class="col-md-12" style="text-align:center;">
                                    <input type="submit" name="sub" value="Add" class="btn btn-primary"/> 
                                    <input type="reset" name="clear" value="Clear" class="btn btn-primary"/>   
                                </div>

                                <div class="col-md-6">
                                    &nbsp;
                                </div>
                            </div>

                            <div class="clearfix">&nbsp;</div>


                        </div>
                    </div> 
                </form>

            </div>  

        </div>
        <div id="footer"> <?php include '../common/footer.php'; ?> </div>


    </body>

    <script type='text/javascript' src="../plugins/jQuery/jQuery-2.1.4.min.js">
    </script>

    <!-- External JS for validation -->
   
</html>
