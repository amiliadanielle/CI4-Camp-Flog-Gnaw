<!-- ✅ Header -->
<header class="fixed top-0 left-0 w-full bg-black bg-opacity-90 backdrop-blur-sm text-white flex items-center justify-between px-32 py-5 z-50">
  <div class="flex items-center space-x-6">
    <!-- 🔗 Logo now redirects to landingPage -->
    <a href="<?= site_url('landingPage'); ?>">
      <img src="../img/logo.svg" alt="Logo" class="w-12 h-12 rounded-full hover:opacity-80 transition duration-300">
    </a>
  </div>

  <nav class="space-x-8 uppercase text-md font-medium flex items-center relative">
    <a href="#" class="hover:text-gray-400 transition duration-300">Lineup</a>
    <a href="#" class="hover:text-gray-400 transition duration-300">Passes</a>

    <!-- 🌟 Animated Info Dropdown -->
    <div class="relative group">
      <a href="#" class="hover:text-sky-300 transition duration-300 flex items-center gap-1">
        Info
        <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </a>

      <!-- Dropdown Content -->
      <div class="absolute left-0 top-full mt-2 w-48 bg-white/90 backdrop-blur-lg text-black rounded-xl shadow-lg 
                  opacity-0 translate-y-3 scale-95 invisible group-hover:visible group-hover:opacity-100 
                  group-hover:translate-y-0 group-hover:scale-100 transition-all duration-300 ease-out origin-top">
        <a href="<?= site_url('roadmap'); ?>" 
           class="block px-5 py-3 rounded-t-xl hover:bg-sky-100 hover:text-sky-700 transition duration-200">
           🗺️ Roadmap
        </a>
        <a href="<?= site_url('moodboard'); ?>" 
           class="block px-5 py-3 rounded-b-xl hover:bg-sky-100 hover:text-sky-700 transition duration-200">
           🎨 Moodboard
        </a>
      </div>
    </div>

    <a href="<?= site_url('loginPage') ?>" 
       class="bg-gray-200 text-black px-5 py-2 rounded-full hover:bg-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 font-semibold">
       Join Waitlist
    </a>
  </nav>
</header>

