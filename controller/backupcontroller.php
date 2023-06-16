<?php
include '../common/sessionhandling.php';
include '../common/dbconnection.php';
include '../model/backupmodel.php';

$obb=new backup();
ECHO $user_id=$userInfo['user_id'];

//Database connection
//require_once("../common/dbconnection_inc.php");

// MySQL host
$mysql_host = "localhost";
// MySQL username
$mysql_username = "root";
// MySQL password
$mysql_password = "";
// Database name
$mysql_database = "desha";

/* backup the db OR just a table */
function backup_tables($host,$user,$pass,$name,$tables = '*')
{
  global $user_id;
  $link = mysqli_connect($host,$user,$pass,$name);
  //mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysqli_query($link,'SHOW TABLES');
    while($row = mysqli_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  
  //cycle through
  foreach($tables as $table)
  {
    $result = mysqli_query($link,'SELECT * FROM '.$table);
    $num_fields = mysqli_num_fields($result);
    
    //$return.= 'DROP TABLE '.$table.';';
    $row2 = mysqli_fetch_row(mysqli_query($link,'SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysqli_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          //$row[$j] = preg_match("/\n/","/\\n/",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
	
  }
  
  $tid=time();
  
  //save file
  $path="../store/";
  $handle = fopen($path.$tid.'.sql','w+');
  fwrite($handle,$return);
  fclose($handle);
  $p=$_SESSION['path']=$path."/".$tid.'.sql';
  $_SESSION['path1']=$tid;

  $sql="INSERT INTO backup VALUES('',NOW(),'$user_id','','$tid','$path')";
  $link->query($sql);
}
$a=backup_tables($mysql_host,$mysql_username,$mysql_password,$mysql_database);

//http://www.latestcode.net/2013/03/create-compressed-zip-file-in-php.html
$zip = new ZipArchive();
$archive_name = "../store/".$_SESSION['path1'].".zip";//name of the output zip file
$file_to_compress = $_SESSION['path'];//this is the file that you need to compress

if ($zip->open($archive_name, ZIPARCHIVE::CREATE)!==TRUE) {
exit("Error while opening $archive_name");
}else{ 
if(file_exists($file_to_compress) && is_file($file_to_compress)){
$zip->addFile($file_to_compress,$_SESSION['path1'].".sql");
$zip->close();
echo 'File size = '.number_format((filesize($archive_name)/1024),2).' Kb';
}else{
exit("File does not exists");
}
}
$msg= base64_encode("Successfully store a backup...");
 
 
  require_once '../../Website/php_mailer/PHPMailer/PHPMailerAutoload.php';
    
   $html="Backup";
    
    
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth=true;

    $mail->Host = 'smtp.gmail.com';
    $mail->Username='deshapriyatradecenter@gmail.com';
    $mail->Password='desha321';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;

    $mail->From="abc@pro.com";

    $mail->FromName='Backup';
    $mail->addAddress("katgamage7@gmail.com", "Admin");
    //$mail->AddCC("gihan798114@gmail.com");
    $mail->addAttachment($archive_name);
    //$mail->addAttachment('Ceylon_Government_Railways_logo.jpg');
    $mail->isHTML(true);
    //$mail->AddEmbeddedImage('../../images/Ceylon_Government_Railways_logo.gif', 'logoimg', 'logo.gif'); 
    //$mail->AddEmbeddedImage('../../images/sintameng2.PNG', 'logoimg1', 'sintameng2.PNG'); 
    //$mail->AddEmbeddedImage('../../images/Government_of_Sri_Lanka.png', 'logoimg2', 'logo.gif'); 
    $mail->Subject='Back up';


    $mail->Body= $html;
    $mail->AltBody = $html;

    if($mail->send()){
            $m="Yes";
 //$sqlno1="INSERT INTO notification (no_dt,no_type,no_cat,no_status,ref_id) VALUES(now(),'Email','reservation','Unseen','$res_id')";
 //$resultno1=$con->query($sqlno1);          

    }else{
            $m=$mail->ErrorInfo;
    }
    
  // echo $m; 
 
header("Location:../view/backup.php?msg=$msg");



?>