<?php
#ChangePassword.php

include('classes/User.php');

$user = new User();

$reset = pg_escape_string($_GET["code"]);
$uname = pg_escape_string($_GET["username"]);


if (isset($_POST['newPass'])){

   $newPass = pg_escape_string($_POST["newPass"]);
   $verifyPass = pg_escape_string($_POST["verifyPass"]);

    if ($newPass == $verifyPass && $newPass != ''){
    
       $user->changePassword($uname,$reset,$newPass);     
       echo "Password updated Successfully";   
       header("Location:Login.php");

    }
    else{
       echo "Password not changed. Please try again";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <?php include('templates/formatting.php'); ?>
 </head>
 <body>
  <div class="container">
    <div class="row">
      <div class="Absolute-Center is-Responsive">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
          <form action="ChangePassword.php?code=<?php echo $reset; ?>&username=<?php echo $uname; ?>" method="post" id="chgpassForm">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input class="form-control" type="password" name="newPass" id="newPass" placeholder="Enter New Password"/>          
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-ok-sign"></i></span>
              <input class="form-control" type="password" name="verifyPass" id="verifyPass" placeholder="Re-enter Password"/>     
              <span id="message"></span>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-def btn-block">Submit</button>
            </div>
          </form>        
      </div>  
     </div>    
    </div>
  </div>
 </body>
</html>
<script>
  $('#verifyPass').on('keyup', function () {
      if ($(this).val() == $('#newPass').val()) {
          $('#message').html('matching').css('color', 'green');
      } else $('#message').html('not matching').css('color', 'red');
  });
</script>
