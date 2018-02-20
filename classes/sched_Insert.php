<?php
#insert.php
 include('dbconnect.php');

$userno = $_POST['user_no'];
$roleno = $_POST['role_no'];
$week = date("Y-m-d",strtotime("next Monday"));

$sql = "INSERT INTO schedule select '$week','$userno','$roleno',default_start_time,default_end_time,default_start_time,default_end_time,default_start_time,default_end_time,default_start_time,default_end_time,default_start_time,default_end_time,default_start_time,default_end_time,default_start_time,default_end_time from roles where role_no='$roleno';";

 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Inserted';  
 }  
 ?>  
