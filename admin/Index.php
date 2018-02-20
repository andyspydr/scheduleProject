<?php
#Index.php(Manager)
include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();
# $dt_min = new DateTime("next monday");

?>
<!DOCTYPE html>

<html>
 <head>
   <title>Index page</title>
   <?php include('../templates/formatting.php'); ?>
 </head>

 <body>
  <?php include('../templates/header.php'); ?>
  <h1>Index</h1>
  <?php include '../templates/navbarMgr.php'; ?>
  <br/>
  <div>
    <button id="print_btn" type="button" style="float:right" class="btn btn-info">Export to Excel</button>
  </div>
          <div class="container">  
                <br />  
                <table id="t2excel" class="table">  
                     <div id="live_data"></div>                 
                </table>  
           </div> 
 </body>
</html>
<script>  
 $(document).ready(function(){  

      function fetch_data()  
      { 
           $.ajax({  
                url:"../classes/sched_Display.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      } 
      fetch_data();  

  $("#print_btn").click(function(){
   $("#live_data").table2excel({
  	    // exclude CSS class
  	    exclude: ".noExl",
  	    name: "Schedule",
  	    filename: "Schedule" //do not include extension
  	  })
  //print();
  
  });

});

</script>
