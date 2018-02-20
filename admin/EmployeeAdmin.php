<?php
#EmployeeAdmin.php

 include("../classes/dbconnect.php");
 include("../classes/User.php");
 include('../classes/Session.php');

 $sess = new Session();
 $sess->checkSession();
 $sess->checkMgrSession();


 $user = new User();
 $result = $user->getEmployeeAdmin();


?>

<!DOCTYPE html>
<html>
 <head>
   <title>Employee Dashboard</title>
   <?php include('../templates/formatting.php');?>
 </head>

 <body>
  <?php include('../templates/header.php'); ?> 
  <h1>Employee Dashboard</h1>
   <?php include '../templates/navbarMgr.php'; ?>
   <br/>
   <br/>
     <table id="admintable" class="Display" width="100%"> 
        <thead>
           <tr>
             <th class="hidden"></th>
             <th>Login ID</th>
             <th>Name</th>
             <th>Email address</th>
             <th>Phone Number</th> 
             <th>Roles</th>
             <th>Days Unavailable</th>
             <th>Expired</th>
           </tr>
        </thead>
        <tbody>
          <?php
          while ($row = pg_fetch_assoc($result)) {
            ?>
              <tr>
                 <td class="hidden"><?php echo $row['user_no']; ?></td>
                 <td><a href="EmployeeEdit.php?user_no=<?php echo $row['user_no'] ?>"><?php echo $row['login_id']; ?></td>
                 <td><?php echo $row['full_name']; ?></td>
                 <td><?php echo $row['email_address']; ?></td>
                 <td><?php echo $row['phone_number']; ?></td>
                 <td><?php echo $row['roles']; ?></td>
                 <td><?php echo $row['unavailable']; ?></td>
                 <td><?php echo $row['expired']; ?></td>
             </tr>
            <?php
          }
          ?>
        </tbody>
     </table>
   <script>
    $(document).ready( function () {
       $('#admintable').DataTable();
   } );
   </script>
      <a href="CreateUser.php" onClick="return confirm('Create new User?')">Create New User</a>
 </body>
</html>
