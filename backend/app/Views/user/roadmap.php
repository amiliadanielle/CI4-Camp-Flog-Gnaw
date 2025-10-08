views >> user >> roadmap.php

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Roadmap</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Font: Balsamiq Sans -->
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
    body {
      font-family: 'Balsamiq Sans', cursive;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Include Header -->
  <?= $this->include('components/header'); ?>

  <main class="max-w-5xl mx-auto px-6 pt-32 pb-12">

    <h1 class="text-4xl font-bold mb-6">Project Roadmap</h1>

    <!-- Form: Create / Edit -->
    <form action="<?= site_url('roadmap'); ?>" method="post" class="bg-white p-6 rounded-lg shadow mb-10 space-y-4">
      <input type="hidden" name="id" value="<?= isset($editTask) ? esc($editTask['id']) : ''; ?>">

      <div>
        <label class="block font-semibold mb-1">Title</label>
        <input type="text" name="title" required
               value="<?= isset($editTask) ? esc($editTask['title']) : ''; ?>"
               class="w-full border px-4 py-2 rounded">
      </div>

      <div>
        <label class="block font-semibold mb-1">Description</label>
        <textarea name="description" rows="2" required class="w-full border px-4 py-2 rounded"><?= isset($editTask) ? esc($editTask['description']) : ''; ?></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block font-semibold mb-1">Priority</label>
          <select name="priority" class="w-full border px-4 py-2 rounded">
            <?php $priorities = ['Low', 'Medium', 'High']; ?>
            <?php foreach ($priorities as $p): ?>
              <option <?= isset($editTask) && $editTask['priority'] === $p ? 'selected' : ''; ?>><?= $p; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div>
          <label class="block font-semibold mb-1">Status</label>
          <select name="status" class="w-full border px-4 py-2 rounded">
            <?php $statuses = ['Planned', 'In Progress', 'Done']; ?>
            <?php foreach ($statuses as $s): ?>
              <option <?= isset($editTask) && $editTask['status'] === $s ? 'selected' : ''; ?>><?= $s; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="flex justify-end gap-3">
        <?php if (isset($editTask)): ?>
          <button type="submit" name="action" value="update" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Update</button>
          <a href="<?= site_url('roadmap'); ?>" class="px-4 py-2 border rounded">Cancel</a>
        <?php else: ?>
          <button type="submit" name="action" value="create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Task</button>
        <?php endif; ?>
      </div>
    </form>

    <!-- Task List -->
    <?php if (!empty($tasks)): ?>
      <div class="space-y-6">
        <?php foreach ($tasks as $task): ?>
          <div class="bg-white border rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-2">
              <h2 class="text-xl font-semibold"><?= esc($task['title']); ?></h2>
              <?php if ($task['status'] === 'Done'): ?>
                <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded">Done</span>
              <?php elseif ($task['status'] === 'In Progress'): ?>
                <span class="bg-yellow-100 text-yellow-700 text-sm px-3 py-1 rounded">In Progress</span>
              <?php else: ?>
                <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded">Planned</span>
              <?php endif; ?>
            </div>

            <p class="text-gray-600 mb-2"><?= esc($task['description']); ?></p>
            <p class="text-sm text-gray-500 mb-3"><strong>Priority:</strong> <?= esc($task['priority']); ?></p>

            <div class="flex gap-3">
              <form action="<?= site_url('roadmap'); ?>" method="post" class="inline">
                <input type="hidden" name="id" value="<?= esc($task['id']); ?>">
                <button type="submit" name="edit" value="1" class="text-blue-600 hover:underline">Edit</button>
              </form>

              <form action="<?= site_url('roadmap'); ?>" method="post" class="inline" onsubmit="return confirm('Delete this task?')">
                <input type="hidden" name="id" value="<?= esc($task['id']); ?>">
                <button type="submit" name="action" value="delete" class="text-red-600 hover:underline">Delete</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <p class="text-gray-500">No tasks yet. Add one above!</p>
    <?php endif; ?>
  </main>

  <!-- Include Footer -->
  <?= $this->include('components/footer'); ?>

</body>
</html>
