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
    $eventType = $_POST['EventType']; // 'Single' or 'Group'

    $con = Connect_Database();

    if ($eventType === 'Single') {
        $userID = intval($_SESSION['UserID']); // Assuming logged-in user info is stored in session

        // Insert participation record for individual
        $query = "INSERT INTO Participation (UserID, EventID) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $userID, $eventID);

        if ($stmt->execute()) {
            echo "Registration successful for individual event!";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    // Handle Group Registration
    elseif ($eventType === 'Group') {
        $userID = intval($_SESSION['UserID']); // Team leader (logged-in user)
        $members = json_decode($_POST['members'], true); // Array of members with name and email

        // Insert team leader's participation
        $query = "INSERT INTO Participations (UserID, EventID) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $userID, $eventID);

        if ($stmt->execute()) {
            $teamID = $stmt->insert_id;

            // Insert team members into TeamMembers table
            $memberQuery = "INSERT INTO TeamMembers (TeamID, MemberName, MemberEmail) VALUES (?, ?, ?)";
            $memberStmt = $con->prepare($memberQuery);

            foreach ($members as $member) {
                $memberName = mysqli_real_escape_string($con, $member['name']);
                $memberEmail = mysqli_real_escape_string($con, $member['email']);
                $memberStmt->bind_param('iss', $teamID, $memberName, $memberEmail);
                $memberStmt->execute();
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