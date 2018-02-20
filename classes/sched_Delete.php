<?php
#sched_Delete.php
 include('dbconnect.php');

$userno = $_POST['user_no'];
$roleno = $_POST['role_no'];
$week = date("Y-m-d",strtotime("next Monday"));


$sql = "DELETE FROM schedule where user_no='$userno' and role_no='$roleno' and week='$week';";

 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Deleted';  
 }  
 ?>  
