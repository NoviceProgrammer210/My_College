<?php 


require_once('./Logic.php');



if (isset($_POST['register'])){
  Register();
}

if (isset($_POST['login'])){
    login();
  }
  

?>