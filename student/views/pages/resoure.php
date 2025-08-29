<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Left: Grid -->
  <div class="md:col-span-2 space-y-4">
    <h2 class="font-bold text-lg">ทรัพยากรการเรียนรู้</h2>
    <?php
    component('components/resource-browser.php', [
  'categories' => ['ทั้งหมด','วิดีโอ','บทพูด','Exam','Script','Story board','กรณีศึกษา'],
  'active' => 'ทั้งหมด',
  'items' => [
    [
      'image' => '/uploads/computer.jpg',
      'title' => 'The Future of Computing: How to Stay Ahead',
      'tag' => 'DESIGN',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['Script','กรณีศึกษา']
    ],
    [
      'image' => '/uploads/color.jpg',
      'title' => 'The Power of Color',
      'tag' => 'DESIGN',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['วิดีโอ']
    ],
    [
      'image' => '/uploads/van.jpg',
      'title' => 'Travel: Orange Camper',
      'tag' => 'TRAVEL',
      'date' => 'Jan 24',
      'readTime' => '8 Mins',
      'cats' => ['Exam','กรณีศึกษา']
    ],
    // เพิ่มได้ตามต้องการ
  ]
]);
    ?>
  </div>

  <!-- Right: List -->
  <div class="space-y-4">
    <h2 class="font-bold text-lg">แหล่งการเรียนรู้</h2>
    <?php
    component('components/resource-list.php', [
      'items' => [
        [
          'image' => '/uploads/sport.jpg',
          'title' => 'The History of Sport: Understanding the Origins and Evolution of Athletic Competition',
          'author' => 'Ali Husni',
          'date' => 'Jan 26',
          'readTime' => '10 Mins'
        ],
        [
          'image' => '/uploads/home.jpg',
          'title' => 'Making the Most of Your Space: Tips for Home Renovation and Design',
          'author' => 'Brian O\'Connor',
          'date' => 'Jan 27',
          'readTime' => '15 Mins'
        ],
      ]
    ]);
    ?>
  </div>
</div>
