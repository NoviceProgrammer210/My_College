<?php
require './DataBase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the event_id from POST data
    $eventId = intval($_POST['event_id']); // Use POST instead of GET

    if (!$eventId) {
        echo "Invalid Event ID.";
        exit;
    }

    $con = Connect_Database();

    $query = "DELETE FROM Events WHERE EventID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventId);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Event deleted successfully!'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Failed to delete the event. Please try again.'); window.location.href = '../index.php';</script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
