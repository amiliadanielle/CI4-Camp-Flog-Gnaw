<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
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

    /* subtle form backdrop so it stands out but doesn't look like a floating card */
    .panel {
      background: rgba(255,255,255,0.88);
      backdrop-filter: blur(6px);
      border-radius: 12px;
      padding: 1.25rem;
    }
  </style>
</head>

<body class="font-balsamiq min-h-screen flex items-center justify-center relative bg-white">

  <!-- Background Image with Overlay (kept) -->
  <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?= base_url('img/bg.png'); ?>');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>
  </div>

  <!-- 🔙 Back Arrow Button (kept) -->
  <a href="<?= base_url('loginPage'); ?>"
     class="absolute top-6 left-6 z-20 text-white hover:text-orange-400 transition"
     aria-label="Back to login">
    <svg xmlns="http://www.w3.org/2000/svg"
         fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
         class="w-8 h-8" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
    </svg>
  </a>

<?php
  $session = session();
  $errors  = $session->getFlashdata('errors') ?? [];
  $old     = $session->getFlashdata('old') ?? [];
  $successMsg = $session->getFlashdata('success') ?? $session->getFlashdata('message') ?? null;

  $oldFirst  = esc(old('first_name')  ?? $old['first_name']  ?? '');
  $oldMiddle = esc(old('middle_name') ?? $old['middle_name'] ?? '');
  $oldLast   = esc(old('last_name')   ?? $old['last_name']   ?? '');
  $oldEmail  = esc(old('email')       ?? $old['email']       ?? '');
?>

  <!-- Slim centered panel (no floating hero / poster) -->
  <main class="relative z-10 w-full max-w-xl mx-4 my-12">
    <section class="panel shadow-none">

      <h1 class="text-2xl font-semibold text-orange-600 mb-4">Sign Up</h1>

      <?php if ($successMsg): ?>
        <div id="successBanner" class="mb-4 p-3 rounded-md bg-green-50 border border-green-200 text-green-800 text-sm">
          <?= esc($successMsg) ?>
          <div class="mt-1 text-xs text-gray-600">Redirecting to login page… <a href="<?= base_url('loginPage') ?>" class="underline">Go now</a></div>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <div class="mb-4">
          <div class="p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
            <?php if (is_array($errors)): ?>
              <ul class="list-disc list-inside">
                <?php foreach ($errors as $k => $v): ?>
                  <li><?= esc(is_array($v) ? implode(' ', $v) : $v) ?></li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <?= esc($errors) ?>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <form id="signupForm" action="<?= base_url('signup'); ?>" method="post" class="space-y-4" novalidate>
        <?= csrf_field() ?>

        <div>
          <label for="first_name" class="sr-only">First Name</label>
          <input id="first_name" type="text" name="first_name" placeholder="First Name" required
            value="<?= $oldFirst ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
          <label for="middle_name" class="sr-only">Middle Name</label>
          <input id="middle_name" type="text" name="middle_name" placeholder="Middle Name (optional)"
            value="<?= $oldMiddle ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
          <label for="last_name" class="sr-only">Last Name</label>
          <input id="last_name" type="text" name="last_name" placeholder="Last Name" required
            value="<?= $oldLast ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div>
          <label for="email" class="sr-only">Email</label>
          <input id="email" type="email" name="email" placeholder="Email Address" required
            value="<?= $oldEmail ?>"
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400">
        </div>

        <div class="relative">
          <label for="password" class="sr-only">Password</label>
          <input id="password" type="password" name="password" placeholder="Password" required
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 pr-20">
          <button type="button" id="togglePassword" aria-label="Show password"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent p-1 text-sm text-gray-600 hover:text-gray-900">
            Show
          </button>
        </div>

        <div class="relative">
          <label for="password_confirm" class="sr-only">Confirm Password</label>
          <input id="password_confirm" type="password" name="password_confirm" placeholder="Confirm Password" required
            class="w-full px-4 py-2 border border-orange-500 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-400 pr-20">
          <button type="button" id="toggleConfirmPassword" aria-label="Show confirm password"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent p-1 text-sm text-gray-600 hover:text-gray-900">
            Show
          </button>
        </div>

        <div>
          <button id="submitBtn" type="submit"
            class="w-full bg-orange-500 text-white font-semibold py-2 rounded-md hover:bg-orange-400 transition disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center">
            <span id="btnText">Sign Up</span>
            <span id="btnSpinner" class="ml-2 hidden" aria-hidden="true">
              <span class="spinner" role="status" aria-hidden="true"></span>
            </span>
          </button>
        </div>
      </form>

      <div class="mt-4 text-center text-sm text-gray-700">
        Already have an account?
        <a href="<?= base_url('loginPage'); ?>" class="text-orange-500 font-medium hover:underline"> Log In Here</a>
      </div>
    </section>
  </main>

  <script>
    // If signup was successful, redirect to login page after delay.
    (function () {
      const success = <?= json_encode((bool)$successMsg) ?>;
      if (success) {
        setTimeout(() => {
          window.location.href = <?= json_encode(base_url('loginPage')) ?>;
        }, 1800);
      }
    })();

    // Toggle password visibility for both fields
    (function () {
      function setupToggle(toggleId, inputId) {
        const t = document.getElementById(toggleId);
        const inp = document.getElementById(inputId);
        if (!t || !inp) return;
        t.addEventListener('click', () => {
          const type = inp.getAttribute('type') === 'password' ? 'text' : 'password';
          inp.setAttribute('type', type);
          t.textContent = type === 'password' ? 'Show' : 'Hide';
        });
      }
      setupToggle('togglePassword', 'password');
      setupToggle('toggleConfirmPassword', 'password_confirm');
    })();

    // Client-side validation + submit state (spinner / disable)
    (function () {
      const form = document.getElementById('signupForm');
      const submitBtn = document.getElementById('submitBtn');
      const btnText = document.getElementById('btnText');
      const btnSpinner = document.getElementById('btnSpinner');

      const firstName = document.getElementById('first_name');
      const lastName = document.getElementById('last_name');
      const email = document.getElementById('email');
      const password = document.getElementById('password');
      const confirm = document.getElementById('password_confirm');

      function showError(el, msg) {
        // minimal client-side inline errors handled in browser; server errors use flash
        alert(msg);
      }

      form.addEventListener('submit', function (e) {
        // basic client-side checks
        if (!firstName.value.trim() || !lastName.value.trim() || !email.value.trim() ||
            !password.value.trim() || !confirm.value.trim()) {
          e.preventDefault();
          showError(null, 'Please fill all required fields.');
          return;
        }
        if (password.value.length < 8) {
          e.preventDefault();
          showError(null, 'Password must be at least 8 characters.');
          return;
        }
        if (password.value !== confirm.value) {
          e.preventDefault();
          showError(null, 'Passwords do not match.');
          return;
        }

        submitBtn.disabled = true;
        btnText.textContent = 'Signing up...';
        btnSpinner.classList.remove('hidden');
      });
    })();
  </script>

</body>
</html>
