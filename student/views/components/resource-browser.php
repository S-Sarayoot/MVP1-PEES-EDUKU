<?php
/**
 * props ที่รับเข้า:
 * - $categories: array เช่น ['ทั้งหมด','วิดีโอ','บทพูด','Exam','Script','Story board']
 * - $items: array ของ resource แต่ละชิ้น:
 *      [
 *        'image' => '/uploads/pic.jpg',
 *        'title' => 'หัวเรื่อง',
 *        'tag'   => 'DESIGN',
 *        'date'  => 'Jan 27',
 *        'readTime' => '10 Mins',
 *        'cats'  => ['วิดีโอ','Script'] // หมวดหมู่ของการ์ด (หลายหมวดได้)
 *      ]
 * - $active (optional): ค่าแท็บเริ่มต้น, ดีฟอลต์ = 'ทั้งหมด'
 */
$categories = $categories ?? ['ทั้งหมด'];
$active = $active ?? 'ทั้งหมด';
$componentId = 'rb_' . substr(md5(serialize($categories).rand()),0,6); // กัน id ซ้ำ
?>
<div class="space-y-4" id="<?= $componentId ?>">
  <!-- แท็บเลื่อนแนวนอน -->
  <div class="relative">
    <button type="button"
      class="rb-prev absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100">‹</button>

    <div class="rb-tabs flex gap-3 overflow-x-auto scrollbar-hide px-10">
      <?php foreach ($categories as $cat): ?>
        <?php $isActive = ($cat === $active); ?>
        <button type="button"
          data-cat="<?= htmlspecialchars($cat) ?>"
          class="rb-tab whitespace-nowrap px-4 py-2 rounded-full text-sm font-medium transition
          <?= $isActive ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
          <?= htmlspecialchars($cat) ?>
        </button>
      <?php endforeach; ?>
    </div>

    <button type="button"
      class="rb-next absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100">›</button>
  </div>

  <!-- กริดการ์ด -->
  <div class="rb-grid grid grid-cols-1 sm:grid-cols-2 gap-4">
    <?php foreach ($items as $item): ?>
      <div class="rb-card bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden"
           data-cats="<?= htmlspecialchars(implode('|', $item['cats'] ?? [])) ?>">
        <div class="relative h-40">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="" class="w-full h-full object-cover">
          <?php if (!empty($item['tag'])): ?>
            <span class="absolute top-2 left-2 bg-gray-900 text-white text-xs px-2 py-1 rounded">
              <?= htmlspecialchars($item['tag']) ?>
            </span>
          <?php endif; ?>
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
</div>

<style>
  .scrollbar-hide::-webkit-scrollbar { display: none; }
  .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
(() => {
  const root = document.getElementById("<?= $componentId ?>");
  const tabs = root.querySelectorAll(".rb-tab");
  const grid = root.querySelector(".rb-grid");
  const cards = grid.querySelectorAll(".rb-card");
  const tabsWrap = root.querySelector(".rb-tabs");
  const btnPrev = root.querySelector(".rb-prev");
  const btnNext = root.querySelector(".rb-next");

  const setActive = (btn) => {
    tabs.forEach(b => b.classList.remove("bg-gray-900","text-white"));
    tabs.forEach(b => b.classList.add("bg-gray-100","text-gray-700"));
    btn.classList.remove("bg-gray-100","text-gray-700");
    btn.classList.add("bg-gray-900","text-white");
  };

  const filterBy = (cat) => {
    const showAll = (cat === "ทั้งหมด");
    cards.forEach(card => {
      const set = (card.getAttribute("data-cats") || "").split("|").filter(Boolean);
      const matched = showAll || set.includes(cat);
      card.classList.toggle("hidden", !matched);
    });
  };

  tabs.forEach(btn => {
    btn.addEventListener("click", () => {
      const cat = btn.getAttribute("data-cat");
      setActive(btn);
      filterBy(cat);
      // อัปเดต hash เล็ก ๆ เผื่อแชร์ลิงก์ได้
      try { history.replaceState(null, "", location.pathname + "#cat=" + encodeURIComponent(cat)); } catch(e){}
    });
  });

  // ปุ่มเลื่อนแท็บซ้าย/ขวา
  btnPrev.addEventListener("click", () => tabsWrap.scrollBy({ left: -160, behavior: 'smooth' }));
  btnNext.addEventListener("click", () => tabsWrap.scrollBy({ left: 160, behavior: 'smooth' }));

  // เปิดหน้ามาพร้อม hash หรือค่า default
  const fromHash = (location.hash.match(/cat=([^&]+)/) || [null, "<?= $active ?>"])[1];
  const target = Array.from(tabs).find(b => b.getAttribute("data-cat") === decodeURIComponent(fromHash));
  if (target) { setActive(target); filterBy(target.getAttribute("data-cat")); }
})();
</script>
