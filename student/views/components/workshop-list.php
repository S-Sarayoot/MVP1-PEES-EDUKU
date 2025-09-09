<?php
/**
 * Props:
 * - $title              (string)  ชื่อบล็อก เช่น "บทเรียน"
 * - $instruction_title  (string)  หัวข้อคำชี้แจง
 * - $instruction_text   (string)  เนื้อหาคำชี้แจง
 * - $workshops          (array)   รายการเวิร์กช็อป
 *    [
 *      [
 *        'name' => 'Workshop 1',
 *        'desc' => 'คำชี้แจงเกี่ยวกับ workshop 1.. เวลา 3 ชั่วโมง',
 *        // ปุ่ม 3 ตัว (optional: ไม่ส่งก็ได้ จะใช้ชื่อดีฟอลต์)
 *        'buttons' => [
 *          ['label' => 'กิจกรรม',  'href' => '#'],
 *          ['label' => 'ทรัพยากร', 'href' => '#'],
 *          ['label' => 'สะท้อนคิด', 'href' => '#'],
 *        ],
 *      ],
 *      ...
 *    ]
 */

$title             = $title             ?? 'บทเรียน';
$instruction_title = $instruction_title ?? 'คำชี้แจง';
$instruction_text  = $instruction_text  ?? 'คำชี้แจง workshop...';
$workshops         = $workshops         ?? [];
?>

<div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200">
   <h2 class="text-2xl font-bold mb-4"><?= htmlspecialchars($title) ?></h2>

  <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200">
    <span class="font-semibold underline mx-4"><?= htmlspecialchars($instruction_title) ?></span>
    <span><?= htmlspecialchars($instruction_text) ?></span>
  </div>

  <div class="flex w-full max-lg:flex-col justify-center max-md:flex-col gap-5 mb-2 mt-4">
    <?php foreach ($workshops as $i => $ws): ?>
      <div class="border border-purple-100 rounded-lg shadow-sm p-4 hover:shadow-lg hover:ring hover:ring-purple-300 w-full">
        <p class="text-center font-semibold text-lg text-violet-900">
          <?= htmlspecialchars($ws['name'] ) ?>
        </p>

        <div class="flex text-sm my-3 flex-wrap">
          <p class="underline font-semibold text-purple-800">คำชี้แจง</p>
          <p class="">
            <?= htmlspecialchars($ws['desc'] ?? ('คำชี้แจงเกี่ยวกับ ' . $ws['name'] . '.. เวลา 3 ชั่วโมง')) ?>
          </p>
        </div>

        <?php
          // ปุ่มดีฟอลต์ 3 อัน ถ้าไม่ส่งมา
          $buttons = $ws['buttons'] ?? [
            ['label' => 'กิจกรรม',  'href' => '#'],
            ['label' => 'ทรัพยากร', 'href' => '#'],
            ['label' => 'สะท้อนคิด', 'href' => '#'],
          ];
        ?>

        <div class="flex flex-col mt-4 mb-2 gap-2 w-full items-center">
          <?php foreach ($buttons as $btn): ?>
            <a href="<?= htmlspecialchars($btn['href'] ?? '#') ?>"
               class="w-full bg-purple-50 border border-purple-200 rounded-md py-1 px-4  transition-transform shadow-sm hover:bg-purple-200 hover:shadow-lg hover:-translate-y-0.5 ease-in-out duration-200 text-center">
              <p><?= htmlspecialchars($btn['label'] ?? 'เปิด') ?></p>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
