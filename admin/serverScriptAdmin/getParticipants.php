<?php
// Connect to the database
require_once('./DataBase.php');
$con = Connect_Database();

$eventID = intval($_GET['EventID']);

// Fetch participants for the selected event, along with user details
$query = "
    SELECT p.ParticipationID, u.name, u.Email, p.RegisteredAt 
    FROM Participations p
    JOIN Users u ON p.UserID = u.UserID
    WHERE p.EventID = ?";
$stmt = $con->prepare($query);

if (!$stmt) {
    die("Prepare failed: " . $con->error);
}

$stmt->bind_param('i', $eventID);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any participants
if ($result->num_rows === 0) {
    echo "<tr><td colspan='5' class='text-center py-2'>No participants found for this event.</td></tr>";
    exit;
}

// Generate table rows
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['ParticipationID']) . "</td>";
    echo "<td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['UserName']) . "</td>";
    echo "<td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['Email']) . "</td>";
    echo "<td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['RegisteredAt']) . "</td>";
   
    echo "</tr>";
}

$stmt->close();
$con->close();
?>
