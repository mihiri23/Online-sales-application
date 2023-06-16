<?php
session_start();
$userInfo=$_SESSION['userInfo']; //To identify unique session ID
$session_id=$userInfo[18];

include '../common/dbconnection.php';
include '../model/logmodel.php';
$oblog=new log();
$log_status="logout";
$oblog->updatelog($log_status, $session_id);


unset( $_SESSION['userInfo']);
header("refresh:5,url=../view/login.php");//Redirection 
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
    </head>
    <body>
        <div id="main">
            <div  id="heading">
               <div class="row">
    <div class="col-md-3 col-sm-6"></div>
    <div class="col-md-6 col-sm-12 heading">Deshapriya Trade Center</div> <!-- Grid Handling -->
    <div class="col-md-3 col-sm-6">
        <p class="heading-right">
            
            <?php echo $userInfo['user_fname']; ?> <?php echo $userInfo['user_lname']; ?> | <a href="../View/logout.php" class="a1 logout">Logout</a>
        </p>
        </div>
</div>

            </div>

            <div style="background: linear-gradient(darkgrey,#ffffff);">
                <div class="row" >
                 

                       

                   
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                          
                        
                        </ol>

                    </div>
                </div>
            </div>
                
            
            <div class="clearfix"></div>
            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
            <div class="clearfix">&nbsp;</div>
            <div id="contents">
                <div class="row">
                  
                    <div class="col-md-12 col-sm-12">
                        <center>
                            <h3 style="color: brown">Successfully Logged out </h3>
                             <div class="clearfix">&nbsp;</div>
                        <img src="../images/loading.gif" /> <br /><br />
                         <div class="clearfix">&nbsp;</div>
                        <a href="../view/login.php">Login</a>
                        </center>
                    </div>
                </div>
                
                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
</html>
