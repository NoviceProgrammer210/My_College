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
            <!-- <a href="logout.php" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700">Logout</a> -->
        </div>
    </header>

    <!-- Main Content -->
    <div class="container mx-auto py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Messages Section -->
            <section class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4">Messages</h2>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Email</th>
                                <th class="border border-gray-300 px-4 py-2">Message</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require('./serverScriptAdmin/DataBase.php');
                            $con = Connect_Database();

                            $query = "SELECT id, name, email, message, status FROM contact_messages";
                            $result = mysqli_query($con, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>
                                            <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>
                                            <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>
                                            <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['message']) . "</td>
                                            <td class='border border-gray-300 px-4 py-2'>" . htmlspecialchars($row['status']) . "</td>
                                            <td class='border border-gray-300 px-4 py-2 text-center'>
                                                <form action='./serverScriptAdmin/Handling.php' method='post'>
                                                    <input type='hidden' name='message_id' value='" . $row['id'] . "'>
                                                    <button type='submit' name='status' value='Read' class='bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700'>Mark Read</button>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='border border-gray-300 px-4 py-2 text-center'>No messages found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add Event Section -->
            <section id="add-event" class="container mx-auto py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Add Event</h2>
    <form method="POST" action="./serverScriptAdmin/Handling.php" enctype="multipart/form-data" class="max-w-lg mx-auto bg-gray-800 bg-opacity-80 p-6 shadow-md rounded-lg">
        <div class="mb-4">
            <label for="event_name" class="block text-white">Event Name</label>
            <input type="text" id="event_name" name="event_name" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="event_description" class="block text-white">Event Description</label>
            <textarea id="event_description" name="event_description" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required></textarea>
        </div>
        <div class="mb-4">
            <label for="event_date" class="block text-white">Event Date</label>
            <input type="date" id="event_date" name="event_date" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="event_time" class="block text-white">Event Time</label>
            <input type="time" id="event_time" name="event_time" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="location" class="block text-white">Location</label>
            <input type="text" id="location" name="location" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="organizer" class="block text-white">Organizer</label>
            <input type="text" id="organizer" name="organizer" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label for="rules" class="block text-white">Rules</label>
            <textarea id="rules" name="rules" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500"></textarea>
        </div>
        <div class="mb-4">
            <label for="event_type" class="block text-white">Event Type</label>
            <select id="event_type" name="event_type" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" onchange="toggleMaxParticipants()" required>
                <option value="Single">Single</option>
                <option value="Group">Group</option>
            </select>
        </div>
        <div class="mb-4 hidden" id="max_participants_container">
            <label for="max_participants" class="block text-white">Maximum Participants (Group Event Only)</label>
            <input type="number" id="max_participants" name="max_participants" min="1" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- New Poster Input -->
        <div class="mb-4">
            <label for="event_poster" class="block text-white">Event Poster</label>
            <input type="file" id="event_poster" name="event_poster" accept="image/*" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required onchange="previewPoster()">
            <div id="poster_preview" class="mt-4 hidden">
                <img id="poster_image" src="#" alt="Poster Preview" class="w-full h-auto rounded-lg shadow-lg">
            </div>
        </div>
        <button type="submit" name="add_event" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Add Event</button>
    </form>
</section>

<script>
    function toggleMaxParticipants() {
        const eventType = document.getElementById('event_type').value;
        const maxParticipantsContainer = document.getElementById('max_participants_container');
        if (eventType === 'Group') {
            maxParticipantsContainer.classList.remove('hidden');
        } else {
            maxParticipantsContainer.classList.add('hidden');
        }
    }

    function previewPoster() {
        const posterInput = document.getElementById('event_poster');
        const posterPreview = document.getElementById('poster_preview');
        const posterImage = document.getElementById('poster_image');

        if (posterInput.files && posterInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                posterImage.src = e.target.result;
                posterPreview.classList.remove('hidden');
            };
            reader.readAsDataURL(posterInput.files[0]);
        }
    }
</script>


<section id="view-events" class="container mx-auto py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Event List</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        $con = Connect_Database();
        $query = "SELECT * FROM Events ORDER BY CreatedAt DESC";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $eventType = $row['EventType'];
            $maxParticipants = $eventType === 'Group' ? " | Max Participants: {$row['MaxParticipants']}" : "";
            echo "
            <div class='bg-gray-800 bg-opacity-80 shadow-md rounded-lg overflow-hidden'>
                <div class='p-4'>
                    <h3 class='text-xl font-bold text-white'>{$row['EventName']}</h3>
                    <p class='mt-2 text-gray-300'><strong>Type:</strong> {$eventType}{$maxParticipants}</p>
                    <p class='mt-2 text-gray-300'><strong>Date:</strong> {$row['EventDate']} | <strong>Time:</strong> {$row['EventTime']}</p>
                    <p class='mt-2 text-gray-300'><strong>Location:</strong> {$row['Location']}</p>
                    <button onclick=\"viewDetails({$row['EventID']})\" class='mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'>Read More</button>
                </div>
            </div>
            ";
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




            <section class="container mx-auto py-16 px-4">
                <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Message History</h2>

                <!-- Search Bar -->
                <div class="mb-4 flex justify-center">
                    <input
                        type="text"
                        id="search"
                        class="w-1/2 px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500"
                        placeholder="Search by Name, Email, or Message">
                    <button
                        onclick="searchHistory()"
                        class="ml-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Search
                    </button>
                </div>

                <!-- History Table -->
                <div id="historyTable" class="overflow-x-auto bg-gray-800 rounded-lg">
                    <table class="table-auto w-full text-left text-white">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Message</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Marked Read At</th>
                            </tr>
                        </thead>
                        <tbody id="historyData">
                            <?php
                            $con = Connect_Database();
                            $historyQuery = "SELECT * FROM history";
                            $historyResult = mysqli_query($con, $historyQuery);

                            while ($row = mysqli_fetch_assoc($historyResult)) {
                                echo "<tr class='border-t border-gray-700'>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($row['message']) . "</td>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td class='px-4 py-2'>" . htmlspecialchars($row['marked_read_at']) . "</td>";
                                echo "</tr>";
                            }

                            mysqli_close($con);
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</body>
<script>

let currentEventId = null;

function toggleMaxParticipants() {
    const eventType = document.getElementById("event_type").value;
    const maxParticipantsContainer = document.getElementById("max_participants_container");

    if (eventType === "Group") {
        maxParticipantsContainer.classList.remove("hidden");
    } else {
        maxParticipantsContainer.classList.add("hidden");
        document.getElementById("max_participants").value = ''; // Clear value
    }
}


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
                event_id: currentEventId,
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
    fetch(`./serverScriptAdmin/get_event_details.php?event_id=${eventID}`)
        .then(response => response.json())
        .then(event => {
            document.getElementById("modalEventName").innerText = event.EventName;
            document.getElementById("modalEventType").innerText = `Type: ${event.EventType}`;
            if (event.EventType === "Group" && event.MaxParticipants) {
                document.getElementById("modalEventType").innerText += ` | Max Participants: ${event.MaxParticipants}`;
            }
            document.getElementById("modalEventDescription").innerText = `Description: ${event.EventDescription}`;
            document.getElementById("modalEventDetails").innerText = `Date: ${event.EventDate} | Time: ${event.EventTime} | Location: ${event.Location}`;
            document.getElementById("modalEventRules").innerText = `Rules: ${event.Rules}`;
            document.getElementById("eventModal").classList.remove("hidden");
        })
        .catch(error => console.error("Error fetching event details:", error));
}

function closeModal() {
    document.getElementById("eventModal").classList.add("hidden");
}

function deleteEvent() {
    if (confirm('Are you sure you want to delete this event?')) {
        fetch(`./serverScriptAdmin/delete_event.php?event_id=${currentEventId}`, {
            method: 'POST',
        })
            .then(response => response.text())
            .then(result => {
                alert(result);
                location.reload();
            });
    }
}



    function searchHistory() {
        const searchInput = document.getElementById('search').value.toLowerCase();
        const tableRows = document.querySelectorAll('#historyData tr');

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>


</html>