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

  <style>
    .spinner {
      border: 3px solid rgba(255,255,255,0.15);
      border-top: 3px solid white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      animation: spin 0.75s linear infinite;
      display:inline-block;
      vertical-align: middle;
      margin-left: 8px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* subtle translucent form background for readability */
    .glass {
      background: rgba(255,255,255,0.06);
      backdrop-filter: blur(6px);
      border: 1px solid rgba(255,255,255,0.06);
    }
  </style>
</head>
<body class="font-balsamiq min-h-screen flex items-center justify-center relative bg-white">

  <!-- Background Image + dark overlay (unchanged) -->
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= base_url('img/bg.png'); ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
  </div>

  <!-- Back Button (kept) -->
  <a href="<?= base_url('users'); ?>"
     class="absolute top-6 left-6 z-20 text-white hover:text-orange-400 transition" aria-label="Back to landing page">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

<?php
  $session = session();
  $errorMessage = $session->getFlashdata('error') ?? null;
  $message = $session->getFlashdata('message') ?? null;
  $oldEmail = esc(old('email') ?? '');
?>

  <!-- Simple centered container (no big floating card, no poster) -->
  <main class="relative z-10 w-full max-w-lg mx-4">
    <section class="glass rounded-lg p-8 md:p-10 text-white shadow-lg">
<h1 class="text-2xl md:text-3xl font-semibold text-orange-500 mb-4 text-center mx-auto">
  LOG IN
</h1>

      <!-- Flash messages -->
      <?php if ($message): ?>
        <div class="mb-4 p-3 rounded-md bg-green-50 text-green-700 text-sm">
          <?= esc($message) ?>
        </div>
      <?php endif; ?>

      <?php if ($errorMessage): ?>
        <div class="mb-4 p-3 rounded-md bg-red-50 text-red-700 text-sm">
          <?= esc($errorMessage) ?>
        </div>
      <?php endif; ?>

      <!-- Form (posts to /login) -->
      <form id="loginForm" action="<?= base_url('login'); ?>" method="post" class="space-y-4" novalidate>
        <?= csrf_field() ?>

        <div>
          <label for="email" class="sr-only">Email</label>
          <input id="email" type="email" name="email" placeholder="Email" value="<?= $oldEmail ?>"
            required
            class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-orange-400 text-white">
        </div>

        <div class="relative">
          <label for="password" class="sr-only">Password</label>
          <input id="password" type="password" name="password" placeholder="Password" required
            class="w-full px-4 py-3 rounded-lg bg-transparent border border-white/20 placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-orange-400 text-white pr-12">
          <button type="button" id="togglePassword" aria-label="Show password"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-transparent p-1 text-sm text-white/80 hover:text-white">
            Show
          </button>
        </div>

        <div class="flex items-center justify-between text-sm">
          <label class="flex items-center gap-2 text-white/80">
            <input type="checkbox" name="remember" id="remember" class="h-4 w-4 accent-orange-400">
            <span>Remember me</span>
          </label>
          <a href="#" class="text-orange-400 hover:underline">Forgot password?</a>
        </div>

        <div>
          <button type="submit"
            class="w-full bg-orange-500 text-white font-semibold py-3 rounded-lg hover:bg-orange-400 transition flex items-center justify-center">
            <span id="btnText">Log In</span>
            <span id="btnSpinner" class="ml-2 hidden" aria-hidden="true">
              <span class="spinner" role="status" aria-hidden="true"></span>
            </span>
          </button>
        </div>
      </form>

      <p class="mt-6 text-center text-white/80">
        Don’t have an account?
        <a href="<?= base_url('signupPage'); ?>" class="text-orange-400 font-medium hover:underline"> Sign Up Here</a>
      </p>
    </section>
  </main>

  <script>
    // Toggle password visibility
    (function () {
      const toggleBtn = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');
      if (!toggleBtn || !passwordInput) return;
      toggleBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleBtn.textContent = type === 'password' ? 'Show' : 'Hide';
      });
    })();

    // Prevent double submit and show spinner (optional UX)
    (function () {
      const form = document.getElementById('loginForm');
      const btn = document.getElementById('btnText');
      const spinnerWrap = document.getElementById('btnSpinner');
      if (!form) return;
      form.addEventListener('submit', function (e) {
        // basic client-side check
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        if (!email || !password) {
          // let server handle nice validation messages — prevent submit only if empty
          e.preventDefault();
          return;
        }
        // disable to avoid double submit
        form.querySelector('button[type="submit"]').disabled = true;
        btn.textContent = 'Signing in...';
        spinnerWrap.classList.remove('hidden');
      });
    })();
  </script>
</body>
</html>
