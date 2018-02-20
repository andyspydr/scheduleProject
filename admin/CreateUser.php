<?php
#CreateUser.php

include('../classes/dbconnect.php');
include('../classes/User.php');
include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();


 if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user = new User();
 
    $is_manager = isset($_POST['is_manager']) ? 1:0;
    $loginID = pg_escape_string($_POST['loginID']);
    $fullname = pg_escape_string($_POST['full_name']);
    $email = pg_escape_string($_POST['email']);
    $phone = pg_escape_string($_POST['phone']);
    $emcon = pg_escape_string($_POST['emergency']);
    $expired = isset($_POST['expired']) ? 1:0;
    $work_fri = isset($_POST['work_fri']) ? 0:1;
    $work_sat = isset($_POST['work_sat']) ? 0:1;    
    $work_sun = isset($_POST['work_sun']) ? 0:1;
    $work_mon = isset($_POST['work_mon']) ? 0:1; 
    $work_tue = isset($_POST['work_tue']) ? 0:1;
    $work_wed = isset($_POST['work_wed']) ? 0:1; 
    $work_thurs = isset($_POST['work_thurs']) ? 0:1;

    $fri_start = pg_escape_string($_POST['fri_start']);
    $sat_start = pg_escape_string($_POST['sat_start']);
    $sun_start = pg_escape_string($_POST['sun_start']);
    $mon_start = pg_escape_string($_POST['mon_start']);
    $tue_start = pg_escape_string($_POST['tue_start']);
    $wed_start = pg_escape_string($_POST['wed_start']);
    $thu_start = pg_escape_string($_POST['thu_start']);

    $fri_end = pg_escape_string($_POST['fri_end']);
    $sat_end = pg_escape_string($_POST['sat_end']);
    $sun_end = pg_escape_string($_POST['sun_end']);     
    $mon_end = pg_escape_string($_POST['mon_end']);
    $tue_end = pg_escape_string($_POST['tue_end']);
    $wed_end = pg_escape_string($_POST['wed_end']);
    $thu_end = pg_escape_string($_POST['thu_end']);

    $de  = isset($_POST['DE']) ? 1:0;
    $ve  = isset($_POST['VE']) ? 1:0;
    $clr = isset($_POST['CLR']) ? 1:0;
    $vm  = isset($_POST['VM']) ? 1:0;
    $tm  = isset($_POST['TM']) ? 1:0;
    $flr = isset($_POST['FLR']) ? 1:0;
    $fr  = isset($_POST['FR']) ? 1:0;

    $depr  = pg_escape_string($_POST['DEPR']);
    $vepr  = pg_escape_string($_POST['VEPR']);
    $clrpr = pg_escape_string($_POST['CLRPR']);
    $vmpr  = pg_escape_string($_POST['VMPR']);
    $tmpr  = pg_escape_string($_POST['TMPR']);    
    $flrpr = pg_escape_string($_POST['FLRPR']);
    $frpr  = pg_escape_string($_POST['FRPR']);

 $duplicate = $user->checkExistsLoginID($loginID);


  if (!$duplicate){

    if ($loginID !=''){
     
         $userno =  $user->CreateUser($is_manager,$loginID,$fullname,$email,$phone,$emcon,$expired,$work_fri,$work_sat,$work_sun,$work_mon,$work_tue,$work_wed,$work_thurs,$fri_start,$sat_start,$sun_start,$mon_start,$tue_start,$wed_start,$thu_start,$fri_end,$sat_end,$sun_end,$mon_end,$tue_end,$wed_end,$thu_end);
       
         $new_uno_array = pg_fetch_assoc($userno);
         $new_user_no = $new_uno_array['user_no'];
       
         $user->updateRoles($de,$ve,$clr,$vm,$tm,$flr,$fr,$depr,$vepr,$clrpr,$vmpr,$tmpr,$flrpr,$frpr,$new_user_no);
         echo "<h2>User Created</h2>";
    }
    else echo "Login ID is required";
  } else if ($duplicate){
        echo "<h3>LoginID already taken</h3"; 
    } 

 }

?>

<!DOCTYPE html>

<html>
 <head>
    <title>Employee Edit</title>
    <?php include('../templates/formatting.php');?>
 </head>
 <body> 
   <?php include('../templates/header.php');?> 
  <h1>Employee Edit</h1> 
  <?php include ('../templates/navbarMgr.php'); ?>
  
  <div class="container-fluid">
    <form class="form-horizontal" method='POST' action="CreateUser.php" role="form">
 
     <div class="form-group form-group-sm"> 
       <label class="col-sm-2 control-label" for="is_manager">Manager</label>
       <div class="col-sm-2"> 
         <input class="form-control" type="checkbox" name="is_manager">
       </div>
     </div>
 
     <div class="form-group form-group-sm"> 
       <label class="col-sm-2 control-label" for="loginID">Login ID</label>
       <div class="col-sm-2"> 
         <input class="form-control" type="text" name="loginID" id="loginID">
       </div>
     </div>
 
     <div class="form-group form-group-sm"> 
       <label class="col-sm-2 control-label" for="full_name">Name</label>
       <div class="col-sm-2"> 
         <input class="form-control" type="text" name="full_name" id="full_name">
       </div>
      </div>
 
     <div class="form-group form-group-sm"> 
      <label class="col-sm-2 control-label" for="email">Email</label>
      <div class="col-sm-2"> 
        <input class="form-control" type="text" name="email" id="email">
      </div>
     </div>
   
     <div class="form-group form-group-sm"> 
      <label class="col-sm-2 control-label" for="phone">Phone #</label>
      <div class="col-sm-2"> 
        <input class="form-control" type="text" name="phone" id="phone">
     </div>
   
    </div>
     <div class="form-group form-group-sm"> 
      <label class="col-sm-2 control-label" for="emergency">Emergency Contact</label>
      <div class="col-sm-2"> 
        <input class="form-control" type="text" name="emergency" id="emergency">
     </div>
    </div>
   
    <div class="form-group form-group-sm"> 
      <label class="col-sm-2 control-label" for="expired">Expired</label>
      <div class="col-sm-2"> 
        <input class="form-control" type="checkbox" name="expired" id="expired">
      </div>
    </div>
    <br/>
     <label class="col-sm-2 control-label" for="DR">Roles</label>
     <label class="checkbox-inline"><input type="checkbox"  name="DE">Data Entry</label>
     <label class="checkbox-inline"><input type="checkbox"  name="VE">Verifier</label>
     <label class="checkbox-inline"><input type="checkbox"  name="CLR">Caller</label>
     <label class="checkbox-inline"><input type="checkbox"  name="VM">Voicemail</label>
     <label class="checkbox-inline"><input type="checkbox"  name="TM">Titlematching</label>
     <label class="checkbox-inline"><input type="checkbox"  name="FLR">Filer</label>
     <label class="checkbox-inline"><input type="checkbox"  name="FR">French Data Entry</label>
    <br/>
     <label class="col-sm-2 control-label" for="DEPR">Role Priority</label>
     <input class="form-inline input-xxs" type="text" name="DEPR">
     <input class="form-inline input-xxs" type="text" name="VEPR">
     <input class="form-inline input-xxs" type="text" name="CLRPR">
     <input class="form-inline input-xxs" type="text" name="VMPR">  
     <input class="form-inline input-xxs" type="text" name="TMPR">
     <input class="form-inline input-xxs" type="text" name="FLRPR">
     <input class="form-inline input-xxs" type="text" name="FRPR">
   <br/>
    <div class="well">
    <h3>Unavailable Days/Times</h3>
       <label class="checkbox-inline"><input type="checkbox" name="work_fri">Fri</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_sat">Sat</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_sun">Sun</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_mon">Mon</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_tue">Tue</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_wed">Wed</label>
       <label class="checkbox-inline"><input type="checkbox" name="work_thurs">Thu</label>
   <br/> 
   <br/>
       <input class="form-inline input-xs" type="text" name="fri_start" placeholder="FriSt">
       <input class="form-inline input-xs" type="text" name="sat_start" placeholder="SatSt">
       <input class="form-inline input-xs" type="text" name="sun_start" placeholder="SunSt">
       <input class="form-inline input-xs" type="text" name="mon_start" placeholder="MonSt">
       <input class="form-inline input-xs" type="text" name="tue_start" placeholder="TueSt">
       <input class="form-inline input-xs" type="text" name="wed_start" placeholder="WedSt">
       <input class="form-inline input-xs" type="text" name="thu_start" placeholder="ThuSt">
   <br/>
       <input class="form-inline input-xs" type="text" name="fri_end"  placeholder="FriEnd">
       <input class="form-inline input-xs" type="text" name="sat_end"  placeholder="SatEnd">
       <input class="form-inline input-xs" type="text" name="sun_end"  placeholder="SunEnd">
       <input class="form-inline input-xs" type="text" name="mon_end"  placeholder="MonEnd">
       <input class="form-inline input-xs" type="text" name="tue_end"  placeholder="TueEnd">
       <input class="form-inline input-xs" type="text" name="wed_end"  placeholder="WedEnd">
       <input class="form-inline input-xs" type="text" name="thu_end"  placeholder="ThuEnd">
    </div>
       <button type="submit" class="btn btn-primary" name="savebtn">Save Changes</button>
       <a href="EmployeeAdmin.php"><button type="button" class="btn" name="cancelbtn" >Cancel Changes</button></a>
   </form>
  </div>
 </body>
</html>
