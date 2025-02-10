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


function send_message(){

    $conn =Connect_Database();


    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


function Register_Event(){
    $con = Connect_Database();
    $userName = $_SESSION['user_name'];

    $getIdQuery = "SELECT UserID FROM Users WHERE UserName = ?";
    $stmt = mysqli_prepare($con, $getIdQuery);
    mysqli_stmt_bind_param($stmt, "s", $userName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $userID = $row['UserID']; 
    } else {
        echo "<script>alert('User not found. Please log in again.'); window.location.href = '../index.php';</script>";
        exit;
    }
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please log in to register for events.'); window.location.href = '../index.php';</script>";
        exit;
    }

    $userID = $_SESSION['user_id']; // User ID from the session
    $eventID = intval($_POST['EventID']); // Event ID from the form submission

    $con = Connect_Database();

    $checkQuery = "SELECT * FROM participation WHERE UserID = ? AND EventID = ?";
    $checkStmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "ii", $userID, $eventID);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('You are already registered for this event.'); window.location.href = '../menu.php';</script>";
        exit;
    }

    // Insert the registration into the `participation` table
    $query = "INSERT INTO participation (UserID, EventID) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userID, $eventID);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registration successful!'); window.location.href = '../menu.php';</script>";
    } else {
        echo "<script>alert('Failed to register. Please try again.'); window.location.href = '../menu.php';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}





?>