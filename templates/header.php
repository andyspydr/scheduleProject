<?php
#header.php

$epoch_time = strtotime('NOW');
$cur_time = date('Y/m/d (h:i A)',$epoch_time);
$fullname = $_SESSION['fullname'];

?>

   <?php include('formatting.php');?>
     <div align="right"> 
       <?php echo "<h4>$cur_time - $fullname - <a href='../classes/Logout.php'>Logout</a> </h4>" ?> 
    </div>

