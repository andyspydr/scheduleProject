<?php

include("classes/dbconnect.php");
include('classes/Session.php');

 $sess = new Session();
 $sess->checkSession();


#  session_start();
  $user_no = $_SESSION['userno'];

//results for datatable
$procsql = "SELECT from_date,to_date,requested_on,case when approved='t' then 'YES' else 'NO' end as approved FROM time_off_requests where approved is not null and user_no='$user_no';";
$processed = pg_query($dbconn,$procsql);


if (isset($_POST['submit']))
{
  $first_day = strip_tags($_POST["fdo"]);
  $last_day  = strip_tags($_POST["ldo"]);
  $TOsql = "INSERT into time_off_requests values(nextval('request_no_sequence'),'$user_no','$first_day','$last_day',NOW(),null);";

 if ($first_day =="" || $last_day ==""){
   echo "<h3>Missing a date field</h3>";
}
else{
 $res = pg_query($dbconn,$TOsql);
 pg_close($dbconn); 
    }

}

?>

<!DOCTYPE html>
<html>
 <head>
   <title>Time Off Requests</title>
   <?php include('templates/formatting.php');?>

     <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                  $('#myrequests').dataTable()
             })
     </script>
 </head>
 <body> 
   <?php include('templates/header.php'); ?>
   <h1>Time off Requests</h1>
   <?php include_once('/var/www/html/templates/navbarEmp.php'); ?>
   <br/>
   <br/>
   <br/>
   <br/>
   <div>
    <h2>Enter time off requests here:</h2>
   </div>
   <form action="TimeOffRequests.php" method="post">
     <div class="container">
         <div class="row">
            <div class='col-md-4'>
              <div class="form-group"> 
   	         <input type='text' class="form-control" id='datepicker1' name='fdo' placeholder='First Date Out'/>
              </div>
           </div>
        </div>
     </div>
     <div class="container"> 
         <div class="row">
            <div class='col-md-4'>
             
              <div class="form-group">
                    <input type='text' class="form-control" id='datepicker2' name='ldo' placeholder='Last Date Out(Same as above if Single Day)'>
                <br/>
                <div class="form-group">
                  <input type="submit" action="TimeOffRequests.php" name="submit" class="btn btn-def btn-block" value="Submit"> 
              </div>  
           </div>
        </div>
      </div>
     </div>
   </form>

    <script type="text/javascript">
         $(function () {
             $('#datepicker1').datepicker();
             $('#datepicker2').datepicker({
                 useCurrent: false
             });
             $("#datepicker1").on("dp.change", function (e) {
                 $('#datepicker2').data("DatePicker").minDate(e.date);
             });
             $("#datepicker2").on("dp.change", function (e) {
                 $('#datepicker1').data("DatePicker").maxDate(e.date);
             });
         });
     </script>
   <br/>
   <br/>
          
     <div class="container">  
          <br />  
          <br />  
          <br />  
          <div class="table-responsive">  
               <h3 align="center">Pending Requests</h3><br />  
               <div id="live_data"></div>                 
          </div>  
     </div>  
     <br/>
     <br/>
     <h3>Processed Requests</h3>
     <table id="myrequests" class="display" cellspacing="0" width="100%"> 
        <thead>
           <tr>
             <th>First Day Out</th>
             <th>Last Day Out</th>
             <th>Requested on</th>
             <th>Approved?</th> 
           </tr>
        </thead>
        <tbody>
          <?php
          while ($row = pg_fetch_assoc($processed)) {
            ?>
              <tr>
                 <td><?php echo $row['from_date']; ?></td>
                 <td><?php echo $row['to_date']; ?></td>
                 <td><?php echo $row['requested_on']; ?></td>
                 <td><?php echo $row['approved']; ?></td>
             </tr>
            <?php
          }
          ?>
        </tbody>
     </table>
 </body>
</html>
 <script>  
 $(document).ready(function(){  
      function fetch_data()  
      {  
           $.ajax({  
                url:"classes/empTORSelect.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      }  
      fetch_data();  
      $(document).on('click', '.btn_delete', function(){  
           var id=$(this).data("id5");  
           if(confirm("Are you sure you want to delete this?"))  
           {  
                $.ajax({  
                     url:"classes/empTORDelete.php",  
                     method:"POST",  
                     data:{id:id},  
                     dataType:"text",  
                     success:function(data){  
                          alert(data);  
                          fetch_data();  
                     }  
                });  
           }  
      });  
 });  
 </script>  
