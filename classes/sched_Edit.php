<?php
#sched_Edit.php
 include('dbconnect.php');

$userno = $_POST['user_no'];
$roleno = $_POST['role_no'];
$column = $_POST['column_name'];
$text   = $_POST['text'];

$week = date("Y-m-d",strtotime("next Monday"));



$sql = "UPDATE schedule SET ".$column." = (case when '$text'='' then null else '$text' end) WHERE user_no='$userno' and role_no='$roleno' and week='$week';";


 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Updated';  
 }  
 ?>  
