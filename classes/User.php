<?php



Class User

{

  public function getUEData($i){
     include('dbconnect.php');
     $sql = "SELECT user_no,
                    is_manager,
                    login_id,
                    full_name,
                    email_address,
                    phone_number,
                    emergency_contact,
                    expired,
                    work_fri,
                    work_sat,
                    work_sun,
                    work_mon,
                    work_tue,
                    work_wed,
                    work_thurs,
                    fri_start,
                    fri_end,
                    sat_start,
                    sat_end,
                    sun_start,
                    sun_end,
                    mon_start,
                    mon_end,
                    tue_start,
                    tue_end,
                    wed_start,
                    wed_end,
                    thurs_start,
                    thurs_end 
             FROM   users 
             WHERE  user_no='$i';"; 
  
     $result = pg_query($dbconn,$sql);
     $array = pg_fetch_assoc($result);
     return $array;

  }


 public function getUserRoles($i){
    include('dbconnect.php');


     $sql = "select sum(de) as de,
                    sum(de_rp) as de_rp,
                    sum(ve) as ve,
                    sum(ve_rp) as ve_rp,
                    sum(clr) as clr,
                    sum(clr_rp) as clr_rp,
                    sum(vm) as vm,
                    sum(vm_rp) as vm_rp,
                    sum(tm) as tm,
                    sum(tm_rp) as tm_rp,
                    sum(flr) as flr,
                    sum(flr_rp) as flr_rp,
                    sum(fr) as fr, 
                    sum(fr_rp) as fr_rp,
                    sum(oth) as oth,
                    sum(ot_rp) as ot_rp
             
             from   (select sum(case when user_no=$i and role_no=1 then 1 else 0 end) as DE, 
                            sum(case when user_no=$i and role_no=2 then 1 else 0 end) as VE, 
                            sum(case when user_no=$i and role_no=3 then 1 else 0 end) as CLR,
                            sum(case when user_no=$i and role_no=4 then 1 else 0 end) as VM,
                            sum(case when user_no=$i and role_no=5 then 1 else 0 end) as TM, 
                            sum(case when user_no=$i and role_no=6 then 1 else 0 end) as FLR,
                            sum(case when user_no=$i and role_no=7 then 1 else 0 end) as FR,
                            sum(case when user_no=$i and role_no=8 then 1 else 0 end) as OTH,
                            case when user_no='$i' and role_no=1 then role_priority end as de_rp,
                            case when user_no='$i' and role_no=2 then role_priority end as ve_rp,
                            case when user_no='$i' and role_no=3 then role_priority end as clr_rp,
                            case when user_no='$i' and role_no=4 then role_priority end as vm_rp,
                            case when user_no='$i' and role_no=5 then role_priority end as tm_rp,
                            case when user_no='$i' and role_no=6 then role_priority end as flr_rp,
                            case when user_no='$i' and role_no=7 then role_priority end as fr_rp,
                            case when user_no='$i' and role_no=8 then role_priority end as ot_rp
                     from user_roles where user_no=$i group by user_no,role_no,role_priority) 
             foo;";
     
            $results = pg_query($dbconn,$sql);
            $array = pg_fetch_assoc($results);
            return $array;

 }


 public function updateRoles($de,$ve,$clr,$vm,$tm,$flr,$fr,$oth,$depr,$vepr,$clrpr,$vmpr,$tmpr,$flrpr,$frpr,$othpr,$userno){
    include('dbconnect.php');       
        $de_no = 1;
        $ve_no = 2;
        $clr_no = 3;
        $vm_no = 4;
        $tm_no = 5;
        $flr_no = 6;
        $fr_no = 7;
        $oth_no = 8;

        $clear_sql = "DELETE FROM user_roles WHERE user_no='$userno';";

  
        pg_query($dbconn,$clear_sql);

        if ($de =='1'){        
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$de_no','$userno','$depr');");  
        }
        if ($ve =='1'){                                                                             
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$ve_no','$userno','$vepr');");  
        }
        if ($clr =='1'){        
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$clr_no','$userno','$clrpr');");  
        }
        if ($vm =='1'){                                                                      
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$vm_no','$userno','$vmpr');");  
        }
        if ($tm =='1'){        
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$tm_no','$userno','$tmpr');");  
        }
        if ($flr =='1'){                                                                      
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$flr_no','$userno','$flrpr');");  
        }
        if ($fr =='1'){        
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$fr_no','$userno','$frpr');");  
        }
        if ($oth =='1'){        
          pg_query($dbconn,"INSERT INTO user_roles VALUES ('$oth_no','$userno','$othpr');");  
        }


 }


 public function updateUser($is_manager,$loginID,$name,$email,$ph,$em_contact,$expired,$work_fri,$work_sat,$work_sun,$work_mon,$work_tue,$work_wed,$work_thurs,$fri_start,$sat_start,$sun_start,$mon_start,$tue_start,$wed_start,$thu_start,$fri_end,$sat_end,$sun_end,$mon_end,$tue_end,$wed_end,$thu_end,$userno){

 include('dbconnect.php');
  
      $sql = "update users set is_manager='$is_manager',login_id='$loginID',full_name='$name',email_address='$email',phone_number='$ph',emergency_contact='$em_contact', expired='$expired', work_fri='$work_fri',work_sat='$work_sat',work_sun='$work_sun',work_mon='$work_mon',work_tue='$work_tue',work_wed='$work_wed',work_thurs='$work_thurs',fri_start='$fri_start',sat_start='$sat_start',sun_start='$sun_start',mon_start='$mon_start',tue_start='$tue_start',wed_start='$wed_start',thurs_start='$thu_start',fri_end='$fri_end',sat_end='$sat_end',sun_end='$sun_end',mon_end='$mon_end',tue_end='$tue_end',wed_end='$wed_end',thurs_end='$thu_end' where user_no='$userno';";  
      pg_query($dbconn,$sql);



}





  public function CreateUser($is_manager,$loginID,$fullname,$email,$phone,$emcon,$expired,$work_fri,$work_sat,$work_sun,$work_mon,$work_tue,$work_wed,$work_thurs,$fri_start,$sat_start,$sun_start,$mon_start,$tue_start,$wed_start,$thu_start,$fri_end,$sat_end,$sun_end,$mon_end,$tue_end,$wed_end,$thu_end) {
  
  include('dbconnect.php');
 
   $insert_sql = "INSERT into users values (nextval('user_no_sequence'),'$loginID','$fullname','abc123','$is_manager','f','$email','$phone','$emcon','$work_fri','$work_sat','$work_sun','$work_mon','$work_tue','$work_wed','$work_thurs','$fri_start','$fri_end','$sat_start','$sat_end','$sun_start','$sun_end','$mon_start','$mon_end','$tue_start','$tue_end','$wed_start','$wed_end','$thu_start','$thu_end','$expired',null);";
  
 
   pg_query($dbconn,$insert_sql);

   $userno_sql = "SELECT user_no from users where login_id='$loginID';";
 
   $userno = pg_query($dbconn,$userno_sql);

   return $userno;  

  }


  public function checkExistsLoginID($loginID,$userno){

     include('dbconnect.php');
  
     $sql = "SELECT distinct login_id from users where user_no<>'$userno' and login_id='$loginID';";

     $result = pg_query($dbconn,$sql);
     $value = pg_fetch_assoc($result);
     $val = $value['login_id'];
     if ($val == ''){
        return 0;
     }
     else{ 
       return 1;
     }
     

  }




  public function getEmployeeAdmin(){

   include('dbconnect.php');

   $tblsql= "SELECT distinct u.user_no as user_no,
                     login_id,
                     full_name,
                     email_address,
                     phone_number,
                     array_to_string(array_agg(r.name),', ') as roles,
                    (case when work_fri='f' then 'Fri' else '' end||','||
                     case when work_sat='f' then 'Sat' else '' end||','||
                     case when work_sun='f' then 'Sun' else '' end||','||
                     case when work_mon='f' then 'Mon' else '' end||','||
                     case when work_tue='f' then 'Tue' else '' end||','||
                     case when work_wed='f' then 'Wed' else '' end||','||
                     case when work_thurs='f' then 'Thurs' else '' end) as unavailable, 
                     case when expired='t' then 'Yes' else 'No' end as expired 
              FROM   users u left outer join user_roles ur on u.user_no=ur.user_no 
                     left outer join roles r on ur.role_no=r.role_no
              WHERE  expired='f' 
              group by login_id,u.user_no,full_name,email_address,phone_number,expired,work_fri,work_sat,work_sun,work_mon,work_tue,work_wed,work_thurs";
     
    $result = pg_query($dbconn,$tblsql);

    return $result;
  }





  public function changePassword($username,$reset,$password){

       include('dbconnect.php');

       $pwd = password_hash($password,PASSWORD_DEFAULT);
       $sql = "UPDATE users SET password='$pwd',reset_code=null WHERE reset_code='$reset' AND login_id='$username';";

       pg_query($dbconn,$sql);       

  }

}

?>
