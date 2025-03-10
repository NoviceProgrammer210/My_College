<?php
// Start the session
session_start();

// Include necessary logic or database files
require('./serverScript/Logic.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit();
}

// Fetch session variables after confirming the user is logged in
$id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];
$email = $_SESSION['Email'];

// Debugging: Print session values (optional, for development)

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

    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 1s ease-out;
        }
    </style>
</head>

<body class="bg-gray-100 bg-cover bg-center" style="background-image: url('./Images/mitchell-luo-0P22PaQ54Nk-unsplash.jpg');background-size: cover;background-repeat: no-repeat;background-position: center;">
    <nav class="bg-gray-800 bg-opacity-90 backdrop-blur-md p-4 fixed top-0 w-full z-20 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="#" class="text-white text-2xl font-bold flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v10m-7-5l7 5 7-5" />
                </svg>
                <span>CollegeHub</span>
            </a>

            <!-- Mobile Menu Button -->
            <button id="menu-btn" class="text-white md:hidden focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <!-- Navigation Links -->
            <ul id="menu" class="hidden md:flex space-x-6 items-center">
                <li>
                    <a href="#" class="text-white flex items-center space-x-2 group">
                        <i class="fas fa-home group-hover:text-blue-500 transition-transform duration-300 transform group-hover:scale-110"></i>
                        <span class="group-hover:text-blue-500 transition-transform duration-300 transform group-hover:translate-x-1">
                            Home
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#events" class="text-white flex items-center space-x-2 group">
                        <i class="fas fa-calendar-alt group-hover:text-blue-500 transition-transform duration-300 transform group-hover:scale-110"></i>
                        <span class="group-hover:text-blue-500 transition-transform duration-300 transform group-hover:translate-x-1">
                            Events
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#about" class="text-white flex items-center space-x-2 group">
                        <i class="fas fa-info-circle group-hover:text-blue-500 transition-transform duration-300 transform group-hover:scale-110"></i>
                        <span class="group-hover:text-blue-500 transition-transform duration-300 transform group-hover:translate-x-1">
                            About
                        </span>
                    </a>
                </li>
                <li>
                    <a href="#contact" class="text-white flex items-center space-x-2 group">
                        <i class="fas fa-envelope group-hover:text-blue-500 transition-transform duration-300 transform group-hover:scale-110"></i>
                        <span class="group-hover:text-blue-500 transition-transform duration-300 transform group-hover:translate-x-1">
                            Contact
                        </span>
                    </a>
                </li>
                <li>
                    <a href="./logout.php" class="text-white flex items-center space-x-2 group">
                        <i class="fas fa-sign-out-alt group-hover:text-red-500 transition-transform duration-300 transform group-hover:scale-110"></i>
                        <span class="group-hover:text-red-500 transition-transform duration-300 transform group-hover:translate-x-1">
                            Logout
                        </span>
                    </a>
                </li>
            </ul>

        </div>
    </nav>

    <br><br>

    <section class="relative bg-cover bg-center text-white text-center py-28 px-4" style="background-image: url('your-background-image.jpg');">
        <!-- Overlay -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm"></div>

        <!-- Content -->
        <div class="relative z-10 animate-fadeInUp">
            <h1 class="text-5xl font-extrabold drop-shadow-lg">Welcome <?php echo $name; ?></h1>
            <p class="mt-4 text-lg md:text-xl font-medium text-gray-300 drop-shadow-md">
                Your one-stop solution for managing college events effortlessly
            </p>
            <a href="#events"
                class="mt-6 inline-block bg-gradient-to-r from-blue-500 to-blue-700 text-white px-8 py-3 rounded-full font-semibold hover:scale-105 transition-transform duration-300 shadow-lg">
                Explore Events
            </a>
        </div>
    </section>

    <br><br><br><br>
    <section id="Complete_events" class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-extrabold text-center text-gray-100 mb-12 tracking-wide">
        Completed Events
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php
        require_once('./serverScript/DataBase.php');
        $query = "SELECT * FROM completed_events ORDER BY EventDate DESC LIMIT 3";
        $con = Connect_Database();
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            $events = [];
        }

        if (!empty($events)):
            foreach ($events as $event): ?>
                <div class="bg-gradient-to-br from-gray-800 via-gray-900 to-black shadow-lg rounded-2xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-400 mb-2">
                            <?= htmlspecialchars($event['EventName']) ?>
                        </h3>
                        <p class="text-gray-300 text-sm leading-relaxed mb-4">
                            <?= htmlspecialchars($event['EventDescription']) ?>
                        </p>
                        <button
                            onclick="fetchCompleteEventModal(<?php echo htmlspecialchars($event['CompletedEventID']); ?>)"
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow-md hover:scale-105 transition-all">
                            Read More
                        </button>
                    </div>
                </div>
            <?php endforeach;
        else: ?>
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center">
                <h3 class="text-gray-300 text-lg">No Completed Events</h3>
            </div>
        <?php endif; ?>
    </div>

    <div id="completeModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
        <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
            <h3 id="modal-title" class="text-2xl font-bold mb-4"></h3>
            <p id="modal-description" class="text-gray-300 mb-4"></p>
            <p id="modal-date" class="text-gray-300 mb-4"></p>
            <p id="modal-location" class="text-gray-300 mb-4"></p>
            <div class="flex justify-end mt-6">
                <button onclick="closeEModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</section>

<script>
function fetchCompleteEventModal(eventID) {
    fetch(`./serverScript/fetch_events.php?EventID=${eventID}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                const event = data.event;

                // Debugging: Log event object and keys
                console.log(event);
                console.log(Object.keys(event));

                // Ensure keys match the event object
                document.getElementById("modal-title").innerText = event.EventName || "N/A"; // Adjust keys as necessary
                document.getElementById("modal-description").innerText = event.EventDescription || "N/A";
                document.getElementById("modal-date").innerText = `Date: ${event.EventDate || "N/A"}`;
                document.getElementById("modal-location").innerText = `Location: ${event.Location || "N/A"}`;

                // Show the modal
                document.getElementById("completeModal").classList.remove("hidden");
            } else {
                alert(data.message || "Event not found");
            }
        })
        .catch(error => {
            console.error("Error fetching event details:", error);
            alert("An error occurred while fetching event details.");
        });
}

    function closeEModal() {
        document.getElementById("completeModal").classList.add("hidden");
    }
</script>


    <section id="events" class="container mx-auto py-16 px-4">
        <h2 class="text-4xl font-extrabold text-center text-gray-100 mb-12 tracking-wide">
            Upcoming Events
        </h2>
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
            }

            if (!empty($events)) {
                foreach ($events as $event): ?>
                    <div class="relative bg-gray-800 bg-opacity-90 shadow-lg rounded-xl overflow-hidden transition-transform transform hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-gray-800 to-gray-900 opacity-80"></div>
                        <div class="relative z-10 p-6">
                            <h3 class="text-2xl font-semibold text-white truncate"><?= htmlspecialchars($event['EventName']) ?></h3>
                            <p class="mt-2 text-sm text-gray-300">Date: <?= htmlspecialchars($event['EventDate']) ?></p>
                            <p class="mt-3 text-gray-400 leading-relaxed line-clamp-3">
                                <?= htmlspecialchars($event['EventDescription']) ?>
                            </p>
                            <button
                                onclick="openEventModal(<?php echo htmlspecialchars($event['EventID']); ?>)"
                                class="mt-4 w-full bg-blue-600 text-white font-bold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Read More
                            </button>
                        </div>
                    </div>
            <?php endforeach;
            } else {
                echo "<p class='text-center text-lg text-gray-300 font-medium'>No events available at the moment.</p>";
            } ?>
        </div>



        <div id="eventModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 flex items-center justify-center">
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
                <h3 id="modalEventName" class="text-2xl font-bold mb-4"></h3>
                <p id="modalEventDescription" class="text-gray-300 mb-4"></p>
                <p id="modalEventDate" class="text-gray-300 mb-4"></p>
                <p id="modalMax" class="text-gray-300 mb-4"></p>
                <p id="modalEventLocation" class="text-gray-300 mb-4"></p>
                <p id="modalEventOrganizer" class="text-gray-300 mb-4"></p>
                <p id="modalEventRules" class="text-gray-300 mb-4"></p>

                <form method="POST" action="./serverScript/Handling.php" class="mt-6">
                    <input type="hidden" name="EventID"  id="EventID">
                    <button type="submit"
                        name="event_reg"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full mb-4">
                        Register for Event
                    </button>
                    <button onclick="closeEventModal()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition w-full mt-4">
                        Close
                    </button>
                </form>
            </div>
        </div>
    </section>


    <section id="about" class="py-20 bg-gradient-to-r from-gray-800 via-gray-900 to-black text-white">
        <div class="container mx-auto px-6">
            <h2
                class="text-4xl font-extrabold text-center mb-10 text-blue-400 tracking-wider opacity-0 transform translate-y-6 transition duration-1000 ease-out"
                id="about-title">
                About EventHub
            </h2>
            <div
                class="max-w-4xl mx-auto space-y-6 opacity-0 transform translate-y-6 transition duration-1000 ease-out delay-200"
                id="about-content">
                <p class="text-lg leading-relaxed text-gray-300">
                    EventHub is a platform designed to simplify the process of managing and participating in college events. Whether you are a student, organizer, or faculty member, our platform offers the tools and features needed to ensure events run smoothly and efficiently.
                </p>
                <p class="text-lg leading-relaxed text-gray-300">
                    From registration to tracking attendance, EventHub provides a seamless experience for everyone involved. With a user-friendly interface and advanced capabilities, we aim to revolutionize the way college events are planned and executed.
                </p>
                <p class="text-lg leading-relaxed text-gray-300">
                    Join us in creating memorable events and fostering a stronger sense of community. At EventHub, your success is our priority.
                </p>
            </div>
            <div
                class="mt-10 text-center opacity-0 transform translate-y-6 transition duration-1000 ease-out delay-400"
                id="about-button">
                <a href="#contact" class="inline-block bg-blue-600 text-white font-semibold py-3 px-8 rounded-full hover:bg-blue-700 transition shadow-lg">
                    Contact Us
                </a>
            </div>
        </div>
    </section>


    <section id="contact" class="relative py-20 bg-gradient-to-br from-gray-800 via-gray-900 to-black">
        <div class="container mx-auto px-6">
            <h2
                class="text-4xl font-extrabold text-center text-blue-400 mb-10 tracking-wide opacity-0 transform translate-y-6 transition duration-1000 ease-out"
                id="contact-title">
                Contact Us
            </h2>
            <form
                class="max-w-lg mx-auto bg-gray-800 bg-opacity-90 p-8 shadow-xl rounded-lg space-y-6 opacity-0 transform translate-y-6 transition duration-1000 ease-out delay-200"
                action="./serverScript/Handling.php" method="POST"
                id="contact-form">
                <div class="mb-4">
                    <label for="name" class="block text-white font-medium">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Your Name"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-white font-medium">Email</label>
                    <input
                        type="email"
                        value="<?php echo htmlspecialchars($_SESSION['Email'], ENT_QUOTES, 'UTF-8'); ?>"
                        name="email"
                        id="email"
                        class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Your Email"
                        required>
                </div>
                <div class="mb-4">
                    <label for="message" class="block text-white font-medium">Message</label>
                    <textarea
                        id="message"
                        name="message"
                        class="w-full px-4 py-2 border border-gray-700 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Your Message"
                        rows="5"
                        required>
                </textarea>
                </div>
                <button
                    type="submit"
                    name="send_message"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition shadow-lg">
                    Send Message
                </button>
            </form>
        </div>
    </section>



    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        var events = <?php echo json_encode($events); ?>;


        function openEventModal(eventID) {
            console.log("Event ID passed to openEventModal:", eventID);

            fetch(`./serverScript/fetchDetails.php?event_id=${eventID}`)
                .then(response => response.json())
                .then(event => {
                    console.log("Event data fetched:", event); // Debug the response

                    if (event.error) {
                        alert(event.error);
                        return;
                    }

                    // Populate the modal fields
                    document.getElementById("modalEventName").textContent = event.EventName || "N/A";
                    document.getElementById("modalEventDescription").textContent = event.EventDescription || "N/A";
                    document.getElementById("modalEventDate").textContent = "Date: " + (event.EventDate || "N/A");
                    document.getElementById("modalMax").textContent = "Max Participants: " + (event.MaxParticipants || "N/A");
                    document.getElementById("modalEventLocation").textContent = "Location: " + (event.Location || "N/A");
                    document.getElementById("modalEventOrganizer").textContent = "Organizer: " + (event.Organizer || "N/A");
                    document.getElementById("modalEventRules").textContent = "Rules: " + (event.rules || "N/A");

                    document.getElementById('EventID').value=eventID;
                    // Show the modal
                    document.getElementById("eventModal").classList.remove("hidden");
                })
                .catch(error => {
                    console.error("Error fetching event details:", error);
                    alert("Failed to fetch event details. Please check the console for more information.");
                });
        }


        function closeEventModal() {
            document.getElementById("eventModal").classList.add("hidden");
        }





        function closeRegisterModal() {
            const modal = document.getElementById('registerModal');
            modal.classList.add('hidden');
        }

        function closeEventModal() {
            document.getElementById("eventModal").classList.add("hidden");
        }

        





        document.addEventListener("DOMContentLoaded", () => {

            const aboutSection = document.getElementById("about");
            const title = document.getElementById("about-title");
            const content = document.getElementById("about-content");
            const button = document.getElementById("about-button");
            const contactSection = document.getElementById("contact");
            const contactTitle = document.getElementById("contact-title");
            const contactForm = document.getElementById("contact-form");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Animate elements when the section is in view
                            title.classList.remove("opacity-0", "translate-y-6");
                            content.classList.remove("opacity-0", "translate-y-6");
                            button.classList.remove("opacity-0", "translate-y-6");
                            contactTitle.classList.remove("opacity-0", "translate-y-6");
                            contactForm.classList.remove("opacity-0", "translate-y-6");
                        }
                    });
                }, {
                    threshold: 0.2
                }
            );

            observer.observe(aboutSection);
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>

</html>