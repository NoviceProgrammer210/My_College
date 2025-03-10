<?php
require('./DataBase.php');

if (!isset($_GET['event_id'])) {
    echo json_encode(['error' => 'event_id is required']);
    exit;
}

$eventID = intval($_GET['event_id']);
$con = Connect_Database();

$query = "SELECT * FROM Events WHERE EventID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('i', $eventID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    echo json_encode($event);
} else {
    echo json_encode(['error' => 'Event not found']);
}

$stmt->close();
$con->close();
?>
