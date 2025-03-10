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

function login() {
    session_start(); // Start the session

    $con = Connect_Database();
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM Users WHERE Email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['Password'])) {
            $_SESSION['logged_in'] = TRUE;
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['user_name'] = $user['Name'];
            $_SESSION['Email'] = $user['Email'];

            // Debugging session data
            echo "Login successful. Session variables:";
            print_r($_SESSION);

            // Redirect to menu page
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
        header("Location: ../menu.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
function Register_Event() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo '<script>alert("Please log in to register for the event."); window.location.href="../login.php";</script>';
        exit;
    }
    $eventID = intval($_POST['EventID']);
    $userID = intval($_SESSION['user_id']);

        $con = Connect_Database();

    if (!$con) {
        echo '<script>alert("Failed to connect to the database."); window.location.href="../menu.php";</script>';
        exit;
    }
    echo 'infi';

    $eventCheckQuery = "SELECT COUNT(*) as count FROM Events WHERE EventID = ?";
    $eventCheckStmt = $con->prepare($eventCheckQuery);
    
    if (!$eventCheckStmt) {
        die('Prepare failed: ' . $con->error);
    }
    
    $eventCheckStmt->bind_param('i', $eventID);
    $eventCheckStmt->execute();
    $eventCheckResult = $eventCheckStmt->get_result();
    $eventRow = $eventCheckResult->fetch_assoc();
    echo $eventID;
        if ($eventRow['count'] === 0) {
        echo '<script>alert("Invalid EventID. This event does not exist. "); window.location.href="../menu.php";</script>';
        exit;
    }
    $eventCheckStmt->close();
    
    // Check if the user is already registered for the event
    $checkQuery = "SELECT COUNT(*) as count FROM Participations WHERE UserID = ? AND EventID = ?";
    $checkStmt = $con->prepare($checkQuery);

    if (!$checkStmt) {
        echo '<script>alert("An error occurred while checking registration. Please try again later."); window.location.href="../menu.php";</script>';
        exit;
    }

    $checkStmt->bind_param('ii', $userID, $eventID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $row = $checkResult->fetch_assoc();

    if ($row['count'] > 0) {
        $checkStmt->close();
        echo '<script>alert("You are already registered for this event."); window.location.href="../menu.php";</script>';
        exit;
    }
    
    $checkStmt->close();

    // Insert the new registration into the database
    $query = "INSERT INTO Participations(UserID, EventID, RegisteredAt) VALUES (?, ?, NOW())";
    $stmt = $con->prepare($query);

    if (!$stmt) {
        echo '<script>alert("Failed to prepare registration. Please try again later."); window.location.href="../menu.php";</script>';
        exit;
    }
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    

    $stmt->bind_param('ii', $userID, $eventID);

    if ($stmt->execute()) {

        echo '<script>alert("Successfully registered for the event!"); window.location.href="../menu.php";</script>';
    } else {

        echo '<script>alert("Registration failed. Please try again later."); window.location.href="../menu.php";</script>';
    }

    $stmt->close();
    $con->close();
}

    




?>