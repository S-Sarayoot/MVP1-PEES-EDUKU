<!-- Main Content -->
<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">

  <?php
  // ====== Config / Data ======
  // $categories, $items สามารถมาจาก controller ได้
  $active     =  'ทั้งหมด';
  // หมวดหมู่ (อิงจาก field `type` ของ data)
$categories = ['ทั้งหมด','image','videos','learning','plan','criteria'];

// ตัวอย่างข้อมูล items (เทียบกับ const data ที่ให้มา)
$items = [
  [
    'title'       => 'นวัตกรรมตัวอย่างห้องเรียนเสมอภาค',
    'description' => 'Image',
    'image'       => 'https://www.eef.or.th/wp-content/uploads/2021/01/all-1-scaled-1-768x1024.jpeg',
    'src'         => '',
    'tag'         => 'Image',
    'cats'        => ['image'],
    'author'      => 'ครูอร',
  ],
  [
    'title'       => 'วีดีโอสอนภาษาอังกฤษ รหัสวิชา1022934',
    'description' => 'Videos',
    'image'       => 'https://i.ytimg.com/vi/71bDQNpPtOs/maxresdefault.jpg',
    'src'         => '',
    'tag'         => 'Videos',
    'cats'        => ['videos'],
    'author'      => 'ครูภูมิ',
  ],
  [
    'title'       => 'แหล่งการเรียนรู้แนะนำ',
    'description' => 'แหล่งการเรียนรู้แนะนำ',
    'image'       => 'https://media.the101.world/wp-content/uploads/2022/07/05140421/Sorravit_20220722_PolicyInsight-Banner.png',
    'src'         => '',
    'tag'         => 'แหล่งการเรียนรู้',
    'cats'        => ['learning'],
    'author'      => 'ครูมุก',
  ],
  [
    'title'       => 'แผนการจัดการเรียนรีู้ตัวอย่าง',
    'description' => 'แผนการจัดการเรียนรู้',
    'image'       => 'https://online.pubhtml5.com/lbvh/amtn/files/large/1.jpg?1622465202',
    'src'         => '',
    'tag'         => 'แผนการสอน',
    'cats'        => ['plan'],
    'author'      => 'ครูบี',
  ],
  [
    'title'       => 'เกณฑ์การประเมิณคะแนน รหัสวิชา1022934',
    'description' => 'เกณฑ์การประเมิณ',
    'image'       => '../image/rubric.png',
    'src'         => '',
    'tag'         => 'เกณฑ์การประเมิน',
    'cats'        => ['criteria'],
    'author'      => 'ครูจูน',
  ],
];

  if (!in_array($active, $categories, true)) $active = $categories[0] ?? 'ทั้งหมด';

  $cid = 'dd_' . substr(md5(serialize($categories) . rand()), 0, 6);
  $h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
  ?>

  <div class="flex flex-col">

    <div id="<?= $h($cid) ?>" class="bg-white shadow-md rounded-lg p-4">
      <div class="flex flex-wrap gap-2 justify-between items-center">
        <h2 class="text-2xl font-bold mb-4">สื่อการสอนของฉัน</h2>
        <!-- Dropdown กรองหมวดหมู่ -->
        <div class="flex items-center gap-2">
          <label for="<?= $h($cid) ?>_select" class="text-sm text-gray-600">หมวดหมู่:</label>
          <select id="<?= $h($cid) ?>_select"
                  class="border rounded-md px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $h($cat) ?>" <?= $cat === $active ? 'selected' : '' ?>>
                <?= $h($cat) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <!-- ถ้าจะใช้ไฟล์ dropdown.php เดิมแทน select นี้ ก็ส่ง $categories/$active เข้าไปได้ -->
        <?php /* include '../component/dropdown.php' */ ?>
      </div>

      <hr class="border-0.5 border-gray-100 -mx-4">

      <!-- ว่างเปล่า -->
      <div class="rb-empty hidden text-center text-gray-500 py-10">
        ไม่มีเนื้อหาที่จะแสดง
      </div>

      <!-- การ์ด -->
      <div id="<?= $h($cid) ?>_grid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <?php foreach ($items as $item): ?>
          <?php
            // รองรับทั้ง 'cats' (array) หรือ 'tag' (string)
            $cats = $item['cats'] ?? ($item['tag'] ?? []);
            if (!is_array($cats)) { $cats = array_filter([$cats]); }
            $cats = array_values(array_filter(array_map('strval', $cats)));
            if (!$cats) { $cats = ['ทั้งหมด']; }

            // ให้ card.php เห็นตัวแปร $data
            $data = $item;
          ?>
          <div class="rb-card" data-cats="<?= $h(implode('|', $cats)) ?>">
            <?php include __DIR__ . '/../components/card.php'; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<script>
(() => {
  const cid = <?= json_encode($cid) ?>;
  const root   = document.getElementById(cid);
  const select = root.querySelector('#' + cid + '_select');
  const grid   = root.querySelector('#' + cid + '_grid');
  const cards  = Array.from(grid.querySelectorAll('.rb-card'));
  const empty  = root.querySelector('.rb-empty');

  const updateEmpty = () => {
    const anyVisible = cards.some(c => c.style.display !== 'none');
    empty.classList.toggle('hidden', anyVisible);
  };

  const filterBy = (cat) => {
    const showAll = (cat === 'ทั้งหมด');
    cards.forEach(card => {
      const set = (card.getAttribute('data-cats') || '').split('|').filter(Boolean);
      const matched = showAll || set.includes(cat);
      card.style.display = matched ? '' : 'none';
    });
    updateEmpty();
    try {
      history.replaceState(null, '', location.pathname + '#cat=' + encodeURIComponent(cat));
    } catch (_) {}
  };

  // เปลี่ยนค่าจาก dropdown
  select.addEventListener('change', () => filterBy(select.value));

  // เปิดหน้ามาพร้อม hash หรือ active เดิม
  const fromHash = (location.hash.match(/cat=([^&]+)/) || [null, select.value])[1];
  select.value = decodeURIComponent(fromHash || select.value);
  filterBy(select.value);
})();
</script>
