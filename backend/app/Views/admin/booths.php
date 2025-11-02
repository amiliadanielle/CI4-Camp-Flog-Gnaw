<?php // app/Views/booths.php
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Booths — Admin</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Balsamiq Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <style>
    :root{ --accent: #fb923c; --success:#16a34a; --error:#ef4444; --info:#0ea5e9; }
    body { font-family: 'Balsamiq Sans', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }

    /* keep the background fixed and visible while only the table scrolls */
    .bg-fixed-hero {
      background-image: url('<?= base_url('img/bg.png') ?>');
      background-position: center;
      background-size: cover;
      background-attachment: fixed;
    }

    .glass { background: rgba(255,255,255,0.06); backdrop-filter: blur(10px) saturate(120%); border: 1px solid rgba(255,255,255,0.06); border-radius: 12px; }
    .hero-overlay { background: linear-gradient(180deg, rgba(0,0,0,0.6), rgba(0,0,0,0.65)); }
    .card-anim { transition: transform .28s cubic-bezier(.2,.9,.3,1), box-shadow .28s; }
    .card-anim:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 14px 40px rgba(0,0,0,0.45); }
    .sidebar { width: 320px; transform: translateX(-110%); transition: transform .36s cubic-bezier(.2,.9,.3,1); }
    .sidebar.active { transform: translateX(0%); }
    .overlay { background: rgba(0,0,0,0.6); opacity: 0; visibility: hidden; transition: opacity .24s ease; }
    .overlay.active { opacity: 1; visibility: visible; }

    /* make the table area the only scrollable region */
    .table-scroll {
      max-height: 56vh; /* adjust height as needed */
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      scroll-behavior: smooth;
    }
    .table-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
    .table-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 8px; }

    /* sticky table header so headers remain visible while scrolling table */
    .table-scroll thead th {
      position: sticky;
      top: 0;
      z-index: 10;
      backdrop-filter: blur(6px);
      background: rgba(0,0,0,0.55);
    }

    .scrollbar-thin::-webkit-scrollbar { height: 6px; width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 10px; }

    /* modal styles */
    .modal-backdrop {
      position: fixed; inset: 0; display: none; align-items: center; justify-content: center; z-index: 90; padding: 1.5rem;
      background: rgba(0,0,0,0.55);
    }
    .modal-backdrop.active { display:flex; }
    .modal-window {
      width: 100%; max-width: 720px; border-radius: 12px; background: linear-gradient(180deg, #0b0b0d, #101012);
      padding: 1rem; border: 1px solid rgba(255,255,255,0.04); box-shadow: 0 14px 40px rgba(0,0,0,0.6);
    }

    /* toast styles (top-right) */
    .toast-wrap {
      position: fixed;
      top: 1rem;
      right: 1rem;
      z-index: 110;
      display: flex;
      flex-direction: column;
      gap: .6rem;
      align-items: flex-end;
      pointer-events: none;
    }
    .toast {
      pointer-events: auto;
      min-width: 220px;
      max-width: 360px;
      background: rgba(17,17,17,0.94);
      border-radius: 10px;
      padding: .6rem .9rem;
      box-shadow: 0 10px 30px rgba(0,0,0,0.6);
      border: 1px solid rgba(255,255,255,0.04);
      display:flex;
      gap:.6rem;
      align-items:center;
      transform-origin: top right;
      opacity: 0;
      transform: translateY(-6px) scale(.995);
      transition: opacity .22s ease, transform .22s ease;
    }
    .toast.show { opacity: 1; transform: translateY(0) scale(1); }
    .toast .icon {
      width: 10px; height: 10px; border-radius: 50%;
      flex: 0 0 10px;
    }
    .toast .content { flex:1; }
    .toast .title { font-weight:700; font-size:0.95rem; }
    .toast .desc { font-size:0.88rem; color:#ddd; margin-top:0.15rem; }
    .toast.success .icon { background: var(--success); }
    .toast.error .icon { background: var(--error); }
    .toast.info .icon { background: var(--info); }

    @media (max-width: 640px){ .sidebar { width: 85%; } }
  </style>
</head>
<body class="min-h-screen bg-gray-900 text-white bg-fixed-hero">

  <!-- BACKGROUND OVERLAY (keeps design identical) -->
  <div class="absolute inset-0 z-0">
    <div class="absolute inset-0 hero-overlay"></div>
  </div>

  <!-- HEADER (copied from dashboard for consistent look) -->
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
        <h1 class="text-xl md:text-2xl font-extrabold" style="color:var(--accent)">Admin — Booths</h1>
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

  <!-- SIDEBAR & OVERLAY (same behaviour as dashboard) -->
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
      <h1 class="text-2xl font-bold">Booths</h1>
      <div class="flex gap-2">
        <a href="<?= base_url('dashboard') ?>" class="px-3 py-1 bg-white/6 rounded">Dashboard</a>
      </div>
    </div>

    <!-- Hidden flash placeholders (we'll pick these up with JS and show toasts instead) -->
    <?php if (session()->getFlashdata('success')): ?>
      <div id="flashSuccess" style="display:none;"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div id="flashError" style="display:none;"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div id="editSuccess" class="mb-4 p-3 bg-green-600/20 border border-green-600 rounded hidden">Edit successful</div>

    <div class="bg-white/5 rounded p-4">
      <!-- ONLY THIS DIV SCROLLS -->
      <div class="table-scroll scrollbar-thin">
        <table class="w-full table-auto text-sm">
          <thead class="text-left text-white/70">
            <tr>
              <th class="px-3 py-2">Name</th>
              <th class="px-3 py-2">Location</th>
              <th class="px-3 py-2">Description</th>
              <th class="px-3 py-2">Created</th>
              <th class="px-3 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($booths)): foreach ($booths as $b): ?>
              <tr class="border-t border-white/6" data-id="<?= esc($b['id']) ?>">
                <td class="px-3 py-3 booth-name"><?= esc($b['name']) ?></td>
                <td class="px-3 py-3 booth-location"><?= esc($b['location']) ?></td>
                <td class="px-3 py-3 booth-desc"><?= esc($b['description']) ?></td>
                <td class="px-3 py-3 booth-created"><?= esc($b['created_at'] ?? '-') ?></td>
                <td class="px-3 py-3">
                  <button class="px-2 py-1 bg-blue-600/80 rounded text-xs"
                          onclick="openEdit(<?= htmlspecialchars(json_encode($b), ENT_QUOTES, 'UTF-8') ?>, 'booth')">Edit</button>
                  <a href="<?= base_url('admin/boothDelete/'.$b['id']) ?>" onclick="return confirm('Delete booth?')" class="px-2 py-1 bg-red-600/80 rounded text-xs ml-2">Delete</a>
                </td>
              </tr>
            <?php endforeach; else: ?>
              <tr><td colspan="5" class="px-3 py-6 text-center text-white/70">No booths found.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div> <!-- /.table-scroll -->
    </div>

    <!-- Inline edit form (hidden) - kept as a template but not shown when editing via modal -->
    <div id="boothEdit" class="mt-6 hidden bg-white/5 p-4 rounded" aria-hidden="true">
      <h3 class="font-semibold mb-3">Edit Booth</h3>

      <div id="boothEditAlert" class="mb-3 text-sm text-yellow-300 hidden"></div>

      <form id="boothEditForm" action="<?= base_url('admin/boothSave') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="edit_booth_id">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <div>
            <label class="block text-xs text-white/70 mb-1">Name</label>
            <input id="edit_booth_name" name="name" class="w-full px-3 py-2 rounded bg-black/30" required>
          </div>
          <div>
            <label class="block text-xs text-white/70 mb-1">Location</label>
            <input id="edit_booth_location" name="location" class="w-full px-3 py-2 rounded bg-black/30">
          </div>
          <div class="md:col-span-2">
            <label class="block text-xs text-white/70 mb-1">Description</label>
            <textarea id="edit_booth_description" name="description" class="w-full px-3 py-2 rounded bg-black/30"></textarea>
          </div>
        </div>
        <div class="mt-3 flex gap-2 justify-end">
          <button type="submit" class="px-3 py-1 bg-[--accent] text-black rounded" style="--accent:#fb923c">Save</button>
          <button type="button" id="boothEditCancel" class="px-3 py-1 bg-white/6 rounded">Cancel</button>
        </div>
      </form>
    </div>

  </main>

  <!-- MODAL BACKDROP (for edit modal) -->
  <div id="modalBackdrop" class="modal-backdrop" aria-hidden="true">
    <div id="modalWindow" class="modal-window" role="dialog" aria-modal="true" aria-labelledby="modalTitle"></div>
  </div>

  <!-- Toast container -->
  <div id="toastWrap" class="toast-wrap" aria-live="polite" aria-atomic="true"></div>

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
      // also hide inline edit if visible
      document.getElementById('boothEdit')?.classList.add('hidden');
      // also close modal if open
      closeModal();
    });

    // --- Modal helpers ---
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalWindow = document.getElementById('modalWindow');

    function openModal() {
      modalBackdrop.classList.add('active');
      modalBackdrop.setAttribute('aria-hidden', 'false');
      document.addEventListener('keydown', modalEscHandler);
    }
    function closeModal() {
      modalBackdrop.classList.remove('active');
      modalBackdrop.setAttribute('aria-hidden', 'true');
      modalWindow.innerHTML = '';
      document.removeEventListener('keydown', modalEscHandler);
    }
    function modalEscHandler(e) {
      if (e.key === 'Escape') closeModal();
    }
    // close modal when clicking backdrop (but not when clicking inside modalWindow)
    modalBackdrop.addEventListener('click', (ev) => {
      if (ev.target === modalBackdrop) closeModal();
    });

    // --- Toast helper ---
    function showToast(title, desc = '', type = 'success', duration = 4000) {
      const wrap = document.getElementById('toastWrap');
      if (!wrap) return;
      const t = document.createElement('div');
      t.className = `toast ${type}`;
      t.innerHTML = `<div class="icon" aria-hidden="true"></div>
                     <div class="content"><div class="title">${escapeHtml(title)}</div>${desc ? `<div class="desc">${escapeHtml(desc)}</div>` : ''}</div>
                     <div style="margin-left:.6rem;cursor:pointer;font-weight:700" aria-label="Dismiss">×</div>`;
      // dismiss click
      t.querySelector('[aria-label="Dismiss"]').addEventListener('click', () => {
        hideToast(t);
      });
      wrap.appendChild(t);
      // show with animation
      requestAnimationFrame(() => t.classList.add('show'));
      // auto remove
      const to = setTimeout(() => { hideToast(t); }, duration);
      // store timeout so we can clear if user clicks dismiss
      t._timeout = to;
    }
    function hideToast(el) {
      if (!el) return;
      if (el._timeout) { clearTimeout(el._timeout); delete el._timeout; }
      el.classList.remove('show');
      setTimeout(()=> { el.remove(); }, 220);
    }

    // simple escape (small)
    function escapeHtml(s) { if (!s) return ''; return String(s).replace(/[&<>"']/g, (m) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m])); }

    // helper to show / hide small inline alerts (kept for compatibility)
    function showBoothAlert(msg, isError = false) {
      const el = document.getElementById('boothEditAlert');
      if (!el) return;
      el.textContent = msg;
      el.classList.remove('hidden');
      el.style.color = isError ? '#f87171' : '#a3e635'; // red or lime
    }
    function hideBoothAlert() {
      const el = document.getElementById('boothEditAlert');
      if (!el) return;
      el.textContent = '';
      el.classList.add('hidden');
    }

    // --- openEdit now opens a modal with a fresh form populated from obj ---
    function openEdit(obj, type){
      if (type !== 'booth') return;

      // obj might be a JSON string if passed that way; parse defensively
      if (typeof obj === 'string') {
        try { obj = JSON.parse(obj); } catch(e) { console.warn('openEdit: parse failed', e); }
      }

      // Build form elements programmatically to avoid id collisions
      modalWindow.innerHTML = ''; // clear

      // Modal header
      const header = document.createElement('div');
      header.style.display = 'flex';
      header.style.justifyContent = 'space-between';
      header.style.alignItems = 'center';
      header.style.marginBottom = '0.6rem';

      const title = document.createElement('h3');
      title.id = 'modalTitle';
      title.className = 'text-lg font-bold';
      title.textContent = 'Edit Booth';
      title.style.color = 'var(--accent)';

      const closeBtn = document.createElement('button');
      closeBtn.type = 'button';
      closeBtn.innerHTML = '&times;';
      closeBtn.className = 'text-2xl';
      closeBtn.addEventListener('click', closeModal);

      header.appendChild(title);
      header.appendChild(closeBtn);
      modalWindow.appendChild(header);

      // alert container
      const modalAlert = document.createElement('div');
      modalAlert.id = 'modalAlert';
      modalAlert.className = 'mb-3 text-sm';
      modalAlert.style.display = 'none';
      modalWindow.appendChild(modalAlert);

      // form
      const form = document.createElement('form');
      form.id = 'modalEditForm';
      form.setAttribute('method', 'post');
      form.setAttribute('action', '<?= base_url('admin/boothSave') ?>');

      // include CSRF field by copying from hidden template if present
      const hiddenCsrf = document.querySelector('#boothEditForm input[name="<?= csrf_token() ?>"]');
      if (hiddenCsrf) {
        const cs = hiddenCsrf.cloneNode(true);
        form.appendChild(cs);
      } else {
        // fallback: server-rendered csrf_field() markup
        const csrfHtml = `<?= csrf_field() ?>`;
        const frag = document.createElement('div');
        frag.innerHTML = csrfHtml;
        while (frag.firstChild) form.appendChild(frag.firstChild);
      }

      // hidden id input
      const idInput = document.createElement('input');
      idInput.type = 'hidden';
      idInput.name = 'id';
      idInput.value = obj.id ?? '';
      form.appendChild(idInput);

      // create grid container
      const grid = document.createElement('div');
      grid.style.display = 'grid';
      grid.style.gridTemplateColumns = '1fr';
      grid.style.gap = '0.75rem';

      // Name (text)
      const nameWrap = document.createElement('div');
      const nameLabel = document.createElement('label');
      nameLabel.className = 'block text-xs text-white/70 mb-1';
      nameLabel.textContent = 'Name';
      const nameInput = document.createElement('input');
      nameInput.type = 'text';
      nameInput.name = 'name';
      nameInput.value = obj.name ?? '';
      nameInput.required = true;
      nameInput.className = 'w-full px-3 py-2 rounded bg-black/30';
      nameWrap.appendChild(nameLabel); nameWrap.appendChild(nameInput);
      grid.appendChild(nameWrap);

      // Location
      const locWrap = document.createElement('div');
      const locLabel = document.createElement('label');
      locLabel.className = 'block text-xs text-white/70 mb-1';
      locLabel.textContent = 'Location';
      const locInput = document.createElement('input');
      locInput.type = 'text';
      locInput.name = 'location';
      locInput.value = obj.location ?? '';
      locInput.className = 'w-full px-3 py-2 rounded bg-black/30';
      locWrap.appendChild(locLabel); locWrap.appendChild(locInput);
      grid.appendChild(locWrap);

      // Description
      const descWrap = document.createElement('div');
      const descLabel = document.createElement('label');
      descLabel.className = 'block text-xs text-white/70 mb-1';
      descLabel.textContent = 'Description';
      const descTextarea = document.createElement('textarea');
      descTextarea.name = 'description';
      descTextarea.className = 'w-full px-3 py-2 rounded bg-black/30';
      descTextarea.rows = 4;
      descTextarea.value = obj.description ?? '';
      descWrap.appendChild(descLabel); descWrap.appendChild(descTextarea);
      grid.appendChild(descWrap);

      form.appendChild(grid);

      // actions
      const actions = document.createElement('div');
      actions.style.display = 'flex';
      actions.style.justifyContent = 'flex-end';
      actions.style.gap = '0.5rem';
      actions.style.marginTop = '0.75rem';

      const submitBtn = document.createElement('button');
      submitBtn.type = 'submit';
      submitBtn.className = 'px-3 py-1 rounded';
      submitBtn.style.background = 'var(--accent)';
      submitBtn.style.color = '#000';
      submitBtn.textContent = 'Save';

      const cancelBtn = document.createElement('button');
      cancelBtn.type = 'button';
      cancelBtn.className = 'px-3 py-1 bg-white/6 rounded';
      cancelBtn.textContent = 'Cancel';
      cancelBtn.addEventListener('click', closeModal);

      actions.appendChild(cancelBtn);
      actions.appendChild(submitBtn);

      form.appendChild(actions);

      modalWindow.appendChild(form);

      // open the modal
      openModal();

      // hide any previous alerts
      modalAlert.style.display = 'none';
      modalAlert.textContent = '';

      // attach submit handler (idempotent: remove existing listener first)
      const submitHandler = async function(e) {
        e.preventDefault();
        modalAlert.style.display = 'none';
        modalAlert.textContent = '';

        const fdata = new FormData(form);
        // fetch post
        try {
          const resp = await fetch(form.getAttribute('action') || '/admin/boothSave', {
            method: 'POST',
            body: fdata,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
          });

          // parse JSON when possible
          let body = null;
          const ct = (resp.headers.get('Content-Type') || '');
          if (ct.includes('application/json')) body = await resp.json();
          else body = await resp.text();

          if (!resp.ok) {
            const errMsg = (body && body.error) ? body.error : (body && body.message) ? body.message : (typeof body === 'string' ? body : `HTTP ${resp.status}`);
            modalAlert.style.display = 'block';
            modalAlert.style.color = '#f87171';
            modalAlert.textContent = 'Error: ' + errMsg;
            return;
          }

          // success — update row on page
          const id = fdata.get('id');
          if (id) {
            const row = document.querySelector(`tr[data-id="${CSS.escape(id)}"]`);
            if (row) {
              const nameCell = row.querySelector('.booth-name');
              const locCell = row.querySelector('.booth-location');
              const descCell = row.querySelector('.booth-desc');
              if (nameCell) nameCell.textContent = fdata.get('name') || '';
              if (locCell) locCell.textContent = fdata.get('location') || '';
              if (descCell) descCell.textContent = fdata.get('description') || '';
            }
          }

          // show success toast
          showToast('Edit successful', 'Booth updated.', 'success', 4000);

          // close modal
          closeModal();

        } catch (err) {
          console.error('Save failed', err);
          modalAlert.style.display = 'block';
          modalAlert.style.color = '#f87171';
          modalAlert.textContent = 'Network error: ' + (err.message || 'Request failed');
        }
      };

      // Remove previous handler if any then attach fresh
      form.removeEventListener('submit', submitHandler);
      form.addEventListener('submit', submitHandler);
    }

    // Cancel button hides inline edit form (kept for backward compatibility)
    const boothEditCancel = document.getElementById('boothEditCancel');
    if (boothEditCancel) {
      boothEditCancel.addEventListener('click', function(){
        document.getElementById('boothEdit').classList.add('hidden');
        hideBoothAlert();
      });
    }

    // On page load: if server-side flash messages exist, show them as toasts
    document.addEventListener('DOMContentLoaded', () => {
      const s = document.getElementById('flashSuccess');
      const e = document.getElementById('flashError');
      if (s && s.textContent.trim()) {
        showToast('Success', s.textContent.trim(), 'success', 4000);
      }
      if (e && e.textContent.trim()) {
        showToast('Error', e.textContent.trim(), 'error', 4000);
      }
      // ensure hidden placeholders are not visible
      if (s) s.remove();
      if (e) e.remove();
    });
  </script>
</body>
</html>
