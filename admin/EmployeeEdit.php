<?php
#EmployeeEdit.php

include('../classes/dbconnect.php');
include('../classes/User.php');
include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();


 if (!empty($_POST['loginID'])){

    if (isset($_POST["user_no"])){
    
      $user = new User();
 
      $is_manager = isset($_POST['is_manager']) ? 1:0;
       $userno = $_POST["user_no"];
   
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
       $oth = isset($_POST['OTH']) ? 1:0;

       $depr  = pg_escape_string($_POST['DEPR']);
       $vepr  = pg_escape_string($_POST['VEPR']);
       $clrpr = pg_escape_string($_POST['CLRPR']);
       $vmpr  = pg_escape_string($_POST['VMPR']);
       $tmpr  = pg_escape_string($_POST['TMPR']);    
       $flrpr = pg_escape_string($_POST['FLRPR']);
       $frpr  = pg_escape_string($_POST['FRPR']);
       $othpr = pg_escape_string($_POST['OTHPR']);

   $duplicate = $user->checkExistsLoginID($loginID,$userno);

   if (!$duplicate){ 
   
       $user->updateUser($is_manager,$loginID,$fullname,$email,$phone,$emcon,$expired,$work_fri,$work_sat,$work_sun,$work_mon,$work_tue,$work_wed,$work_thurs,$fri_start,$sat_start,$sun_start,$mon_start,$tue_start,$wed_start,$thu_start,$fri_end,$sat_end,$sun_end,$mon_end,$tue_end,$wed_end,$thu_end,$userno);
   
       $user->updateRoles($de,$ve,$clr,$vm,$tm,$flr,$fr,$oth,$depr,$vepr,$clrpr,$vmpr,$tmpr,$flrpr,$frpr,$othpr,$userno);
   
   
       $ue_array = $user->getUEData("$userno"); 
       $role_array = $user->getUserRoles("$userno");  
    echo "<h2>User updated</h2>";
   }
   else echo "<h2>Login ID already exists</h2>";
       $ue_array = $user->getUEData("$userno"); 
       $role_array = $user->getUserRoles("$userno");  


  }
 } 
 if (empty($_POST['loginID']) && isset($_POST['loginID'])){
  echo "Login ID cannot be blank";
  $user = new User();
  $ue_array = $user->getUEData($_POST['user_no']);
  $role_array = $user->getUserRoles($_POST['user_no']);
 }




 if (isset($_GET["user_no"])){
  $userno = $_GET["user_no"];
  $user = new User();
  $ue_array = $user->getUEData("$userno");
  $role_array = $user->getUserRoles("$userno"); 
 }

?>

<!DOCTYPE html>

<html>

 <head>
   <title>Employee Edit</title>
  <?php include('../templates/formatting.php'); ?>
 </head>

 <body> 
   <?php include('../templates/header.php');?> 
   <h1>Employee Edit</h1> 
   <?php include '../templates/navbarMgr.php'; ?>
    <h2><?php echo $ue_array['full_name']; ?></h2>
  
    <div class="container-fluid">
      <form class="form-horizontal" method='POST' action="EmployeeEdit.php" role="form">
   
      <div class="form-group form-group-sm"> 
         <label class="col-sm-2 control-label" for="userno">User #</label>
         <div class="col-sm-2"> 
           <input class="form-control" type="text" name="user_no" readonly id="user_no" value="<?php echo $ue_array['user_no']; ?>">
         </div>
       </div>
   
       <div class="form-group form-group-sm"> 
         <label class="col-sm-2 control-label" for="is_manager">Manager</label>
         <div class="col-sm-2"> 
           <input class="form-control" type="checkbox" <?php if($ue_array['is_manager']=='t') echo "checked"; ?> name="is_manager">
         </div>
       </div>

       <div class="form-group form-group-sm">
          <label class="col-sm-2 control-label" for="reset_pass_btn"></label>
          <div class="col-sm-2">
           <button type="button" class="btn btn-success" name="reset_pass_btn" id="reset_pass_btn">Reset Password</button>
         </div> 
       </div>

       <div class="form-group form-group-sm"> 
         <label class="col-sm-2 control-label" for="loginID">Login ID</label>
         <div class="col-sm-2"> 
           <input class="form-control" type="text" name="loginID" id="loginID" value="<?php echo $ue_array['login_id']; ?>">
         </div>
       </div>
   
       <div class="form-group form-group-sm"> 
         <label class="col-sm-2 control-label" for="full_name">Name</label>
         <div class="col-sm-2"> 
           <input class="form-control" type="text" name="full_name" id="full_name" value="<?php echo $ue_array['full_name']; ?>">
         </div>
        </div>
   
       <div class="form-group form-group-sm"> 
        <label class="col-sm-2 control-label" for="email">Email</label>
        <div class="col-sm-2"> 
          <input class="form-control" type="text" name="email" id="email" value="<?php echo $ue_array['email_address']; ?>">
        </div>
       </div>
     
       <div class="form-group form-group-sm"> 
        <label class="col-sm-2 control-label" for="phone">Phone #</label>
        <div class="col-sm-2"> 
          <input class="form-control" type="text" name="phone" id="phone" value="<?php echo $ue_array['phone_number']; ?>">
       </div>
     
      </div>
       <div class="form-group form-group-sm"> 
        <label class="col-sm-2 control-label" for="emergency">Emergency Contact</label>
        <div class="col-sm-2"> 
          <input class="form-control" type="text" name="emergency" id="emergency" value="<?php echo $ue_array['emergency_contact']; ?>">
       </div>
      </div>
     
      <div class="form-group form-group-sm"> 
        <label class="col-sm-2 control-label" for="expired">Expired</label>
        <div class="col-sm-2"> 
          <input class="form-control" type="checkbox" <?php if($ue_array['expired']=='t') echo "checked"; ?> name="expired" id="expired">
        </div>
      </div>
      <br/>
       <label class="col-sm-2 control-label" for="DR">Roles</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['de']=='1'){echo "checked";}; ?>  name="DE">Data Entry</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['ve']=='1'){echo "checked";}; ?>  name="VE">Verifier</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['clr']=='1'){echo "checked";}; ?> name="CLR">Caller</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['vm']=='1'){echo "checked";}; ?>  name="VM">Voicemail</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['tm']=='1'){echo "checked";}; ?>  name="TM">Titlematching</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['flr']=='1'){echo "checked";}; ?> name="FLR">Filer</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['fr']=='1'){echo "checked";}; ?>  name="FR">French Data Entry</label>
       <label class="checkbox-inline"><input type="checkbox" <?php if($role_array['oth']=='1'){echo "checked";}; ?>  name="OTH">Other</label>
      <br/>
       <label class="col-sm-2 control-label" for="DEPR">Role Priority</label>
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['de_rp']; ?>" name="DEPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['ve_rp']; ?>" name="VEPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['clr_rp']; ?>" name="CLRPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['vm_rp']; ?>" name="VMPR">  
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['tm_rp']; ?>" name="TMPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['flr_rp']; ?>" name="FLRPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['fr_rp']; ?>" name="FRPR">
       <input class="form-inline input-xxs" type="text" value="<?php echo $role_array['ot_rp']; ?>" name="OTHPR">

   
     <br/>
      <div class="well">
      <h3>Unavailable Days/Times</h3>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_fri']=='f') echo "checked"; ?> name="work_fri">Fri</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_sat']=='f') echo "checked"; ?> name="work_sat">Sat</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_sun']=='f') echo "checked"; ?> name="work_sun">Sun</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_mon']=='f') echo "checked"; ?> name="work_mon">Mon</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_tue']=='f') echo "checked"; ?> name="work_tue">Tue</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_wed']=='f') echo "checked"; ?> name="work_wed">Wed</label>
         <label class="checkbox-inline"><input type="checkbox" <?php if($ue_array['work_thurs']=='f') echo "checked"; ?> name="work_thurs">Thu</label>
     <br/> 
     <br/>
         <input class="form-inline input-xs" type="text" name="fri_start" value="<?php echo $ue_array['fri_start']; ?>" placeholder="FriSt">
         <input class="form-inline input-xs" type="text" name="sat_start" value="<?php echo $ue_array['sat_start']; ?>" placeholder="SatSt">
         <input class="form-inline input-xs" type="text" name="sun_start" value="<?php echo $ue_array['sun_start']; ?>" placeholder="SunSt">
         <input class="form-inline input-xs" type="text" name="mon_start" value="<?php echo $ue_array['mon_start']; ?>" placeholder="MonSt">
         <input class="form-inline input-xs" type="text" name="tue_start" value="<?php echo $ue_array['tue_start']; ?>" placeholder="TueSt">
         <input class="form-inline input-xs" type="text" name="wed_start" value="<?php echo $ue_array['wed_start']; ?>" placeholder="WedSt">
         <input class="form-inline input-xs" type="text" name="thu_start" value="<?php echo $ue_array['thurs_start']; ?>" placeholder="ThuSt">
     <br/>
         <input class="form-inline input-xs" type="text" name="fri_end" value="<?php echo $ue_array['fri_end']; ?>" placeholder="FriEnd">
         <input class="form-inline input-xs" type="text" name="sat_end" value="<?php echo $ue_array['sat_end']; ?>" placeholder="SatEnd">
         <input class="form-inline input-xs" type="text" name="sun_end" value="<?php echo $ue_array['sun_end']; ?>" placeholder="SunEnd">
         <input class="form-inline input-xs" type="text" name="mon_end" value="<?php echo $ue_array['mon_end']; ?>" placeholder="MonEnd">
         <input class="form-inline input-xs" type="text" name="tue_end" value="<?php echo $ue_array['tue_end']; ?>" placeholder="TueEnd">
         <input class="form-inline input-xs" type="text" name="wed_end" value="<?php echo $ue_array['wed_end']; ?>" placeholder="WedEnd">
         <input class="form-inline input-xs" type="text" name="thu_end" value="<?php echo $ue_array['thurs_end']; ?>" placeholder="ThuEnd">
      </div>
         <button type="submit" class="btn btn-primary" name="savebtn">Save Changes</button>
         <a href="EmployeeAdmin.php"><button type="button" class="btn" name="cancelbtn" >Cancel Changes</button></a>
     </form>
    </div>
 </body>
</html>
<script>
      $(document).on('click', '#reset_pass_btn', function(){

            var user_no = $('#user_no').val();

           if(confirm("Reset user password?")){
              alert("Password Reset");
                $.ajax({
                url:"../classes/MGRresetPassword.php",
                method:"POST",
                data:{user_no:user_no},
                dataType:"text",
                success:function(data)
                {
                }
           })
          }
       });
</script>
