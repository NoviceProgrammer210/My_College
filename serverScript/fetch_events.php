<?php
require('./DataBase.php');


if (isset($_GET['EventID'])) {
    $eventID = intval($_GET['EventID']);
    $con = Connect_Database();

    // Fetch event details
    $query = "SELECT * FROM Events WHERE EventID = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row); 
    } else {
        echo json_encode(["error" => "Event not found"]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    echo json_encode(["error" => "Invalid EventID"]);
}



?>
