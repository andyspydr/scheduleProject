<?php  
#sched_Mine.php
session_start(); 
 include ('schedule_class.php');
 include('dbconnect.php');
 
 $sched = new Schedule();
 $userno = $_SESSION['userno'];
 $week = $sched->getDisplayWeek();
 $roleinfo = $sched->getmyroleDefaults($userno,$week);

   echo '<h3 align="center">Week of '.$week.'</h3><br />';


while ($roles = pg_fetch_assoc($roleinfo)){

 $output = '';

 $scheduled_sql = "SELECT week,u.user_no as user_no,full_name,role_no,s.mon_start as mon_start,s.mon_end as mon_end,s.tue_start,s.tue_end,s.wed_start,s.wed_end,s.thurs_start,s.thurs_end,s.fri_start,s.fri_end,s.sat_start,s.sat_end,s.sun_start,s.sun_end FROM schedule s inner join users u on s.user_no=u.user_no WHERE published='Y' and s.user_no='$userno' and week='$week' and role_no='$roles[role_no]'";

 $scheduled_result = pg_query($dbconn, $scheduled_sql);  


 $output .= '  
     <div class="container-fluid">  
           <table class="table table-bordered table-hover">  
             <th bgcolor="#e6e6e6" colspan="8" >'.$roles['name'].'</th> 
             <div class="container-fluid">  
                <tr>  
                     <th width="10%">Name</th>  
                     <th width="10%">Monday</th> 
                     <th width="10%">Tuesday</th> 
                     <th width="10%">Wednesday</th> 
                     <th width="10%">Thursday</th> 
                     <th width="10%">Friday</th> 
                     <th width="10%">Saturday</th>
                     <th width="10%">Sunday</th>
                </tr>';  
      while($row = pg_fetch_assoc($scheduled_result))  
      {  
           $output .= '  
                <tr>  
                     <td>'.$row["full_name"].'</td>  
                     <td align="center">'.$row["mon_start"].' -- '.$row["mon_end"].'</td>  
                     <td align="center">'.$row["tue_start"].' -- '.$row["tue_end"].'</td>  
                     <td align="center">'.$row["wed_start"].' -- '.$row["wed_end"].'</td>  
                     <td align="center">'.$row["thurs_start"].' -- '.$row["thurs_end"].'</td>
                     <td align="center">'.$row["fri_start"].' -- '.$row["fri_end"].'</td>  
                     <td align="center">'.$row["sat_start"].' -- '.$row["sat_end"].'</td>  
                     <td align="center">'.$row["sun_start"].' -- '.$row["sun_end"].'</td>  
                </tr>  
       ';
       }        
 
  $output .= '</table>  
            </div>';  

 echo $output;  
}

?>  
