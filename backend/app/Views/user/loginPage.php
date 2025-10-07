<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Font: Balsamiq Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
  
  <!-- Tailwind Custom Config for Font -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            balsamiq: ['"Balsamiq Sans"', "cursive"],
          },
        },
      },
    };
  </script>
</head>

<body class="font-balsamiq min-h-screen flex items-center justify-center relative bg-white">

  <!-- Background Image with Overlay -->
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= base_url('img/bg.png'); ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
  </div>

  <!-- 🔙 Back Arrow Button -->
<a href="<?= base_url('landingPage'); ?>" 
   class="absolute top-6 left-6 z-20 text-white hover:text-orange-400 transition">
  <!-- SVG Back Arrow Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" 
       fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" 
       class="w-8 h-8">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
  </svg>
</a>

  <!-- Main Card -->
  <div class="relative z-10 bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl flex overflow-hidden w-[900px] h-[560px]">

    <!-- Left: Login Form -->
    <div class="w-1/2 p-10 flex flex-col justify-center bg-white/90">
      <h2 class="text-2xl font-semibold text-orange-600 mb-6">LOG IN</h2>

      <form action="<?= base_url('login'); ?>" method="post" class="space-y-4">
        <!-- Email -->
        <input type="email" name="email" placeholder="Email" 
          class="w-full px-4 py-2 border border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">
        
        <!-- Password -->
        <input type="password" name="password" placeholder="Password" 
          class="w-full px-4 py-2 border border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400">

        <!-- Forgot Password -->
        <div class="flex justify-end">
          <a href="#" class="text-sm text-orange-600 hover:underline">Forgot password?</a>
        </div>

        <!-- Login Button -->
        <button type="submit" 
          class="w-full bg-orange-500 text-white font-semibold py-2 rounded-lg hover:bg-orange-400 transition">
          Log In
        </button>
      </form>

      <!-- Sign Up Link -->
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-700">
          Don’t have an account? 
          <a href="<?= base_url('signupPage'); ?>" class="text-orange-500 font-medium hover:underline">
            Sign Up Here
          </a>
        </p>
      </div>
    </div>

    <!-- Right: Poster fills entire half -->
    <div class="w-1/2 relative">
      <img 
        src="<?= base_url('../img/flog.jpg'); ?>" 
        alt="Poster" 
        class="w-full h-full object-cover object-center">
    </div>

  </div>

</body>
</html>
