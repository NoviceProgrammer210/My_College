<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" />
</head>
<body class="bg-gray-100 bg-cover bg-center" style="background-image: url('./Images/milad-fakurian-wNsHBf_bTBo-unsplash.jpg');">



<section class="bg-gray-900 bg-opacity-10 text-white text-center py-20 px-4">
        <h1 class="text-4xl font-bold">Welcome to EventHub</h1>
        <p class="mt-4 text-lg">Your one-stop solution for managing college events effortlessly</p>
    </section>

<section id="register" class="container mx-auto py-16 px-4">
    <h2 class="text-4xl font-bold text-center text-white mb-8">Register</h2>
    <form 
        method="POST" 
        action="./serverScript/Handling.php" 
        class="max-w-lg mx-auto bg-gray-800 bg-opacity-80 p-8 shadow-lg rounded-lg"
    >
        <div class="mb-6">
            <label for="name" class="block text-white font-medium mb-2">Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                placeholder="Your Name" 
                required
            >
        </div>
        <div class="mb-6">
            <label for="email" class="block text-white font-medium mb-2">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                placeholder="Your Email" 
                required
            >
        </div>
        <div class="mb-6">
            <label for="password" class="block text-white font-medium mb-2">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-900 text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" 
                placeholder="Your Password" 
                required
            >
        </div>
        <button 
            type="submit" 
            name="register" 
            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition"
        >
            Register
        </button>
        <p class="text-center text-white mt-4">
            Already have an account? 
            <a href="index.php" class="text-blue-400 hover:underline">Login</a>
        </p>
    </form>
</section>




    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

</body>
</html>