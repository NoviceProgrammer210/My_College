<?php
require('./DataBase.php');

// Check if EventID is provided
if (!isset($_GET['EventID'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'EventID is required']);
    exit;
}

// Sanitize and validate EventID
$eventID = intval($_GET['EventID']);

// Connect to the database
$con = Connect_Database();
if (!$con) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to connect to the database']);
    exit;
}

// Prepare the query
$query = "SELECT * FROM completed_events WHERE CompletedEventID = ?";
$stmt = $con->prepare($query);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Failed to prepare the query']);
    exit;
}

// Bind and execute
$stmt->bind_param('i', $eventID);
$stmt->execute();
$result = $stmt->get_result();

// Check if the event exists
if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'event' => $event]);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Event not found']);
}

// Close connections
$stmt->close();
$con->close();
?>
