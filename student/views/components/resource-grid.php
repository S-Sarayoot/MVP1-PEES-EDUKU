<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
  <?php foreach ($items as $item): ?>
    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
      <div class="relative h-40">
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="thumbnail" class="w-full h-full object-cover">
        <span class="absolute top-2 left-2 bg-gray-900 text-white text-xs px-2 py-1 rounded">
          <?= htmlspecialchars($item['tag']) ?>
        </span>
      </div>
      <div class="p-4">
        <h3 class="font-semibold text-gray-800 text-sm leading-tight">
          <?= htmlspecialchars($item['title']) ?>
        </h3>
        <div class="text-xs text-gray-500 mt-2 flex justify-between">
          <span><?= htmlspecialchars($item['date']) ?></span>
          <span><?= htmlspecialchars($item['readTime']) ?> read</span>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
