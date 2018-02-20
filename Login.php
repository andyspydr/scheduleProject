<?php
#Login.php
 session_start();

 if (isset($_POST['username'])) {
 
   include_once("classes/dbconnect.php"); 
 
   $username = strip_tags($_POST["username"]);
   $password = strip_tags($_POST["password"]);
   $usname = pg_escape_string($dbconn, $username);
 
   $_SESSION['login_id'] = $username;
   $sql = "SELECT user_no,full_name,login_id,password,is_manager,expired FROM users WHERE login_id='$username'";
 
   $result = pg_query($dbconn, $sql);
   $row = pg_fetch_assoc($result);
 
   $userno = $row['user_no'];
   $fullname = $row['full_name'];
   $db_uname = $row['login_id'];
   $db_password = $row['password'];
   $manager = $row['is_manager'];
   $expired = $row['expired'];

    //Check username/password correctness
    if ($username == $db_uname && password_verify($password,$db_password) && $expired != 't') { 
     //set session
      $_SESSION['username'] = $usname;
      $_SESSION['userno'] = $userno;
      $_SESSION['fullname'] = $fullname;  
      $_SESSION['is_manager'] = $manager;
   //Send to different Index Pages depending if MGR or Employee
      
      if ($manager == 't' ){
         echo "<h2>MGR login successful</h2>";
         header("Location:/admin/Index.php");
      }
      if ($manager == 'f') {
         echo "<h2>Emp login successful</h2>";  
         header("Location:Index.php"); 
      } 
    } 
    else if ($expired == 't') { 
        echo "<h2>Your account is expired. Please see Manager</h2>"; 
      }
    else if ($password != $db_password){
        $_SESSION['Bad_Credentials'] = "<h2>Wrong username or password</h2>";
        echo "<h3>Wrong username or password</h3>";
    }    
 }

?>

<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <?php include('templates/formatting.php'); ?>
 </head>
 <body>
  <div class="container">
    <div class="row">
      <div class="Absolute-Center is-Responsive">
        <div id="logo-container"></div>
        <div class="col-lg-12 col-lg-10 col-lg-offset-1">
          <form action="Login.php" method="post" id="loginForm">
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input class="form-control" type="text" name='username' placeholder="username"/>          
            </div>
            <div class="form-group input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
              <input class="form-control" type="password" name='password' placeholder="password"/>     
            </div>
  
            <div class="form-group">
              <button type="submit" class="btn btn-def btn-block">Login</button>
            </div>
            <div class="form-group text-center">
              <a href="ForgotPassword.php">Forgot/Change Password</a>
            </div>
          </form>        
      </div>  
      </div>    
    </div>
  </div>
 </body>
</html>

