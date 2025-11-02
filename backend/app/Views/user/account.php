<?php // app/Views/user/account.php
/**
 * Account page - allows user to edit their account details.
 * Expects $user array provided by controller with keys matching UsersModel fields.
 */
$user = $user ?? [];
$first   = esc($user['first_name'] ?? '');
$middle  = esc($user['middle_name'] ?? '');
$last    = esc($user['last_name'] ?? '');
$email   = esc($user['email'] ?? '');
$profile = esc($user['profile_image'] ?? '');
$gender  = esc($user['gender'] ?? '');
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Account</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Balsamiq Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    :root { --accent: #fb923c; --glass-border: rgba(255,255,255,0.06); }
    html, body { height: 100%; margin: 0; overflow: hidden; }
    body {
      font-family: 'Balsamiq Sans', system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif;
      color:#fff;
      background-color:#060607;
      background-image: url('<?= base_url('img/bg.png') ?>');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 6.5rem;
    }

    .hero-overlay {
      position: fixed;
      inset: 0;
      background: linear-gradient(180deg, rgba(0,0,0,0.56), rgba(3,7,18,0.78));
      z-index: 5;
      pointer-events: none;
    }

    main {
      position: relative;
      z-index: 10;
      width: 100%;
      max-width: 1100px;
      padding: 0 2rem;
    }

    .glass {
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      backdrop-filter: blur(8px);
      border: 1px solid var(--glass-border);
      border-radius: 14px;
      padding: 2rem;
    }

    .label-small { font-size:.9rem; color: rgba(255,255,255,0.86); }
    .field-input {
      width:100%;
      padding:.8rem 1rem;
      border-radius:10px;
      background: rgba(255,255,255,0.03);
      border:1px solid rgba(255,255,255,0.04);
      color: #fff;
      outline:none;
      transition: box-shadow .14s, border-color .14s;
    }
    .field-input::placeholder { color: rgba(255,255,255,0.44); }
    .field-input:focus {
      border-color: rgba(251,146,60,0.95);
      box-shadow: 0 8px 30px rgba(251,146,60,0.07);
    }

    select.field-input { color: #fff; background: rgba(255,255,255,0.03); }

    .panel-header {
      display:flex;
      gap:2rem;
      align-items:center;
      flex-wrap: wrap;
    }

    .avatar-wrap {
      width:120px;
      height:120px;
      border-radius:999px;
      overflow:hidden;
      border:2px solid rgba(255,255,255,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      background:linear-gradient(180deg, rgba(0,0,0,0.16), rgba(0,0,0,0.06));
      flex-shrink:0;
    }
    .avatar { width:100%; height:100%; display:block; object-fit:cover; }

    .name-block { flex:1; min-width:0; }
    .name-block h2 { margin:0; font-size:1.3rem; color:var(--accent); letter-spacing:.2px; }
    .name-block p { margin:0; color:rgba(255,255,255,0.8); font-size:.95rem; }

    .file-btn {
      display:inline-flex;
      align-items:center;
      gap:.6rem;
      padding:.55rem 1rem;
      border-radius:10px;
      background: linear-gradient(90deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
      border:1px solid rgba(255,255,255,0.04);
      cursor:pointer;
      font-weight:700;
      color: #fff;
    }

    .btn-primary { background: var(--accent); color:#0b0b0b; padding:.7rem 1.1rem; border-radius:.9rem; font-weight:800; }
    .btn-cancel { background: rgba(255,255,255,0.06); color:#fff; padding:.6rem 1rem; border-radius:.6rem; }

    .muted { color: rgba(255,255,255,0.65); font-size:.92rem; }
    .hint { font-size:.83rem; color: rgba(255,255,255,0.52); }

    @media (max-width: 768px) {
      html, body { overflow-y:auto; } 
      main { max-width: 100%; padding: 1rem; }
      .panel-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
      .avatar-wrap { width:90px; height:90px; }
    }
  </style>
</head>
<body>

  <!-- header -->
  <?= $this->include('components/header'); ?>

  <!-- overlay -->
  <div class="hero-overlay" aria-hidden="true"></div>

  <main class="max-w-3xl mx-auto panel px-4 sm:px-6 lg:px-0">
    <div class="glass">
      <div class="panel-header mb-5">
        <div style="display:flex;align-items:center;gap:1rem;">
          <div class="avatar-wrap" title="Profile picture">
            <?php if ($profile): ?>
              <img id="avatarPreview" src="<?= base_url('uploads/profiles/'.$profile) ?>" alt="Profile" class="avatar">
            <?php else: ?>
              <img id="avatarPreview" src="<?= base_url('img/default-avatar.png') ?>" alt="Profile" class="avatar">
            <?php endif; ?>
          </div>

          <div style="display:flex;flex-direction:column;gap:.45rem;">
            <label for="profile_image" class="file-btn" title="Upload new profile image">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M12 3v10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5 10l7-7 7 7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 21H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Choose file
            </label>
            <div class="hint">PNG, JPG, WEBP • up to 2MB</div>
          </div>
        </div>

        <div class="name-block">
          <h2><?= $first ? esc($first . ' ' . $last) : 'Your Profile' ?></h2>
          <p class="muted">Edit your account details below. Changes will be saved to your account.</p>
        </div>
      </div>

      <form id="accountForm" action="<?= site_url('account/save') ?>" method="post" enctype="multipart/form-data" novalidate>
        <?= csrf_field() ?>
        <input type="file" name="profile_image" id="profile_image" class="sr-only" accept="image/*">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="field-row">
            <label class="label-small">First name</label>
            <input class="field-input" type="text" name="first_name" id="first_name" value="<?= $first ?>" required />
          </div>
          <div class="field-row">
            <label class="label-small">Middle name</label>
            <input class="field-input" type="text" name="middle_name" id="middle_name" value="<?= $middle ?>" />
          </div>
          <div class="field-row">
            <label class="label-small">Last name</label>
            <input class="field-input" type="text" name="last_name" id="last_name" value="<?= $last ?>" required />
          </div>
          <div class="field-row">
            <label class="label-small">Email</label>
            <input class="field-input" type="email" name="email" id="email" value="<?= $email ?>" required />
          </div>
          <div class="md:col-span-2">
            <label class="label-small">Gender</label>
            <select name="gender" id="gender" class="field-input mt-1" aria-label="Gender">
              <option value="" <?= $gender === '' ? 'selected' : '' ?>>Select gender…</option>
              <option value="Male" <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $gender === 'Female' ? 'selected' : '' ?>>Female</option>
            </select>
          </div>
          <div class="md:col-span-2">
            <label class="label-small">Change password (optional)</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mt-2">
              <input class="field-input" type="password" name="current_password" id="current_password" placeholder="Current password" />
              <input class="field-input" type="password" name="new_password" id="new_password" placeholder="New password" />
              <input class="field-input" type="password" name="new_password_confirm" id="new_password_confirm" placeholder="Confirm new" />
            </div>
            <div class="text-xs text-white/60 mt-2">Leave blank if you don't want to change password.</div>
          </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
          <button type="button" id="cancelBtn" class="btn-cancel">Cancel</button>
          <button type="submit" id="saveBtn" class="btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </main>

  <div id="toastWrap" style="position:fixed;top:1rem;right:1rem;z-index:110;display:flex;flex-direction:column;gap:.6rem;"></div>

  <script>
    const fileLabel = document.querySelector('label[for="profile_image"]');
    const fileInput = document.getElementById('profile_image');
    fileLabel?.addEventListener('keydown', (e)=> { if (e.key==='Enter'||e.key===' ') fileInput.click(); });

    fileInput?.addEventListener('change', function(e){
      const f = this.files && this.files[0];
      if(!f) return;
      if(f.size>2*1024*1024){ showToast('File too large','Please upload an image under 2MB'); this.value=''; return; }
      const reader = new FileReader();
      reader.onload = function(ev){
        const img = document.getElementById('avatarPreview');
        if(img) img.src = ev.target.result;
        const headerImg = document.getElementById('headerProfileImg');
        if(headerImg) headerImg.src = ev.target.result;
      };
      reader.readAsDataURL(f);
    });

    function showToast(title, desc='', timeout=4200){
      const wrap = document.getElementById('toastWrap');
      if(!wrap) return;
      const t = document.createElement('div');
      t.className='toast';
      t.style.position='relative';
      t.style.opacity='1';
      t.style.transition='opacity .24s ease';
      t.style.minWidth='250px';
      t.style.maxWidth='350px';
      t.style.background='rgba(17,17,17,0.94)';
      t.style.padding='1rem 1.2rem';
      t.style.borderRadius='10px';
      t.style.boxShadow='0 10px 30px rgba(0,0,0,0.6)';
      t.style.color='#fff';
      t.style.display='flex';
      t.style.alignItems='flex-start';
      t.style.gap='0.6rem';
      t.style.wordBreak='break-word';

      const dot=document.createElement('div');
      dot.style.width='10px';
      dot.style.height='10px';
      dot.style.borderRadius='50%';
      dot.style.background='var(--accent)';
      dot.style.flexShrink='0';
      dot.style.marginTop='0.3rem';

      const content=document.createElement('div');
      content.style.flex='1';
      content.innerHTML=`<div style="font-weight:700;margin-bottom:0.2rem;">${escapeHtml(title)}</div>${desc?`<div style="opacity:0.9;">${escapeHtml(desc)}</div>`:''}`;

      const closeBtn=document.createElement('div');
      closeBtn.innerHTML='×';
      closeBtn.style.position='absolute';
      closeBtn.style.top='6px';
      closeBtn.style.right='8px';
      closeBtn.style.cursor='pointer';
      closeBtn.style.fontWeight='700';
      closeBtn.style.fontSize='1rem';
      closeBtn.addEventListener('click',()=>{clearTimeout(rm); t.remove();});

      t.appendChild(dot);
      t.appendChild(content);
      t.appendChild(closeBtn);
      wrap.appendChild(t);

      const rm=setTimeout(()=>{t.remove();},timeout);
    }

    function escapeHtml(s){ if(!s) return ''; return String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c])); }

    document.getElementById('accountForm')?.addEventListener('submit', async function(e){
      e.preventDefault();
      const form=new FormData(this);
      const np=form.get('new_password'), npc=form.get('new_password_confirm');
      if(np && np!=='' && np!==npc){ showToast('Passwords do not match'); return; }

      const saveBtn=document.getElementById('saveBtn');
      saveBtn.disabled=true; saveBtn.textContent='Saving...';

      try{
        const resp=await fetch(this.getAttribute('action'),{
          method:'POST',
          body:form,
          credentials:'same-origin',
          headers:{'X-Requested-With':'XMLHttpRequest'}
        });
        const ct=resp.headers.get('Content-Type')||'';
        let body=null;
        if(ct.includes('application/json')) body=await resp.json(); else body=await resp.text();

        if(!resp.ok){
          const msg=(body && (body.message || body.errors))?(body.message||JSON.stringify(body.errors)):(typeof body==='string'?body:'Save failed');
          showToast('Error', typeof msg==='string'?msg:JSON.stringify(msg));
        } else {
          showToast('Saved','Account updated');
          if(body && body.user){
            const headerName=document.querySelector('[data-header-name]');
            if(headerName) headerName.textContent=body.user.first_name;
          }
        }
      } catch(err){
        console.error(err);
        showToast('Network error',err.message||'Request failed');
      } finally{
        saveBtn.disabled=false; saveBtn.textContent='Save changes';
      }
    });

    document.getElementById('cancelBtn')?.addEventListener('click',()=>window.location.href='<?= site_url('dashboard') ?>');
  </script>
</body>
</html>
