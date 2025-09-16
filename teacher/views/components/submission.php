<?php
/**
 * Student Workshop Table (PHP component)
 *
 * Props ที่รับ:
 * - $rows: array ของแถวข้อมูล โดยแต่ละแถวรองรับคีย์:
 *   - 'date' (หรือ 'submitted_at')      ว/ด/ป ที่ส่ง
 *   - 'id' (หรือ 'student_id')          รหัสนิสิต
 *   - 'name' (หรือ 'student_name')      ชื่อ - นามสกุล
 *   - 'major' (หรือ 'program')          สาขาวิชา
 *   - 'workshops' (หรือ 'workshop')     รายชื่อ workshop ที่ส่ง (array หรือ string คั่นด้วย , ; | ก็ได้)
 *
 * ตัวเลือกเพิ่มเติม (optional):
 * - $showIndex   = true|false   แสดงคอลัมน์ลำดับที่หรือไม่ (default true)
 * - $maxHeight   = class tailwind สำหรับกำหนดความสูง เช่น 'max-h-52' (default 'max-h-60')
 */

$rows       = $items       ?? [];
$showIndex  = isset($showIndex) ? (bool)$showIndex : true;


$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
$componentId = 'swt_' . substr(md5(json_encode($rows) . rand()), 0, 6);

/** normalize แต่ละแถวให้คีย์มาตรฐาน */
$normalize = function ($r) {
  $date  = $r['date']         ?? $r['submitted_at']  ?? '';
  $id    = $r['id']           ?? $r['student_id']    ?? '';
  $name  = $r['name']         ?? $r['student_name']  ?? '';
  $major = $r['major']        ?? $r['program']       ?? '';
  $w     = $r['workshops']    ?? $r['workshop']      ?? [];

  if (!is_array($w)) {
    // แยกสตริงด้วย , ; | แล้ว trim
    $w = array_filter(array_map('trim', preg_split('/[;,|]/', (string)$w)));
  }
  return [
    'date' => $date,
    'id' => $id,
    'name' => $name,
    'major' => $major,
    'workshops' => array_values($w),
  ];
};

?>
<div class="w-full  max-h-[20rem] overflow-auto border border-purple-200 shadow-md rounded-md" id="<?= $h($componentId) ?>">
  <table class="w-full text-sm">
    <thead class="whitespace-nowrap">
      <tr class="bg-purple-200 text-gray-800">
        <?php if ($showIndex): ?>
          <th class="py-2 px-3 font-semibold border border-purple-200 text-center">ลำดับที่</th>
        <?php endif; ?>
        <th class="py-2 px-3 font-semibold border border-purple-200">ว/ด/ป ที่ส่ง</th>
        <th class="py-2 px-3 font-semibold border border-purple-200">รหัสนิสิต</th>
        <th class="py-2 px-3 font-semibold border border-purple-200">ชื่อ - นามสกุล</th>
        <th class="py-2 px-3 font-semibold border border-purple-200">สาขาวิชา</th>
        <th class="py-2 px-3 font-semibold border border-purple-200">workshop ที่ส่ง</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!$rows): ?>
        <tr>
          <td colspan="<?= $showIndex ? 6 : 5 ?>" class="py-4 px-3 text-center text-gray-500">
            ไม่มีข้อมูล
          </td>
        </tr>
      <?php else: ?>
        <?php $i = 1; foreach ($rows as $raw): $r = $normalize($raw); ?>
          <tr class="odd:bg-white even:bg-purple-50/40">
            <?php if ($showIndex): ?>
              <td class="py-2 px-2 border border-purple-200 text-center"><?= $i ?></td>
            <?php endif; ?>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['date']) ?></td>
            <td class="py-2 px-3 border border-purple-200 text-blue-800"><?= $h($r['id']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['name']) ?></td>
            <td class="py-2 px-3 border border-purple-200"><?= $h($r['major']) ?></td>
            <td class="py-2 px-3 border border-purple-200">
              <?php if ($r['workshops']): ?>
                <div class="flex flex-wrap gap-1">
                  <?php foreach ($r['workshops'] as $ws): ?>
                    <span class="inline-flex items-center rounded-full bg-purple-100 text-purple-800 px-2 py-0.5 text-xs font-medium">
                      <?= $h($ws) ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <span class="text-gray-400">-</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php $i++; endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
