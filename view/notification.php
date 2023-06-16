 <?php
 date_default_timezone_set("Asia/Colombo");
 $m_id=9;
 
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/usermodel.php';  //user queries
include '../common/functions.php';
include '../model/notificationmodel.php';
include '../model/customermodel.php';

$obuser=new user();
$obcus=new customer();

$role_id=$userInfo['role_id'];

$countm= checkModuleRole($m_id, $role_id);

if ($countm==0){ // check user priviledges
   $msg= base64_encode("You dont have permission to access.") ;
   header("Location:../view/login.php?msg=$msg");
   
}

$obnot = new notification(); //to create an object
$result=$obnot->viewNotification();

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
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf','print','csv','colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
    } );
    
    </script>
    
    
    
    
    </head>
    <body>
        <div id="main">
            <div id="heading">
                <?php include '../common/header.php'; ?>
                <!-- to display name and image beside logout -->
            </div>
            <div id="navi" style="background: #f5f5f5">
                <div class="row">
                    <div class="col-md-4 col-sm-6 paddinga">
                    <img class="style1" src="<?php echo $iname; ?>" />
                    <?php echo $userInfo['role_name']; ?>
                    </div>
                    <div class="col-md-8 col-sm-6" style="text-align: right">
                        <ol class="breadcrumb">
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li class="active">Notification Module</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div id="contents">
                <div class="row">
                    
                  
                    <div class="col-md-12 col-sm-6">
                        <h3 class="alig">Notification Module</h3>
                    </div>
                </div>
                
                       <div class="row container">
                    <div class="col-md-6">
                        <p> 
                            <a href="../view/addnotification.php">
                            <button type="button" class="btn btn-success">
                                <i class="glyphicon glyphicon-plus"></i>
                                Add Notification
                            </button>
                            </a>
                        </p>
                    </div>
                       </div>
                
                <div class="clearfix">&nbsp;</div>
                <div style="text-align: center" class="alert alert-info">
                    <?php
                    if (isset($_GET['msg'])){
                        echo base64_decode($_GET['msg']);
                    }
                    ?>
                    
                </div>
                
                 <div class="clearfix">&nbsp;</div>
                   
                <div class="row container-fluid" style="padding-left: 30px">
                    <div class="col-md-12 col-sm-6">
                        <table class=" ui celled table" id="example">
                            <thead>
                                <tr>
                                 
                                    <th>ID</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Generated By</th>
                                    <th>Status</th>
                                                                     
                               </tr>
                            </thead>
                            <tbody>
                                <?php while ($row=$result->fetch(PDO::FETCH_BOTH)){                              
                                      
                               
                                
                            ?>
                            <tr>
                                 
                                <td><?php echo $row['not_id']; ?></td>
                                <td><?php echo $row['not_msg']; ?></td>
                                <td><?php echo $row['not_date']; ?></td>
                                <td><?php echo $row['not_type']; ?></td>
                                <td><?php 
                                if($row['user_id']==0){
                                    echo "Auto";
                                }else{
                                    echo "Manual";
                                }
                                ?></td>
                                <td><?php 
                                $resultuc=$obnot->viewNoticationUsers($row['not_id']);
                                while ($rowuc=$resultuc->fetch(PDO::FETCH_BOTH)){
                                    if($rowuc['user_id']==0){
                          $rescus=$obcus->viewCustomer($rowuc['cus_id']);
                          $rowcus=$rescus->fetch(PDO::FETCH_BOTH);
                          echo $rowcus['cus_fname'];
                          echo ":".$rowuc['nu_status']."-".$rowuc['nu_error'];
                                        
                                    }else{
                                       $rowuc['user_id'];
                       $resus=$obuser->viewAUser($rowuc['user_id']);
                          $rowus=$resus->fetch(PDO::FETCH_BOTH);
        echo $rowus['user_fname']." ".$rowus['user_lname'];
        echo ",";
                                        
                                    }  
                                    
                                 
                                }
                                
                                ?></td>
                                
                                
                                
                            </tr>
                            <?php } ?>
                            </tbody>                           
                        </table>
                  
                 </div>
                </div>
        </div>
            <div id="footer"> <?php include '../common/footer.php';?> </div>
            
        </div>
    </body>
    
    <script>
      
      function confirmation(str,str1){
          var r= confirm("Do you want to "+str+ " "+str1+"?");  
          if (!r) {
              return false;
          }
    

      }
      
    </script>
    
</html>
