<?php

class Session {



 static function checkSession(){

   session_start();

    if (empty ($_SESSION['userno'])){

         header('location:Login.php');


    }


 }


 static function checkMgrSession(){


    if ($_SESSION['is_manager'] == 'f'){

         header('location:../Index.php');


    }


 }





}

?>
