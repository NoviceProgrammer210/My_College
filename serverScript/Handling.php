<?php 


include('./Logic.php');



if (isset($_POST['register'])){
  Register();
}

if (isset($_POST['login'])){
    login();
  }
  
if(isset($_POST['send_message'])){
    send_message();
}


if(isset($_POST['event_reg'])){
  Register_Event();
}

?>