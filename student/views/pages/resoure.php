<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Left: Grid -->
  <div class="md:col-span-2 space-y-4">
    <h2 class="text-2xl font-bold mb-4">ทรัพยากรการเรียนรู้</h2>
    <?php
    component('components/resource-browser.php', [
  'categories' => ['ทั้งหมด','วิดีโอ','บทพูด','Exam','Script','Story board','กรณีศึกษา'],
  'active' => 'ทั้งหมด',
  'items' => [
    [
      'image' => 'https://www.abcollege.org/wp-content/uploads/2025/04/aracde-business-colllege-IT-2.jpg',
      'title' => 'The Future of Computing: How to Stay Ahead',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'tag' => 'DESIGN',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['Script','กรณีศึกษา']
    ],
    [
      'image' => 'https://i.ytimg.com/vi/Kd-GNqGCJR4/maxresdefault.jpg',
      'title' => 'The Power of Color',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'tag' => 'DESIGN',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['วิดีโอ']
    ],
    [
      'image' => 'https://i.ytimg.com/vi/03AOafCNcWk/hq720.jpg?sqp=-oaymwEhCK4FEIIDSFryq4qpAxMIARUAAAAAGAElAADIQj0AgKJD&rs=AOn4CLDTfWT5FeTph7Ng-5sfI81QVWyhcw',
      'title' => 'Travel: Orange Camper',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
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
    <h2 class="text-2xl font-bold mb-4">แหล่งการเรียนรู้</h2>
    <?php
    component('components/resource-list.php', [
      'items' => [
        [
          'image' => 'https://media.licdn.com/dms/image/v2/D4E12AQFppEpF_DF-lQ/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1690977883416?e=2147483647&v=beta&t=MbAnZK8bW5aRa8U-5C39qb6wDFm_CszY4ImWLuZYe-E',
          'title' => 'The History of Sport: Understanding the Origins and Evolution of Athletic Competition',
          'author' => 'Ali Husni',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 26',
          'readTime' => '10 Mins'
        ],
        [
          'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRScV8Esr92AAEbi3_Y60Vd1Ssqr42TyVEMNA&s',
          'title' => 'Making the Most of Your Space: Tips for Home Renovation and Design',
          'author' => 'Brian O\'Connor',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 27',
          'readTime' => '15 Mins'
        ],
      ]
    ]);
    ?>
  </div>
</div>
