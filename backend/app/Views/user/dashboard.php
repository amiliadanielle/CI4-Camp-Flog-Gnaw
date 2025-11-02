<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Balsamiq Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!-- AOS for scroll animations -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- CSRF meta tags for JS (CodeIgniter 4) -->
  <meta id="csrf-name" content="<?= csrf_token() ?>">
  <meta id="csrf-hash" content="<?= csrf_hash() ?>">

  <style>
    :root{
      --accent: #fb923c;
      --bg: #0b0b0d;
      --glass-bg: rgba(255,255,255,0.04);
      --glass-border: rgba(255,255,255,0.06);
    }

    body {
      font-family: 'Balsamiq Sans', system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      color: #fff;
      background-color: #060607;
    }

    .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.6), rgba(0,0,0,0.7)); }

    .glass {
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      backdrop-filter: blur(10px) saturate(120%);
      border: 1px solid var(--glass-border);
      border-radius: 14px;
      transition: transform .26s cubic-bezier(.2,.9,.2,1), box-shadow .26s;
    }
    .glass:hover { transform: translateY(-8px); box-shadow: 0 18px 40px rgba(0,0,0,0.6); }

    .mini { font-size: 0.9rem; color: rgba(255,255,255,0.78); }
    .small-muted { font-size:.82rem; color:rgba(255,255,255,0.62); }

    /* Aligned top cards: centered, equal height */
    .grid-top-container {
      display:flex;
      justify-content:center;
      width:100%;
    }
    .grid-top {
      display:flex;
      gap:1rem;
      align-items:stretch; /* equal height */
      justify-content:space-between;
      width:620px; /* comfortable width for two cards */
      margin:0 auto;
    }
    .square-card {
      flex: 0 0 300px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      align-items:center;
      padding:1rem;
      min-height:220px;
    }
    .rect-card {
      padding:1rem;
      max-width:620px;
      margin:0 auto;
    }

    .sidebar { width: 320px; transform: translateX(-110%); transition: transform .38s cubic-bezier(.2,.9,.2,1); box-shadow: 0 18px 40px rgba(0,0,0,0.5); }
    .sidebar.active { transform: translateX(0%); }

    .overlay { background: rgba(0,0,0,0.6); opacity: 0; visibility: hidden; transition: opacity .24s ease; }
    .overlay.active { opacity: 1; visibility: visible; }

    .btn-sm {
      padding: .42rem .7rem;
      border-radius: .6rem;
      font-size: .92rem;
      display:inline-flex;
      align-items:center;
      gap:.5rem;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border: 1px solid rgba(255,255,255,0.03);
      transition: transform .12s, background .12s, box-shadow .12s;
    }
    .btn-sm:active { transform: translateY(1px) scale(.997); }
    .btn-accent {
      background: linear-gradient(90deg, rgba(251,146,60,0.12), rgba(251,146,60,0.08));
      border: 1px solid rgba(251,146,60,0.14);
      color: white;
      box-shadow: 0 6px 20px rgba(251,146,60,0.06);
    }

    .modal-backdrop {
      position: fixed; inset: 0; display: none; align-items: center; justify-content: center; z-index: 60; padding: 2rem; pointer-events: none;
    }
    .modal-backdrop.active { display:flex; pointer-events: auto; }
    .modal {
      max-width: 720px; width: 100%;
      background: linear-gradient(180deg, rgba(8,8,8,0.98), rgba(10,10,10,0.98));
      border-radius: 12px; padding: 1.1rem;
      box-shadow: 0 18px 60px rgba(0,0,0,0.6);
      border: 1px solid rgba(255,255,255,0.04);
      transform-origin: center; opacity: 0; transform: translateY(12px) scale(.995);
      transition: opacity .26s ease, transform .26s cubic-bezier(.2,.9,.2,1);
    }
    .modal-backdrop.active .modal { opacity: 1; transform: translateY(0) scale(1); }

    .modal .modal-head { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:.6rem; }
    .modal .modal-head h3 { margin:0; font-size:1.05rem; font-weight:700; color:var(--accent); }

    .field { margin-bottom: .7rem; }
    .field label { display:block; font-size:.9rem; margin-bottom:.28rem; color:#dcdcdc; }
    .field input, .field textarea, .field select {
      width:100%; padding:.6rem .75rem; border-radius:8px; background:#0f0f10; color:#fff; border:1px solid rgba(255,255,255,0.04);
      outline: none; transition: box-shadow .12s, border-color .12s;
    }
    .field input:focus, .field textarea:focus, .field select:focus {
      border-color: rgba(251,146,60,0.7);
      box-shadow: 0 6px 24px rgba(251,146,60,0.06);
    }

    .list-row { display:flex; justify-content:space-between; gap:10px; padding:.55rem; border-radius:8px; background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.00)); margin-bottom:.5rem; align-items:center; transition: background .12s, transform .08s; }
    .list-row:hover { background: rgba(255,255,255,0.02); transform: translateY(-3px); }

    .count-anim { display:inline-block; transition: transform .26s; }

    /* toast */
    .toast-wrap {
      position: fixed; top: 1.2rem; right: 1.2rem; z-index: 80;
      display:flex; flex-direction:column; gap:.5rem; align-items:flex-end;
      pointer-events: none;
    }
    .toast {
      min-width: 220px; max-width: 380px;
      background: rgba(15,15,15,0.96); border-radius: 10px; padding:.6rem .9rem;
      border: 1px solid rgba(255,255,255,0.04);
      box-shadow: 0 12px 30px rgba(0,0,0,0.6);
      display:flex; gap:.6rem; align-items:center; pointer-events: auto;
      transform-origin: top right;
      opacity: 0; transform: translateY(-6px) scale(.985); transition: opacity .22s, transform .22s;
    }
    .toast.show { opacity: 1; transform: translateY(0) scale(1); }
    .toast .title { font-weight:700; color:var(--accent); }
    .toast .desc { font-size:.9rem; color:#ddd; }

    @media (max-width:920px) {
      .grid-top { width:100%; max-width:100%; padding:0 1rem; flex-direction:column; gap: .75rem; }
      .square-card { flex:1 1 auto; min-height:160px; width:100%; }
      .rect-card { max-width:100%; padding:1rem; }
    }
  </style>
</head>

<body class="min-h-screen bg-gray-900 text-white relative overflow-x-hidden">

<?php
// ---------- SAFELY AGGREGATE DATA ----------
// Use controller-provided counts if present; otherwise query DB for accurate numbers.
$booths_count = isset($booths) && is_array($booths) ? count($booths) : null;
$singers_count = isset($singers) && is_array($singers) ? count($singers) : null;
$tickets_list = isset($tickets) && is_array($tickets) ? $tickets : (isset($tickets_list) && is_array($tickets_list) ? $tickets_list : []);

if ($booths_count === null || $singers_count === null || empty($tickets_list)) {
    try {
        $db = \Config\Database::connect();
        if ($booths_count === null) {
            $booths_count = (int)$db->table('booths')->countAllResults(false);
        }
        if ($singers_count === null) {
            $singers_count = (int)$db->table('singers')->countAllResults(false);
        }
        if (empty($tickets_list)) {
            $query = $db->table('tickets')->get();
            $tickets_list = $query ? $query->getResultArray() : [];
        }
    } catch (\Throwable $e) {
        if ($booths_count === null) $booths_count = 0;
        if ($singers_count === null) $singers_count = 0;
        if (empty($tickets_list)) $tickets_list = [];
    }
}

$types = [
  'VVIP' => ['available' => 0, 'sold' => 0, 'initial_sum' => 0, 'has_initial' => false, 'has_sold' => false],
  'VIP'  => ['available' => 0, 'sold' => 0, 'initial_sum' => 0, 'has_initial' => false, 'has_sold' => false],
  'General Admission' => ['available' => 0, 'sold' => 0, 'initial_sum' => 0, 'has_initial' => false, 'has_sold' => false],
];

// Build types aggregates and also capture first-known price per type
$price_map = ['VVIP' => null, 'VIP' => null, 'General Admission' => null];

foreach ($tickets_list as $tk) {
    $rawType = isset($tk['type']) ? trim($tk['type']) : '';
    $typeKey = null;
    if ($rawType === '') { $typeKey = 'General Admission'; }
    else {
        $rt = strtolower($rawType);
        if (strpos($rt, 'vvip') !== false) $typeKey = 'VVIP';
        elseif (strpos($rt, 'vip') !== false && strpos($rt, 'vvip') === false) $typeKey = 'VIP';
        else $typeKey = 'General Admission';
    }
    if (!isset($types[$typeKey])) $typeKey = 'General Admission';
    if (isset($tk['available'])) $types[$typeKey]['available'] += (int)$tk['available'];
    else {
        if (isset($tk['stock'])) $types[$typeKey]['available'] += (int)$tk['stock'];
        elseif (isset($tk['initial'])) $types[$typeKey]['available'] += (int)$tk['initial'];
    }
    if (isset($tk['sold'])) { $types[$typeKey]['sold'] += (int)$tk['sold']; $types[$typeKey]['has_sold'] = true; }
    if (isset($tk['initial']) || isset($tk['stock'])) { $types[$typeKey]['has_initial'] = true; $types[$typeKey]['initial_sum'] += (int)($tk['initial'] ?? ($tk['stock'] ?? 0)); }

    // collect first known price per type (string/number)
    if ($price_map[$typeKey] === null) {
        if (isset($tk['price']) && $tk['price'] !== '') {
            $price_map[$typeKey] = (float)$tk['price'];
        }
    }
}

function compute_bought_display($data) {
    if (!empty($data['has_sold'])) return $data['sold'];
    if (!empty($data['has_initial'])) {
        $b = $data['initial_sum'] - $data['available'];
        return max(0, $b);
    }
    return null;
}

$total_tickets_available = 0; $total_tickets_bought = 0;
foreach ($types as $k => $d) {
    $total_tickets_available += $d['available'];
    $b = compute_bought_display($d);
    if (!is_null($b)) $total_tickets_bought += (int)$b;
}

$base = rtrim(base_url(), '/');
?>

  <!-- BACKGROUND -->
  <div class="absolute inset-0 z-0 bg-cover bg-center" style="background-image: url('<?= base_url('img/bg.png') ?>');">
    <div class="absolute inset-0 hero-overlay"></div>
  </div>

  <!-- HEADER -->
  <header class="relative z-30 flex items-center justify-between px-5 py-4 bg-black/30 backdrop-blur-sm">
    <div class="flex items-center gap-4">
      <button id="burgerBtn" class="p-2 rounded-md hover:bg-white/6 transition" aria-label="Open menu" title="Open menu">
        <div class="space-y-1">
          <span class="block w-6 h-0.5 bg-white"></span>
          <span class="block w-6 h-0.5 bg-white"></span>
          <span class="block w-6 h-0.5 bg-white"></span>
        </div>
      </button>

      <div>
        <h1 class="text-xl md:text-2xl font-extrabold" style="color:var(--accent)">Admin Dashboard</h1>
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
      <button id="closeSidebar" class="text-2xl text-white/80 hover:text-white" aria-label="Close sidebar">&times;</button>
    </div>

    <nav class="flex flex-col gap-3">
      <a href="<?= base_url('admin/booths') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">📋 View Booths</a>
      <a href="<?= base_url('admin/singers') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🎶 View Singers</a>
      <a href="<?= base_url('admin/tickets') ?>" class="px-3 py-2 rounded-md hover:bg-white/10">🎫 View Tickets</a>

      <button onclick="if(confirm('Logout admin?')) location.href='<?= base_url('logout') ?>';" class="text-left px-3 py-2 rounded-md hover:bg-white/10">🚪 Logout Admin</button>
    </nav>

    <div class="mt-auto text-xs text-white/60">
      <div>Logged in as: <span class="font-medium"><?= esc(session()->get('email') ?? 'admin') ?></span></div>
    </div>
  </aside>

  <!-- MAIN -->
<main class="relative z-20 max-w-4xl mx-auto px-6 py-12">
    <section class="mb-8" data-aos="fade-down">
    <div class="text-center w-full">
    <h2 class="text-3xl md:text-4xl font-extrabold text-center" style="color:var(--accent)">Hello, <?= esc(session()->get('name') ?? session()->get('email')) ?></h2>
    <p class="text-sm text-white/70 mt-1">Overview</p>
  </div>
</section>

    <!-- Top: aligned two cards side-by-side -->
    <div class="grid-top-container mb-6">
      <div class="grid-top">
        <!-- Booths small square -->
        <div class="glass square-card text-center">
          <div class="mini">Booths</div>
          <div class="text-3xl font-bold mt-3"><span class="count-anim" data-count="booths"><?= (int)$booths_count ?></span></div>
          <div class="mt-4 flex justify-center gap-2">
            <button data-open="addBoothModal" class="btn-sm">➕ <span class="hidden sm:inline">Add Booth</span></button>
            <button data-manage="booths" class="btn-sm manage-btn">✏️ <span class="hidden sm:inline">Manage</span></button>
          </div>
        </div>

        <!-- Singers small square -->
        <div class="glass square-card text-center">
          <div class="mini">Singers</div>
          <div class="text-3xl font-bold mt-3"><span class="count-anim" data-count="singers"><?= (int)$singers_count ?></span></div>
          <div class="mt-4 flex justify-center gap-2">
            <button data-open="addSingerModal" class="btn-sm">➕ <span class="hidden sm:inline">Add Singer</span></button>
            <button data-manage="singers" class="btn-sm manage-btn">✏️ <span class="hidden sm:inline">Manage</span></button>
          </div>
        </div>
      </div>
    </div>

    <!-- Tickets rectangle under the two squares -->
    <div class="glass rect-card">
      <div class="flex items-center justify-between mb-4">
        <div>
          <div class="font-medium">Tickets (Available / Bought)</div>
          <div class="text-xs text-white/60"><span data-total-available><?= (int)$total_tickets_available ?></span> available</div>
        </div>

        <div class="flex gap-3 items-center">
          <div class="text-right">
            <div class="text-xl font-semibold" style="color:var(--accent)" data-total-available-display><?= (int)$total_tickets_available ?></div>
            <div class="text-xs text-white/60">bought: <?= (int)$total_tickets_bought ?></div>
          </div>
          <div>
            <button data-open="addTicketModal" class="btn-sm btn-accent">➕ <span class="hidden sm:inline">Add Availability</span></button>
            <button data-manage="tickets" class="btn-sm manage-btn">✏️ <span class="hidden sm:inline">Manage</span></button>
          </div>
        </div>
      </div>

      <div class="space-y-3">
        <?php foreach (['VVIP','VIP','General Admission'] as $tk):
          $data = $types[$tk];
          $bought = compute_bought_display($data);
          $bought_display = is_null($bought) ? '—' : (int)$bought;
          $key = str_replace(' ', '-', strtolower($tk));
        ?>
          <div class="flex items-center justify-between">
            <div>
              <div class="font-medium"><?= esc($tk) ?></div>
              <div class="text-xs text-white/60"><span data-ticket-available="<?= esc($key) ?>"><?= $data['available'] ?></span> available</div>
            </div>
            <div class="text-right">
              <div class="text-xl font-semibold" style="color:var(--accent)"><span data-ticket-available-display="<?= esc($key) ?>"><?= $data['available'] ?></span></div>
              <div class="text-xs text-white/60">bought: <?= $bought_display ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <!-- MODAL BACKDROP -->
  <div id="modalBackdrop" class="modal-backdrop">
    <div id="modal" class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
      <!-- dynamic content inserted here -->
    </div>
  </div>

  <!-- TOAST WRAPPER -->
  <div class="toast-wrap" id="toastWrap"></div>

  <!-- TEMPLATES: Add Booth / Singer / Ticket Forms -->
  <template id="addBoothTemplate">
    <div>
      <div class="modal-head">
        <h3 id="modalTitle">Add Booth</h3>
        <button data-close class="text-xl" aria-label="Close modal">&times;</button>
      </div>
      <div id="modalAlert" class="small-muted mb-2"></div>
      <form id="addBoothForm">
        <div class="field">
          <label for="booth_name">Booth Name</label>
          <input id="booth_name" name="name" required />
        </div>
        <div class="field">
          <label for="booth_location">Location</label>
          <input id="booth_location" name="location" />
        </div>
        <div class="field">
          <label for="booth_description">Description</label>
          <textarea id="booth_description" name="description" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-2 mt-2">
          <button type="button" data-close class="btn-sm">Cancel</button>
          <button type="submit" class="btn-sm btn-accent" id="submitAddBooth">Save Booth</button>
        </div>
      </form>
    </div>
  </template>

  <template id="addSingerTemplate">
    <div>
      <div class="modal-head">
        <h3 id="modalTitle">Add Singer</h3>
        <button data-close class="text-xl" aria-label="Close modal">&times;</button>
      </div>
      <div id="modalAlert" class="small-muted mb-2"></div>
      <form id="addSingerForm">
        <div class="field">
          <label for="singer_name">Singer Name</label>
          <input id="singer_name" name="name" required />
        </div>
        <div class="field">
          <label for="singer_genre">Genre</label>
          <input id="singer_genre" name="genre" />
        </div>
        <div class="field">
          <label for="performance_date">Performance Date</label>
          <input id="performance_date" name="performance_date" type="date" />
        </div>
        <div class="field">
          <label for="singer_bio">Bio</label>
          <textarea id="singer_bio" name="bio" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" data-close class="btn-sm">Cancel</button>
          <button type="submit" class="btn-sm btn-accent" id="submitAddSinger">Save Singer</button>
        </div>
      </form>
    </div>
  </template>

  <template id="addTicketTemplate">
    <div>
      <div class="modal-head">
        <h3 id="modalTitle">Add Availability</h3>
        <button data-close class="text-xl" aria-label="Close modal">&times;</button>
      </div>
      <div id="modalAlert" class="small-muted mb-2"></div>
      <form id="addTicketForm">
        <?= csrf_field() ?>
        <div class="field">
          <label for="ticket_type">Ticket Type</label>
          <select id="ticket_type" name="type" required>
            <option value="">Select type…</option>
            <option value="VVIP">VVIP</option>
            <option value="VIP">VIP</option>
            <option value="General Admission">General Admission</option>
          </select>
        </div>

        <div class="field">
          <label for="ticket_price">Price (fixed)</label>
          <input id="ticket_price" name="price" type="text" readonly placeholder="Select a type" />
        </div>

        <div class="field">
          <label for="ticket_add_qty">Quantity to add</label>
          <input id="ticket_add_qty" name="add_quantity" type="number" min="1" value="1" />
          <div class="text-xs text-white/60 mt-1">This will increase the selected ticket's available count.</div>
        </div>

        <input type="hidden" name="increment_only" value="1" />

        <div class="flex justify-end gap-2">
          <button type="button" data-close class="btn-sm">Cancel</button>
          <button type="submit" class="btn-sm btn-accent" id="submitAddTicket">Add to Availability</button>
        </div>
      </form>
    </div>
  </template>

  <!-- TEMPLATE: Manage List (generic) -->
  <template id="manageListTemplate">
    <div>
      <div class="modal-head">
        <h3 id="modalTitle">Manage <span id="manageKind"></span></h3>
        <button data-close class="text-xl" aria-label="Close modal">&times;</button>
      </div>
      <div id="modalAlert" class="small-muted mb-2"></div>
      <div id="manageList" style="max-height:44vh; overflow:auto;"></div>
      <div class="mt-3 flex justify-end gap-2">
        <button data-close class="btn-sm">Close</button>
      </div>
    </div>
  </template>

  <script>
    AOS.init({ duration: 560, once: true, easing: 'ease-out-cubic' });

    const baseUrl = "<?= $base ?>";
    const priceMap = <?= json_encode($price_map, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>;

    // toast helper
    function showToast(title, desc = '', duration = 3600) {
      const wrap = document.getElementById('toastWrap');
      if (!wrap) return;
      const t = document.createElement('div');
      t.className = 'toast';
      t.innerHTML = `<div style="width:10px;height:10px;border-radius:50%;background:var(--accent);flex:0 0 10px;"></div>
                     <div style="flex:1"><div class="title">${title}</div><div class="desc">${desc}</div></div>
                     <div style="margin-left:.6rem;cursor:pointer;font-weight:700" aria-label="Dismiss">×</div>`;
      wrap.appendChild(t);
      requestAnimationFrame(() => t.classList.add('show'));
      t.querySelector('[aria-label="Dismiss"]').addEventListener('click', () => {
        t.classList.remove('show'); setTimeout(()=> t.remove(), 220);
      });
      setTimeout(() => { t.classList.remove('show'); setTimeout(()=> t.remove(), 220); }, duration);
    }

    // small counter animation
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.count-anim').forEach(el => {
        el.style.transform = 'translateY(6px)';
        setTimeout(() => { el.style.transform = 'translateY(0)'; }, 120);
      });
    });

    // modal helpers
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modal = document.getElementById('modal');

    function openModal(fragment) {
      modal.innerHTML = '';
      modal.appendChild(fragment);
      modalBackdrop.classList.add('active');
      modal.querySelectorAll('[data-close]').forEach(el => el.addEventListener('click', closeModal));
      document.addEventListener('keydown', escListener);

      // wire ticket price select if present
      const typeSelect = modal.querySelector('#ticket_type');
      const priceInput = modal.querySelector('#ticket_price');
      if (typeSelect && priceInput) {
        setPriceForType(typeSelect.value, priceInput);
        typeSelect.addEventListener('change', () => setPriceForType(typeSelect.value, priceInput));
      }

      // attach form handlers for forms inside the modal
      attachFormBehavior();
    }

    function closeModal() {
      modalBackdrop.classList.remove('active');
      modal.innerHTML = '';
      document.removeEventListener('keydown', escListener);
    }
    function escListener(e) { if (e.key === 'Escape') closeModal(); }

    function setPriceForType(typeValue, priceInputEl) {
      if (!priceInputEl) return;
      if (!typeValue) { priceInputEl.value = ''; priceInputEl.placeholder = 'Select a type'; return; }
      const mapKey = typeValue === 'General Admission' ? 'General Admission' : (typeValue === 'VIP' ? 'VIP' : (typeValue === 'VVIP' ? 'VVIP' : typeValue));
      const v = priceMap[mapKey];
      if (v === null || typeof v === 'undefined') {
        priceInputEl.value = ''; priceInputEl.placeholder = 'Price unknown';
      } else {
        priceInputEl.value = Number(v).toFixed(2);
      }
    }

    // delegated opener: any element with data-open will open a modal
    document.addEventListener('click', (e) => {
      const btn = e.target.closest('[data-open]');
      if (!btn) return;
      e.preventDefault();
      const which = btn.getAttribute('data-open');
      const tplId = { 'addBoothModal': 'addBoothTemplate', 'addSingerModal': 'addSingerTemplate', 'addTicketModal': 'addTicketTemplate' }[which];
      if (!tplId) return;
      const tpl = document.getElementById(tplId);
      if (!tpl) return;
      openModal(tpl.content.cloneNode(true));
    });

    // Manage buttons redirect
    document.querySelectorAll('.manage-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const kind = btn.getAttribute('data-manage');
        const pageUrl = `${baseUrl}/admin/${kind}`;
        window.location.href = pageUrl;
      });
    });

    function showManageModal(kind, items) {
      const tpl = document.getElementById('manageListTemplate');
      const node = tpl.content.cloneNode(true);
      node.getElementById('manageKind').textContent = kind.charAt(0).toUpperCase() + kind.slice(1);
      const listContainer = node.getElementById('manageList');
      if (!Array.isArray(items) || items.length === 0) {
        listContainer.innerHTML = '<div class="small-muted">No items found.</div>';
      } else {
        items.forEach(it => {
          const title = it.name || it.title || it.type || ('#' + (it.id ?? ''));
          const id = it.id ?? (it._id ?? null);
          const row = document.createElement('div');
          row.className = 'list-row';
          row.innerHTML = `<div><div class="font-medium">${escapeHtml(title)}</div><div class="small-muted">${escapeHtml(it.description ?? '')}</div></div>
            <div class="list-actions">
              <a href="${baseUrl}/admin/${kind}/${id}/edit" class="btn-sm">Edit</a>
              <a href="${baseUrl}/admin/${kind}/${id}" class="btn-sm">View</a>
            </div>`;
          listContainer.appendChild(row);
        });
      }
      openModal(node);
    }

    // Post helper (appends CSRF if available)
    async function postResource(path, formData, successMessage = 'Saved', onSuccess = null) {
      const alertEl = modal.querySelector('#modalAlert') || document.getElementById('modalAlert');
      if (alertEl) alertEl.textContent = 'Saving...';

      try {
        const csrfNameMeta = document.getElementById('csrf-name');
        const csrfHashMeta = document.getElementById('csrf-hash');
        if (csrfNameMeta && csrfHashMeta) {
          const name = csrfNameMeta.getAttribute('content');
          const hash = csrfHashMeta.getAttribute('content');
          if (name && hash) formData.append(name, hash);
        }
      } catch (e) { console.warn('CSRF meta not found or error reading it', e); }

      try {
        const resp = await fetch(baseUrl + path, {
          method: 'POST',
          body: formData,
          credentials: 'same-origin',
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });

        if (!resp.ok) {
          let errText = `HTTP ${resp.status} ${resp.statusText}`;
          try {
            const j = await resp.json();
            if (j && j.error) errText = j.error;
            else if (j && j.message) errText = j.message;
            else errText = JSON.stringify(j);
          } catch (e) {
            try { errText = await resp.text(); } catch(e2) { /* ignore */ }
          }
          if (alertEl) alertEl.textContent = 'Error: ' + errText;
          console.error('POST error', resp.status, errText);
          return { ok:false, error: errText };
        }

        let json = null;
        try { json = await resp.json(); } catch (e) { /* not JSON */ }

        if (alertEl) alertEl.textContent = successMessage;
        if (typeof onSuccess === 'function') onSuccess(json);
        return { ok:true, json };
      } catch (err) {
        if (alertEl) alertEl.textContent = 'Network error: ' + (err.message || 'Request failed');
        console.error('Fetch failed', err);
        return { ok:false, error: err.message || 'Network error' };
      }
    }

    // attach form submit handlers for forms inside the modal (idempotent)
    function attachFormBehavior() {
      // helper to append CSRF (defensive)
      function appendCsrf(formData) {
        try {
          const csrfNameMeta = document.getElementById('csrf-name');
          const csrfHashMeta = document.getElementById('csrf-hash');
          if (csrfNameMeta && csrfHashMeta) {
            const name = csrfNameMeta.getAttribute('content');
            const hash = csrfHashMeta.getAttribute('content');
            if (name && hash) formData.append(name, hash);
          }
        } catch(e) { /* ignore */ }
      }

      // Add Booth
      const boothForm = modal.querySelector('#addBoothForm');
      if (boothForm && !boothForm.dataset.bound) {
        boothForm.addEventListener('submit', async (ev) => {
          ev.preventDefault();
          const form = new FormData(boothForm);
          appendCsrf(form);
          await postResource('/admin/boothSave', form, 'Booth added successfully', (json) => {
            const el = document.querySelector('[data-count="booths"]');
            if (el) el.textContent = (parseInt(el.textContent||'0') + 1);
            boothForm.reset();
            showToast('Booth successfully added', 'You can add another or close this dialog.');
          });
        });
        boothForm.dataset.bound = '1';
      }

      // Add Singer
      const singerForm = modal.querySelector('#addSingerForm');
      if (singerForm && !singerForm.dataset.bound) {
        singerForm.addEventListener('submit', async (ev) => {
          ev.preventDefault();
          const form = new FormData(singerForm);
          appendCsrf(form);
          await postResource('/admin/singerSave', form, 'Singer added successfully', (json) => {
            const el = document.querySelector('[data-count="singers"]');
            if (el) el.textContent = (parseInt(el.textContent||'0') + 1);
            singerForm.reset();
            showToast('Artist successfully added', 'Artist saved — add another or close the dialog.');
          });
        });
        singerForm.dataset.bound = '1';
      }

      // Add Ticket (Add Availability)
      const ticketForm = modal.querySelector('#addTicketForm');
      if (ticketForm && !ticketForm.dataset.bound) {
        ticketForm.addEventListener('submit', async (ev) => {
          ev.preventDefault();
          const form = new FormData(ticketForm);
          appendCsrf(form);

          const type = form.get('type');
          const qty = parseInt(form.get('add_quantity') || '0', 10);
          if (!type || qty <= 0) {
            const alertEl = modal.querySelector('#modalAlert');
            if (alertEl) alertEl.textContent = 'Please select a ticket type and a quantity greater than 0.';
            return;
          }

          const priceInput = modal.querySelector('#ticket_price');
          if (priceInput && priceInput.value) form.set('price', priceInput.value);

          const res = await postResource('/admin/ticketSave', form, 'Availability updated', (json) => {
            // update totals on page
            const totalEls = document.querySelectorAll('[data-total-available], [data-total-available-display]');
            totalEls.forEach(el => {
              const cur = parseInt(el.textContent||'0', 10) || 0;
              el.textContent = cur + qty;
            });

            const key = type === 'General Admission' ? 'general-admission' : (type === 'VIP' ? 'vip' : (type === 'VVIP' ? 'vvip' : type.toLowerCase().replace(/\s+/g,'-')));
            const perEls = document.querySelectorAll(`[data-ticket-available="${key}"], [data-ticket-available-display="${key}"]`);
            perEls.forEach(el => {
              const cur = parseInt(el.textContent||'0', 10) || 0;
              el.textContent = cur + qty;
            });

            ticketForm.querySelector('#ticket_add_qty').value = '1';
            showToast('Availability updated', `Added ${qty} to ${type}.`);
          });
        });
        ticketForm.dataset.bound = '1';
      }
    }

    function escapeHtml(s) { if (!s) return ''; return String(s).replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

    // Sidebar toggle
    const burgerBtn = document.getElementById('burgerBtn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const closeSidebar = document.getElementById('closeSidebar');
    function setSidebar(open){ sidebar.classList.toggle('active', open); overlay.classList.toggle('active', open); }
    burgerBtn && burgerBtn.addEventListener('click', ()=> setSidebar(true));
    closeSidebar && closeSidebar.addEventListener('click', ()=> setSidebar(false));
    overlay && overlay.addEventListener('click', ()=> setSidebar(false));
  </script>
</body>
</html>
