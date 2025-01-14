<?php 
function Connect_Database(){
    $server ="localhost";
    $username= "root";
    $pass = "";
    $db = 'College_Event';
    $con = mysqli_connect($server,$username,$pass,$db);
    
    if($con){
        return $con;
        echo "<script>Console.log('Connected</script>";
    
    }else{
        echo "Not connected";
    }}
    

?>