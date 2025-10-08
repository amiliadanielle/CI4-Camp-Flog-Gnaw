  components >> header.php

<header class="fixed top-0 left-0 w-full bg-black bg-opacity-90 backdrop-blur-sm text-white flex items-center justify-between px-32 py-5 z-50">
  <div class="flex items-center space-x-6">
    <a href="<?= site_url('dashboard'); ?>" class="flex items-center space-x-3">
  <img src="<?= base_url('img/logo.svg'); ?>" alt="Logo" class="w-12 h-12 rounded-full hover:opacity-80 transition">
</a>
  </div>

  <nav class="space-x-6 uppercase text-md font-medium flex items-center relative">
    <a href="#" class="hover:text-gray-400">Lineup</a>
    <a href="#" class="hover:text-gray-400">Passes</a>
    <a href="#" class="hover:text-gray-400">Info</a>

    <!-- Cart Icon -->
    <a href="<?= site_url('cart'); ?>" class="hover:text-gray-400">
      <i class="fas fa-shopping-cart text-xl"></i>
    </a>

    <!-- Profile Dropdown -->
    <div class="relative group">
      <button class="hover:text-gray-400 flex items-center space-x-2 focus:outline-none">
        <i class="fas fa-user-circle text-xl"></i>
      </button>

<!-- Dropdown Menu -->
<div class="absolute right-0 mt-3 w-40 bg-white text-black rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
  <a href="<?= site_url('profile'); ?>" class="block px-4 py-2 hover:bg-gray-200">Account</a>
  <a href="<?= site_url('moodboard'); ?>" class="block px-4 py-2 hover:bg-gray-200">Mood Board</a>
  <a href="<?= site_url('roadmap'); ?>" class="block px-4 py-2 hover:bg-gray-200">Road Map</a>
  <a href="<?= site_url('logout'); ?>" class="block px-4 py-2 hover:bg-gray-200">Logout</a>
</div>

</header>