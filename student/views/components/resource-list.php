<div class="space-y-4">
  <?php foreach ($items as $item): ?>
    <div class="flex space-x-3">
      <div class="w-20 h-20 flex-shrink-0">
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="thumbnail" class="w-full h-full object-cover rounded">
      </div>
      <div class="flex-1">
        <p class="font-semibold text-gray-800 text-sm leading-snug">
          <?= htmlspecialchars($item['title']) ?>
        </p>
        <div class="text-xs text-gray-500 mt-1">
          <?= htmlspecialchars($item['author']) ?> &bull; <?= htmlspecialchars($item['date']) ?> &bull; <?= htmlspecialchars($item['readTime']) ?> read
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
