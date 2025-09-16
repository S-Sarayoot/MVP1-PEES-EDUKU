<div class="w-full">
<?php
// Defaults & guards
$categories = $categories ?? ['ทั้งหมด'];
$active     = $active ?? 'ทั้งหมด';
$items      = $items ?? [];

// If provided $active not in $categories, fall back to the first element
if (!in_array($active, $categories, true)) {
  $active = $categories[0] ?? 'ทั้งหมด';
}

$componentId = 'rb_' . substr(md5(serialize($categories) . rand()), 0, 6); // prevent duplicated ids

// small helpers
$h    = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$hAttr = $h; // alias for clarity
?>

  <div class="space-y-4" id="<?= $hAttr($componentId) ?>">
    <!-- แท็บเลื่อนแนวนอน -->
    <div class="relative">
      <button type="button"
        class="rb-prev absolute left-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
        aria-label="เลื่อนซ้าย">‹</button>

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
        class="rb-next absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-8 h-8 flex items-center justify-center z-10 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed"
        aria-label="เลื่อนขวา">›</button>
    </div>

    <!-- ข้อความว่าง -->
    <div class="rb-empty hidden text-center text-gray-500 py-10">
      ไม่มีเนื้อหาที่จะแสดง
    </div>

    <!-- กริด/สไลด์การ์ด -->
    <div class="rb-grid relative">
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php foreach ($items as $item): ?>
            <?php
              $cats = $item['cats'] ?? [];
              if (!is_array($cats)) { $cats = array_filter([$cats]); }
              $cats = array_values(array_filter(array_map('strval', $cats)));
              if (!$cats) { $cats = ['ทั้งหมด']; } // ให้ทุกการ์ดเข้าแท็บ "ทั้งหมด"
              $src  = $item['src'] ?? '';
              $data = $item; // ให้ card.php ใช้ตัวแปร $data
            ?>
            <div class="rb-card swiper-slide"
                 data-cats="<?= $hAttr(implode('|', $cats)) ?>"
                 data-href="<?= $hAttr($src) ?>">
              <?php component('/components/card.php', $data); ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- ปุ่มเลื่อน -->
      <div class="absolute left-0 top-1/2 -translate-y-1/2 z-10">
        <button class="swiper-button-prev w-16 h-5 bg-green-700/95 text-white p-2 rounded-full shadow"></button>
      </div>
      <div class="absolute right-0 top-1/2 -translate-y-1/2 z-10">
        <button class="swiper-button-next w-16 h-5 bg-green-700/80 text-white p-2 rounded-full shadow"></button>
      </div>
    </div>
  </div>
</div>

<script>
// สร้าง Swiper instance
const swiper = new Swiper(".mySwiper", {
  slidesPerView: 3,
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    1:    { slidesPerView: 1 },
    425:  { slidesPerView: 1.2 },
    768:  { slidesPerView: 2 },
    1024: { slidesPerView: 2.3 },
    1440: { slidesPerView: 4.5 }
  }
});

(() => {
  const root     = document.getElementById(<?= json_encode($componentId) ?>);
  const tabs     = root.querySelectorAll('.rb-tab');
  const tabsWrap = root.querySelector('.rb-tabs');
  const btnPrev  = root.querySelector('.rb-prev');
  const btnNext  = root.querySelector('.rb-next');
  const emptyEl  = root.querySelector('.rb-empty');

  // ใช้รายการสไลด์จาก Swiper (สำคัญ)
  const cards = Array.from(swiper.slides);

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
    const anyVisible = cards.some(c => c.style.display !== 'none');
    emptyEl.classList.toggle('hidden', anyVisible);
  };

  const filterBy = (cat) => {
    const showAll = (cat === 'ทั้งหมด');
    cards.forEach(card => {
      const set = (card.getAttribute('data-cats') || '').split('|').filter(Boolean);
      const matched = showAll || set.includes(cat);
      // ใช้ display เพื่อให้ Swiper คิดเลย์เอาต์ใหม่ถูกต้อง
      card.style.display = matched ? '' : 'none';
    });
    swiper.update();   // อัปเดตเลย์เอาต์
    updateEmptyState();
  };

  // คลิกการ์ดทั้งใบเพื่อเปิดลิงก์ (ถ้าไม่มีการกดปุ่มแท็ก)
  cards.forEach(card => {
    card.addEventListener('click', (e) => {
      if (e.target.closest('.rb-tag')) return; // ถ้าคลิกแท็ก อย่าเปิดลิงก์
      const href = card.getAttribute('data-href');
      if (href) window.open(href, '_blank');
    });
  });

  // คลิกแท็บเพื่อกรอง
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

  // ให้ปุ่มแท็บซ้าย-ขวาทำงาน/สถานะ
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

  // กรองด้วยค่า hash หรือค่าเริ่มต้น
  const fromHash     = (location.hash.match(/cat=([^&]+)/) || [null, <?= json_encode($active) ?>])[1];
  const catFromHash  = decodeURIComponent(fromHash || '');
  const target       = Array.from(tabs).find(b => b.getAttribute('data-cat') === catFromHash);
  if (target) {
    setActive(target);
    filterBy(catFromHash);
  } else if (tabs[0]) {
    filterBy(tabs[0].getAttribute('data-cat'));
  } else {
    updateEmptyState();
  }

  // ให้แท็กบนการ์ดทำหน้าที่เป็นตัวกรอง (event delegation)
  root.addEventListener('click', (e) => {
    const tagBtn = e.target.closest('.rb-tag');
    if (!tagBtn) return;
    const cat = tagBtn.getAttribute('data-tag');
    const btn = Array.from(tabs).find(b => b.getAttribute('data-cat') === cat);
    if (btn) {
      setActive(btn);
      filterBy(cat);
      try {
        history.replaceState(null, '', location.pathname + '#cat=' + encodeURIComponent(cat));
      } catch (_) {}
    }
  });

  requestAnimationFrame(updateArrows);
})();
</script>
