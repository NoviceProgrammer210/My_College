<?php 
session_start();

include('./DataBase.php');


function Register(){
    $con = Connect_Database();
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    $checkEmailQuery = "SELECT * FROM Users WHERE Email='$email'";
    $result = mysqli_query($con, $checkEmailQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered.";
    } else {
        $insertQuery = "INSERT INTO Users (Name, Email, Password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($con, $insertQuery)) {
            echo "<script>alert('Registration successful!')</script>";
            header("Location: ../index.php");
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}


function login(){
    $con = Connect_Database();
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['Password'])) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['user_name'] = $user['Name'];
            header("Location: ../menu.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "<h1>User with this email does not exist.</h1>";
    }
}

?>