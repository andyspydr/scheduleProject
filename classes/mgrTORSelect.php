<?php  
#mgrTORSelect.php
 session_start();

 include('dbconnect.php'); 
 $output = '';  
 $sql = "SELECT request_no,full_name,from_date,to_date,requested_on,case when approved='Y' then 'YES' when approved='N' then 'NO' else 'Pending' end as approved FROM time_off_requests r inner join users u on u.user_no=r.user_no ORDER BY requested_on DESC";  
 $result = pg_query($dbconn, $sql);  
 $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered table-hover">  
                <tr>  
                     <th width="5%">Request #</th>  
                     <th width="20%">Name</th>
                     <th width="15%">Date Out</th>  
                     <th width="15%">Last Date Out</th>  
                     <th width="20%">Requested on</th> 
                     <th class="text-primary" width="25%">Approved(Y N or P)</th>
                </tr>';  
 if(pg_num_rows($result) > 0)  
 {  
      while($row = pg_fetch_assoc($result))  
      {  
           $output .= '  
                <tr>
                     <td>'.$row['request_no'].'</td>
                     <td class="full_name" data-id1="'.$row['request_no'].'">'.$row["full_name"].'</td>  
                     <td class="from_date" data-id2="'.$row['request_no'].'">'.$row["from_date"].'</td>  
                     <td class="to_date" data-id3="'.$row["request_no"].'">'.$row["to_date"].'</td>  
                     <td class="requested_on" data-id4="'.$row["request_no"].'">'.$row["requested_on"].'</td>  
                     <td class="approved" data-id5="'.$row["request_no"].'" contenteditable>'.$row["approved"].'</td>  
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
