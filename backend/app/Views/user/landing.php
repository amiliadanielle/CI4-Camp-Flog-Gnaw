<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Camp Flog Gnaw</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  <!-- AOS (Animate On Scroll) Library -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">

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
</head>

<body class="font-balsamiq min-h-screen flex flex-col bg-white">

  <!-- ✅ Header -->
  <?= $this->include('components/header'); ?>

  <!-- Main Content (with background image only here) -->
  <main class="flex flex-col md:flex-row items-center justify-between px-8 md:px-32 py-16 flex-grow 
               bg-cover bg-center pt-28"
        style="background-image: url('<?= base_url('img/bg.png') ?>');">
    <!-- Left Section -->
    <div class="md:w-1/2 space-y-6 text-center md:text-left text-white">
      <h2 class="text-3xl md:text-4xl font-bold leading-snug">
        NOVEMBER 15–16, 2025 <br>
        DODGER STADIUM GROUNDS
      </h2>
      <p class="text-lg">CAMP FLOG GNAW 2025 IS COMPLETELY SOLD OUT.</p>
    </div>

    <!-- Right Section -->
    <div class="md:w-1/2 mt-8 md:mt-0 flex justify-end">
      <img src="<?= base_url('img/wordsearch.png') ?>" alt="Lineup Word Search" class="rounded shadow-lg max-w-lg">
    </div>
  </main>

  <!-- Cards Section -->
  <?= view('components/cards'); ?>

  <!-- Flog Archive Section -->
  <section class="bg-sky-100 px-8 md:px-32 py-16">
    <h1 class="text-3xl font-bold mb-8">FLOG ARCHIVE</h1>

    <div class="relative">
      <!-- Left Arrow -->
      <button id="scrollLeft"
        class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2 z-10 hover:bg-gray-200 transition">
        &#8592;
      </button>

      <!-- Scrollable Images -->
      <div id="gallery" class="flex overflow-x-hidden space-x-6 scroll-smooth">
        <img src="<?= base_url('img/img1.jpg') ?>" alt="Gallery 1" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img2.jpg') ?>" alt="Gallery 2" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img3.jpg') ?>" alt="Gallery 3" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img4.jpg') ?>" alt="Gallery 4" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img5.jpg') ?>" alt="Gallery 5" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img6.jpg') ?>" alt="Gallery 6" class="h-[28rem] rounded-lg flex-shrink-0">
        <img src="<?= base_url('img/img7.jpg') ?>" alt="Gallery 7" class="h-[28rem] rounded-lg flex-shrink-0">
      </div>

      <!-- Right Arrow -->
      <button id="scrollRight"
        class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2 z-10 hover:bg-gray-200 transition">
        &#8594;
      </button>
    </div>
  </section>

  <!-- CTA Section (component) -->
  <?= view('components/cta'); ?>

  <!-- Image right before the footer -->
  <div class="w-full">
    <img src="<?= base_url('img/footer.png') ?>" alt="Banner Image" class="w-full object-cover">
  </div>

  <?= view('components/footer'); ?>

  <!-- Smooth infinite scroll script -->
  <script>
    (function () {
      const gallery = document.getElementById('gallery');
      if (!gallery) return;

      const scrollLeftBtn = document.getElementById('scrollLeft');
      const scrollRightBtn = document.getElementById('scrollRight');
      const images = Array.from(gallery.children);

      // if no images, nothing to do
      if (images.length === 0) return;

      // calculate width after images have loaded
      function imageWidthWithGap() {
        const first = gallery.children[0];
        const style = getComputedStyle(first);
        const marginRight = parseFloat(style.marginRight || 0);
        return Math.round(first.offsetWidth + marginRight);
      }

      // clone for infinite effect
      const imageWidth = imageWidthWithGap();
      const clonesBefore = images.map(img => img.cloneNode(true));
      const clonesAfter = images.map(img => img.cloneNode(true));
      clonesAfter.forEach(img => gallery.appendChild(img));
      clonesBefore.reverse().forEach(img => gallery.prepend(img));

      const totalClones = clonesBefore.length;
      gallery.scrollLeft = totalClones * imageWidth;

      function scrollTo(offsetIndex) {
        gallery.scrollTo({ left: offsetIndex * imageWidth, behavior: 'smooth' });
      }

      let currentIndex = 0;
      scrollRightBtn && scrollRightBtn.addEventListener('click', () => { currentIndex++; scrollTo(currentIndex + totalClones); });
      scrollLeftBtn && scrollLeftBtn.addEventListener('click', () => { currentIndex--; scrollTo(currentIndex + totalClones); });

      gallery.addEventListener('scroll', () => {
        const totalWidth = imageWidth * (images.length + totalClones * 2);
        if (gallery.scrollLeft <= imageWidth) {
          gallery.scrollLeft = totalWidth - (totalClones * imageWidth * 2);
        } else if (gallery.scrollLeft >= totalWidth - imageWidth) {
          gallery.scrollLeft = totalClones * imageWidth;
        }
      });
    })();
  </script>

  <script>
    AOS.init({
      duration: 1000,
      once: true,
      easing: 'ease-in-out'
    });
  </script>

  <!-- Robust Join-Waitlist fix: ensures Join Waitlist navigates to loginPage -->
  <script>
    (function () {
      const loginUrl = <?= json_encode(base_url('loginPage')) ?>;

      // Helper to set navigation handler on an element
      function attachNav(el) {
        if (!el) return;
        // If it's a button inside a form, prevent submit behavior
        if (el.tagName.toLowerCase() === 'button') {
          el.setAttribute('type', 'button');
          el.addEventListener('click', () => { window.location.href = loginUrl; });
          return;
        }
        // if it's a link (<a>)
        if (el.tagName.toLowerCase() === 'a') {
          el.addEventListener('click', (e) => {
            // allow modifiers (open in new tab)
            if (e.ctrlKey || e.metaKey || e.shiftKey) return;
            e.preventDefault();
            window.location.href = loginUrl;
          });
          return;
        }
        // fallback for other elements
        el.addEventListener('click', () => { window.location.href = loginUrl; });
      }

      // 1) If any element already has class "join-waitlist", attach handler
      document.querySelectorAll('.join-waitlist, [data-join="waitlist"]').forEach(el => attachNav(el));

      // 2) If there are anchors/buttons with href="#" or href="" and text contains "Join" or "Waitlist", attach handler
      const candidates = Array.from(document.querySelectorAll('a, button, [role="button"]'));
      candidates.forEach(el => {
        const text = (el.textContent || '').trim().toLowerCase();
        const href = el.getAttribute('href') || '';
        // match text that likely corresponds to join waitlist
        if (/(join|waitlist)/i.test(text) && (href === '#' || href === '' || el.classList.contains('join-waitlist'))) {
          attachNav(el);
        }
      });

      // 3) Defensive: if there's a form whose submit button contains "Join" or "Waitlist", intercept submit and redirect instead
      document.querySelectorAll('form').forEach(form => {
        const submitBtn = Array.from(form.querySelectorAll('button, input[type="submit"]')).find(b => {
          const t = (b.textContent || b.value || '').toLowerCase();
          return /(join|waitlist)/i.test(t);
        });
        if (submitBtn) {
          // ensure button won't submit
          if (submitBtn.tagName.toLowerCase() === 'button') submitBtn.setAttribute('type', 'button');
          submitBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.location.href = loginUrl;
          });
        }
      });
    })();
  </script>

</body>
</html>
