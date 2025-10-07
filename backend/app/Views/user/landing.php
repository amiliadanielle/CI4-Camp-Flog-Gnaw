<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Camp Flog Gnaw</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

  
  <!-- Google Fonts -->
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
<body class="font-balsamiq min-h-screen flex flex-col bg-white">

  <!-- Header (Fixed) -->
  <header class="fixed top-0 left-0 w-full bg-black bg-opacity-90 backdrop-blur-sm text-white flex items-center justify-between px-32 py-5 z-50">
    <div class="flex items-center space-x-6">
      <img src="../img/logo.svg" alt="Logo" class="w-12 h-12 rounded-full">
    </div>
    <nav class="space-x-6 uppercase text-md font-medium">
      <a href="#" class="hover:text-gray-400">Lineup</a>
      <a href="#" class="hover:text-gray-400">Passes</a>
      <a href="#" class="hover:text-gray-400">Info</a>
    <a href="<?= site_url('loginPage') ?>" 
   class="bg-gray-200 text-black px-4 py-2 rounded hover:bg-white transition font-semibold">
   Join Waitlist
</a>
    </nav>
  </header>

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

    <!-- Join Waitlist Button -->
    <a href="<?= site_url('loginPage'); ?>" 
       class="bg-black text-white px-8 py-3 rounded hover:bg-gray-800 transition font-semibold inline-block">
      JOIN WAITLIST
    </a>
  </div>

  <!-- Right Section -->
  <div class="md:w-1/2 mt-8 md:mt-0 flex justify-end">
    <img src="../img/wordsearch.png" alt="Lineup Word Search" class="rounded shadow-lg max-w-lg">
  </div>
</main>

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


<!-- Sign Up Section -->
<section class="bg-sky-100 px-4 py-16">
<div class="w-[85%] mx-auto bg-sky-200 rounded-lg shadow-lg p-10 flex flex-col md:flex-row items-center gap-10">
    
    <!-- Left Images -->
    <div class="flex flex-col items-center space-y-6">
      <img src="../img/signup2.png" alt="Radio" class="w-59 h-59">    </div>

    <!-- Right Form -->
    <div class="flex-1">
      <h2 class="text-2xl font-bold mb-6">SIGN UP FOR THE LATEST CAMP FLOG GNAW UPDATES!</h2>
      
      <form class="space-y-6">
        <!-- Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-2">Email Address</label>
            <input type="email" placeholder="contact@cfg.com (Required)"
              class="w-full px-4 py-2 rounded-md bg-sky-100 focus:outline-none focus:ring-2 focus:ring-black">
          </div>
          <div>
            <label class="block text-sm font-medium mb-2">Mobile Number</label>
            <input type="text" placeholder="###-###-####"
              class="w-full px-4 py-2 rounded-md bg-sky-100 focus:outline-none focus:ring-2 focus:ring-black">
          </div>
        </div>

        <!-- Checkboxes -->
        <div class="space-y-4 text-sm">
          <label class="flex items-start space-x-2">
            <input type="checkbox" class="mt-1">
            <span>I would like Goldenvoice to send me updates and the latest information.</span>
          </label>
          <label class="flex items-start space-x-2">
            <input type="checkbox" class="mt-1">
            <span>
              I agree to receive autodialed marketing and promotional text messages sent by or on behalf of Camp Flog Gnaw and Tyler, The Creator at the provided phone number. I understand that my consent is not required and is not a condition of any purchase. MSG and DATA rates may apply. MSG frequency varies. My consent may be revoked at any time. TEXT STOP to opt-out or HELP for help. I agree to the AEG Presents 
              <a href="#" class="text-green-700 font-bold hover:underline">Terms of Use</a> and acknowledge the 
              <a href="#" class="text-green-700 font-bold hover:underline">AEG Privacy Policy</a>.
            </span>
          </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="px-6 py-3 border border-black rounded-md font-semibold hover:bg-black hover:text-white transition">
          SUBSCRIBE NOW
        </button>
      </form>
    </div>
  </div>
</section>

<!-- Image right before the footer -->
<div class="w-full">
  <img src="../img/footer.png" alt="Banner Image" class="w-full object-cover">
</div>

<?= view('components/footer'); ?>
</body>
</html>