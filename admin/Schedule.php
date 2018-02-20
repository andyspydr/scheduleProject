<?php
#Schedule.php
 include('../classes/schedule_class.php');
 include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();

 $sched = new Schedule(); 
 $defaults = $sched->getroleDefaults();
 $dt_min = new DateTime("next monday");

if (isset($_POST['clearbtn'])){
     $sched->clearSchedule(); 
}
if (isset($_POST['publishbtn'])){
     $sched->publishSchedule();
}
if (isset($_POST['autoschedbtn'])){
     $sched->autoSchedule();
}
?>


<!DOCTYPE html>
<html>
 <head>
   <title>Schedule Admin</title>
   <?php include('../templates/formatting.php'); ?>
 </head>

 <body> 
   <?php include('../templates/header.php'); ?> 
   <h1>Schedule Admin</h1>
    <?php include ('../templates/navbarMgr.php'); ?>
   <br/>

  <form method="POST">
    <div>
      <button class="btn btn-success" method="POST" action="Schedule.php" name="publishbtn" style="float: right; margin: 5px">Publish</button>
    </div>
  </form>
  <form method="POST">
    <div>
     <button class="btn btn-danger" method="POST" action="Schedule.php" name="clearbtn" style="float: right; margin: 5px">Clear all</button>
    </div>
  </form>
  <form method="POST">
    <div>
     <button class="btn btn-primary" method="POST" action="Schedule.php" name="autoschedbtn" style="float: right; margin: 5px">Auto-populate</button>
   </div>
  </form>
    <table class="roletable table-bordered">
     <thead>
        <th>Role</th>
        <th>Default limit</th>
        <th>Default Start Time</th>
        <th>Default End Time</th> 
     </thead>
     <tbody>
       <?php while ($row = pg_fetch_assoc($defaults)) {
        ?>
       <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['default_limit']; ?></td>
        <td><?php echo $row['default_start_time']; ?></td>  
        <td><?php echo $row['default_end_time']; ?></td>  
       </tr>
       <?php
       }
       ?>
     </tbody> 
    </table>

           <div class="container">  
                <br />  
                <div class="table">  
                     <h3 align="center">Schedule Admin (Week of <?php echo $dt_min->format('m/d/Y'); ?>)</h3><br />  
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
                url:"../classes/sched_Select.php",  
                method:"POST",  
                success:function(data){  
                     $('#live_data').html(data);  
                }  
           });  
      }  
      fetch_data();  

      $(document).on('click', '#1', function(){  
 
            var user_no = $('.1').val();  
            var role_no = '1';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           }) 
       });
      $(document).on('click', '#2', function(){  
    
            var user_no = $('.2').val();  
            var role_no = '2';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           }) 
       });
       $(document).on('click', '#3', function(){  
    
            var user_no = $('.3').val();  
            var role_no = '3';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })
       });  
       $(document).on('click', '#4', function(){  
    
            var user_no = $('.4').val();  
            var role_no = '4';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })
       });  
       $(document).on('click', '#5', function(){  
    
            var user_no = $('.5').val();  
            var role_no = '5';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })
       });  
       $(document).on('click', '#6', function(){  
    
            var user_no = $('.6').val();  
            var role_no = '6';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })
       });  
       $(document).on('click', '#7', function(){  
    
            var user_no = $('.7').val();  
            var role_no = '7';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })  
       });
       $(document).on('click', '#8', function(){  
    
            var user_no = $('.8').val();  
            var role_no = '8';

           $.ajax({  
                url:"../classes/sched_Insert.php",  
                method:"POST",  
                data:{user_no:user_no, role_no:role_no},  
                dataType:"text",  
                success:function(data)
                {  
//                     alert(data);  
                     fetch_data();  
                }  
           })  
       });

      function edit_data(user_no, role_no, text, column_name)  
      {  

           var timeRegex = new RegExp('(^([0-9]|[0-1][0-9]|[2][0-3]):([0-5][0-9])$)|(^([0-9]|[1][0-9]|[2][0-3])$)');
           if (timeRegex.test(text) || text == ''){

           $.ajax({  
                url:"../classes/sched_Edit.php",  
                method:"POST",  
                data:{user_no:user_no,role_no:role_no, text:text, column_name:column_name},  
                dataType:"text",  
                success:function(data){  
                }  
           }); 
           }
           else{
               alert("Incorrect format");
               return false;
           }

      }  

  $(document).on('blur', '.mon_start', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var mon_start = $(this).text();  
   edit_data(user_no, role_no, mon_start, "mon_start");  
   fetch_data();
  });  

  $(document).on('blur', '.mon_end', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var mon_end = $(this).text();  
   edit_data(user_no, role_no, mon_end, "mon_end");  
       fetch_data();
  });  

  $(document).on('blur', '.tue_start', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var tue_start = $(this).text();  
   edit_data(user_no, role_no, tue_start, "tue_start");  
       fetch_data();
  });  

  $(document).on('blur', '.tue_end', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var tue_end = $(this).text();  
   edit_data(user_no, role_no, tue_end, "tue_end");  
       fetch_data();
  });  

  $(document).on('blur', '.wed_start', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var wed_start = $(this).text();  
   edit_data(user_no, role_no, wed_start, "wed_start");  
       fetch_data();
  });  

  $(document).on('blur', '.wed_end', function(){  
       var user_no = $(this).data("id16");  
       var role_no = $(this).data("id17");
       var wed_end = $(this).text();  
   edit_data(user_no, role_no, wed_end, "wed_end");  
       fetch_data();
    });  

    $(document).on('blur', '.thurs_start', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var thurs_start = $(this).text();  
     edit_data(user_no, role_no, thurs_start, "thurs_start");  
       fetch_data();
    });  

    $(document).on('blur', '.thurs_end', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var thurs_end = $(this).text();  
     edit_data(user_no, role_no, thurs_end, "thurs_end");  
       fetch_data();
    });  

    $(document).on('blur', '.fri_start', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var fri_start = $(this).text();  
     edit_data(user_no, role_no, fri_start, "fri_start");  
       fetch_data();
    });  

    $(document).on('blur', '.fri_end', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var fri_end = $(this).text();  
     edit_data(user_no, role_no, fri_end, "fri_end");  
       fetch_data();
    });  

    $(document).on('blur', '.sat_start', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var sat_start = $(this).text();  
     edit_data(user_no, role_no, sat_start, "sat_start");  
       fetch_data();
    });  

    $(document).on('blur', '.sat_end', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var sat_end = $(this).text();  
     edit_data(user_no, role_no, sat_end, "sat_end");  
       fetch_data();
    });  

    $(document).on('blur', '.sun_start', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var sun_start = $(this).text();  
     edit_data(user_no, role_no, sun_start, "sun_start");  
       fetch_data();
    });  

    $(document).on('blur', '.sun_end', function(){  
         var user_no = $(this).data("id16");  
         var role_no = $(this).data("id17");
         var sun_end = $(this).text();  
     edit_data(user_no, role_no, sun_end, "sun_end");  
       fetch_data();
      });  


      function edit_rlbd(role_no, text, column_name)  
      {  

           var timeRegex = new RegExp('(^([0-9]|[0-1][0-9]|[2][0-3]):([0-5][0-9])$)|(^([0-9]|[1][0-9]|[2][0-3])$)');
           if (timeRegex.test(text) || text == ''){
           $.ajax({  
                url:"../classes/sched_rlbdEdit.php",  
                method:"POST",  
                data:{role_no:role_no, text:text, column_name:column_name},  
                dataType:"text",  
                success:function(data){  
                }  
           }); 
           }
           else{
               alert("Incorrect format");
               return false;
           }

      }  


  $(document).on('blur', '.mon', function(){  
       var role_no = $(this).data("id99");
       var mon = $(this).text();  
   edit_rlbd(role_no, mon, "mon");  
       fetch_data();
  });  

  $(document).on('blur', '.tue', function(){  
       var role_no = $(this).data("id99");
       var tue = $(this).text();  
   edit_rlbd(role_no, tue, "tue");  
       fetch_data();
  });  

  $(document).on('blur', '.wed', function(){  
       var role_no = $(this).data("id99");
       var wed = $(this).text();  
   edit_rlbd(role_no, wed, "wed");  
       fetch_data();
  });  

  $(document).on('blur', '.thurs', function(){  
       var role_no = $(this).data("id99");
       var thurs = $(this).text();  
   edit_rlbd(role_no, thurs, "thurs");  
       fetch_data();
  });  

  $(document).on('blur', '.fri', function(){  
       var role_no = $(this).data("id99");
       var fri = $(this).text();  
   edit_rlbd(role_no, fri, "fri");  
       fetch_data();
  });  

  $(document).on('blur', '.sat', function(){  
       var role_no = $(this).data("id99");
       var sat = $(this).text();  
   edit_rlbd(role_no, sat, "sat");  
       fetch_data();
    });  

  $(document).on('blur', '.sun', function(){  
       var role_no = $(this).data("id99");
       var sun = $(this).text();  
   edit_rlbd(role_no, sun, "sun");  
       fetch_data();
    });  


      $(document).on('click', '.btn_delete', function(){  

            var role_no = $(this).data("id17");  
            var user_no = $(this).data("id16");

           if(confirm("Are you sure you want to delete this?"))  
           {  
                $.ajax({  
                     url:"../classes/sched_Delete.php",  
                     method:"POST",  
                     data:{user_no:user_no, role_no:role_no},  
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
