<?php  
#empSchedSelect.php
 session_start();
 $userno = $_SESSION['userno'];

 include('../classes/dbconnect.php'); 
 $output = '';  
 $sql = "SELECT request_no,from_date,to_date,requested_on,approved FROM time_off_requests where (approved is null or approved='P') and user_no='$userno' ORDER BY requested_on DESC";  
 $result = pg_query($dbconn, $sql);  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">  
                <tr>  
                     <th width="10%">Id</th>  
                     <th width="20%">Date Out</th>  
                     <th width="20%">Last Date Out</th>  
                     <th width="40%">Requested on</th>
                     <th width="10%">Delete</th>  
                </tr>';  
 if(pg_num_rows($result) > 0)  
 {  
      while($row = pg_fetch_assoc($result))  
      {  
           $output .= '  
                <tr>
                     <td>'.$row["request_no"].'</td>  
                     <td class="from_date" data-id1="'.$row["from_date"].'" contenteditable>'.$row["from_date"].'</td>  
                     <td class="to_date" data-id2="'.$row["to_date"].'" contenteditable>'.$row["to_date"].'</td>  
                     <td class="requested_on" data-id3="'.$row["requested_on"].'" contenteditable>'.$row["requested_on"].'</td>  
                     <!td class="approved" data-id4="'.$row["approved"].'" contenteditable>'.$row["approved"].'</td>  
                     <td><button type="button" name="delete_btn" data-id5="'.$row["request_no"].'" class="btn btn-xs btn-danger btn_delete">x</button></td>  
                </tr>  
           ';  
      }  
 }  
 else  
 {  
      $output .= '<tr>  
                          <td colspan="4">No Data Found</td>  
                     </tr>';  
 }  
 $output .= '</table>  
      </div>';  
 echo $output;  
 ?>  
