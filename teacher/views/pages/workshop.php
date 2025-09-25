 <div class="w-full bg-white rounded-lg shadow p-6">
  <h2 class="text-2xl font-semibold mb-4">Workshop และสะท้อนคิด</h2>

 <?php
    component('components/submission.php', [
        'showAction' => true,
      'items' => [
  [
    'date' => '03/09/2025',
    'id'   => '65209010012',
    'name' => 'น.ส. วิไลวรรณ ใจดี',
    'major'=> 'คอมพิวเตอร์ธุรกิจ',
    'Workshop'   => ['Workshop 1'],               // ส่งเฉพาะ w1
    'reflections' => [],                           // ยังไม่สะท้อนคิด
  ],
  [
    'date' => '05/09/2025',
    'id'   => '65209010013',
    'name' => 'นายสมชาย คงคอย',
    'major'=> 'เทคโนโลยีสารสนเทศ',
    'Workshop'   => ['Workshop 2'],               // ส่งเฉพาะ w2
    'reflections' => ['Workshop 2'],               // สะท้อนคิดแล้ว w2
  ],
  [
    'date' => '06/09/2025',
    'id'   => '65209010014',
    'name' => 'น.ส. ชลิดา มานะ',
    'major'=> 'เทคโนโลยีมัลติมีเดีย',
    'Workshop'   => ['Workshop 1'], // ส่งสองตัว
    'reflections' => ['Workshop 1'],               // สะท้อนคิด w2 (w1 ยัง)
  ],
  [
    'date' => '06/09/2025',
    'id'   => '65209010014',
    'name' => 'น.ส. ชลิดา มานะ',
    'major'=> 'เทคโนโลยีมัลติมีเดีย',
    'Workshop'   => ['Workshop 2'], // ส่งสองตัว
    'reflections' => [''],               // สะท้อนคิด w2 (w1 ยัง)
  ],
  [
    'date' => '08/09/2025',
    'id'   => '65209010015',
    'name' => 'นายภัทร วัฒนะ',
    'major'=> 'อิเล็กทรอนิกส์',
    'Workshop'   => ['Workshop 1'],               // ส่งเฉพาะ w1
    // ไม่ส่ง reflections -> ในคอมโพเนนต์จะ default = Workshop (ถือว่าส่งแล้ว w1)
  ],
  [
    'date' => '10/09/2025',
    'id'   => '65209010016',
    'name' => 'น.ส. ขวัญใจ พูนทรัพย์',
    'major'=> 'เครือข่ายคอมพิวเตอร์',
    'Workshop'   => ['Workshop 2'],               // ส่งเฉพาะ w2
    'reflections' => [],                           // ยังไม่สะท้อนคิด
  ],
]
    ]);
    ?>
 </div>