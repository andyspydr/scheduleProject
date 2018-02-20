<?php
#MgrTimeOffRequests.php

include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();

?>

<!DOCTYPE html>

<html>
 <head>
   <meta charset="UTF-8">
   <title>Employee Dashboard</title>
   <?php include('../templates/formatting.php'); ?>
 </head>
  
 <body>
   <?php include('../templates/header.php'); ?>
   <h1>Time off Requests</h1>
   <?php include '../templates/navbarMgr.php'; ?>
     <div class="container">  
          <br />  
          <br />  
          <br />  
          <div class="table-responsive">  
               <h3 align="center">All Requests</h3><br />  
               <div id="live_data"></div>                 
          </div>  
 </body>
</html>
<script>
 $(document).ready(function(){  
      function fetch_data()  
      {  
           $.ajax({  
                url:"../classes/mgrTORSelect.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      }  
      fetch_data();  
      function edit_data(id, text, column_name)  
      {  
           $.ajax({  
                url:"../classes/mgrTORedit.php",  
                method:"POST",  
                data:{id:id, text:text, column_name:column_name},  
                dataType:"text",  
                success:function(data){  
                     alert(data);
                     fetch_data();  
                }  
           });  
      }  
      $(document).on('blur', '.approved', function(){  
           var id = $(this).data("id5");
           var changes = $(this).text();

           if (changes =='Y' || changes =='N' || changes =='P'){
           
               edit_data(id, changes, "approved");
           }
           else{
             alert("Must be Y, N, or P");
             fetch_data();
           }  
      });  
 });  
 </script>  

