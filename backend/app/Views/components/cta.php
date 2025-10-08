<!-- Sign Up Section -->
<section class="bg-sky-100 px-4 py-16">
  <div class="w-[85%] mx-auto bg-sky-200 rounded-lg shadow-lg p-10 flex flex-col md:flex-row items-center gap-10">
    
    <!-- Left Images -->
    <div class="flex flex-col items-center space-y-6">
      <img src="../img/signup2.png" alt="Radio" class="w-59 h-59">
    </div>

    <!-- Right Form -->
    <div class="flex-1">
      <h2 class="text-2xl font-bold mb-6">SIGN UP FOR THE LATEST CAMP FLOG GNAW UPDATES!</h2>
      
      <form id="subscribeForm" class="space-y-6">
        <!-- Inputs -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium mb-2">Email Address</label>
            <input id="email" type="email" placeholder="contact@cfg.com (Required)"
              class="w-full px-4 py-2 rounded-md bg-sky-100 focus:outline-none focus:ring-2 focus:ring-black" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-2">Mobile Number</label>
            <input id="phone" type="text" placeholder="###-###-####"
              class="w-full px-4 py-2 rounded-md bg-sky-100 focus:outline-none focus:ring-2 focus:ring-black" required>
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
        <button id="subscribeBtn" type="submit" 
          class="px-6 py-3 border border-black rounded-md font-semibold hover:bg-black hover:text-white transition-all duration-300">
          SUBSCRIBE NOW
        </button>
      </form>
    </div>
  </div>
</section>

<!-- ✅ Script for Dynamic Button Change -->
<script>
  const form = document.getElementById('subscribeForm');
  const button = document.getElementById('subscribeBtn');
  const emailInput = document.getElementById('email');
  const phoneInput = document.getElementById('phone');

  form.addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent page reload

    if (emailInput.value.trim() && phoneInput.value.trim()) {
      button.textContent = "Thank you for subscribing!";
      button.classList.add("bg-green-500", "text-white", "border-green-500");
      button.disabled = true; // disable after success
    } else {
      button.textContent = "Please fill in all fields";
      button.classList.add("bg-red-500", "text-white", "border-red-500");
      setTimeout(() => {
        button.textContent = "SUBSCRIBE NOW";
        button.classList.remove("bg-red-500", "text-white", "border-red-500");
      }, 2000);
    }
  });
</script>
