<?php
session_start();
require('./DataBase.php'); // Adjust the path as needed

if (!isset($_SESSION['user_id'])) {
    die('<script>alert("You need to log in to view your participated events."); window.location.href="./login.php";</script>');
}

$userID = intval($_SESSION['user_id']);
$con = Connect_Database();

    $query = "
    SELECT 
        P.ParticipationID,
        P.RegisteredAt,
        E.EventName,
        E.EventDescription,
        E.EventDate,
        E.Location
    FROM 
        Participations P
    JOIN 
        Events E ON P.EventID = E.EventID
    WHERE 
        P.UserID = ?
    ORDER BY 
        P.RegisteredAt DESC";

$stmt = $con->prepare($query);

if (!$stmt) {
    die("Database error: " . $con->error);
}

$stmt->bind_param('i', $userID);
$stmt->execute();
$result = $stmt->get_result();

$participations = [];
while ($row = $result->fetch_assoc()) {
    $participations[] = $row;
}

$stmt->close();
$con->close();

echo json_encode($participations);
?>
