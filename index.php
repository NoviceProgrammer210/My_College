<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Event Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" />

    <style>
        /* Fade-in animation */
@keyframes fade-in {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Slide-up animation */
@keyframes slide-up {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Animation classes */
.animate-fade-in {
    animation: fade-in 1s ease-in-out forwards;
}

.animate-slide-up {
    animation: slide-up 1s ease-in-out forwards;
}

    </style>


</head>
<body class="bg-gray-100 bg-cover bg-center" style="background-image: url('./Images/sebastian-svenson-d2w-_1LJioQ-unsplash.jpg');">

<section class="bg-gray-900 bg-opacity-10 text-white text-center py-20 px-4">
        <h1 class="text-4xl font-bold">Login to EventHub</h1>
        <p class="mt-4 text-lg">Your one-stop solution for managing college events effortlessly</p>
    </section>


<section id="login" class="container mx-auto py-16 px-4">
    <h2 
        class="text-4xl font-bold text-center text-white mb-8 animate-fade-in"
    >
        Login
    </h2>
    <form 
        method="POST" 
        action="./serverScript/Handling.php" 
        class="max-w-lg mx-auto bg-gray-800 bg-opacity-40 p-8 shadow-2xl rounded-2xl animate-slide-up"
    >
        <!-- Email Field -->
        <div class="mb-6">
            <label for="email" class="block  text-white font-medium mb-2">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-900 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Enter Your Email" 
                required
            >
        </div>

        <!-- Password Field -->
        <div class="mb-6">
            <label for="password" class="block text-white font-medium mb-2">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-900 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:outline-none transition"
                placeholder="Enter Your Password" 
                required
            >
        </div>

        <!-- Login Button -->
        <button 
            type="submit" 
            name="login" 
            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:scale-105 transition-transform hover:shadow-lg"
        >
            Login
        </button>

        <!-- Create Account Link -->
        <p class="text-center text-white mt-6">
            Don't have an account? 
            <a href="register.php" class="text-blue-400 hover:underline">Create an Account</a>
        </p>
    </form>
</section>



        </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

</body>
</html>