<?php
#insert.php
 include('dbconnect.php');

$userno = $_POST['user_no'];

$default = 'abc123';
$default_pass = password_hash($default,PASSWORD_DEFAULT);


$sql = "UPDATE users SET password='$default_pass' where user_no='$userno';";


 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Inserted';  
 }  
 ?>  
