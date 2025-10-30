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

  <style>
    /* small helper to keep spinner centered */
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
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>

<body class="font-balsamiq min-h-screen flex items-center justify-center relative bg-white">

  <!-- Background Image with Overlay -->
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= base_url('img/bg.png'); ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
  </div>

<?php
  $session = session();

  // If already logged in, send user to landing immediately
  if ($session->get('isLoggedIn')) {
    // server-side redirect is safest; if headers already sent this will not work,
    // but normally views are returned by controllers, so we attempt redirect.
    header('Location: ' . base_url('landingPage'));
    exit;
  }

  // collect flash data
  $flashErrors = $session->getFlashdata('errors') ?? [];
  $flashMessage = $session->getFlashdata('message') ?? $session->getFlashdata('success') ?? null;
  $old = $session->getFlashdata('old') ?? [];
  $oldEmail = esc(old('email') ?? $old['email'] ?? '');

  // normalize errors so we can check field-specific ones
  // if controller set errors as array keyed by field, we use them; if a string, show as general.
  $fieldErrors = [];
  $generalErrors = [];

  if (!empty($flashErrors)) {
    if (is_array($flashErrors)) {
      // Could be associative (field => msg) or indexed list; handle both
      foreach ($flashErrors as $k => $v) {
        if (is_int($k)) {
          // numeric key -> general message
          $generalErrors[] = is_array($v) ? implode(' ', $v) : $v;
        } else {
          // field specific
          $fieldErrors[$k] = is_array($v) ? implode(' ', $v) : $v;
        }
      }
    } else {
      $generalErrors[] = $flashErrors;
    }
  }
?>

  <!-- 🔙 Back Arrow Button -->
<a href="<?= base_url('landingPage'); ?>" 
   class="absolute top-6 left-6 z-20 text-white hover:text-orange-400 transition" aria-label="Back to landing page">
  <!-- SVG Back Arrow Icon -->
  <svg xmlns="http://www.w3.org/2000/svg" 
       fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" 
       class="w-8 h-8" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
  </svg>
</a>

  <!-- Main Card -->
  <div class="relative z-10 bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl flex overflow-hidden w-full max-w-[1000px] h-auto md:h-[560px] mx-4">

    <!-- Left: Login Form -->
    <div class="w-full md:w-1/2 p-8 md:p-10 flex flex-col justify-center bg-white/90">
      <h2 class="text-2xl font-semibold text-orange-600 mb-6">LOG IN</h2>

      <!-- Success / General Message -->
      <?php if ($flashMessage): ?>
        <div id="flashMessage" class="mb-4 p-3 rounded-md bg-green-50 text-green-700 text-sm">
          <?= esc($flashMessage) ?>
        </div>
      <?php endif; ?>

      <!-- General Errors -->
      <?php if (!empty($generalErrors)): ?>
        <div class="mb-4 p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
          <ul class="list-disc list-inside">
            <?php foreach ($generalErrors as $err): ?>
              <li><?= esc($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form id="loginForm" action="<?= base_url('login'); ?>" method="post" class="space-y-4" novalidate>
        <?= csrf_field() ?>

        <!-- Email -->
        <div>
          <label for="email" class="sr-only">Email</label>
          <input
            id="email"
            type="email"
            name="email"
            placeholder="Email"
            required
            aria-required="true"
            aria-invalid="<?= isset($fieldErrors['email']) ? 'true' : 'false' ?>"
            value="<?= $oldEmail ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400"
          >
          <?php if (!empty($fieldErrors['email'])): ?>
            <p class="mt-2 text-sm text-red-600"><?= esc($fieldErrors['email']) ?></p>
          <?php else: ?>
            <p id="emailError" class="mt-2 text-sm text-red-600 hidden"></p>
          <?php endif; ?>
        </div>
        
        <!-- Password -->
        <div class="relative">
          <label for="password" class="sr-only">Password</label>
          <input
            id="password"
            type="password"
            name="password"
            placeholder="Password"
            required
            aria-required="true"
            aria-invalid="<?= isset($fieldErrors['password']) ? 'true' : 'false' ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-400 pr-12"
          >
          <button type="button" id="togglePassword" aria-label="Show password"
            class="absolute right-2 top-1/2 -translate-y-1/2 bg-transparent p-1 text-sm text-gray-600 hover:text-gray-900">
            Show
          </button>
          <?php if (!empty($fieldErrors['password'])): ?>
            <p class="mt-2 text-sm text-red-600"><?= esc($fieldErrors['password']) ?></p>
          <?php else: ?>
            <p id="passwordError" class="mt-2 text-sm text-red-600 hidden"></p>
          <?php endif; ?>
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" id="remember" class="h-4 w-4">
            <span>Remember me</span>
          </label>

          <!-- Forgot Password -->
          <div class="text-right">
            <a href="#" class="text-sm text-orange-600 hover:underline">Forgot password?</a>
          </div>
        </div>

        <!-- Login Button -->
        <div>
          <button id="submitBtn" type="submit"
            class="w-full bg-orange-500 text-white font-semibold py-2 rounded-lg hover:bg-orange-400 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center">
            <span id="btnText">Log In</span>
            <span id="btnSpinner" class="ml-2 hidden" aria-hidden="true">
              <span class="spinner" role="status" aria-hidden="true"></span>
            </span>
          </button>
        </div>
      </form>

      <!-- Sign Up Link -->
      <div class="mt-6 text-center">
        <p class="text-sm text-gray-700">
          Don’t have an account? 
          <a href="<?= base_url('signupPage'); ?>" class="text-orange-500 font-medium hover:underline">
            Sign Up Here
          </a>
        </p>
      </div>
    </div>

    <!-- Right: Poster fills entire half -->
    <div class="hidden md:block md:w-1/2 relative">
      <img 
        src="<?= base_url('../img/flog.jpg'); ?>" 
        alt="Poster" 
        class="w-full h-full object-cover object-center rounded-r-3xl">
      <!-- subtle overlay to ensure contrast -->
      <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white/40 pointer-events-none"></div>
    </div>

  </div>

  <script>
    // If server set a success message and login was successful, redirect to landing
    (function () {
      const hasFlash = <?= json_encode((bool)$flashMessage) ?>;
      // Some controllers may set 'success' flash when they redirect to this view after login.
      if (hasFlash) {
        setTimeout(() => {
          window.location.href = <?= json_encode(base_url('landingPage')) ?>;
        }, 600); // small delay so user sees message
      }
    })();

    // Toggle password visibility
    (function () {
      const toggleBtn = document.getElementById('togglePassword');
      const passwordInput = document.getElementById('password');

      toggleBtn.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        toggleBtn.textContent = type === 'password' ? 'Show' : 'Hide';
      });
    })();

    // Client-side validation + submit state (spinner / disable)
    (function () {
      const form = document.getElementById('loginForm');
      const submitBtn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');
      const btnSpinner = document.getElementById('btnSpinner');

      const emailInput = document.getElementById('email');
      const passwordInput = document.getElementById('password');
      const emailError = document.getElementById('emailError');
      const passwordError = document.getElementById('passwordError');

      function showError(el, message) {
        if (!el) return;
        el.textContent = message;
        el.classList.remove('hidden');
      }

      function hideError(el) {
        if (!el) return;
        el.textContent = '';
        el.classList.add('hidden');
      }

      form.addEventListener('submit', function (e) {
        // Clear previous errors
        hideError(emailError);
        hideError(passwordError);

        let valid = true;

        // Basic client-side checks
        if (!emailInput.value.trim()) {
          showError(emailError, 'Email is required.');
          valid = false;
        } else if (!/^\S+@\S+\.\S+$/.test(emailInput.value.trim())) {
          showError(emailError, 'Please enter a valid email address.');
          valid = false;
        }

        if (!passwordInput.value.trim()) {
          showError(passwordError, 'Password is required.');
          valid = false;
        }

        if (!valid) {
          e.preventDefault();
          return;
        }

        // Prevent double submit: show spinner and disable button
        submitBtn.disabled = true;
        btnText.textContent = 'Signing in...';
        btnSpinner.classList.remove('hidden');
        // Let the form submit naturally (server-side will handle auth)
      });

      // optional: clear server errors on input
      emailInput.addEventListener('input', () => hideError(emailError));
      passwordInput.addEventListener('input', () => hideError(passwordError));
    })();
  </script>

</body>
</html>
