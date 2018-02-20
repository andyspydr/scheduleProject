<?php 

$dbconn = pg_connect("host=localhost dbname=scheduledb user=postgres password=gititdone")
     or die('Could not connect: ' . pg_last_error());

?>
