<?php  
#mgrTORedit.php
 
 include('dbconnect.php');

 $id = $_POST["id"];
 $text = $_POST["text"];  
 $column_name = $_POST["column_name"];  
 $sql = "UPDATE time_off_requests SET ".$column_name."='".$text."' WHERE request_no='".$id."'";  
 if(pg_query($dbconn, $sql))  
 {  
      echo 'Data Updated';  
 }  
 ?>  
