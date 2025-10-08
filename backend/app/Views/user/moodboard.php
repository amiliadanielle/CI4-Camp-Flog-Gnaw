<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Camp Flog Gnaw — Moodboard</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


  <!-- Google Font: Balsamiq Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap"
    rel="stylesheet"
  >

  <!-- Tailwind Custom Font Config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            balsamiq: ['"Balsamiq Sans"', 'cursive'],
          },
        },
      },
    };
  </script>

  <style>
    body {
      font-family: 'Balsamiq Sans', cursive;
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 font-balsamiq">

  <!-- ✅ Include header -->
  <?= $this->include('components/header'); ?>

  <!-- ✅ Main content with top padding -->
  <main class="max-w-6xl mx-auto px-6 pt-32 pb-12">
    <h1 class="text-4xl font-bold mb-2 text-black">Mood board</h1>
    <p class="text-gray-600 mb-10">Visual identity for <strong>Camp Flog Gnaw 2025</strong> festival website.</p>

    <!-- Color System -->
    <section class="mb-16">
      <h2 class="text-2xl font-semibold mb-4">Color System</h2>
      <p class="text-gray-600 mb-6">Main palette inspired by sunset tones, festival lights, and stage energy.</p>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex space-x-2 mb-3">
            <div class="w-12 h-12 bg-[#FFD400] rounded"></div>
            <div class="w-12 h-12 bg-[#FFEA80] rounded"></div>
            <div class="w-12 h-12 bg-[#FFF7CC] rounded"></div>
          </div>
          <p class="font-semibold">Festival Yellow</p>
          <p class="text-sm text-gray-500">#FFD400 – #FFEA80 – #FFF7CC</p>
        </div>

        <div>
          <div class="flex space-x-2 mb-3">
            <div class="w-12 h-12 bg-[#7B61FF] rounded"></div>
            <div class="w-12 h-12 bg-[#A48CFF] rounded"></div>
            <div class="w-12 h-12 bg-[#D1C6FF] rounded"></div>
          </div>
          <p class="font-semibold">Electric Purple</p>
          <p class="text-sm text-gray-500">#7B61FF – #A48CFF – #D1C6FF</p>
        </div>

        <div>
          <div class="flex space-x-2 mb-3">
            <div class="w-12 h-12 bg-[#FF7BA9] rounded"></div>
            <div class="w-12 h-12 bg-[#FFAACC] rounded"></div>
            <div class="w-12 h-12 bg-[#FFD6E6] rounded"></div>
          </div>
          <p class="font-semibold">Flog Pink</p>
          <p class="text-sm text-gray-500">#FF7BA9 – #FFAACC – #FFD6E6</p>
        </div>

        <div>
          <div class="flex space-x-2 mb-3">
            <div class="w-12 h-12 bg-[#00BFFF] rounded"></div>
            <div class="w-12 h-12 bg-[#5FDFFF] rounded"></div>
            <div class="w-12 h-12 bg-[#BFF4FF] rounded"></div>
          </div>
          <p class="font-semibold">Sky Blue</p>
          <p class="text-sm text-gray-500">#00BFFF – #5FDFFF – #BFF4FF</p>
        </div>
      </div>
    </section>

    <!-- Typography -->
    <section class="mb-16">
      <h2 class="text-2xl font-semibold mb-4">Typography</h2>
      <div class="grid md:grid-cols-2 gap-10">
        <div>
          <p class="text-xl text-[#7B61FF] mb-1 font-bold">Balsamiq Sans</p>
          <p class="text-gray-600">Used for headings and event titles — bold and expressive.</p>
        </div>
        <div>
          <p class="text-xl text-[#00BFFF] mb-1 font-bold">Inter</p>
          <p class="text-gray-600">Used for body text and UI — modern, clear, and versatile.</p>
        </div>
      </div>
    </section>

    <!-- Buttons -->
    <section class="mb-16">
      <h2 class="text-2xl font-semibold mb-4">Buttons</h2>

      <div class="mb-6">
        <p class="mb-2 text-gray-600">Light Mode</p>
        <div class="flex flex-wrap gap-3">
          <button class="bg-[#7B61FF] text-white px-5 py-2 rounded font-medium">Primary</button>
          <button class="bg-[#FFD400] text-black px-5 py-2 rounded font-medium">Secondary</button>
          <button class="border border-black px-5 py-2 rounded font-medium">Border</button>
          <button class="bg-gray-300 text-gray-500 px-5 py-2 rounded" disabled>Disabled</button>
        </div>
      </div>

      <div>
        <p class="mb-2 text-gray-600">Dark Mode</p>
        <div class="flex flex-wrap gap-3 bg-black p-5 rounded-lg">
          <button class="bg-[#7B61FF] px-5 py-2 rounded text-white font-medium">Primary</button>
          <button class="bg-[#FFD400] px-5 py-2 rounded text-black font-medium">Secondary</button>
          <button class="border border-gray-500 px-5 py-2 rounded text-white">Border</button>
          <button class="bg-gray-700 text-gray-400 px-5 py-2 rounded" disabled>Disabled</button>
        </div>
      </div>
    </section>

    <!-- Card Samples -->
    <section class="mb-16">
      <h2 class="text-2xl font-semibold mb-4">Card Samples</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <div class="border rounded-lg p-6 shadow-sm bg-white">
          <p class="text-xl text-[#7B61FF] font-bold">Weekend Pass</p>
          <p class="text-gray-600 mb-4">Access to all two days of the festival.</p>
          <a href="#" class="text-[#00BFFF] hover:underline">Learn more</a>
        </div>
        <div class="border rounded-lg p-6 shadow-sm bg-white">
          <p class="text-xl text-[#FF7BA9] font-bold">VIP Pass</p>
          <p class="text-gray-600 mb-4">Premium seating and artist meet & greet access.</p>
          <a href="#" class="text-[#00BFFF] hover:underline">Learn more</a>
        </div>
        <div class="border rounded-lg p-6 shadow-sm bg-white">
          <p class="text-xl text-[#FFD400] font-bold">Merch Drop</p>
          <p class="text-gray-600 mb-4">Exclusive 2025 Flog Gnaw merchandise.</p>
          <a href="#" class="text-[#00BFFF] hover:underline">Learn more</a>
        </div>
      </div>
    </section>

    <!-- Logos -->
    <section>
      <h2 class="text-2xl font-semibold mb-4">Logos</h2>
      <div class="grid md:grid-cols-2 gap-6">
        <div class="flex flex-col items-center border rounded-lg bg-white p-6">
          <img src="<?= base_url('img/logo.svg'); ?>" alt="Camp Flog Gnaw Logo Circle" class="w-24 h-24 mb-3">
          <p class="text-gray-700">Main — Circle</p>
        </div>
        <div class="flex flex-col items-center border rounded-lg bg-white p-6">
          <img src="<?= base_url('img/logo_square.svg'); ?>" alt="Camp Flog Gnaw Logo Square" class="w-24 h-24 mb-3">
          <p class="text-gray-700">Main — Square</p>
        </div>
      </div>
    </section>
  </main>

     <!-- Include Footer -->
  <?= $this->include('components/footer'); ?>
  
</body>
</html>
