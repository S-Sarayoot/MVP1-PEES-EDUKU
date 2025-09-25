<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Left: Grid -->
  <div class="md:col-span-2 space-y-4">
    <h2 class="text-2xl font-bold mb-4">ทรัพยากรการเรียนรู้</h2>
    <?php
    component('components/resource-browser.php', [
  'categories' => ['ทั้งหมด','แผนการจัดการเรียนรู้','วิดีโอ', 'Script','Story board','กรณีศึกษา'],
  'active' => 'ทั้งหมด',
  'items' => [
    [
      'image' => 'https://online.pubhtml5.com/lbvh/amtn/files/large/1.jpg?1622465202',
      'title' => 'แผนการจัดการเรียนรู้วิทยาศาสตร์ ม.1 เทอม 1 ',
      'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
      'tag' => 'แผนการจัดการเรียนรู้',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'นางสาวธัญญลักษณ์ ดิษฐ์ประสพ',

    ],
    [
      'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRScV8Esr92AAEbi3_Y60Vd1Ssqr42TyVEMNA&s',
      'title' => 'Making the Most of Your Space: Tips for Home Renovation and Design',
      'description' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
      'tag' => 'กรณีศึกษา',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'Brian O\'Connor',

    ],
    [
      'image' => 'https://storage.inskru.com/ideas/covers/1739202837472233725.jpeg',
      'title' => 'การเขียนแผนภาพโครงเรื่อง',
      'description' => 'แผนภาพโครงเรื่อง คือ การเขียนที่แสดงให้เห็นโครงเรื่องโดยรวมทั้งเรื่อง ต้องอาศัยการตั้งคำถามและตอบคำถาม ว่าตัวละครในเรื่องมีใครบ้าง สถานที่เกิดเหตุการณ์คือที่ไหน มีเหตุการณ์อะไร เกิดขึ้น ผลของเหตุการณ์นั้นคืออะไร',
      'tag' => 'Story board',
      'src' => 'https://inskru.com/idea/-MZE-rlC1wrTcw1XJa_C/#google_vignette',
      'author' => 'ครูดอยร้อยพลังแสง',
    ],
    [
      'image' => '',
      'title' => 'How to Stay Ahead',
      'description' => 'Story board',
      'tag' => 'Story board',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'Brian O\'Connor',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['Script','กรณีศึกษา']
    ],
    [
      'image' => '',
      'title' => 'How to Stay Ahead',
      'description' => 'Story board',
      'tag' => 'Story board',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'Brian O\'Connor',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['Script','กรณีศึกษา']
    ],
    [
      'image' => '',
      'title' => 'The Power of Color',
      'description' => 'Story board',
      'tag' => 'Story board',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'Brian O\'Connor',
      'date' => 'Jan 27',
      'readTime' => '10 Mins',
      'cats' => ['วิดีโอ']
    ],
    [
      'image' => '',
      'title' => 'Travel: Orange Camper',
      'description' => 'Story board',
      'tag' => 'Story board',
      'src' => 'https://dev.kittelweb.xyz/student/storage',
      'author' => 'Brian O\'Connor',
      'date' => 'Jan 24',
      'readTime' => '8 Mins',
      'cats' => ['กรณีศึกษา']
    ]
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
