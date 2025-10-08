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
  <main class="flex flex-col md:flex-row items-center justify-between px-32 py-16 flex-grow 
               bg-[url('../img/bg.png')] bg-cover bg-center pt-28">
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
      <img src="../img/wordsearch.png" alt="Lineup Word Search" class="rounded shadow-lg max-w-lg">
    </div>
  </main>

    <!-- Cards Section -->
 <?= view('components/cards'); ?>
 <?= view('components/button', ['label' => 'LEARN MORE']); ?>

<!-- Flog Archive Section -->
<section class="bg-sky-100 px-32 py-16">
  <h1 class="text-3xl font-bold mb-8">FLOG ARCHIVE</h1>

  <div class="relative">
    <!-- Left Arrow -->
    <button id="scrollLeft" 
      class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2 z-10 hover:bg-gray-200 transition">
      &#8592;
    </button>

    <!-- Scrollable Images -->
    <div id="gallery" class="flex overflow-x-hidden space-x-6 scroll-smooth">
      <img src="../img/img1.jpg" alt="Gallery 1" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img2.jpg" alt="Gallery 2" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img3.jpg" alt="Gallery 3" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img4.jpg" alt="Gallery 4" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img5.jpg" alt="Gallery 5" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img6.jpg" alt="Gallery 6" class="h-[28rem] rounded-lg flex-shrink-0">
      <img src="../img/img7.jpg" alt="Gallery 7" class="h-[28rem] rounded-lg flex-shrink-0">
    </div>

    <!-- Right Arrow -->
    <button id="scrollRight" 
      class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow p-2 z-10 hover:bg-gray-200 transition">
      &#8594;
    </button>
  </div>
</section>

<!-- ✅ Fixed Smooth Infinite Scroll Script -->
<script>
  const gallery = document.getElementById('gallery');
  const scrollLeftBtn = document.getElementById('scrollLeft');
  const scrollRightBtn = document.getElementById('scrollRight');
  const images = Array.from(gallery.children);
  const imageWidth = images[0].offsetWidth + 24; // include space-x gap
  let currentIndex = 0;

  // ✅ Clone first and last images for smooth infinite loop
  const clonesBefore = images.map(img => img.cloneNode(true));
  const clonesAfter = images.map(img => img.cloneNode(true));

  clonesAfter.forEach(img => gallery.appendChild(img));
  clonesBefore.reverse().forEach(img => gallery.prepend(img));

  const totalClones = clonesBefore.length;
  gallery.scrollLeft = totalClones * imageWidth; // center on originals

  // ✅ Smooth Scroll Function
  function scrollToIndex(index) {
    gallery.scrollTo({
      left: index * imageWidth,
      behavior: 'smooth'
    });
  }

  // ✅ Loop Handling
  function handleLoop() {
    const totalWidth = imageWidth * (images.length + totalClones * 2);

    if (gallery.scrollLeft <= imageWidth) {
      gallery.scrollLeft = totalWidth - (totalClones * imageWidth * 2);
    } 
    else if (gallery.scrollLeft >= totalWidth - imageWidth) {
      gallery.scrollLeft = totalClones * imageWidth;
    }
  }

  scrollRightBtn.addEventListener('click', () => {
    currentIndex++;
    scrollToIndex(currentIndex + totalClones);
  });

  scrollLeftBtn.addEventListener('click', () => {
    currentIndex--;
    scrollToIndex(currentIndex + totalClones);
  });

  gallery.addEventListener('scroll', handleLoop);

</script>


<?= view('components/cta'); ?>


<!-- Image right before the footer -->
<div class="w-full">
  <img src="../img/footer.png" alt="Banner Image" class="w-full object-cover">
</div>

<?= view('components/footer'); ?>

<script>
  AOS.init({
    duration: 1000,   // animation duration (ms)
    once: true,       // animate only once
    easing: 'ease-in-out'
  });
</script>

</body>
</html>
