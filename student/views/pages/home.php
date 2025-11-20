<?php
component('components/banner.php', [
    'id' => 'home1',
    'title' => 'Game based learning',
    'subtitle' => 'ช่วยคุณได้มากกว่าที่คิด',
    'author' => 'นางสาวธัญญลักษณ์ ดิษฐ์ประสพ',
    'mediaUrl' => 'https://www.asiancollegeofteachers.com/admin_act/blog_images/Game-based%20learning%20in%20primary%20teaching.jpg'
]);
$link_content = 'http://localhost/mvp1-pees-eduku/student/content';

component('components/MenuCarousel.php', [
    'title' => 'สื่อการสอน',
    'items' => [
    [
          'image' => 'https://krukob.com/web/wp-content/uploads/2022/07/%E0%B8%9B%E0%B8%81-Canva.png',
          'title' => 'แผนการจัดการเรียนรู้วิทยาศาสตร์ ม.1 เทอม 1',
          'description' => 'แผนการจัดการเรียนรู้ฉบับนี้ประกอบด้วยกิจกรรมการทดลองและการสังเกต เพื่อเสริมสร้างความเข้าใจในหลักการพื้นฐานของวิทยาศาสตร์ เหมาะสำหรับครูและนักเรียนระดับมัธยมศึกษาตอนต้น',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => $link_content,
          'author' => 'นางสาวธัญญลักษณ์ ดิษฐ์ประสพ',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://i.ytimg.com/vi/xe_vvMlX3MQ/maxresdefault.jpg',
          'title' => 'วิดีโอสอนเรื่องแรงและการเคลื่อนที่',
          'description' => 'วิดีโอการสอนนี้นำเสนอเนื้อหาเกี่ยวกับแรงและการเคลื่อนที่ในชีวิตประจำวัน พร้อมตัวอย่างและกิจกรรมให้ผู้เรียนได้ทดลองปฏิบัติจริง',
          'tag' => 'วิดีโอ',
          'src' => $link_content,
          'author' => 'ครูสมชาย ใจดี',
          'cats' => ['วิดีโอ']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80',
          'title' => 'Script การสอนเรื่องระบบสุริยะ',
          'description' => 'Script สำหรับครูใช้ประกอบการสอนเรื่องระบบสุริยะ มีบทพูดและกิจกรรมให้ผู้เรียนได้มีส่วนร่วมในการเรียนรู้',
          'tag' => 'Script',
          'src' => $link_content,
          'author' => 'ครูอารีย์ สอนดี',
          'cats' => ['Script']
        ],
        [
          'image' => 'https://ngthai.com/app/uploads/2017/11/water.jpg',
          'title' => 'Story board: การเดินทางของน้ำ',
          'description' => 'Story board แสดงลำดับเหตุการณ์การเดินทางของน้ำในธรรมชาติ เหมาะสำหรับใช้ประกอบการสอนวิทยาศาสตร์และสิ่งแวดล้อม',
          'tag' => 'Story board',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูดอยร้อยพลังแสง',
          'cats' => ['Story board']
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

component('pages/workshop.php');


?>

