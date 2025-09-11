<?php
/**
 * Refined resource browser component
 * Props:
 * - $categories: array เช่น ['ทั้งหมด','วิดีโอ','บทพูด','Exam','Script','Story board']
 * - $items: array ของ resource แต่ละชิ้น (ดูตัวอย่างโครงสร้างในโค้ดเดิม)
 * - $active (optional): ค่าแท็บเริ่มต้น, ดีฟอลต์ = 'ทั้งหมด'
 */

// Defaults & guards
$categories = $categories ?? ['ทั้งหมด'];
$active = $active ?? 'ทั้งหมด';
$items = $items ?? [];

// If provided $active not in $categories, fall back to the first element
if (!in_array($active, $categories, true)) {
    $active = $categories[0] ?? 'ทั้งหมด';
}

$componentId = 'rb_' . substr(md5(serialize($categories) . rand()), 0, 6); // prevent duplicated ids

// small helpers
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$hAttr = $h; // alias for clarity
?>
<div class="space-y-4" id="<?= $hAttr($componentId) ?>">
  <!-- แท็บเลื่อนแนวนอน -->
  <div class="relative">
    <button type="button"
      class="rb-prev absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed" aria-label="เลื่อนซ้าย">‹</button>

    <div class="rb-tabs flex gap-3 overflow-x-auto scrollbar-hide px-10" role="tablist">
      <?php foreach ($categories as $cat): ?>
        <?php $isActive = ($cat === $active); ?>
        <button type="button"
          role="tab"
          aria-selected="<?= $isActive ? 'true' : 'false' ?>"
          data-cat="<?= $hAttr($cat) ?>"
          class="rb-tab whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition
          <?= $isActive ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
          <?= $h($cat) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <button type="button"
      class="rb-next absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed" aria-label="เลื่อนขวา">›</button>
  </div>

  <!-- ข้อความว่าง -->
  <div class="rb-empty hidden text-center text-gray-500 py-10">
    ไม่มีเนื้อหาที่จะแสดง
  </div>

  <!-- กริดการ์ด -->
  <div class="rb-grid grid grid-cols-1 sm:grid-cols-2 gap-4">
    <?php foreach ($items as $item): ?>
      <?php
        $image = $item['image'] ?? '';
        $title = $item['title'] ?? '';
        $src = $item['src'] ?? '';
        $tag   = $item['tag']   ?? '';
        $date  = $item['date']  ?? '';
        $readTime = $item['readTime'] ?? '';
        $cats  = $item['cats']  ?? [];
        // Normalize cats to array of strings
        if (!is_array($cats)) { $cats = array_filter([$cats]); }
        $cats = array_values(array_filter(array_map('strval', $cats)));
      ?>
      <a href="<?= $hAttr($src) ?>" class="rb-card bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden"
        data-cats="<?= $hAttr(implode('|', $cats)) ?>">
        <div class="relative h-40">
          <img src="<?= $hAttr($image) ?>" alt="<?= $hAttr($title ?: 'resource') ?>" class="w-full h-full object-cover" loading="lazy">
          <?php if ($tag !== ''): ?>
            <span class="absolute top-2 left-2 bg-gray-900/70 text-white text-xs px-2 py-1 rounded">
              <?= $h($tag) ?>
            </span>
          <?php endif; ?>
        </div>
        <div class="p-4">
          <h3 class="font-semibold text-gray-800 text-lg leading-snug">
            <?= $h($title) ?>
          </h3>
          <div class="text-xs text-gray-500 mt-2 flex justify-between">
            <span><?= $h($date) ?></span>
            <span><?= $h($readTime) ?> read</span>
          </div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<style>
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
(() => {
  const root = document.getElementById(<?= json_encode($componentId) ?>);
  const tabs = root.querySelectorAll('.rb-tab');
  const tabsWrap = root.querySelector('.rb-tabs');
  const btnPrev = root.querySelector('.rb-prev');
  const btnNext = root.querySelector('.rb-next');
  const grid = root.querySelector('.rb-grid');
  const cards = Array.from(grid.querySelectorAll('.rb-card'));
  const emptyEl = root.querySelector('.rb-empty');

  const setActive = (btn) => {
    tabs.forEach(b => {
      b.classList.remove('bg-gray-900', 'text-white');
      b.classList.add('bg-gray-100', 'text-gray-700');
      b.setAttribute('aria-selected', 'false');
    });
    btn.classList.remove('bg-gray-100', 'text-gray-700');
    btn.classList.add('bg-gray-900', 'text-white');
    btn.setAttribute('aria-selected', 'true');
  };

  const updateEmptyState = () => {
    const anyVisible = cards.some(c => !c.classList.contains('hidden'));
    emptyEl.classList.toggle('hidden', anyVisible);
  };

  const filterBy = (cat) => {
    const showAll = (cat === 'ทั้งหมด');
    cards.forEach(card => {
      const set = (card.getAttribute('data-cats') || '').split('|').filter(Boolean);
      const matched = showAll || set.includes(cat);
      card.classList.toggle('hidden', !matched);
    });
    updateEmptyState();
  };

  tabs.forEach(btn => {
    btn.addEventListener('click', () => {
      const cat = btn.getAttribute('data-cat');
      setActive(btn);
      filterBy(cat);
      try {
        history.replaceState(null, '', location.pathname + '#cat=' + encodeURIComponent(cat));
      } catch (_) {}
    });
  });

  // Scroll controls state
  const updateArrows = () => {
    const maxScroll = tabsWrap.scrollWidth - tabsWrap.clientWidth;
    btnPrev.disabled = tabsWrap.scrollLeft <= 0;
    btnNext.disabled = tabsWrap.scrollLeft >= maxScroll - 1;
  };
  btnPrev.addEventListener('click', () => {
    tabsWrap.scrollBy({ left: -160, behavior: 'smooth' });
  });
  btnNext.addEventListener('click', () => {
    tabsWrap.scrollBy({ left: 160, behavior: 'smooth' });
  });
  tabsWrap.addEventListener('scroll', updateArrows, { passive: true });

  // Open with hash or default
  const fromHash = (location.hash.match(/cat=([^&]+)/) || [null, <?= json_encode($active) ?>])[1];
  const catFromHash = decodeURIComponent(fromHash || '');
  const target = Array.from(tabs).find(b => b.getAttribute('data-cat') === catFromHash);
  if (target) {
    setActive(target);
    filterBy(catFromHash);
  } else if (tabs[0]) {
    // ensure initial empty-state reflects current active
    filterBy(tabs[0].getAttribute('data-cat'));
  } else {
    updateEmptyState();
  }

  // Initial arrow state after layout
  requestAnimationFrame(updateArrows);
})();
</script>
