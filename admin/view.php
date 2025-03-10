<?php require('./serverScriptAdmin/DataBase.php');
$con =Connect_Database();

$eventsQuery = "SELECT EventID, EventName FROM Events";
$eventsResult = $con->query($eventsQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Admin Panel</h1>
            <a href="view.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">View Participants</a>
            <a href="#add-event" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Add Event</a>
            <a href="index.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Go Home</a>
        </div>
    </header>



    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Admin - View Participants by Event</h1>

<!-- Events Section -->
<div id="events-section" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($event = $eventsResult->fetch_assoc()) { ?>
        <div 
            class="bg-white rounded-lg shadow-lg p-6 hover:bg-gray-100 cursor-pointer transition-all"
            onclick="viewParticipants(<?php echo $event['EventID']; ?>)">
            <h3 class="text-xl font-semibold text-gray-700 mb-2"><?php echo htmlspecialchars($event['EventName']); ?></h3>
            <p class="text-sm text-gray-500">
                <?php echo htmlspecialchars($event['EventDate']); ?> at <?php echo htmlspecialchars($event['EventTime']); ?>
            </p>
            <p class="text-sm text-gray-500">Location: <?php echo htmlspecialchars($event['Location']); ?></p>
            <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                View Participants
            </button>
        </div>
    <?php } 
    
    ini_set('display_errors', 1);
error_reporting(E_ALL);

    ?>
</div>

<!-- Participants Section -->
<div id="participants-section" class="mt-8 hidden">
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Participants</h2>
    <div class="mb-4">
        <input 
            type="text" 
            id="search" 
            placeholder="Search participants..." 
            class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
            onkeyup="filterTable()"
        >
    </div>
    <div class="overflow-x-auto">
        <table id="participants-table" class="min-w-full border border-gray-300 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">Participation ID</th>
                    <th class="border border-gray-300 px-4 py-2">User ID</th>
                    <th class="border border-gray-300 px-4 py-2">User Email</th>
                    <th class="border border-gray-300 px-4 py-2">Registered At </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <button 
        class="mt-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600"
        onclick="hideParticipants()">
        Back
    </button>
</div>



<script>
    function viewParticipants(eventID) {
        // Fetch participants for the selected event
        const xhr = new XMLHttpRequest();
        xhr.open("GET", `./serverScriptAdmin/getParticipants.php?EventID=${eventID}`, true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                const participantsSection = document.getElementById("participants-section");
                const participantsTable = document.getElementById("participants-table").querySelector("tbody");

                participantsTable.innerHTML = xhr.responseText;
                participantsSection.classList.remove("hidden");
            } else {
                alert("Failed to load participants. Please try again.");
            }
        };
        xhr.send();
    }

    function hideParticipants() {
        document.getElementById("participants-section").classList.add("hidden");
    }

    function filterTable() {
        const searchInput = document.getElementById("search").value.toLowerCase();
        const rows = document.querySelectorAll("#participants-table tbody tr");

        rows.forEach(row => {
            const cells = row.querySelectorAll("td");
            const matches = Array.from(cells).some(cell =>
                cell.textContent.toLowerCase().includes(searchInput)
            );
            row.style.display = matches ? "" : "none";
        });
    }
</script>

</body>

</html>