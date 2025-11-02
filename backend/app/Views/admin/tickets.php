<?php // app/Views/tickets.php
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Tickets — Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Balsamiq Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <style>
    :root{ --accent: #fb923c; }
    body { font-family: 'Balsamiq Sans', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

    /* fixed background hero (same as dashboard/others) */
    .bg-fixed-hero {
      background-image: url('<?= base_url('img/bg.png') ?>');
      background-position: center;
      background-size: cover;
      background-attachment: fixed;
    }
    .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.6), rgba(0,0,0,0.65)); }

    .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(10px) saturate(120%); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; }
    .card-anim { transition: transform .28s cubic-bezier(.2,.9,.3,1), box-shadow .28s; }
    .card-anim:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 14px 40px rgba(0,0,0,0.45); }

    .sidebar { width: 320px; transform: translateX(-110%); transition: transform .36s cubic-bezier(.2,.9,.3,1); }
    .sidebar.active { transform: translateX(0%); }
    .overlay { background: rgba(0,0,0,0.6); opacity: 0; visibility: hidden; transition: opacity .24s ease; }
    .overlay.active { opacity: 1; visibility: visible; }

    /* make table area the only scrollable region */
    .table-scroll {
      max-height: 56vh; /* adjust if needed */
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      scroll-behavior: smooth;
    }
    .table-scroll::-webkit-scrollbar { width: 8px; }
    .table-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 8px; }

    /* sticky header inside table-scroll */
    .table-scroll thead th {
      position: sticky;
      top: 0;
      z-index: 10;
      backdrop-filter: blur(6px);
      background: rgba(0,0,0,0.55);
    }

    @media (max-width: 640px){ .sidebar { width: 85%; } }
  </style>
</head>
<body class="min-h-screen bg-gray-900 text-white bg-fixed-hero">

  <!-- BACKGROUND OVERLAY -->
  <div class="absolute inset-0 z-0">
    <div class="absolute inset-0 hero-overlay"></div>
  </div>

  <!-- HEADER -->
  <header class="relative z-30 flex items-center justify-between px-5 py-4 bg-black/30 backdrop-blur-sm">
    <div class="flex items-center gap-3">
      <button id="burgerBtn" class="p-2 bg-white/6 rounded-md hover:bg-white/10 transition" aria-label="Open menu">
        <div class="space-y-1">
          <span class="block w-6 h-0.5 bg-white"></span>
          <span class="block w-6 h-0.5 bg-white"></span>
          <span class="block w-6 h-0.5 bg-white"></span>
        </div>
      </button>
      <div>
        <h1 class="text-xl md:text-2xl font-extrabold" style="color:var(--accent)">Admin — Tickets</h1>
        <p class="text-xs text-white/70 hidden sm:block">Welcome back, <span class="font-medium"><?= esc(session()->get('name') ?? session()->get('email')) ?></span></p>
      </div>
    </div>

    <div class="flex items-center gap-4">
      <div class="hidden sm:flex items-center gap-3 glass px-3 py-1 rounded-md">
        <svg class="w-5 h-5 text-white/80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="8" r="3" stroke="currentColor" stroke-width="1.2"/><path d="M4 20c0-3.314 2.686-6 6-6h4c3.314 0 6 2.686 6 6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
        <div class="text-sm"><?= esc(session()->get('name') ?? session()->get('email')) ?></div>
      </div>
    </div>
  </header>

  <!-- SIDEBAR & OVERLAY -->
  <div id="overlay" class="overlay fixed inset-0 z-40"></div>

  <aside id="sidebar" class="sidebar fixed top-0 left-0 h-full z-50 p-6 glass">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-lg font-bold" style="color:var(--accent)">Admin Menu</h2>
        <p class="text-xs text-white/70">Quick management</p>
      </div>
      <button id="closeSidebar" class="text-2xl text-white/80 hover:text-white">&times;</button>
    </div>

    <nav class="flex flex-col gap-3">
      <a href="<?= base_url('dashboard') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🏠 Dashboard</a>
      <a href="<?= base_url('admin/booths') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🏕️ View Booths</a>
      <a href="<?= base_url('admin/singers') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🎤 View Singers</a>
      <a href="<?= base_url('admin/tickets') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🎟️ View Tickets</a>

      <button onclick="if(confirm('Logout admin?')) location.href='<?= base_url('logout') ?>';" class="text-left px-3 py-2 rounded-md hover:bg-white/10">🚪 Logout Admin</button>
    </nav>

    <div class="mt-auto text-xs text-white/60">
      <div>Logged in as: <span class="font-medium"><?= esc(session()->get('email') ?? 'admin') ?></span></div>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
<main class="relative z-20 max-w-6xl mx-auto px-6 py-10">
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Tickets</h1>
    <div class="flex gap-2">
      <a href="<?= base_url('dashboard') ?>" class="px-3 py-1 bg-white/6 rounded">Dashboard</a>
    </div>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 p-3 bg-green-600/20 border border-green-600 rounded"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="mb-4 p-3 bg-red-600/20 border border-red-600 rounded"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="bg-white/5 rounded p-4">
    <div class="table-scroll scrollbar-thin">
      <table class="w-full table-auto text-sm">
        <thead class="text-left text-white/70">
          <tr>
            <th class="px-3 py-2">Type</th>
            <th class="px-3 py-2">Price</th>
            <th class="px-3 py-2">Available</th>
            <th class="px-3 py-2">Sold</th>
            <th class="px-3 py-2">Description</th>
            <th class="px-3 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($tickets)): foreach ($tickets as $t): ?>
            <tr class="border-t border-white/6">
              <td class="px-3 py-3"><?= esc($t['type']) ?></td>
              <td class="px-3 py-3">₱ <?= number_format((float)($t['price'] ?? 0),2) ?></td>
              <td class="px-3 py-3"><?= esc($t['available'] ?? 0) ?></td>
              <td class="px-3 py-3"><?= esc($t['sold'] ?? 0) ?></td>
              <td class="px-3 py-3"><?= esc($t['description'] ?? '') ?></td>
              <td class="px-3 py-3">
                <button class="px-2 py-1 bg-blue-600/80 rounded text-xs" onclick="openEdit(<?= htmlspecialchars(json_encode($t), ENT_QUOTES, 'UTF-8') ?>, 'ticket')">Edit</button>
                <a href="<?= base_url('admin/ticketDelete/'.$t['id']) ?>" onclick="return confirm('Delete ticket?')" class="px-2 py-1 bg-red-600/80 rounded text-xs ml-2">Delete</a>
              </td>
            </tr>
          <?php endforeach; else: ?>
            <tr><td colspan="6" class="px-3 py-6 text-center text-white/70">No tickets found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Inline edit form -->
  <div id="ticketEdit" class="mt-6 hidden bg-white/5 p-4 rounded">
    <h3 class="font-semibold mb-3">Edit Ticket</h3>
    <form id="ticketEditForm" action="<?= base_url('admin/ticketSave') ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="edit_ticket_id">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block text-xs text-white/70 mb-1">Type</label>
          <input id="edit_ticket_type" name="type" class="w-full px-3 py-2 rounded bg-black/30" required>
        </div>
        <div>
          <label class="block text-xs text-white/70 mb-1">Price</label>
          <input id="edit_ticket_price" name="price" type="number" step="0.01" class="w-full px-3 py-2 rounded bg-black/30" required>
        </div>
        <div>
          <label class="block text-xs text-white/70 mb-1">Available</label>
          <input id="edit_ticket_available" name="available" type="number" class="w-full px-3 py-2 rounded bg-black/30">
        </div>
        <div>
          <label class="block text-xs text-white/70 mb-1">Sold</label>
          <input id="edit_ticket_sold" name="sold" type="number" class="w-full px-3 py-2 rounded bg-black/30">
        </div>
        <div class="md:col-span-2">
          <label class="block text-xs text-white/70 mb-1">Description</label>
          <textarea id="edit_ticket_description" name="description" class="w-full px-3 py-2 rounded bg-black/30"></textarea>
        </div>
      </div>
      <div class="mt-3 flex gap-2 justify-end">
        <button type="submit" class="px-3 py-1 bg-[--accent] text-black rounded" style="--accent:#fb923c">Save</button>
        <button type="button" onclick="document.getElementById('ticketEdit').classList.add('hidden')" class="px-3 py-1 bg-white/6 rounded">Cancel</button>
      </div>
    </form>
  </div>

  <script>
    function openEdit(obj, type){
      if (type === 'ticket'){
        document.getElementById('edit_ticket_id').value = obj.id || '';
        document.getElementById('edit_ticket_type').value = obj.type || '';
        document.getElementById('edit_ticket_price').value = obj.price || '';
        document.getElementById('edit_ticket_available').value = obj.available || 0;
        document.getElementById('edit_ticket_sold').value = obj.sold || 0;
        document.getElementById('edit_ticket_description').value = obj.description || '';
        document.getElementById('ticketEdit').classList.remove('hidden');

        const tableScroll = document.querySelector('.table-scroll');
        if (tableScroll) tableScroll.scrollTop = 0;
        setTimeout(()=> { document.getElementById('ticketEdit').scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 80);
      }
    }
  </script>
</main>


  <script>
    AOS && AOS.init && AOS.init();

    // Sidebar toggle
    const burgerBtn = document.getElementById('burgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');

    function setSidebar(open){
      sidebar.classList.toggle('active', open);
      overlay.classList.toggle('active', open);
    }
    burgerBtn && burgerBtn.addEventListener('click', ()=> setSidebar(true));
    closeSidebar && closeSidebar.addEventListener('click', ()=> setSidebar(false));
    overlay && overlay.addEventListener('click', ()=> {
      setSidebar(false);
      document.getElementById('ticketEdit')?.classList.add('hidden');
    });

    // safe parse helper
    function safeParse(s){ try{ return JSON.parse(s); }catch(e){ return null; } }

    function openEdit(obj, type){
      if (type === 'ticket'){
        document.getElementById('edit_ticket_id').value = obj.id || '';
        document.getElementById('edit_ticket_type').value = obj.type || '';
        document.getElementById('edit_ticket_price').value = obj.price || '';
        document.getElementById('edit_ticket_available').value = obj.available || 0;
        document.getElementById('edit_ticket_description').value = obj.description || '';
        document.getElementById('ticketEdit').classList.remove('hidden');

        // ensure the table scroll doesn't hide edit form
        const tableScroll = document.querySelector('.table-scroll');
        if (tableScroll) tableScroll.scrollTop = 0;

        setTimeout(()=> {
          const editEl = document.getElementById('ticketEdit');
          if (editEl) editEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 80);
      }
    }
  </script>
</body>
</html>
