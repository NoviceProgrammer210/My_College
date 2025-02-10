<?php
// Connect to your database
include './DataBase.php'; // Make sure to create this file with your database credentials

// Fetch events from the database
$query = "SELECT * FROM events ORDER BY EventDate DESC";
$result = mysqli_query($con, $query);

// Check if there are any events in the database
if (mysqli_num_rows($result) > 0) {
    $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $events = [];
}
?>
