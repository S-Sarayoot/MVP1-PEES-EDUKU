<div class="space-y-4">
  <?php foreach ($items as $item): ?>
    <div class="flex gap-3">
      <div class="w-20 h-20 bg-amber-400 shrink-0">
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="thumbnail" class="w-full h-full object-cover rounded">
      </div>
      <div class="flex-1">
        <a href="<?= htmlspecialchars($item['src']) ?>" class="font-semibold text-gray-800 text-lg leading-snug">
          <?= htmlspecialchars($item['title']) ?>
        </a>
        <div class="text-xs text-gray-500 mt-1">
          <?= htmlspecialchars($item['author']) ?> &bull; <?= htmlspecialchars($item['date']) ?> &bull; <?= htmlspecialchars($item['readTime']) ?> read
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
