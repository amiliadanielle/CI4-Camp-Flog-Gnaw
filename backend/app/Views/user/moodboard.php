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
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!-- Tailwind Custom Font Config -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            balsamiq: ['"Balsamiq Sans"', 'cursive'],
          },
          colors: {
            pastelPink: '#FFE6EF',
            pastelPurple: '#E9E3FF',
            pastelYellow: '#FFF8D6',
            darkPink: '#D94E8F',
          },
        },
      },
    };
  </script>

  <style>
    body {
      font-family: 'Balsamiq Sans', cursive;
      background: linear-gradient(180deg, #FFE6EF, #FFF8D6);
      overflow-x: hidden;
    }

    /* ✨ Scroll Animation Base */
    .fade-section {
      opacity: 0;
      transform: translateY(40px);
      transition: all 0.9s ease-out;
    }

    .fade-section.show {
      opacity: 1;
      transform: translateY(0);
    }

    /* Divider Line */
    .section-divider {
      border-top: 2px solid #f1c3d5;
      margin: 4rem 0;
      width: 100%;
    }
  </style>
</head>

<body class="text-gray-800 font-balsamiq">

  <!-- ✅ Header -->
  <?= $this->include('components/header'); ?>

  <!-- ✅ Main content -->
  <main class="max-w-6xl mx-auto px-6 pt-32 pb-20">

    <!-- 🌸 Hero Image -->
    <div class="relative mb-16 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 fade-section">
      <img 
        src="<?= base_url('img/footer.png'); ?>" 
        alt="Camp Flog Gnaw Moodboard Banner" 
        class="w-full h-72 object-cover brightness-95 hover:brightness-100 transition-all duration-500"
      >
      <div class="absolute inset-0 bg-black/20 flex flex-col items-center justify-center text-center px-6">
        <h2 class="text-white text-3xl md:text-5xl font-bold drop-shadow-lg mb-2">
          Mood Board
        </h2>
        <p class="text-white text-sm md:text-base max-w-xl">
          Visual identity for <strong>Camp Flog Gnaw 2025</strong> — playful, vibrant, and nostalgic.
        </p>
      </div>
    </div>

    <div class="section-divider fade-section"></div>

    <!-- 🎨 Color System -->
    <section class="mb-20 fade-section">
      <h2 class="text-3xl font-semibold mb-4 text-darkPink">Color System</h2>
      <p class="text-gray-600 mb-6">Inspired by pastel tones of summer skies, festival lights, and creative freedom.</p>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <?php
          $colors = [
            ['#FFD400', '#FFEA80', '#FFF7CC', 'Festival Yellow'],
            ['#7B61FF', '#A48CFF', '#D1C6FF', 'Electric Purple'],
            ['#FF7BA9', '#FFAACC', '#FFD6E6', 'Flog Pink'],
            ['#00BFFF', '#5FDFFF', '#BFF4FF', 'Sky Blue']
          ];
          foreach ($colors as $set) {
            echo '
              <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex space-x-2 mb-3">
                  <div class="w-12 h-12 rounded" style="background:' . $set[0] . '"></div>
                  <div class="w-12 h-12 rounded" style="background:' . $set[1] . '"></div>
                  <div class="w-12 h-12 rounded" style="background:' . $set[2] . '"></div>
                </div>
                <p class="font-semibold">' . $set[3] . '</p>
                <p class="text-sm text-gray-500">' . $set[0] . ' – ' . $set[1] . ' – ' . $set[2] . '</p>
              </div>';
          }
        ?>
      </div>
    </section>

    <div class="section-divider fade-section"></div>

    <!-- 🔤 Typography -->
    <section class="mb-20 fade-section">
      <h2 class="text-3xl font-semibold mb-4 text-darkPink">Typography</h2>
      <div class="grid md:grid-cols-2 gap-10">
        <div class="bg-white/70 p-6 rounded-2xl shadow-md hover:shadow-xl transition">
          <p class="text-2xl text-darkPink mb-1 font-bold">Balsamiq Sans</p>
          <p class="text-gray-700">Used for headings — bold and expressive, giving a hand-drawn energy.</p>
        </div>
        <div class="bg-white/70 p-6 rounded-2xl shadow-md hover:shadow-xl transition">
          <p class="text-2xl text-sky-500 mb-1 font-bold">Inter</p>
          <p class="text-gray-700">Used for UI and body text — clean, friendly, and modern.</p>
        </div>
      </div>
    </section>

    <div class="section-divider fade-section"></div>

    <!-- 🔘 Buttons -->
    <section class="mb-20 fade-section">
      <h2 class="text-3xl font-semibold mb-4 text-darkPink">Buttons</h2>

      <!-- 🌤 Light Mode -->
      <div class="mb-8">
        <p class="mb-3 text-gray-600">Light Mode</p>
        <div class="flex flex-wrap gap-4">
          <button class="bg-[#7B61FF] text-white px-6 py-2 rounded-lg font-medium shadow hover:bg-[#6a4fff] hover:scale-105 transition">Primary</button>
          <button class="bg-[#FFD400] text-black px-6 py-2 rounded-lg font-medium shadow hover:bg-[#ffe24f] hover:scale-105 transition">Secondary</button>
          <button class="border border-black px-6 py-2 rounded-lg font-medium hover:bg-black hover:text-white transition">Border</button>
          <button class="bg-gray-300 text-gray-500 px-6 py-2 rounded-lg" disabled>Disabled</button>
        </div>
      </div>

      <!-- 🌑 Dark Mode -->
      <div>
        <p class="mb-3 text-gray-600">Dark Mode</p>
        <div class="flex flex-wrap gap-4 bg-black p-6 rounded-2xl shadow-lg">
          <button class="bg-[#7B61FF] px-6 py-2 rounded-lg text-white font-medium hover:bg-[#6a4fff] transition">Primary</button>
          <button class="bg-[#FFD400] px-6 py-2 rounded-lg text-black font-medium hover:bg-[#ffe24f] transition">Secondary</button>
          <button class="border border-gray-500 px-6 py-2 rounded-lg text-white hover:bg-white hover:text-black transition">Border</button>
          <button class="bg-gray-700 text-gray-400 px-6 py-2 rounded-lg" disabled>Disabled</button>
        </div>
      </div>
    </section>

    <div class="section-divider fade-section"></div>

    <!-- 🪩 Card Samples -->
    <section class="mb-20 fade-section">
      <h2 class="text-3xl font-semibold mb-8 text-darkPink">Card Samples</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Unlimited Carnival Games -->
        <div class="bg-sky-200 text-black rounded-lg p-6 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition duration-300">
          <div>
            <h3 class="text-lg font-bold mb-2">2-DAY UNLIMITED CARNIVAL GAMES</h3>
            <p class="text-3xl font-bold">$160 
              <span class="text-base font-normal">no added fees 
                <span class="inline-block w-4 h-4 rounded-full border border-black text-center text-xs font-bold ml-1">i</span>
              </span>
            </p>
            <p class="mt-2 text-sm">(admission not included)</p>
          </div>
          <div class="mt-6">
            <button class="border border-black w-full md:w-auto px-6 py-2 hover:bg-black hover:text-white transition font-semibold">
              LEARN MORE
            </button>
          </div>
        </div>

        <!-- General Parking -->
        <div class="bg-sky-200 text-black rounded-lg p-6 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition duration-300">
          <div>
            <h3 class="text-lg font-bold mb-2">2-DAY GENERAL PARKING</h3>
            <p class="text-3xl font-bold">$65 
              <span class="text-base font-normal">no added fees 
                <span class="inline-block w-4 h-4 rounded-full border border-black text-center text-xs font-bold ml-1">i</span>
              </span>
            </p>
            <p class="mt-2 text-sm">(admission not included)</p>
          </div>
          <div class="mt-6">
            <button class="border border-black w-full md:w-auto px-6 py-2 hover:bg-black hover:text-white transition font-semibold">
              LEARN MORE
            </button>
          </div>
        </div>
      </div>
    </section>

    <div class="section-divider fade-section"></div>

    <!-- 🎵 Logos -->
    <section class="fade-section">
      <h2 class="text-3xl font-semibold mb-6 text-darkPink">Logos</h2>
      <div class="grid md:grid-cols-2 gap-8">
        <div class="flex flex-col items-center border rounded-2xl bg-white/80 p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition">
          <img src="<?= base_url('img/logo.svg'); ?>" alt="Camp Flog Gnaw Logo Circle" class="w-24 h-24 mb-3">
          <p class="text-gray-700">Main — Circle</p>
        </div>
        <div class="flex flex-col items-center border rounded-2xl bg-white/80 p-8 shadow-md hover:shadow-xl hover:-translate-y-1 transition">
          <img src="<?= base_url('img/squarelogo.png'); ?>" alt="Camp Flog Gnaw Logo Square" class="w-24 h-24 mb-3">
          <p class="text-gray-700">Main — Square</p>
        </div>
      </div>
    </section>
  </main>

  <!-- ✅ Footer -->
  <?= $this->include('components/footer'); ?>

  <!-- 🔥 Scroll Animation Script -->
  <script>
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('show');
          observer.unobserve(entry.target); // animate once
        }
      });
    }, { threshold: 0.2 });

    document.querySelectorAll('.fade-section').forEach(section => {
      observer.observe(section);
    });
  </script>

</body>
</html>
