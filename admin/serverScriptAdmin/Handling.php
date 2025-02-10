<?php 
require ('./Logic.php');

if(isset($_POST['add_event'])){
 add_event();
}


if(isset($_POST['status'])){
    Update_Status();
   }

?>