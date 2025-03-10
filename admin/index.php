<?php
require './serverScriptAdmin/DataBase.php'; // Ensure your database connection file is included

$con = Connect_Database(); // Connect to the database

$query = "SELECT EventID, EventName, EventDescription, EventDate, EventTime, Location, Organizer, CreatedAt, Rules FROM Events";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 ">

<header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <a href="view.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">View Participants</a>
            <a href="#add-event" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Add Event</a>
        </div>
    </header>


    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Event List</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $con = Connect_Database();
        $query = "SELECT * FROM Events ORDER BY CreatedAt DESC";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $eventType = $row['EventType'];
            $maxParticipants = $eventType === 'Group' ? " | Max Participants: {$row['MaxParticipants']}" : "";
            $eventID = $row['EventID']; // Store the event ID in a variable to concatenate
            echo '
            <div class="bg-gray-800 bg-opacity-80 shadow-md rounded-lg overflow-hidden">
                <div class="p-4">
                    <h3 class="text-xl font-bold text-white">' . $row['EventName'] . '</h3>
                    <p class="mt-2 text-gray-300"><strong>Type:</strong> ' . $eventType . $maxParticipants . '</p>
                    <p class="mt-2 text-gray-300"><strong>Date:</strong> ' . $row['EventDate'] . ' | <strong>Time:</strong> ' . $row['EventTime'] . '</p>
                    <p class="mt-2 text-gray-300"><strong>Location:</strong> ' . $row['Location'] . '</p>
                    <button onclick="viewDetails(' . $eventID . ')" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Read More</button>
                </div>
            </div>
            ';
        }
        

        mysqli_close($con);
        ?>
    </div>





    <div id="eventModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
            <h3 id="modalEventName" class="text-2xl font-bold mb-4"></h3>
            <p id="modalEventType" class="text-gray-300 mb-4"></p>
            <p id="modalEventDescription" class="text-gray-300 mb-4"></p>
            <p id="modalEventDetails" class="text-gray-300 mb-4"></p>
            <p id="modalEventRules" class="text-gray-300 mb-4"></p>
            <div class="flex justify-between">
                <button onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Close</button>
                <button onclick="deleteEvent()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Event</button>
                <button onclick="markEventCompleted()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Mark as Completed</button>
            </div>
        </div>
    </div>
</section>


    <section id="add-event" class="container mx-auto py-12">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Add Event</h2>
    <form method="POST" action="./serverScriptAdmin/Handling.php" enctype="multipart/form-data" class="max-w-xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <div class="mb-4">
            <label for="event_name" class="block text-gray-700 font-medium">Event Name</label>
            <input type="text" id="event_name" name="event_name" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="event_description" class="block text-gray-700 font-medium">Event Description</label>
            <textarea id="event_description" name="event_description" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>
        <div class="mb-4">
            <label for="event_date" class="block text-gray-700 font-medium">Event Date</label>
            <input type="date" id="event_date" name="event_date" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="event_time" class="block text-gray-700 font-medium">Event Time</label>
            <input type="time" id="event_time" name="event_time" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="location" class="block text-gray-700 font-medium">Location</label>
            <input type="text" id="location" name="location" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="organizer" class="block text-gray-700 font-medium">Organizer</label>
            <input type="text" id="organizer" name="organizer" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="rules" class="block text-gray-700 font-medium">Rules</label>
            <textarea id="rules" name="rules" class="w-full px-4 py-2 border rounded focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
        
        <div class="text-center">
            <button type="submit" name="add_event" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Add Event</button>
        </div>
    </form>
</section>


</body>


<script>
let currentEvent = null;
function markEventCompleted() {
    const rating = prompt("Rate this event out of 10:");
    if (!rating || rating < 1 || rating > 10) {
        alert("Invalid rating. Please provide a number between 1 and 10.");
        return;
    }

    const feedback = prompt("Please provide feedback for the event:");
    if (!feedback) {
        alert("Feedback cannot be empty.");
        return;
    }

    if (confirm("Are you sure you want to mark this event as completed?")) {
        fetch(`./serverScriptAdmin/complete.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                event_id: currentEvent,
                rating: rating,
                feedback: feedback,
            }),
        })
            .then(response => response.text())
            .then(result => {
                alert(result);
                location.reload();
            });
    }
}

function viewDetails(eventID) {
    console.log("viewDetails called with eventID:", eventID);
    currentEvent = eventID;

    fetch(`./serverScriptAdmin/get_event_details.php?event_id=${eventID}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(event => {
            if (event.error) {
                console.error("Error in response:", event.error);
                return;
            }
            console.log("Fetched event details:", event);

            document.getElementById("modalEventName").innerText = event.EventName || "N/A";
            
            document.getElementById("modalEventDescription").innerText = `Description: ${event.EventDescription || "No description available."}`;
            document.getElementById("modalEventDetails").innerText = `Date: ${event.EventDate} | Time: ${event.EventTime} | Location: ${event.Location}`;
            document.getElementById("modalEventRules").innerText = `Rules: ${event.Rules || "No rules specified."}`;
            document.getElementById("eventModal").classList.remove("hidden");
        })
    }


    function closeModal() {
    const modal = document.getElementById("eventModal");
    modal.classList.add("hidden"); // Hide the modal by adding the 'hidden' class
}


</script>

</html>
