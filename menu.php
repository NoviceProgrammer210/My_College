<?php 
session_start();
require('./serverScript/Logic.php');
$name = $_SESSION['user_name'] ;
$email = $_SESSION['Email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100 bg-cover bg-center" style="background-image: url('./Images/rachel-coyne-U7HLzMO4SIY-unsplash.jpg');">
<nav class="bg-gray-900 bg-opacity-75 p-4 fixed top-0 w-full z-10">
    <div class="container mx-auto flex justify-between items-center">
        <a href="#" class="text-white text-xl font-bold flex items-center">
            <i class="fas fa-graduation-cap mr-2"></i> CollegeHub
        </a>
        <button id="menu-btn" class="text-white md:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <ul id="menu" class="hidden md:flex space-x-4">
            <li><a href="#" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-home mr-2"></i> Home</a></li>
            <li><a href="#events" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-calendar-alt mr-2"></i> Events</a></li>
            <li><a href="#about" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-info-circle mr-2"></i> About</a></li>
            <li><a href="#contact" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-envelope mr-2"></i> Contact</a></li>
            <li><a href="./logout.php" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
        </ul>
    </div>
</nav>


    <section class="relative bg-cover bg-center text-white text-center py-28 px-4">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-60"></div>
        <div class="relative z-10">
            <h1 class="text-5xl font-bold">Welcome <?php echo $name;  ?></h1>
            <p class="mt-4 text-lg md:text-xl">Your one-stop solution for managing college events effortlessly</p>
            <a href="#events" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Explore Events</a>
        </div>
    </section>

    <section id="Complete_events" class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-bold text-center text-gray-100 mb-12 tracking-wide">Completed Events</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        require_once('./serverScript/DataBase.php');
         $query = "SELECT * FROM completed_events ORDER BY EventDate DESC limit 3";
         $con = Connect_Database();
         $result = mysqli_query($con, $query);
         
         if (mysqli_num_rows($result) > 0) {
             $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
         } else {
             $events = [];
             
         }
         if($events!=[]){
        foreach ($events as $event): ?>
            <div class="bg-gray-800 bg-opacity-90 shadow-lg rounded-xl overflow-hidden transition-transform transform hover:scale-105">
                <img src="https://via.placeholder.com/400x200" alt="Event" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-2xl font-semibold text-white"><?= htmlspecialchars($event['EventName']) ?></h3>
                    <p class="mt-3 text-gray-300 leading-relaxed"><?= htmlspecialchars($event['EventDescription']) ?></p>
                    <button 
                        onclick="openEventModal(<?php echo htmlspecialchars($event['EventID']); ?>)" 
                        class="mt-6 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        Read More
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div><?php }else{
        echo "<h1>No Completed Events</h1>";
    } ?>

  



    <section id="events" class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-bold text-center text-gray-100 mb-12 tracking-wide">Upcoming Events</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        require_once('./serverScript/DataBase.php');
         $query = "SELECT * FROM Events ORDER BY EventDate DESC";
         $con = Connect_Database();
         $result = mysqli_query($con, $query);
         
         if (mysqli_num_rows($result) > 0) {
             $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
         } else {
             $events = [];
             
         } if($events!=[]){
            foreach ($events as $event): ?>
                <div class="bg-gray-800 bg-opacity-90 shadow-lg rounded-xl overflow-hidden transition-transform transform hover:scale-105">
                    <img src="https://via.placeholder.com/400x200" alt="Event" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-white"><?= htmlspecialchars($event['EventName']) ?></h3>
                        <p class="mt-3 text-gray-300 leading-relaxed"><?= htmlspecialchars($event['EventType']) ?></p>
                        <p class="mt-3 text-gray-300 leading-relaxed"><?= htmlspecialchars($event['EventDescription']) ?></p>
                        <button 
                            onclick="openEventModal(<?php echo htmlspecialchars($event['EventID']); ?>)" 
                            class="mt-6 w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Read More
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div><?php }else{
            echo "<h1 class='text-2l font-semibold text-black'>No Events Completed</h1>";
        } ?>
    

    <div id="eventModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
        <h3 id="modalEventName" class="text-2xl font-bold mb-4"></h3>
        <p id="modalEventDescription" class="text-gray-300 mb-4"></p>
        <p id="modalEventDate" class="text-gray-300 mb-4"></p>
        <p id="modalEventType" class="text-gray-300 mb-4"></p>
        <p id="modalMax" class="text-gray-300 mb-4"></p>
        <p id="modalEventLocation" class="text-gray-300 mb-4"></p>
        <p id="modalEventOrganizer" class="text-gray-300 mb-4"></p>
        <p id="modalEventRules" class="text-gray-300 mb-4"></p>

        <form method="POST" class="mt-6">
    <input type="hidden" name="EventID" id="registerEventID">
    <button 
        type="button" 
        onclick="openRegisterModal(<?php echo $event['EventID']; ?>, '<?php echo $event['EventType']; ?>')" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full mb-4">
        Register for Event
    </button>

    <button onclick="closeEventModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition w-full mt-4">
            Close
        </button>
</form>

<div id="registerModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
    <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
        <h3 class="text-2xl font-bold mb-4">Register for Event</h3>
        <form action="./serverScript/Handling.php" method="POST" id="registerForm">
            <input type="hidden" id="hiddenEventID" name="EventID">
            <input type="hidden" id="maxParticipants" name="maxParticipants">
            <input type="hidden" id="eventType" name="EventType" value="Single">
            <div id="teamLeaderInfo" class="mb-4">
                <p class="text-lg font-semibold">Team Leader: <?php echo $name; ?></p>
                <p class="text-gray-400">Email: <?php echo $email; ?></p>
                <input type="hidden" name="team_leader_name" value="<?php echo $name; ?>">
                <input type="hidden" name="team_leader_email" value="<?php echo $email; ?>">
            </div>

            <div id="groupFields">
                <div id="teamMembers" class="space-y-4"></div>
                <button type="button" onclick="addTeamMemberField()" id="addMemberButton" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition mb-4">
                    Add Team Member
                </button>
                <p id="errorMsg" class="text-red-500 text-sm hidden">Maximum team members reached.</p>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" name="event_reg" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition w-full">
                Submit
            </button>
        </form>

        <button onclick="closeRegisterModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition w-full mt-4">
            Close
        </button>
    </div>
</div>


</section>


    <section id="about" class="py-16 bg-gray-900 bg-opacity-75 text-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">About EventHub</h2>
        <div class="max-w-4xl mx-auto">
            <p class="text-lg leading-relaxed">
                EventHub is a platform designed to simplify the process of managing and participating in college events. Whether you are a student, organizer, or faculty member, our platform offers the tools and features needed to ensure events run smoothly and efficiently.
            </p>
            <p class="text-lg leading-relaxed mt-4">
                From registration to tracking attendance, EventHub provides a seamless experience for everyone involved. With a user-friendly interface and advanced capabilities, we aim to revolutionize the way college events are planned and executed.
            </p>
            <p class="text-lg leading-relaxed mt-4">
                Join us in creating memorable events and fostering a stronger sense of community. At EventHub, your success is our priority.
            </p>
        </div>
    </div>
</section>

    <section id="contact" class="container mx-auto py-16">
        <h2 class="text-3xl font-bold text-white text-center mb-8">Contact Us</h2>
        <form class="max-w-lg mx-auto bg-gray-800 bg-opacity-80 p-6 shadow-md rounded-lg" action="./serverScript/Handling.php" method="POST">
            <div class="mb-4">
                <label for="name" class="block text-white">Name</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Name">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-white">Email</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Email">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-white">Message</label>
                <textarea id="message" name="message" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Message"></textarea>
            </div>
            <button type="submit" name="send_message" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Send</button>
        </form>
    </section>
 

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    var events = <?php echo json_encode($events); ?>;

function openEventModal(eventID) {
    fetch(`./serverScript/fetch_events.php?EventID=${eventID}`)
        .then(response => response.json())
        .then(event => {
            if (event.error) {
                alert(event.error);
                return;
            }

            // Populate modal details
            document.getElementById("modalEventName").textContent = event.EventName;
            document.getElementById("modalEventDescription").textContent = event.EventDescription;
            document.getElementById("modalEventDate").textContent = "Date: " + event.EventDate;
            document.getElementById("modalEventType").textContent = "Event Type : " + event.EventType;
            document.getElementById("modalMax").textContent = "Max Participants : " + event.MaxParticipants;
            document.getElementById("modalEventLocation").textContent = "Location: " + event.Location;
            document.getElementById("modalEventOrganizer").textContent = "Organizer: " + event.Organizer;
            document.getElementById("modalEventRules").textContent = "Rules: " + event.rules;

            // Set EventID in the form
            document.getElementById("registerEventID").value = eventID;

            // Show the modal
            document.getElementById("maxParticipants").value = event.MaxParticipants;
            document.getElementById("eventModal").classList.remove("hidden");
        })
        .catch(error => {
            console.error("Error fetching event details:", error);
            alert("Failed to fetch event details. Please try again.");
        });
}


function openRegisterModal(eventID, eventType) {
    document.getElementById("hiddenEventID").value = eventID; // Set the Event ID
    document.getElementById("eventType").value = eventType; // Set the Event Type
    if (eventType === "Group") {
        document.getElementById("groupFields").classList.remove("hidden");
    } else {
        document.getElementById("groupFields").classList.add("hidden");
    }
    document.getElementById("registerModal").classList.remove("hidden");
}

function closeRegisterModal() {
    const modal = document.getElementById('registerModal');
    modal.classList.add('hidden');
}

function closeEventModal() {
    document.getElementById("eventModal").classList.add("hidden");
}

function addTeamMemberField() {
    const teamMembersContainer = document.getElementById("teamMembers");
    const maxParticipants = parseInt(document.getElementById("maxParticipants").value);
    const currentMembers = teamMembersContainer.children.length + 1; // Including leader

    if (currentMembers < maxParticipants) {
        const memberDiv = document.createElement("div");
        memberDiv.classList.add("flex", "space-x-2", "items-center", "mb-2");

        memberDiv.innerHTML = `
            <input type="text" name="mem_name[]" placeholder="Team Member Name" 
                   class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
            <input type="email" name="mem_email[]" placeholder="Team Member Email" 
                   class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
            <button type="button" onclick="removeTeamMemberField(this)" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Remove
            </button>
        `;
        teamMembersContainer.appendChild(memberDiv);
        document.getElementById("errorMsg").classList.add("hidden");
    } else {
        document.getElementById("errorMsg").classList.remove("hidden");
        document.getElementById("errorMsg").textContent = "Max members reached!";
    }
}


function removeTeamMemberField(button) {
    button.parentElement.remove();
    document.getElementById('errorMsg').classList.add('hidden');
}





function renderTeamMemberInputs() {
    const teamSize = parseInt(document.getElementById("teamSize").value);
    const teamMembersDiv = document.getElementById("teamMembers");
    teamMembersDiv.innerHTML = "";

    for (let i = 1; i <= teamSize; i++) {
        const memberDiv = document.createElement("div");
        memberDiv.classList.add("mb-4");

        memberDiv.innerHTML = `
            <label class="block mb-2">Team Member ${i} Name</label>
            <input type="text" name="team_member_name_${i}" placeholder="Name of Member ${i}" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 mb-2" required>
            <label class="block mb-2">Team Member ${i} Email</label>
            <input type="email" name="team_member_email_${i}" placeholder="Email of Member ${i}" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" required>
        `;
        teamMembersDiv.appendChild(memberDiv);
    }
}


    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>
</html>
