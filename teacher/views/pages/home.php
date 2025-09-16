<div class="flex  w-full gap-4">
  <div class="flex flex-col w-[70%] gap-4">
    <div class="flex flex-col w-full">
      <h2 class="text-2xl font-bold mb-4">คลังทรัพยากร</h2>
      <?php
      component('components/sourceCarousel.php', [
    'categories' => ['ทั้งหมด','วิดีโอ','บทพูด','Exam','Script','Story board','กรณีศึกษา'],
    'active' => 'ทั้งหมด',
    'items' => [
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
        'cats' => ['Exam','กรณีศึกษา']
      ]
      ]
  ]);
      ?>
    </div>

     <div class="flex flex-col w-full mt-4">
       <h2 class="text-2xl font-bold mb-4">นิสิตที่ส่ง workshop ล่าสุด</h2>
       <?php
    component('components/submission.php', [
      'items' => [
       [
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],
       [
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],
  [
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],[
    'submitted_at' => '03/06/2025',   // alias ก็ได้
    'student_id'   => '65209010012',
    'student_name' => 'น.ส. วิไลวรรณ ใจดี',
    'program'      => 'คอมพิวเตอร์ธุรกิจ',
    'workshop'     => 'workshop 2',
  ],
      ]
    ]);
    ?>
     </div>
  </div>

  <div class="flex flex-col  w-[30%] gap-4">

    <div class="flex  flex-col w-full">
      <h2 class="text-2xl font-bold mb-4">Workshop</h2>
      <?php
      component('components/progressBar.php', [$items = [
    ['label' => 'workshop 1', 'value' => 75],
    ['label' => 'workshop 2', 'value' => 60],
    ['label' => 'workshop 3', 'value' => 50],
      ],
  'color' =>'#b36ad4ff', // ตัวเลือก
  
  ]
  );
      ?>
    </div>

    <div class="flex flex-col w-full">
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
          'image' => 'https://media.licdn.com/dms/image/v2/D4E12AQFppEpF_DF-lQ/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1690977883416?e=2147483647&v=beta&t=MbAnZK8bW5aRa8U-5C39qb6wDFm_CszY4ImWLuZYe-E',
          'title' => 'The History of Sport: Understanding the Origins and Evolution of Athletic Competition',
          'author' => 'Ali Husni',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 26',
          'readTime' => '10 Mins'
        ],
        [
          'image' => 'https://media.licdn.com/dms/image/v2/D4E12AQFppEpF_DF-lQ/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1690977883416?e=2147483647&v=beta&t=MbAnZK8bW5aRa8U-5C39qb6wDFm_CszY4ImWLuZYe-E',
          'title' => 'The History of Sport: Understanding the Origins and Evolution of Athletic Competition',
          'author' => 'Ali Husni',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 26',
          'readTime' => '10 Mins'
        ],
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
  </div>
</div>


