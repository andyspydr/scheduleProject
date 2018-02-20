<?php  
#sched_Select.php
 
 include ('schedule_class.php');
 include('dbconnect.php');
 include('../templates/formatting.php');
 
 $sched = new Schedule();
 $roleinfo = $sched->getroleDefaults();
 $week = date("Y-m-d",strtotime("next Monday"));
 $totals = $sched->calculateTotals();

 $output = '';


 ##Display calculated totals on sidebar
 echo '<div id="message">
          <div id="inner-message" class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h2>Total Hours: '.$totals['cume'].'</h2>
              <br/>
               Monday:...........'.$totals['monday_total'].'<br/> 
               Tuesday:..........'.$totals['tuesday_total'].'<br/>
               Wednesday:.....'.$totals['wednesday_total'].'<br/>
               Thursday:........'.$totals['thursday_total'].'<br/>
               Friday:.............'.$totals['friday_total'].'<br/>
               Saturday:.........'.$totals['saturday_total'].'<br/>
               Sunday:...........'.$totals['sunday_total'].'<br/>
          </div>
       </div>';

  ##Fetch role limits by day for modifying
  $output .= '
     <div class="container-fluid">  

     <table class="table table-bordered table-hover">  
      <th bgcolor="#e6e6e6" colspan="8" >Role Limits Per Day</th>
                 <tr>  
                     <th width="10%">Role</th>  
                     <th width="10%" colspan="1">Monday</th> 
                     <th width="10%" colspan="1">Tuesday</th> 
                     <th width="10%" colspan="1">Wednesday</th> 
                     <th width="10%" colspan="1">Thursday</th> 
                     <th width="10%" colspan="1">Friday</th> 
                     <th width="10%" colspan="1">Saturday</th>
                     <th width="10%" colspan="1">Sunday</th>
                 </tr>
        ';


   while ($roles = pg_fetch_assoc($roleinfo)){

       $rlbd_sql = "SELECT r.name,r.role_no,mon,tue,wed,thurs,fri,sat,sun FROM roles r INNER JOIN role_limits_by_day d ON r.role_no=d.role_no WHERE r.role_no='$roles[role_no]'";
       $rlbd = pg_fetch_assoc(pg_query($dbconn,$rlbd_sql));

         $output .= '
              <tr>
                <td class="role" data-id90="'.$rlbd["role_no"].'">'.$rlbd["name"].'</td>  
                <td class="mon" align="center" data-id91="'.$rlbd["mon"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["mon"].'</td>  
                <td class="tue" align="center" data-id92="'.$rlbd["tue"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["tue"].'</td>  
                <td class="wed" align="center" data-id93="'.$rlbd["wed"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["wed"].'</td>  
                <td class="thurs" align="center" data-id94="'.$rlbd["thurs"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["thurs"].'</td>  
                <td class="fri" align="center" data-id95="'.$rlbd["fri"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["fri"].'</td>  
                <td class="sat" align="center" data-id96="'.$rlbd["sat"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["sat"].'</td>  
                <td class="sun" align="center" data-id97="'.$rlbd["sun"].'" data-id99="'.$rlbd["role_no"].'" contenteditable>'.$rlbd["sun"].'</td>    
              </tr>
         ';
      }
  $output .= '
        </table>
   </div>';
echo $output;
 
##Restart to fetch all roles for modifying
$roleinfo = $sched->getroleDefaults();

while ($roles = pg_fetch_assoc($roleinfo)){

  $output = '';
 
  $emp_sql = "SELECT u.user_no as user_no,full_name,ur.role_no as role_no FROM users u INNER JOIN user_roles ur on u.user_no=ur.user_no WHERE expired='f' and ur.role_no='$roles[role_no]' and u.user_no not in (SELECT user_no FROM schedule WHERE week='$week' AND role_no='$roles[role_no]') ORDER BY full_name";
  $scheduled_sql = "SELECT week,u.user_no as user_no,full_name,role_no,s.mon_start as mon_start,s.mon_end as mon_end,s.tue_start,s.tue_end,s.wed_start,s.wed_end,s.thurs_start,s.thurs_end,s.fri_start,s.fri_end,s.sat_start,s.sat_end,s.sun_start,s.sun_end FROM schedule s inner join users u on s.user_no=u.user_no WHERE week='$week' and role_no='$roles[role_no]' order by full_name";
 
  $scheduled_result = pg_query($dbconn, $scheduled_sql);  
  $emp_result = pg_query($dbconn, $emp_sql); 


 $output .= '  
     <h2>'.$roles['name'].'</h2> 
      <div class="container-fluid">
           <table class="table table-bordered table-hover">  
                <tr>  
                     <th width="10%">Name</th>  
                     <th width="10%" colspan="2">Monday</th> 
                     <th width="10%" colspan="2">Tuesday</th> 
                     <th width="10%" colspan="2">Wednesday</th> 
                     <th width="10%" colspan="2">Thursday</th> 
                     <th width="10%" colspan="2">Friday</th> 
                     <th width="10%" colspan="2">Saturday</th>
                     <th width="10%" colspan="2">Sunday</th>
                     <th width="10%">Delete</th>  
                </tr>';  

      while($row = pg_fetch_assoc($scheduled_result))  
      {  
           $output .= '  
                <tr>  
                     <td class="full_name" data-id1="'.$row["full_name"].'">'.$row["full_name"].'</td>  
                     <td class="mon_start" align="center" data-id2="'.$row["mon_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["mon_start"].'</td>  
                     <td class="mon_end" align="center" data-id3="'.$row["mon_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["mon_end"].'</td>  
                     <td class="tue_start" align="center" data-id4="'.$row["tue_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["tue_start"].'</td>  
                     <td class="tue_end" align="center" data-id5="'.$row["tue_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["tue_end"].'</td>  
                     <td class="wed_start" align="center" data-id6="'.$row["wed_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["wed_start"].'</td>  
                     <td class="wed_end" align="center" data-id7="'.$row["wed_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["wed_end"].'</td>  
                     <td class="thurs_start" align="center" data-id8="'.$row["thurs_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["thurs_start"].'</td>
                     <td class="thurs_end" align="center" data-id9="'.$row["thurs_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["thurs_end"].'</td>
                     <td class="fri_start" align="center" data-id10="'.$row["fri_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["fri_start"].'</td>  
                     <td class="fri_end" align="center" data-id11="'.$row["fri_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["fri_end"].'</td>  
                     <td class="sat_start" align="center" data-id12="'.$row["sat_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["sat_start"].'</td>  
                     <td class="sat_end" align="center" data-id13="'.$row["sat_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["sat_end"].'</td>  
                     <td class="sun_start" align="center" data-id14="'.$row["sun_start"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["sun_start"].'</td>  
                     <td class="sun_end" align="center" data-id15="'.$row["sun_end"].'" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" contenteditable>'.$row["sun_end"].'</td>  
                     <td><button type="button" name="delete_btn" data-id16="'.$row["user_no"].'" data-id17="'.$row["role_no"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>  
                     <!td class="user_no" data-id17="'.$row["user_no"].'" style="display: none;"</td>  
                     <!td class="role_no" data-id18="'.$row["role_no"].'" style="display: none;"</td>  
                </tr>  
           ';  
      }  
      $output .= '  
           <tr>  
                <td id="'.$roles["name"].'">
                <select class="'.$roles["role_no"].'"> 
                <option></option>
                ';
                while ($name = pg_fetch_assoc($emp_result)){  
                   $output .= "<option value='$name[user_no]'>$name[full_name]</option>";
                  }
                
     $output .='</select>
                </td>
                <td id="mon_start" contenteditable></td>  
                <td id="mon_end" contenteditable></td>  
                <td id="tue_start" contenteditable></td>  
                <td id="tue_end" contenteditable></td>  
                <td id="wed_start" contenteditable></td>  
                <td id="wed_end" contenteditable></td>  
                <td id="thurs_start" contenteditable></td>  
                <td id="thurs_end" contenteditable></td>  
                <td id="fri_start" contenteditable></td>  
                <td id="fri_end" contenteditable></td>  
                <td id="sat_start" contenteditable></td>  
                <td id="sat_end" contenteditable></td>  
                <td id="sun_start" contenteditable></td>  
                <td id="sun_end" contenteditable></td>  
                <td><button type="button" id="'.$roles["role_no"].'" class="btn btn-xs btn-success">+</button></td>  
           </tr>  
      ';  

 $output .= '</table>  
      </div>';  

echo $output;
}

?>  
