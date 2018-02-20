<?php

class Schedule
{


  public function publishSchedule(){
 
       include('dbconnect.php');
       $week = date("Y-m-d",strtotime("next Monday")); 
 
    if ($this->findConflicts()){ 

       echo "<H2>There are scheduling conflicts</H2>";

    } else {     
       $update_sql = "UPDATE schedule set published='Y' where week='$week';";
       pg_query($dbconn, $update_sql);
      }

  }

  public function clearSchedule(){

       include('dbconnect.php');
       $week = date("Y-m-d",strtotime("next Monday")); 

       $delete_sql = "DELETE FROM schedule where week='$week';";
       pg_query($dbconn, $delete_sql);
      
  }



  function getroleDefaults(){
   
    include('dbconnect.php');
  
    $sql = "SELECT * FROM roles order by default_limit desc nulls last;";
    $results = pg_query($dbconn,$sql);
  
    return $results;
  
  }


  function getmyroleDefaults($userno, $week){
   
   include('dbconnect.php');
  
    $sql = "SELECT * FROM roles WHERE role_no in (SELECT role_no from schedule where week='$week' and user_no='$userno') order by default_limit desc;";
    $results = pg_query($dbconn,$sql);
  
    return $results;
  
  }


  public function getDisplayWeek(){

      $week = date("Y-m-d",strtotime("next Monday"));
      $rolloverdate = date("Y-m-d",strtotime("now + 2 days"));
     
     
      if ($week < $rolloverdate){ 
           $week = date("Y-m-d",strtotime("next Monday"));
      }
      if ($week > $rolloverdate){
           $week = date("Y-m-d",strtotime("last Monday"));
      }
      if (date("Y-m-d",strtotime("$rolloverdate - 2 days")) == date("Y-m-d",strtotime("Monday"))){
           $week = date("Y-m-d",strtotime("$week + 7 days"));
      }

   return $week; 

  }


  function autoSchedule(){
 
     include('dbconnect.php');
      ##get week dates and role defaults     
        #$dates = getDOWS(); 
      $week = date("Y-m-d",strtotime("next Monday"));

      ##initialize empty schedule
      pg_query($dbconn, "DELETE FROM schedule WHERE week='$week';");


   ##Begin loop to put Employees into Scheduled array     

   for ($role = 0; $role < 9; $role++){

     $count = 0;

        $roles = $this->getschedroleDefaults($role);

           while ($count < $roles['default_limit']){

                 pg_query($dbconn,"insert into schedule select '$week',
                                                                pool.user_no,
                                                                role_no,
                                                                default_start_time,
                                                                default_end_time,
                                                                default_start_time,
                                                                default_end_time,
                                                                default_start_time,
                                                                default_end_time,
                                                                default_start_time,
                                                                default_end_time,
                                                                default_start_time,
                                                                default_end_time,
                                                                default_Start_time,
                                                                default_end_time,
                                                                default_start_time,
                                                                default_end_time from (select u.user_no,
                                                                                              r.role_no,
                        								      default_start_time,
											      default_end_time,
											      rank() over (order by role_priority) as rank 
										       from   users u,
  											      user_roles ur,
											      roles r 
										       where  r.role_no=ur.role_no 
										       and    u.user_no=ur.user_no 
										       and    expired='f' 
										       and    is_manager='f' 
										       and    r.role_no='$roles[role_no]') pool
                                    
				   where    rank >= '1'
                                   and      pool.user_no not in (Select user_no 
							         from   schedule 
							         where  week='$week') 
                                   limit 1;");

                   $count++;

                  }

              }
      $this->unavailableDays();  
      $this->adjustlimitsbyday();
      $this->fillemptyslots(); 
  } 


   function getschedroleDefaults($roleno){
   
     include('dbconnect.php');  
      $sql = "SELECT * FROM roles WHERE role_no='$roleno';";
      $results = pg_query($dbconn,$sql);
      $result = pg_fetch_assoc($results);  
     return $result;
   }



   function unavailableDays(){

        include('dbconnect.php');

      $week = date("Y-m-d",strtotime("next Monday"));

        pg_query($dbconn,"update schedule set mon_start=null,mon_end=null where week='$week' and user_no in (Select user_no from users where work_mon='f');");
        pg_query($dbconn,"update schedule set tue_start=null,tue_end=null where week='$week' and user_no in (Select user_no from users where work_tue='f');");
        pg_query($dbconn,"update schedule set wed_start=null,wed_end=null where week='$week' and user_no in (Select user_no from users where work_wed='f');");
        pg_query($dbconn,"update schedule set thurs_start=null,thurs_end=null where week='$week' and user_no in (Select user_no from users where work_thurs='f');");
        pg_query($dbconn,"update schedule set fri_start=null,fri_end=null where week='$week' and user_no in (Select user_no from users where work_fri='f');");
        pg_query($dbconn,"update schedule set sat_start=null,sat_end=null where week='$week' and user_no in (Select user_no from users where work_sat='f');");
        pg_query($dbconn,"update schedule set sun_start=null,sun_end=null where week='$week' and user_no in (Select user_no from users where work_sun='f');");


        $num_over_sql = "select count(*) from (select user_no,
                                                            sum(case when mon_start is not null then 1 else 0 end) + 
                                                            sum(case when tue_start is not null then 1 else 0 end) + 
                                                            sum(case when wed_start is not null then 1 else 0 end) + 
                                                            sum(case when thurs_start is not null then 1 else 0 end) + 
                                                            sum(case when fri_start is not null then 1 else 0 end) + 
                                                            sum(case when sat_start is not null then 1 else 0 end) + 
                                                            sum(case when sun_start is not null then 1 else 0 end) as num_days 
                             
                                                     from   schedule 
                                                     where  week='$week' 
                                                     group by user_no) foo 
                                      where num_days>5;";


         $num_over = pg_fetch_array(pg_query($dbconn,$num_over_sql));


         while ($num_over[0] > 0){

             $dows = array("mon","tue","wed","thurs","fri","sat","sun");
             $dow_rand = array_rand($dows,1);
             $dow = $dows[$dow_rand];

                               pg_query($dbconn,"update schedule set ${dow}_start=null,${dow}_end=null 
                                                 where user_no in (select user_no from (select user_no,
                                                                                               sum(case when mon_start is not null then 1 else 0 end) + 
                                                                                               sum(case when tue_start is not null then 1 else 0 end) + 
                                                                                               sum(case when wed_start is not null then 1 else 0 end) + 
                                                                                               sum(case when thurs_start is not null then 1 else 0 end) + 
                                                                                               sum(case when fri_start is not null then 1 else 0 end) + 
                                                                                               sum(case when sat_start is not null then 1 else 0 end) + 
                                                                                               sum(case when sun_start is not null then 1 else 0 end) as num_days 
                             
                                                                                        from   schedule 
                                                                                        where  week='$week' 
                                                                                        group by user_no) foo 
                                                                   where week='$week' 
                                                                   and   foo.num_days>5 limit 1);");


         $num_over = pg_fetch_array(pg_query($dbconn,$num_over_sql));

         }

   }


   function adjustlimitsbyday(){

      include('dbconnect.php');
  
      $week = date("Y-m-d",strtotime("next Monday"));
      $dows = array("mon","tue","wed","thurs","fri","sat","sun");

      for ($role = 8; $role > 0; $role--){
       for ($dow = 0; $dow < 7; $dow++){
           $count = 0;
           $roles = $this->getschedroleDefaults($role);
           $num_sched_sql = "SELECT count(*)  from schedule where week='$week' and role_no='$roles[role_no]' and ${dows[$dow]}_start is not null;";
           $custom_limit_sql = "SELECT $dows[$dow] from role_limits_by_day where role_no='$roles[role_no]';";

           $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
           $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));

            while (($num_scheduled[0] > $custom_limit[0]) && ($count != '10')){

              pg_query($dbconn,"UPDATE schedule set ${dows[$dow]}_start=null,${dows[$dow]}_end=null 
                                where user_no in (select user_no from (select user_no 
                                                                       from   schedule 
                                                                       where  week='$week' 
                                                                       and    role_no='$roles[role_no]' 
                                                                       and    ${dows[$dow]}_start is not null limit 1) foo) 
                                                  and    week='$week' 
                                                  and    role_no='$roles[role_no]';");

               
               $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
               $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));
               $count++;

            }  
       }
      }
    }


   function fillemptyslots(){

         
     include('dbconnect.php');
      ##get week dates and role defaults     
        #$dates = getDOWS(); 
      $week = date("Y-m-d",strtotime("next Monday"));
      $dows = array("mon","tue","wed","thurs","fri","sat","sun");
     ##Loop for filling empty days per role through insert of employees     

      for ($role = 8; $role > 0; $role--){
       for ($dow = 0; $dow < 7; $dow++){

           $count = 0;
           $roles = $this->getschedroleDefaults($role);
           $num_sched_sql = "SELECT count(*) from schedule where week='$week' and role_no='$roles[role_no]' and ${dows[$dow]}_start is not null;";
           $custom_limit_sql = "SELECT $dows[$dow] from role_limits_by_day where role_no='$roles[role_no]';";

           $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
           $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));


            while (($num_scheduled[0] < $custom_limit[0]) && ($count != '10')){
  
                    pg_query($dbconn,"insert into schedule (week,user_no,role_no,${dows[$dow]}_start,${dows[$dow]}_end) 
                                                            select '$week',
                                                                   pool.user_no,
                                                                   role_no,
                                                                   default_start_time,
                                                                   default_end_time
                                                            from                      (select u.user_no,
                                                                                              r.role_no,
                           								      default_start_time,
   											      default_end_time,
   											      rank() over (order by role_priority) as rank 
   										       from   users u,
     											      user_roles ur,
   											      roles r 
   										       where  r.role_no=ur.role_no 
   										       and    u.user_no=ur.user_no 
   										       and    expired='f' 
   										       and    is_manager='f'
                                                                                       and    work_$dows[$dow] ='t' 
   										       and    r.role_no='$roles[role_no]') pool
                                       
   				      where    rank >= '0'
                                      and      pool.user_no not in (Select user_no 
   							            from   schedule 
   							            where  week='$week'
                                                                    and    (role_no='$roles[role_no]' or ${dows[$dow]}_start is not null)) 
                                      and      pool.user_no not in 

                                                     (select user_no from (select user_no,
                                                             sum(case when mon_start is not null then 1 else 0 end) + 
                                                             sum(case when tue_start is not null then 1 else 0 end) + 
                                                             sum(case when wed_start is not null then 1 else 0 end) + 
                                                             sum(case when thurs_start is not null then 1 else 0 end) + 
                                                             sum(case when fri_start is not null then 1 else 0 end) + 
                                                             sum(case when sat_start is not null then 1 else 0 end) + 
                                                             sum(case when sun_start is not null then 1 else 0 end) as num_days 
                             
                                                     from    schedule 
                                                     where   week='$week' 
                                                     group by user_no) foo 
                                      where num_days>4)
                                       limit 1;");

                       $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
                       $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));
                       $count++;

           }
         }
      }

    

      for ($role = 8; $role > 0; $role--){
       for ($dow = 0; $dow < 7; $dow++){

           $count = 0;
           $roles = $this->getschedroleDefaults($role);
           $num_sched_sql = "SELECT count(*) from schedule where week='$week' and role_no='$roles[role_no]' and ${dows[$dow]}_start is not null;";
           $custom_limit_sql = "SELECT $dows[$dow] from role_limits_by_day where role_no='$roles[role_no]';";

           $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
           $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));
 
           while (($num_scheduled[0] < $custom_limit[0]) && ($count != '10')){

                        pg_query($dbconn,"UPDATE schedule set ${dows[$dow]}_start='$roles[default_start_time]',${dows[$dow]}_end='$roles[default_end_time]'
                                          WHERE user_no in (SELECT user_no 
                                                            FROM (SELECT user_no 
                                                                  FROM   schedule
                                                                  WHERE  week='$week'
                                                                  AND    role_no='$roles[role_no]'
                                                                  AND    ${dows[$dow]}_start is null
                                                                  AND    user_no in (SELECT user_no 
                                                                                     FROM   users
                                                                                     WHERE  work_$dows[$dow] ='t')
                                                                  AND    user_no not in (SELECT user_no 
                                                                                         FROM   schedule
                                                                                         WHERE  week='$week'
                                                                                         AND    ${dows[$dow]}_start IS NOT NULL)
                                                                  AND    user_no not in (SELECT user_no FROM (SELECT   user_no,
                                                                                                                       sum(case when mon_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when tue_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when wed_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when thurs_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when fri_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when sat_start is not null then 1 else 0 end) + 
                                                                                                                       sum(case when sun_start is not null then 1 else 0 end) as num_days 
                                                                                                              FROM     schedule 
                                                                                                              WHERE    week='$week' 
                                                                                                              GROUP BY user_no) foo 
                                                                                         WHERE num_days>4) 
                                                                 limit 1) fo)
                                            AND role_no='$roles[role_no]'
                                            AND week='$week';");

   
                       $num_scheduled = pg_fetch_array(pg_query($dbconn,$num_sched_sql));  
                       $custom_limit = pg_fetch_array(pg_query($dbconn,$custom_limit_sql));
                       $count++;
   
   
                     }
   
                 }
   
             }
   }

 
   function getDOWs(){

    $dates = array();
    $first = strtotime('next Monday');
    $last  = strtotime('+7 days',$first);
  
    while( $first <= $last) {

       $dates[] = date('d/m/Y',$first);
       $first = strtotime('+1 day',$first);
    }         
     return $dates;

   }



  public function calculateTotals(){

   include('dbconnect.php');

     $week = date("Y-m-d",strtotime("next Monday")); 
   
     $sql = "
          with monday as (select abs(sum(diff)) as monday_total 
      from  (select (abs(extract(epoch from cast(mon_start || 'hours' as interval))) - abs(extract(epoch from cast(mon_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      tuesday as (select abs(sum(diff)) as tuesday_total 
      from  (select (abs(extract(epoch from cast(tue_start || 'hours' as interval))) - abs(extract(epoch from cast(tue_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      wednesday as (select abs(sum(diff)) as wednesday_total 
      from  (select (abs(extract(epoch from cast(wed_start || 'hours' as interval))) - abs(extract(epoch from cast(wed_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      thursday as (select abs(sum(diff)) as thursday_total 
      from  (select (abs(extract(epoch from cast(thurs_start || 'hours' as interval))) - abs(extract(epoch from cast(thurs_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      friday as (select abs(sum(diff)) as friday_total 
      from  (select (abs(extract(epoch from cast(fri_start || 'hours' as interval))) - abs(extract(epoch from cast(fri_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      saturday as (select abs(sum(diff)) as saturday_total 
      from  (select (abs(extract(epoch from cast(sat_start || 'hours' as interval))) - abs(extract(epoch from cast(sat_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo),
      
      sunday as (select abs(sum(diff)) as sunday_total 
      from  (select (abs(extract(epoch from cast(sun_start || 'hours' as interval))) - abs(extract(epoch from cast(sun_end || 'hours' as interval) + interval '12 hours')))/3600 as diff 
             from schedule 
             where week='$week') foo)
      
      SELECT monday_total,
             tuesday_total,
             wednesday_total,
             thursday_total,
             friday_total,
             saturday_total,
             sunday_total,
             sum(monday_total+tuesday_total+wednesday_total+thursday_total+friday_total+saturday_total+sunday_total) as cume
      
      FROM   monday,
             tuesday,
             wednesday,
             thursday,
             friday,
             saturday,
             sunday
      GROUP BY 
             monday_total,
             tuesday_total,
             wednesday_total,
             thursday_total,
             friday_total,
             saturday_total,
             sunday_total
      ;";

 
   $result = pg_query($dbconn, $sql);

   return pg_fetch_assoc($result);


  }


  function findConflicts(){

      include('dbconnect.php');
     
     $week = date("Y-m-d",strtotime("next Monday")); 
 
         $dbl_roles = pg_fetch_array(pg_query($dbconn,"select count(distinct a.user_no) 
                                          from   schedule a inner join schedule b on a.week=b.week 
                                          and a.week='$week' 
                                          and b.week='$week' 
                                          and a.user_no=b.user_no 
                                          and (a.mon_start is not null 
                                               and b.mon_start is not null 
                                               or 
                                               a.tue_start is not null 
                                               and b.tue_start is not null
                                               or 
                                               a.wed_start is not null 
                                               and b.wed_start is not null 
                                               or 
                                               a.thurs_start is not null 
                                               and b.thurs_start is not null
                                               or 
                                               a.fri_start is not null 
                                               and b.fri_start is not null
                                               or 
                                               a.sat_start is not null 
                                               and b.sat_start is not null 
                                               or 
                                               a.sun_start is not null 
                                               and b.sun_start is not null) 
                                          and a.role_no<>b.role_no;"));
      
          if ($dbl_roles[0] >= '1'){
          
             return true;
      
          }
  }






}

?>
