<?php
 include('classes/Session.php');
 $sess = new Session();
 $sess->checkSession();
?>

<!DOCTYPE html>
<html>
 <head>
   <title>Index page</title>
   <?php include('templates/formatting.php');?>
 </head>
 <body>
   <?php include '/var/www/html/templates/header.php';?>
   <h1>Index Page</h1>
   <?php include '/var/www/html/templates/navbarEmp.php';?> 
   <br/> 
   <button id="myschedule" type="button" class="btn btn-primary">My Schedule</button>
   <button id="fullschedule" type="button" class="btn btn-info">Full Schedule</button>
   <button id="export_btn" type="button" class="btn btn-info">Export to Excel</button>  
          <div class="container">  
                <br />  
                <div class="table">  
                     <div id="live_data"></div>                 
                </div>  
           </div> 
 </body>
</html>
<script>  
 $(document).ready(function(){  

      function fetch_data()  
      { 
           $.ajax({  
                url:"classes/sched_Display.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      } 
      fetch_data();  
 });
 $("#myschedule").click(function(){

      function fetch_mine()
      {
           $.ajax({      
                url:"classes/sched_Mine.php",
                method:"POST",
                success:function(data){
                     $('#live_data').html(data);
                }
           });
      }
    fetch_mine();
  });
 $("#fullschedule").click(function(){
          
      function fetch_data()  
      { 
           $.ajax({  
                url:"classes/sched_Display.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      } 
      fetch_data();  
 });
 $("#export_btn").click(function(){
   $("#live_data").table2excel({
  	    // exclude CSS class
  	    exclude: ".noExl",
  	    name: "Schedule",
  	    filename: "Schedule" //do not include extension
  	  })
  //print();
  
  });
</script>
