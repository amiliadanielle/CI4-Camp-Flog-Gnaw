<?php $session = session(); ?>
<header class="fixed top-0 left-0 w-full bg-black bg-opacity-90 backdrop-blur-sm text-white flex items-center justify-between px-32 py-5 z-50">
  <div class="flex items-center space-x-6">
    <!-- Logo -->
    <a href="<?= site_url('landingPage'); ?>">
      <img src="<?= base_url('img/logo.svg') ?>" alt="Logo" class="w-12 h-12 rounded-full hover:opacity-80 transition duration-300">
    </a>
  </div>

  <nav class="space-x-8 uppercase text-md font-medium flex items-center relative">
    <a href="#" class="hover:text-gray-400 transition duration-300">Lineup</a>
    <a href="#" class="hover:text-gray-400 transition duration-300">Passes</a>

    <!-- Info Dropdown -->
    <div class="relative group">
      <a href="#" class="hover:text-sky-300 transition duration-300 flex items-center gap-1">
        Info
        <svg class="w-4 h-4 transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
      </a>
      <div class="absolute left-0 top-full mt-2 w-48 bg-white/90 backdrop-blur-lg text-black rounded-xl shadow-lg 
                  opacity-0 translate-y-3 scale-95 invisible group-hover:visible group-hover:opacity-100 
                  group-hover:translate-y-0 group-hover:scale-100 transition-all duration-300 ease-out origin-top">
        <a href="<?= site_url('roadmap'); ?>" class="block px-5 py-3 rounded-t-xl hover:bg-sky-100 hover:text-sky-700 transition duration-200">
           🗺️ Roadmap
        </a>
        <a href="<?= site_url('moodboard'); ?>" class="block px-5 py-3 rounded-b-xl hover:bg-sky-100 hover:text-sky-700 transition duration-200">
           🎨 Moodboard
        </a>
      </div>
    </div>

    <!-- User Section -->
    <?php if ($session->get('isLoggedIn')): 
        $firstName = explode(' ', trim($session->get('name')))[0] ?? 'User'; ?>
        
        <!-- Profile Dropdown (identical to Info, but slightly larger width) -->
        <div class="relative ml-4 group">
          <a href="#" class="flex items-center gap-2 focus:outline-none hover:text-sky-300 transition duration-300" id="profileBtn" aria-haspopup="true" aria-expanded="false" aria-controls="profileMenu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-8 h-8 text-white rounded-full bg-gray-800 p-1" viewBox="0 0 24 24">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            <span class="font-medium text-white">Hello, <?= esc($firstName) ?>!</span>
            <svg class="w-4 h-4 text-white transform group-hover:rotate-180 transition duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
          </a>

          <div id="profileMenu" class="absolute right-0 top-full mt-2 w-52 bg-white/90 backdrop-blur-lg text-black rounded-xl shadow-lg
                      opacity-0 translate-y-3 scale-95 invisible group-hover:visible group-hover:opacity-100
                      group-hover:translate-y-0 group-hover:scale-100 transition-all duration-300 ease-out origin-top z-50"
               role="menu" aria-labelledby="profileBtn">
            <a href="<?= site_url('account'); ?>" class="block px-5 py-3 rounded-t-xl text-gray-700 hover:bg-sky-100 hover:text-sky-700 transition duration-200" role="menuitem">
              👤 Account
            </a>
            <a href="<?= site_url('logout'); ?>" class="block px-5 py-3 rounded-b-xl text-gray-700 hover:bg-sky-100 hover:text-sky-700 transition duration-200" role="menuitem">
              🚪 Logout
            </a>
          </div>
        </div>

    <?php else: ?>
        <a href="<?= site_url('loginPage') ?>" 
           class="bg-gray-200 text-black px-5 py-2 rounded-full hover:bg-white hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 font-semibold">
           Join Waitlist
        </a>
    <?php endif; ?>

  </nav>
</header>

<!-- Script: makes dropdown toggle work on touch devices -->
<script>
  (function(){
    const profileMenu = document.getElementById('profileMenu');
    if (!profileMenu) return;
    const group = profileMenu.closest('.group');
    const btn = document.getElementById('profileBtn');

    btn?.addEventListener('click', (e) => {
      profileMenu.classList.toggle('visible');
      btn.setAttribute('aria-expanded', profileMenu.classList.contains('visible'));
      e.preventDefault();
      e.stopPropagation();
    });

    document.addEventListener('click', (ev) => {
      if (!group.contains(ev.target)) {
        profileMenu.classList.remove('visible');
        btn.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', (ev) => {
      if (ev.key === 'Escape') {
        profileMenu.classList.remove('visible');
        btn.setAttribute('aria-expanded', 'false');
        btn.focus();
      }
    });
  })();
</script>
