<?php
$m_id=7;
include '../common/sessionhandling.php';
$role_id=$userInfo['role_id'];
include '../common/dbconnection.php';
include '../model/usermodel.php';
include '../common/functions.php';
$countm=checkModuleRole($m_id,$role_id);

if($countm==0){  //To check user previleges
    $msg=base64_encode("You dont have permission to access");
    header("Location:../view/login.php?msg=$msg");    
}

$search=$_REQUEST['search'];

$obuser=new user();
//Search users with a keyword
$results=$obuser->viewSearchUser($search);
$nor=$results->rowCount();
$nop=ceil($nor/5);

if(!isset($_GET['page']) || $_GET['page']==1){
    $start=0;   
    $page=1;
}else{
    $page=$_GET['page'];
    $start=$page*5-5;
}
$limit=5;
//Search users with a keyword 5 per page
$result=$obuser->viewSearchUserLimited($search,$start, $limit);


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
                            <li><a href="../view/dashboard.php">Dashboard</a></li>
                            <li><a href="../view/user.php">User Module</a></li>
                            <li class="active">Search User </li>
                        </ol>
                        
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="contents">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                            <h3 class="alig">Search User </h3>
                    </div>
                </div>
                <div class="row container">
                    <div class="col-md-6">
                        <p>
                            <a href="../view/adduser.php">
                        <button type="button" class="btn btn-success">
                            <i class="glyphicon glyphicon-plus-sign"></i>
                            Add User
                        </button>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6" >
                        <p style="float: right">
                        <form action="searchuser.php" method="post">
                            <i class="glyphicon glyphicon-search">
                                
                            </i>
                            &nbsp;
                            <input type="text" name="search" 
                         id="search" placeholder="Enter a keyword"
                         class="input-sm" size="40"/>  
                            <button type="submit" 
                                    class="btn btn-primary">
                            <i class="glyphicon glyphicon-search"></i>
                            Search User
                        </button>
                        </form> 
                        </p>
                    </div>
                </div>
                 <div class="row container">
                    <div class="col-md-6">
                        <p>
                            Keyword : <span class="text-info">
                                <?php echo $search; ?>
                            </span>   
                        </p>
                    </div>
                    <div class="col-md-6" >
                        <p style="float: right">
                        Number of Records: 
                        <span class="text-primary">
                                <?php echo $nor; ?>
                            </span>   
                        </p>
                    </div>
                </div>
                <div style="text-align: center">
                    <?php
                    if(isset($_GET['msg'])){
                        echo base64_decode($_GET['msg']);
                    }
                    
                    ?>
                </div>
                <div class="row container-fluid">
                    <div class="col-md-12 col-sm-6">
                        <?php if($nor!=0){ ?>
                        <table class="table table-responsive table-striped">
                            <tr>
                                <th>&nbsp;</th>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                            </tr>   
                            
                            <?php while($row=$result->fetch(PDO::FETCH_BOTH)){ 
                                if($row['user_image']==""){
                                    $uimage="../images/user.png";    
                                }else{
                                   $uimage="../images/user_images/".$row['user_image'];
                                } 
                                //echo $uimage;
                                 if($row['user_status']=="Active"){
                                     $status=1;
                                     $sname="Deactivate";//Label
                                     $style="danger"; //Button style
                                 }else{
                                     $status=0;
                                     $sname="Activate";
                                     $style="default";
                                 }
                                ?>
                            <tr>
                                <td><img src="<?php echo $uimage; ?>" 
                                         class="style1" /></td>
                                <td><?php echo $row['user_id']; ?></td>
                                <td>
                                    
          <?php 
        $data1= highlightKeyWord($search, $row['user_fname']);
        
          echo $data1." ".highlightKeyWord($search, $row['user_lname']); ?>
                                </td>
                                <td>
                    <?php echo highlightKeyWord($search,$row['user_gender']); ?>
                                </td>
                                <td><?php echo highlightKeyWord($search,$row['role_name']); ?></td>
                                <td><?php echo highlightKeyWord($search,$row['user_status']); ?></td>
                                <td>
       <a href="../view/viewuser.php?user_id=<?php echo $row['user_id']; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-primary">View
                                    </button>
                                    </a>
      <a href="../view/updateuser.php?user_id=<?php echo $row['user_id']; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-success">Update
                                    </button>
                                    </a>
       <a href="../controller/usercontroller.php?user_id=<?php echo $row['user_id']; ?>&status=<?php echo $status; ?>&action=ACDAC&search=<?php echo $search;?>&page=<?php echo $page; ?>">
                                    <button type="button" 
                                            class="btn btn-sm btn-<?php echo $style; ?>">
                                        <?php echo $sname; ?>
                                    </button>
                                    </a>
                                    
                                </td>
                            </tr>
                            <?php } ?>
                            
                        </table>
                        <?php }else{ ?>
                        <div class="clearfix">&nbsp;</div>
                        <p style="text-align: center" class="alert alert-danger">
                            <span>No Records
                            </span></p>
                        <?php } ?>
                        
                         <nav class="container">
                                <ul class="pagination pagination-sm">
                                 <?php
                                 for($i=1;$i<=$nop;$i++){
                                 ?>
                                    <li><a href="../view/searchuser.php?page=<?php echo $i; ?>&search=<?php echo $search; ?>">
                                        <?php echo $i; ?></a></li>
                                 <?php } ?>
                                </ul>
                            </nav>
                        
                        
                    </div>
                </div>                
            </div>
            <div id="footer"><?PHP include '../common/footer.php'; ?></div>
        </div>
    </body>
</html>