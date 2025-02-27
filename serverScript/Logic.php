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
            $_SESSION['Email']=$user['Email'];
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

function Register_Event() {

    $eventID = intval($_POST['EventID']);
    $eventType = $_POST['EventType']; 
    
    $con = Connect_Database();

    if ($eventType === 'Single') {
        $userID = intval($_SESSION['user_id']);
echo $_SESSION['user_id'];
echo $userID;
        $query = "INSERT INTO Participations(UserID, EventID, RegisteredAt) VALUES (?, ?, NOW())";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $userID, $eventID);

        if ($stmt->execute()) {
            echo "Registration successful for individual event!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    elseif ($eventType === 'Group') {
        $userID = intval($_SESSION['UserID']); 
        $members = json_decode($_POST['members'], true); 

        $query = "INSERT INTO Participations (UserID, EventID, RegisteredAt) VALUES (?, ?, NOW())";

        $stmt = $con->prepare($query);

        $stmt->bind_param('ii', $userID, $eventID);

        if ($stmt->execute()) {

            $participationID = $stmt->insert_id; 

            $memberQuery = "INSERT INTO TeamMembers (ParticipationID, MemberName, MemberEmail, RegisteredAt) VALUES (?, ?, ?, NOW())";
            $memberStmt = $con->prepare($memberQuery);

            foreach ($members as $member) {
                $memberName = mysqli_real_escape_string($con, $member['mem_name']);
                $memberEmail = mysqli_real_escape_string($con, $member['mem_email']);

                $memberStmt->bind_param('iss', $participationID, $memberName, $memberEmail);
                if (!$memberStmt->execute()) {
                    echo "Error adding member: " . $memberStmt->error;
                }
            }

            echo "Group registration successful!";
            $memberStmt->close();
        } else {

            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {

        echo "Invalid event type!";
    }

    $con->close();
}



?>