<?php
require ('./DataBase.php');



function add_event()
{
    $event_name = $_POST['event_name'];
    $event_description = $_POST['event_description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = $_POST['location'];
    $organizer = $_POST['organizer'];
    $rules = $_POST['rules'];

    $con = Connect_Database();

    // Add CreatedAt with the current timestamp
    $created_at = date("Y-m-d H:i:s");

    $query = "INSERT INTO Events (EventName, EventDescription, EventDate, EventTime, Location, Organizer, Rules, CreatedAt) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if (!$stmt) {
        die("Preparation failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $event_name,
        $event_description,
        $event_date,
        $event_time,
        $location,
        $organizer,
        $rules,
        $created_at
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Event added successfully!'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Error adding event: " . mysqli_error($con) . "'); window.location.href = '../index.php';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}




function Update_Status(){
    $messageId = intval($_POST['message_id']); // Sanitize input
    $status = $_POST['status']; // Fetch the status
    $con = Connect_Database();

    // Fetch the message details
    $query = "SELECT * FROM contact_messages WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $messageId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $message = mysqli_fetch_assoc($result);

    if ($message) {
        mysqli_begin_transaction($con); // Begin a transaction
        try {
            // Update the message status in `contact_messages`
            $updateQuery = "UPDATE contact_messages SET status = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "si", $status, $messageId);
            mysqli_stmt_execute($updateStmt);

            if ($status === "Read") {
                // Save the message to the `history` table
                $insertQuery = "INSERT INTO history (name, email, message, status) VALUES (?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($con, $insertQuery);
                mysqli_stmt_bind_param($insertStmt, "ssss", $message['name'], $message['email'], $message['message'], $status);
                mysqli_stmt_execute($insertStmt);

                // Delete the message from `contact_messages`
                $deleteQuery = "DELETE FROM contact_messages WHERE id = ?";
                $deleteStmt = mysqli_prepare($con, $deleteQuery);
                mysqli_stmt_bind_param($deleteStmt, "i", $messageId);
                mysqli_stmt_execute($deleteStmt);
            }

            mysqli_commit($con); // Commit the transaction
            echo "<script>alert('Message status updated and saved to history!'); window.location.href = '../index.php';</script>";
        } catch (Exception $e) {
            mysqli_rollback($con); // Rollback the transaction on error
            echo "<script>alert('An error occurred: " . addslashes($e->getMessage()) . "'); window.location.href = '../index.php';</script>";
        }
    } else {
        echo "<script>alert('Message not found.'); window.location.href = '../index.php';</script>";
    }

    // Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} 
    




?>