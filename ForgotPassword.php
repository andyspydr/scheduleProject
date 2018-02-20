<?php
#ForgotPassword.php

if (isset($_POST['username'])) {

  include_once("classes/dbconnect.php");


   $username = strip_tags($_POST["username"]);
   $usname = pg_escape_string($dbconn, $username);
   $sql = "SELECT login_id,email_address,expired FROM users WHERE login_id='$usname';";
   $result =  pg_query($dbconn, $sql);
   $row = pg_fetch_row($result);
   $db_uname     = $row[0];
   $emailaddress = $row[1];
   $expired      = $row[2];

  
   if ($expired == 't'){
    echo "<h3>Your account is expired. Please see manager.</h3>";
   }
   else if ($db_uname != $usname){
    echo "<h3>Incorrect username</h3>";
   }
   else {  
   
    //Generate random code for insertion into db user for verification
    $code = rand(10000,1000000);

    $reset_sql = "UPDATE users set reset_code='$code' WHERE login_id='$db_uname';";
    //update user with reset code
    pg_query($dbconn, $reset_sql);
  
    //send email
    $to = $emailaddress;
    $from = 'noreply@testing.com';
    $subject = "Password reset for $db_uname";
    $body = "

       Click the link below to reset password
       http://66.171.249.131/ChangePassword.php?code=$code&username=$db_uname

     ";

   if (mail($to,$subject,$body)){
    echo "<h3>Email sent successfully. Please click link in email to reset password.</h3>";
   }
   else {
     echo "There was a problem";
   }  

   } 

}   
   
?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <title>Forgot Password</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
 <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div class="container">
   <div class="row">

     <div class="Absolute-Center is-Responsive">
         <div class="text-center">
           <p>Enter your username and a password reset will be sent to your email address on file</p>
         </div>
       <div class="col-sm-12 col-md-10 col-md-offset-2">
         <form action="ForgotPassword.php" method='POST' id="chgpassForm">
           <div class="text-center">
             <input class="form-control" type="text" name='username' placeholder="username"/>          
           </div>

           <div class="text-center">
             <button type="submit" class="btn btn-def btn-block">Submit</button>
           </div>
           <div class="text-center">
              <a href="Login.php">Back</a>
           </div>

         </form>        
       </div>  
     </div>    
   </div>
  </div>

 </body>
</html>
