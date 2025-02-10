<?php
require './DataBase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = intval($_GET['event_id']);
    $con = Connect_Database();

    $query = "DELETE FROM Events WHERE EventID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Event deleted successfully.";
    } else {
        echo "Failed to delete the event.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
}
?>
