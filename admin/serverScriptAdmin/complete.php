<?php
require './DataBase.php';

$data = json_decode(file_get_contents('php://input'), true);
$eventId = intval($data['event_id']);
$rating = intval($data['rating']);
$feedback = $data['feedback'];

$con = Connect_Database();

$query = "SELECT * FROM Events WHERE EventID = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $eventId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($event = mysqli_fetch_assoc($result)) {
    $insertQuery = "INSERT INTO completed_events (EventName, EventDescription, EventDate, EventTime, Location, Organizer, Rules, Rating, Feedback)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($con, $insertQuery);
    mysqli_stmt_bind_param(
        $insertStmt,
        "sssssssis",
        $event['EventName'],
        $event['EventDescription'],
        $event['EventDate'],
        $event['EventTime'],
        $event['Location'],
        $event['Organizer'],
        $event['Rules'],
        $rating,
        $feedback
    );

    if (mysqli_stmt_execute($insertStmt)) {
        $deleteQuery = "DELETE FROM Events WHERE EventID = ?";
        $deleteStmt = mysqli_prepare($con, $deleteQuery);
        mysqli_stmt_bind_param($deleteStmt, "i", $eventId);
        mysqli_stmt_execute($deleteStmt);

        echo "Event marked as completed and removed from active events.";
    } else {
        echo "Failed to mark event as completed.";
    }

    mysqli_stmt_close($insertStmt);
    mysqli_stmt_close($deleteStmt);
} else {
    echo "Event not found.";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
