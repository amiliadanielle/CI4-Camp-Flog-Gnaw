<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Roadmap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Balsamiq+Sans:wght@400;700&display=swap"
    rel="stylesheet"
  >

  <!-- Tailwind Custom Font Config -->
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

  <style>
    html, body {
      margin: 0;
      padding: 0;
      width: 100%;
      min-height: 100%;
      overflow-x: hidden;
      font-family: 'Balsamiq Sans', cursive;
      background: linear-gradient(135deg, #dbeafe 0%, #93c5fd);
      background-attachment: fixed;
      background-size: cover;
      box-sizing: border-box;
    }

    .fade-in {
      animation: fadeIn 0.6s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .hover-float:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="text-gray-800 min-h-screen relative">

  <!-- ✅ Header -->
  <?= $this->include('components/header'); ?>

  <!-- ✅ Main Content -->
  <main class="relative z-10 max-w-5xl mx-auto px-6 pt-32 pb-12 fade-in">
    <h1 class="text-4xl font-bold mb-6 flex items-center gap-3 text-sky-900 drop-shadow-sm">
      ☁️ PROJECT ROADMAP
    </h1>

    <!-- ✅ Task Form -->
    <form action="<?= site_url('roadmap'); ?>" method="post" 
          class="bg-white/90 backdrop-blur p-6 rounded-2xl shadow-lg mb-10 space-y-4 border border-gray-100 hover:shadow-2xl hover-float transition-all duration-300">
      <input type="hidden" name="id" value="<?= isset($editTask) ? esc($editTask['id']) : ''; ?>">

      <div>
        <label class="block font-semibold mb-1">Title</label>
        <input type="text" name="title" required
               value="<?= isset($editTask) ? esc($editTask['title']) : ''; ?>"
               class="w-full border border-gray-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 px-4 py-2 rounded-lg transition-all duration-200">
      </div>

      <div>
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" rows="2" required
          class="w-full border border-gray-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 px-4 py-2 rounded-lg transition-all duration-200"><?= isset($editTask) ? esc($editTask['description']) : ''; ?></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-1">Priority</label>
          <select name="priority"
                  class="w-full border border-gray-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 px-4 py-2 rounded-lg transition-all duration-200">
            <?php $priorities = ['Low', 'Medium', 'High']; ?>
            <?php foreach ($priorities as $p): ?>
              <option <?= isset($editTask) && $editTask['priority'] === $p ? 'selected' : ''; ?>><?= $p; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-semibold mb-1">Status</label>
          <select name="status"
                  class="w-full border border-gray-300 focus:border-sky-400 focus:ring-2 focus:ring-sky-100 px-4 py-2 rounded-lg transition-all duration-200">
            <?php $statuses = ['Planned', 'In Progress', 'Done']; ?>
            <?php foreach ($statuses as $s): ?>
              <option <?= isset($editTask) && $editTask['status'] === $s ? 'selected' : ''; ?>><?= $s; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="flex justify-end gap-3 pt-3">
        <?php if (isset($editTask)): ?>
          <button type="submit" name="action" value="update"
                  class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700 transition-all duration-300">
            <i class="fa-solid fa-check mr-1"></i> Update
          </button>
          <a href="<?= site_url('roadmap'); ?>" 
             class="px-5 py-2 border rounded-lg hover:bg-gray-100 transition-all duration-200">
             Cancel
          </a>
        <?php else: ?>
          <button type="submit" name="action" value="create"
                  class="bg-sky-600 text-white px-5 py-2 rounded-lg hover:bg-sky-700 hover:scale-105 transition-all duration-300">
            <i class="fa-solid fa-plus mr-1"></i> Add Task
          </button>
        <?php endif; ?>
      </div>
    </form>

    <!-- ✅ Task Sections -->
    <?php
      $activeTasks = array_filter($tasks ?? [], fn($t) => $t['status'] !== 'Done');
      $completedTasks = array_filter($tasks ?? [], fn($t) => $t['status'] === 'Done');
    ?>

    <?php if (!empty($tasks)): ?>
      <!-- Active Tasks -->
      <section class="mb-12 fade-in">
        <h2 class="text-2xl font-bold mb-4 text-sky-700 flex items-center gap-2">
          🧩 Active Tasks
        </h2>
        <?php if (!empty($activeTasks)): ?>
          <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($activeTasks as $task): ?>
              <div class="bg-white border-l-4 rounded-xl shadow-md hover-float transition-all duration-300 p-6 
                          <?= $task['status'] === 'In Progress' ? 'border-yellow-400' : 'border-sky-400'; ?> 
                          flex flex-col justify-between min-h-[220px]">
                <div>
                  <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-semibold"><?= esc($task['title']); ?></h3>
                    <?php if ($task['status'] === 'In Progress'): ?>
                      <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded-full">In Progress</span>
                    <?php else: ?>
                      <span class="bg-sky-100 text-sky-700 text-sm px-3 py-1 rounded-full">Planned</span>
                    <?php endif; ?>
                  </div>
                  <p class="text-gray-600 mb-2"><?= esc($task['description']); ?></p>
                  <p class="text-sm text-gray-500">
                    <strong>Priority:</strong>
                    <span class="font-semibold <?= $task['priority'] === 'High' ? 'text-red-600' : ($task['priority'] === 'Medium' ? 'text-yellow-600' : 'text-green-600'); ?>">
                      <?= esc($task['priority']); ?>
                    </span>
                  </p>
                </div>

                <!-- ✅ Action Buttons (bottom-right corner) -->
                <div class="flex justify-end gap-3 mt-4">
                  <a href="<?= site_url('roadmap/edit/'.$task['id']); ?>" 
                     class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                     <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                  </a>
                  <a href="<?= site_url('roadmap/delete/'.$task['id']); ?>" 
                     class="text-red-600 hover:text-red-800 text-sm font-semibold"
                     onclick="return confirm('Are you sure you want to delete this task?');">
                     <i class="fa-solid fa-trash mr-1"></i> Delete
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-gray-600">No active tasks yet. Add one above!</p>
        <?php endif; ?>
      </section>

      <!-- Completed Tasks -->
      <section class="fade-in">
        <h2 class="text-2xl font-bold mb-4 text-green-700 flex items-center gap-2">
          ✅ Completed Tasks
        </h2>
        <?php if (!empty($completedTasks)): ?>
          <div class="grid md:grid-cols-2 gap-6">
            <?php foreach ($completedTasks as $task): ?>
              <div class="bg-white border-l-4 border-green-400 rounded-xl shadow-md p-6 hover-float transition-all duration-300 flex flex-col justify-between min-h-[220px]">
                <div>
                  <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-semibold"><?= esc($task['title']); ?></h3>
                    <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Done</span>
                  </div>
                  <p class="text-gray-600 mb-2"><?= esc($task['description']); ?></p>
                </div>

                <!-- ✅ Action Buttons (bottom-right corner) -->
                <div class="flex justify-end gap-3 mt-4">
                  <a href="<?= site_url('roadmap/edit/'.$task['id']); ?>" 
                     class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                     <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                  </a>
                  <a href="<?= site_url('roadmap/delete/'.$task['id']); ?>" 
                     class="text-red-600 hover:text-red-800 text-sm font-semibold"
                     onclick="return confirm('Are you sure you want to delete this task?');">
                     <i class="fa-solid fa-trash mr-1"></i> Delete
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <p class="text-gray-600">No completed tasks yet.</p>
        <?php endif; ?>
      </section>
    <?php else: ?>
      <p class="text-gray-600">No tasks yet. Add one above!</p>
    <?php endif; ?>
  </main>

  <!-- ✅ Footer -->
  <?= $this->include('components/footer'); ?>

</body>
</html>
