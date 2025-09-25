<?php
/**
 * Student Workshop Table (PHP component) — filter by submitted Workshop
 * - เลือกหมวด Workshop 1/2/3 แล้วจะแสดงเฉพาะแถวที่ "ส่ง" หมวดนั้น
 * - เลือก "ทั้งหมด" (default) จะแสดงทุกแถว
 * - แสดงคอลัมน์ "สะท้อนคิด" พร้อมไอคอน/สี (ในโหมด "ทั้งหมด" จะแสดง 1–3 แท็กตามสถานะของแต่ละ Workshop)
 * - (option) $showAction = true เพื่อมีปุ่ม "ดูรายละเอียด"
 */

$rows       = $items       ?? [];
$showIndex  = isset($showIndex) ? (bool)$showIndex : true;
$showAction = isset($showAction) ? (bool)$showAction : false;

// << changed: เพิ่ม "ทั้งหมด" และตั้งเป็นค่าเริ่มต้น
$categories = ['ทั้งหมด','Workshop 1','Workshop 2','Workshop 3']; // << changed
$activeCat  = $activeCat ?? $categories[0]; // << changed (default = "ทั้งหมด")

$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$componentId = 'swt_' . substr(md5(json_encode($rows) . rand()), 0, 6);

/** normalize row */
$normalize = function ($r) {
  $date  = $r['date']         ?? $r['submitted_at']  ?? '';
  $id    = $r['id']           ?? $r['student_id']    ?? '';
  $name  = $r['name']         ?? $r['student_name']  ?? '';
  $major = $r['major']        ?? $r['program']       ?? '';

  $w     = $r['Workshops']    ?? $r['Workshop']      ?? [];
  if (!is_array($w)) $w = array_filter(array_map('trim', preg_split('/[;,|]/', (string)$w)));
  $w = array_values($w);

  $ref   = $r['reflections']  ?? $r['reflection']    ?? $w; // default = ส่งแล้วเท่าที่ส่ง
  if (!is_array($ref)) $ref = array_filter(array_map('trim', preg_split('/[;,|]/', (string)$ref)));
  $ref = array_values($ref);

  return compact('date','id','name','major') + ['Workshops'=>$w,'reflections'=>$ref];
};

// ใช้สำหรับโหมดเลือกทีละหมวด
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
      <div class="text-xs text-gray-500">* เลือกหมวดเพื่อกรองผู้ที่ “ส่ง” เฉพาะหมวดนั้น หรือเลือก “ทั้งหมด” เพื่อแสดงทุกคน</div> <!-- << changed (ข้อความช่วย) -->
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
          <th class="py-2 px-3 font-semibold border border-purple-200">Workshop ที่ส่ง</th>
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
              'Workshop 1' => in_array('Workshop 1', $r['Workshops'], true) ? 1 : 0,
              'Workshop 2' => in_array('Workshop 2', $r['Workshops'], true) ? 1 : 0,
              'Workshop 3' => in_array('Workshop 3', $r['Workshops'], true) ? 1 : 0,
            ];
            $refW = [
              'Workshop 1' => in_array('Workshop 1', $r['reflections'], true) ? 1 : 0,
              'Workshop 2' => in_array('Workshop 2', $r['reflections'], true) ? 1 : 0,
              'Workshop 3' => in_array('Workshop 3', $r['reflections'], true) ? 1 : 0,
            ];
            $isRef = $refW[$activeCat] ?? 0; // ถ้า "ทั้งหมด" จะถูกแทนด้วย JS ตอน init
          ?>
          <tr class="odd:bg-white even:bg-purple-50/40"
              data-row
              data-student-id="<?= $h($r['id']) ?>"
              data-sub-w1="<?= $subW['Workshop 1'] ?>" data-ref-w1="<?= $refW['Workshop 1'] ?>"
              data-sub-w2="<?= $subW['Workshop 2'] ?>" data-ref-w2="<?= $refW['Workshop 2'] ?>"
              data-sub-w3="<?= $subW['Workshop 3'] ?>" data-ref-w3="<?= $refW['Workshop 3'] ?>">
            <?php if ($showIndex): ?><td class="py-2 px-2 border border-purple-200 text-center" data-role="row-index"><?= $i ?></td><?php endif; ?> <!-- << changed: ใส่ data-role -->
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['date']) ?></td>
            <td class="py-2 px-3 border border-purple-200 text-blue-800"><?= $h($r['id']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['name']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['major']) ?></td>
            <td class="py-2 px-3 border border-purple-200">
              <?php if ($r['Workshops']): ?>
                <div class="flex flex-wrap gap-1">
                  <?php foreach ($r['Workshops'] as $ws): ?>
                    <span class="inline-flex items-center rounded-full bg-purple-100 text-purple-800 px-2 py-0.5 text-xs font-medium"><?= $h($ws) ?></span>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <span class="text-gray-400">-</span>
              <?php endif; ?>
            </td>
            <td class="py-2 px-3 border border-purple-200" data-role="reflect-cell">
              <?= $renderReflect((bool)$isRef, is_string($activeCat)?$activeCat:'') ?>
            </td>
            <?php if ($showAction): ?>
            <td class="py-2 px-3 border border-purple-200 text-center">
              <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-purple-200 px-2.5 py-1 text-xs text-purple-700 hover:bg-purple-50" 
              data-role="action-Workshop" data-Workshop="<?= $h($activeCat) ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z" stroke="currentColor" stroke-width="2" fill="none"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" fill="none"/></svg>
                Workshop
              </button>
              <button type="button" class="inline-flex items-center gap-1.5 rounded-md border border-purple-200 px-2.5 py-1 text-xs text-purple-700 hover:bg-purple-50" 
              data-role="action-reflection" data-Workshop="<?= $h($activeCat) ?>">
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

  // HTML สำหรับแสดงสถานะทีละหมวด
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

  // HTML สำหรับโหมด "ทั้งหมด" — แสดงสถานะแยก 3 หมวด
  const renderAllStatusesHTML = (tr) => {
    const blocks = [];
    const map = [
      ['1','Workshop 1'],
      ['2','Workshop 2'],
      ['3','Workshop 3'],
    ];
    map.forEach(([k, label]) => {
      const done = Number(tr.dataset['refW' + k]) === 1;
      blocks.push(`
        <div class="flex items-center gap-2 ${done ? 'text-green-600' : 'text-gray-500'}">
          ${done
            ? '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M20 7L10 17L5 12" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>'
            : '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"><path d="M6 6L18 18M18 6L6 18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>'}
          <span class="inline-flex items-center rounded-full ${done ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'} px-2 py-0.5 text-[11px]">${label}</span>
        </div>
      `);
    });
    return `<div class="flex flex-wrap gap-x-4 gap-y-1">${blocks.join('')}</div>`;
  };

  const key = n => (n === 'Workshop 1' ? '1' : n === 'Workshop 2' ? '2' : n === 'Workshop 3' ? '3' : 'all');

  // << changed: ฟังก์ชันรีนัมเบอร์ "ลำดับที่" ตามแถวที่มองเห็น
  const renumberVisibleRows = () => {
    let idx = 1;
    tbody.querySelectorAll('tr[data-row]').forEach(tr => {
      if (tr.style.display === 'none') return;
      const cell = tr.querySelector('[data-role="row-index"]');
      if (cell) cell.textContent = String(idx++);
    });
  };

  const applyFilterAndStatus = () => {
    const cat = select.value;
    const k = key(cat);
    let visible = 0;

    tbody.querySelectorAll('tr[data-row]').forEach(tr => {
      const submittedAll = true; // สำหรับ 'ทั้งหมด'
      const submitted =
        (k === '1' ? Number(tr.dataset['subW1']) === 1 :
        k === '2' ? Number(tr.dataset['subW2']) === 1 :
        k === '3' ? Number(tr.dataset['subW3']) === 1 :
        submittedAll); // << changed: โหมดทั้งหมด = ไม่กรอง

      const reflected =
        (k === '1' ? Number(tr.dataset['refW1']) === 1 :
        k === '2' ? Number(tr.dataset['refW2']) === 1 :
        k === '3' ? Number(tr.dataset['refW3']) === 1 :
        null);

      // อัปเดตคอลัมน์สะท้อนคิด
      const cell = tr.querySelector('[data-role="reflect-cell"]');
      if (cell) {
        if (k === 'all') {
          cell.innerHTML = renderAllStatusesHTML(tr); // << changed
        } else {
          cell.innerHTML = renderStatusHTML(!!reflected, cat);
        }
      }

      // แสดง/ซ่อนตามเงื่อนไข
      tr.style.display = submitted ? '' : 'none';
      if (submitted) visible++;

      // ซิงค์ค่า data-Workshop ให้ปุ่มทั้งสอง
      tr.querySelectorAll('[data-role="action-reflection"],[data-role="action-Workshop"]').forEach(btn => {
        btn.dataset.Workshop = (k === 'all') ? 'Workshop 1' : cat; // ถ้า "ทั้งหมด" ให้ดีฟอลต์ส่งไปที่ Workshop 1 หรือจะปรับภายหลังก็ได้
      });
    });

    // แถว "ไม่มีข้อมูลในหมวดนี้"
    const emptyRow = tbody.querySelector('[data-empty-row]');
    if (emptyRow) emptyRow.classList.toggle('hidden', visible > 0);

    // << changed: รีเซ็ตลำดับตามแถวที่มองเห็น
    renumberVisibleRows();
  };

  select.addEventListener('change', applyFilterAndStatus);

  // init (ค่าเริ่มต้น = "ทั้งหมด")
  applyFilterAndStatus();

  // จับคลิกปุ่ม action ทั้งสองแบบ (รวมไว้ตัวเดียว)
  tbody.addEventListener('click', (e) => {
    const refBtn = e.target.closest('[data-role="action-reflection"]');
    if (refBtn) {
      const tr = refBtn.closest('tr[data-row]');
      const studentId = tr?.dataset?.studentId || '';
      const ws = refBtn.dataset.Workshop || select.value;
      window.open(
        `https://dev.kittelweb.xyz/teacher/Workshop/reflection?student_id=${encodeURIComponent(studentId)}`,
        '_blank'
      );
      return;
    }

    const wsBtn = e.target.closest('[data-role="action-Workshop"]');
    if (!wsBtn) return; // << คงเดิม
    const tr = wsBtn.closest('tr[data-row]');
    const studentId = tr?.dataset?.studentId || '';
    const ws = wsBtn.dataset.Workshop || select.value;
    window.open(
      `https://dev.kittelweb.xyz/teacher/Workshop/activity?student_id=${encodeURIComponent(studentId)}&Workshop=${encodeURIComponent(ws)}`,
      '_blank'
    );
  });
})();
</script>
