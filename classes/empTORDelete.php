 <?php
#empTORDelete.php

 include('dbconnect.php');  
 
 $sql = "DELETE FROM time_off_requests WHERE request_no = '".$_POST["id"]."'";  
 if(pg_query($dbconn, $sql))  
 {  
      echo 'Request Deleted';  
 }  
 ?> 
