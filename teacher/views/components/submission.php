<?php
/**
 * Student Workshop Table (PHP component) — filter by submitted workshop
 * - เลือกหมวด workshop 1/2/3 แล้วจะแสดงเฉพาะแถวที่ "ส่ง" หมวดนั้น
 * - แสดงคอลัมน์ "สะท้อนคิด" พร้อมไอคอน/สี
 * - (option) $showAction = true เพื่อมีปุ่ม "ดูรายละเอียด"
 */

$rows       = $items       ?? [];
$showIndex  = isset($showIndex) ? (bool)$showIndex : true;
$showAction = isset($showAction) ? (bool)$showAction : false;

$categories = ['workshop 1','workshop 2','workshop 3'];
$activeCat  = $activeCat ?? $categories[0];

$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$componentId = 'swt_' . substr(md5(json_encode($rows) . rand()), 0, 6);

/** normalize row */
$normalize = function ($r) {
  $date  = $r['date']         ?? $r['submitted_at']  ?? '';
  $id    = $r['id']           ?? $r['student_id']    ?? '';
  $name  = $r['name']         ?? $r['student_name']  ?? '';
  $major = $r['major']        ?? $r['program']       ?? '';

  $w     = $r['workshops']    ?? $r['workshop']      ?? [];
  if (!is_array($w)) $w = array_filter(array_map('trim', preg_split('/[;,|]/', (string)$w)));
  $w = array_values($w);

  $ref   = $r['reflections']  ?? $r['reflection']    ?? $w; // default = ส่งแล้วเท่าที่ส่ง
  if (!is_array($ref)) $ref = array_filter(array_map('trim', preg_split('/[;,|]/', (string)$ref)));
  $ref = array_values($ref);

  return compact('date','id','name','major') + ['workshops'=>$w,'reflections'=>$ref];
};

$renderReflect = function(bool $isDone, string $cat) use ($h) {
  if ($isDone) {
    return '
    <div class="flex items-center gap-2 text-green-600">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <span class="whitespace-nowrap">ส่งแล้ว</span>
      <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-[11px]">'.$h($cat).'</span>
    </div>';
  }
  return '
  <div class="flex items-center gap-2 text-gray-500">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
    <span class="whitespace-nowrap">ยังไม่ส่ง</span>
    <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-600 px-2 py-0.5 text-[11px]">'.$h($cat).'</span>
  </div>';
};

$colspan = ($showIndex ? 7 : 6) + ($showAction ? 1 : 0);
?>
<div id="<?= $h($componentId) ?>" class="w-full">
  <!-- Toolbar -->
  <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
    <div class="flex items-center gap-2">
      <label for="<?= $h($componentId) ?>_cat" class="text-sm text-gray-700">หมวดหมู่:</label>
      <select id="<?= $h($componentId) ?>_cat"
              class="border rounded-md px-2.5 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-purple-300">
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $h($cat) ?>" <?= $cat === $activeCat ? 'selected' : '' ?>><?= $h($cat) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <?php if ($showAction): ?>
      <div class="text-xs text-gray-500">* แสดงเฉพาะผู้ที่ส่งหมวดที่เลือก</div>
    <?php endif; ?>
  </div>

  <div class="w-full max-h-[20rem] overflow-auto border border-purple-200 shadow-md rounded-md">
    <table class="w-full text-sm">
      <thead class="whitespace-nowrap">
        <tr class="bg-purple-200 text-gray-800">
          <?php if ($showIndex): ?><th class="py-2 px-3 font-semibold border border-purple-200 text-center">ลำดับที่</th><?php endif; ?>
          <th class="py-2 px-3 font-semibold border border-purple-200">ว/ด/ป ที่ส่ง</th>
          <th class="py-2 px-3 font-semibold border border-purple-200">รหัสนิสิต</th>
          <th class="py-2 px-3 font-semibold border border-purple-200">ชื่อ - นามสกุล</th>
          <th class="py-2 px-3 font-semibold border border-purple-200">สาขาวิชา</th>
          <th class="py-2 px-3 font-semibold border border-purple-200">workshop ที่ส่ง</th>
          <th class="py-2 px-3 font-semibold border border-purple-200">สะท้อนคิด</th>
          <?php if ($showAction): ?><th class="py-2 px-3 font-semibold border border-purple-200 text-center"></th><?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!$rows): ?>
          <tr><td colspan="<?= $colspan ?>" class="py-4 px-3 text-center text-gray-500">ไม่มีข้อมูล</td></tr>
        <?php else: ?>
          <?php $i = 1; foreach ($rows as $raw): $r = $normalize($raw);
            $subW = [
              'workshop 1' => in_array('workshop 1', $r['workshops'], true) ? 1 : 0,
              'workshop 2' => in_array('workshop 2', $r['workshops'], true) ? 1 : 0,
              'workshop 3' => in_array('workshop 3', $r['workshops'], true) ? 1 : 0,
            ];
            $refW = [
              'workshop 1' => in_array('workshop 1', $r['reflections'], true) ? 1 : 0,
              'workshop 2' => in_array('workshop 2', $r['reflections'], true) ? 1 : 0,
              'workshop 3' => in_array('workshop 3', $r['reflections'], true) ? 1 : 0,
            ];
            $isRef = $refW[$activeCat] ?? 0;
          ?>
          <tr class="odd:bg-white even:bg-purple-50/40"
              data-row
              data-student-id="<?= $h($r['id']) ?>"
              data-sub-w1="<?= $subW['workshop 1'] ?>" data-ref-w1="<?= $refW['workshop 1'] ?>"
              data-sub-w2="<?= $subW['workshop 2'] ?>" data-ref-w2="<?= $refW['workshop 2'] ?>"
              data-sub-w3="<?= $subW['workshop 3'] ?>" data-ref-w3="<?= $refW['workshop 3'] ?>">
            <?php if ($showIndex): ?><td class="py-2 px-2 border border-purple-200 text-center"><?= $i ?></td><?php endif; ?>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['date']) ?></td>
            <td class="py-2 px-3 border border-purple-200 text-blue-800"><?= $h($r['id']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['name']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['major']) ?></td>
            <td class="py-2 px-3 border border-purple-200">
              <?php if ($r['workshops']): ?>
                <div class="flex flex-wrap gap-1">
                  <?php foreach ($r['workshops'] as $ws): ?>
                    <span class="inline-flex items-center rounded-full bg-purple-100 text-purple-800 px-2 py-0.5 text-xs font-medium"><?= $h($ws) ?></span>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <span class="text-gray-400">-</span>
              <?php endif; ?>
            </td>
            <td class="py-2 px-3 border border-purple-200" data-role="reflect-cell">
              <?= $renderReflect((bool)$isRef, $activeCat) ?>
            </td>
            <?php if ($showAction): ?>
            <td class="py-2 px-3 border border-purple-200 text-center">
              <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-purple-200 px-2.5 py-1 text-xs text-purple-700 hover:bg-purple-50" 
              data-role="action-workshop" data-workshop="<?= $h($activeCat) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                workshop
              </button>
              <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-purple-200 px-2.5 py-1 text-xs text-purple-700 hover:bg-purple-50" 
              data-role="action-reflection" data-workshop="<?= $h($activeCat) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                สะท้อนคิด
              </button>
            </td>
            <?php endif; ?>
          </tr>
          <?php $i++; endforeach; ?>
          <!-- แถวแจ้งไม่มีข้อมูลหลังกรอง -->
          <tr data-empty-row class="hidden">
            <td colspan="<?= $colspan ?>" class="py-4 px-3 text-center text-gray-500">ไม่มีข้อมูลในหมวดนี้</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
(() => {
  const root   = document.getElementById(<?= json_encode($componentId) ?>);
  const select = root.querySelector('#<?= $h($componentId) ?>_cat');
  const tbody  = root.querySelector('tbody');

  const renderStatusHTML = (isDone, cat) => isDone ? `
    <div class="flex items-center gap-2 text-green-600">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <span class="whitespace-nowrap">ส่งแล้ว</span>
      <span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-[11px]">${cat}</span>
    </div>` : `
    <div class="flex items-center gap-2 text-gray-500">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <span class="whitespace-nowrap">ยังไม่ส่ง</span>
      <span class="inline-flex items-center rounded-full bg-gray-100 text-gray-600 px-2 py-0.5 text-[11px]">${cat}</span>
    </div>`;

  const key = n => (n === 'workshop 1' ? '1' : n === 'workshop 2' ? '2' : '3');

  const applyFilterAndStatus = () => {
    const cat = select.value;
    const k = key(cat);
    let visible = 0;

    tbody.querySelectorAll('tr[data-row]').forEach(tr => {
      const submitted = Number(tr.dataset['subW' + k]) === 1;   // กรองจาก workshop ที่ส่ง
      const reflected = Number(tr.dataset['refW' + k]) === 1;

      // อัปเดตคอลัมน์สะท้อนคิด
      const cell = tr.querySelector('[data-role="reflect-cell"]');
      if (cell) cell.innerHTML = renderStatusHTML(reflected, cat);

      // แสดงเฉพาะแถวที่ส่ง
      tr.style.display = submitted ? '' : 'none';
      if (submitted) visible++;

      // ซิงค์ค่า data-workshop ให้ปุ่มทั้งสอง
      tr.querySelectorAll('[data-role="action-reflection"],[data-role="action-workshop"]').forEach(btn => {
        btn.dataset.workshop = cat;
      });
    });

    // แถว "ไม่มีข้อมูลในหมวดนี้"
    const emptyRow = tbody.querySelector('[data-empty-row]');
    if (emptyRow) emptyRow.classList.toggle('hidden', visible > 0);
  };

  select.addEventListener('change', applyFilterAndStatus);

  // init
  applyFilterAndStatus();

  // จับคลิกปุ่ม action ทั้งสองแบบ (รวมไว้ตัวเดียว)
  tbody.addEventListener('click', (e) => {
    const refBtn = e.target.closest('[data-role="action-reflection"]');
    if (refBtn) {
      const tr = refBtn.closest('tr[data-row]');
      const studentId = tr?.dataset?.studentId || '';
      const ws = refBtn.dataset.workshop || select.value;
      window.open(
        `https://dev.kittelweb.xyz/teacher/reflection?student_id=${encodeURIComponent(studentId)}`,
        '_blank'
      );
      return;
    }

    const wsBtn = e.target.closest('[data-role="action-workshop"]');
    if (!wsBtn) return; // << แก้จากเงื่อนไขกลับด้าน
    const tr = wsBtn.closest('tr[data-row]');
    const studentId = tr?.dataset?.studentId || '';
    const ws = wsBtn.dataset.workshop || select.value;
    window.open(
      `https://dev.kittelweb.xyz/teacher/workshop/activity?student_id=${encodeURIComponent(studentId)}&workshop=${encodeURIComponent(ws)}`,
      '_blank'
    );
  });
})();
</script>

