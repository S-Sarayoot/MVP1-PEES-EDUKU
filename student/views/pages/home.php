<?php
component('components/banner.php', [
    'id' => 'home1',
    'title' => 'Game based learning',
    'subtitle' => 'ช่วยคุณได้มากกว่าที่คิด',
    'mediaUrl' => 'https://www.21kschool.com/th/wp-content/uploads/sites/2/2025/01/Game-Based-Learning-Benefits-Strategies-and-More.png'
]);

component('components/MenuCarousel.php', [
    'title' => 'สื่อการสอน',
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

component('pages/workshop.php');


?>

