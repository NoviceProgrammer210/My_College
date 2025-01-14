<?php 
session_start();
require('./serverScript/Logic.php');
$name = $ $_SESSION['user_name'] ;
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
            <li><a href="./serverScript/logout.php" class="text-white hover:text-blue-400 flex items-center"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a></li>
        </ul>
    </div>
</nav>


    <section class="relative bg-cover bg-center text-white text-center py-28 px-4">
        <div class="absolute inset-0 bg-gray-900 bg-opacity-60"></div>
        <div class="relative z-10">
            <h1 class="text-5xl font-bold">Welcome <?php echo $name; ?></h1>
            <p class="mt-4 text-lg md:text-xl">Your one-stop solution for managing college events effortlessly</p>
            <a href="#events" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Explore Events</a>
        </div>
    </section>

    <section id="events" class="container mx-auto py-16 px-4">
        <h2 class="text-3xl font-bold text-center text-gray mb-8">Upcoming Events</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gray-800 bg-opacity-80 shadow-md rounded-lg overflow-hidden">
                <img src="https://via.placeholder.com/400x200" alt="Event" class="w-full">
                <div class="p-4">
                    <h3 class="text-xl font-bold text-white">TechFest 2025</h3>
                    <p class="mt-2 text-gray-300">An exciting technology fest showcasing innovative projects and ideas.</p>
                    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Register</button>
                </div>
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
        <form class="max-w-lg mx-auto bg-gray-800 bg-opacity-80 p-6 shadow-md rounded-lg">
            <div class="mb-4">
                <label for="name" class="block text-white">Name</label>
                <input type="text" id="name" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Name">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-white">Email</label>
                <input type="email" id="email" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Email">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-white">Message</label>
                <textarea id="message" class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" placeholder="Your Message"></textarea>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Send</button>
        </form>
    </section>
 

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>
</html>
