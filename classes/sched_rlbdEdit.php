<?php
#sched_rlbdEdit.php
 include('dbconnect.php');

$roleno = $_POST['role_no'];
$column = $_POST['column_name'];
$text   = $_POST['text'];




$sql = "UPDATE role_limits_by_day SET ".$column."=".$text." WHERE role_no=".$roleno.";";


 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Updated';  
 }  
 ?>  
