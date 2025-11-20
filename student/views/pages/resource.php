<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Left: Grid -->
  <div class="md:col-span-2 space-y-4">
    <h2 class="text-2xl font-bold mb-4">ทรัพยากรการเรียนรู้</h2>
    <?php
      $link_content = "https://dev.kittelweb.xyz/student/content";
    component('components/resource-browser.php', [
      'categories' => ['ทั้งหมด','แผนการจัดการเรียนรู้','วิดีโอ', 'Script','Story board','กรณีศึกษา'],
      'active' => 'ทั้งหมด',
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
          'image' => 'https://img.salehere.co.th/p/1200x0/2024/07/31/ouensjr75yqy.jpg',
          'title' => 'กรณีศึกษา: การอนุรักษ์ป่าไม้',
          'description' => 'กรณีศึกษานี้นำเสนอปัญหาและแนวทางการอนุรักษ์ป่าไม้ในประเทศไทย พร้อมกิจกรรมให้ผู้เรียนวิเคราะห์และเสนอแนวทางแก้ไข',
          'tag' => 'กรณีศึกษา',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุภาพร รักษ์ป่า',
          'cats' => ['กรณีศึกษา']
        ],
        [
          'image' => 'https://positive-learning.net/wp-content/uploads/2021/03/%E0%B9%81%E0%B8%9C%E0%B8%99%E0%B8%81%E0%B8%B2%E0%B8%A3%E0%B8%AA%E0%B8%AD%E0%B8%99%E0%B8%A0%E0%B8%B2%E0%B8%A9%E0%B8%B2%E0%B9%84%E0%B8%97%E0%B8%A2%E0%B8%9B.5-Canva_Page_1-1536x864.jpg',
          'title' => 'แผนการจัดการเรียนรู้คณิตศาสตร์ ป.5 เทอม 2',
          'description' => 'แผนการจัดการเรียนรู้ที่เน้นการแก้โจทย์ปัญหาและกิจกรรมกลุ่ม เพื่อเสริมสร้างทักษะการคิดวิเคราะห์ในวิชาคณิตศาสตร์ระดับมัธยมศึกษาตอนต้น',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุชาติ คำนวณ',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://i.ytimg.com/vi/37Sym3D6h_g/maxresdefault.jpg',
          'title' => 'วิดีโอสอนเรื่องการเปลี่ยนสถานะของสสาร',
          'description' => 'วิดีโอแสดงการทดลองเปลี่ยนสถานะของน้ำและอธิบายหลักการทางฟิสิกส์ที่เกี่ยวข้อง เหมาะสำหรับนักเรียนระดับมัธยมศึกษาตอนต้น',
          'tag' => 'วิดีโอ',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูวรรณา สอนวิทย์',
          'cats' => ['วิดีโอ']
        ],
        
        [
          'image' => 'https://i.ytimg.com/vi/OC1r70gFSfc/maxresdefault.jpg',
          'title' => 'วิดีโอสอนเรื่องการสื่อสารภาษาอังกฤษ',
          'description' => 'วิดีโอสอนเทคนิคการพูดภาษาอังกฤษในสถานการณ์ต่าง ๆ พร้อมตัวอย่างบทสนทนาและกิจกรรมฝึกฝน',
          'tag' => 'วิดีโอ',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูเจนจิรา ภาษา',
          'cats' => ['วิดีโอ']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80',
          'title' => 'Script การสอนเรื่องสิ่งแวดล้อม',
          'description' => 'Script สำหรับครูใช้ประกอบการสอนเรื่องสิ่งแวดล้อม มีบทพูดและกิจกรรมให้ผู้เรียนได้มีส่วนร่วมในการอนุรักษ์ธรรมชาติ',
          'tag' => 'Script',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุพจน์ รักษ์โลก',
          'cats' => ['Script']
        ],
        [
          'image' => 'https://oranee136.wordpress.com/wp-content/uploads/2013/07/spectrumprism.jpg',
          'title' => 'Story board: การเดินทางของแสง',
          'description' => 'Story board แสดงลำดับเหตุการณ์การเดินทางของแสงในธรรมชาติ เหมาะสำหรับใช้ประกอบการสอนฟิสิกส์',
          'tag' => 'Story board',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูอารีย์ แสงสว่าง',
          'cats' => ['Story board']
        ],
        [
          'image' => 'https://www.banklab.go.th/fileupload/2024-06-115711441752.jpg',
          'title' => 'กรณีศึกษา: การอนุรักษ์น้ำ',
          'description' => 'กรณีศึกษานี้นำเสนอปัญหาและแนวทางการอนุรักษ์น้ำในชุมชน พร้อมกิจกรรมให้ผู้เรียนวิเคราะห์และเสนอแนวทางแก้ไข',
          'tag' => 'กรณีศึกษา',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุภาพร น้ำดี',
          'cats' => ['กรณีศึกษา']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80',
          'title' => 'แผนการจัดการเรียนรู้ภาษาไทย ม.3 เทอม 1',
          'description' => 'แผนการจัดการเรียนรู้ภาษาไทยที่เน้นการอ่านวิเคราะห์และการเขียนเชิงสร้างสรรค์ เหมาะสำหรับนักเรียนระดับมัธยมศึกษาตอนต้น',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูอารีย์ ภาษาไทย',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1506784365847-bbad939e9335?auto=format&fit=crop&w=800&q=80',
          'title' => 'แผนการจัดการเรียนรู้วิทยาศาสตร์สิ่งแวดล้อม',
          'description' => 'แผนการจัดการเรียนรู้ที่เน้นการทดลองและกิจกรรมภาคสนามเกี่ยวกับสิ่งแวดล้อม เพื่อสร้างความตระหนักและความเข้าใจในปัญหาสิ่งแวดล้อม',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุวรรณา ธรรมชาติ',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=800&q=80',
          'title' => 'วิดีโอสอนเรื่องการสังเคราะห์แสง',
          'description' => 'วิดีโอแสดงกระบวนการสังเคราะห์แสงในพืช พร้อมกิจกรรมทดลองและคำถามกระตุ้นการคิดวิเคราะห์',
          'tag' => 'วิดีโอ',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูอารีย์ พฤกษา',
          'cats' => ['วิดีโอ']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80',
          'title' => 'Script การสอนเรื่องระบบนิเวศ',
          'description' => 'Script สำหรับครูใช้ประกอบการสอนเรื่องระบบนิเวศ มีบทพูดและกิจกรรมกลุ่มเพื่อให้ผู้เรียนเข้าใจความสัมพันธ์ในธรรมชาติ',
          'tag' => 'Script',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสมชาย ธรรมชาติ',
          'cats' => ['Script']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=800&q=80',
          'title' => 'Story board: การเปลี่ยนแปลงของฤดูกาล',
          'description' => 'Story board แสดงลำดับเหตุการณ์การเปลี่ยนแปลงของฤดูกาลในแต่ละปี เหมาะสำหรับใช้ประกอบการสอนภูมิศาสตร์และวิทยาศาสตร์',
          'tag' => 'Story board',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูวรรณา ฤดูกาล',
          'cats' => ['Story board']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=800&q=80',
          'title' => 'กรณีศึกษา: การจัดการน้ำเสียในชุมชน',
          'description' => 'กรณีศึกษานี้นำเสนอปัญหาและแนวทางการจัดการน้ำเสียในชุมชน พร้อมกิจกรรมให้ผู้เรียนวิเคราะห์และเสนอแนวทางแก้ไข',
          'tag' => 'กรณีศึกษา',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสมพร น้ำใส',
          'cats' => ['กรณีศึกษา']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1506784365847-bbad939e9335?auto=format&fit=crop&w=800&q=80',
          'title' => 'แผนการจัดการเรียนรู้ชีววิทยา ม.4 เทอม 1',
          'description' => 'แผนการจัดการเรียนรู้เน้นการทดลองเกี่ยวกับเซลล์และระบบร่างกายมนุษย์ พร้อมกิจกรรมกลุ่มเพื่อฝึกทักษะการสังเกตและวิเคราะห์ข้อมูล',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุวรรณา ชีววิทยา',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=800&q=80',
          'title' => 'วิดีโอสอนเรื่องการเคลื่อนที่แบบวงกลม',
          'description' => 'วิดีโออธิบายหลักการเคลื่อนที่แบบวงกลมในฟิสิกส์ พร้อมตัวอย่างการทดลองและการคำนวณความเร็วเชิงมุม',
          'tag' => 'วิดีโอ',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสมชาย ฟิสิกส์',
          'cats' => ['วิดีโอ']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80',
          'title' => 'Script การสอนเรื่องการเงินส่วนบุคคล',
          'description' => 'Script สำหรับครูใช้ประกอบการสอนเรื่องการวางแผนการเงินส่วนบุคคล มีบทพูดและกิจกรรมจำลองสถานการณ์การใช้จ่าย',
          'tag' => 'Script',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูอารีย์ การเงิน',
          'cats' => ['Script']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
          'title' => 'Story board: การเดินทางของอากาศ',
          'description' => 'Story board แสดงลำดับเหตุการณ์การเคลื่อนที่ของอากาศในชั้นบรรยากาศโลก เหมาะสำหรับใช้ประกอบการสอนภูมิศาสตร์และวิทยาศาสตร์สิ่งแวดล้อม',
          'tag' => 'Story board',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูดอยร้อยลม',
          'cats' => ['Story board']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?auto=format&fit=crop&w=800&q=80',
          'title' => 'กรณีศึกษา: การจัดการพลังงานในโรงเรียน',
          'description' => 'กรณีศึกษานี้นำเสนอแนวทางการประหยัดพลังงานในโรงเรียน พร้อมกิจกรรมให้ผู้เรียนวิเคราะห์และเสนอวิธีลดการใช้ไฟฟ้า',
          'tag' => 'กรณีศึกษา',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุภาพร พลังงาน',
          'cats' => ['กรณีศึกษา']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1465101059347-763ab02bced9?auto=format&fit=crop&w=800&q=80',
          'title' => 'แผนการจัดการเรียนรู้คณิตศาสตร์ ม.5 เทอม 2',
          'description' => 'แผนการจัดการเรียนรู้เน้นการแก้สมการและการวิเคราะห์กราฟฟังก์ชัน เหมาะสำหรับนักเรียนที่ต้องการเตรียมสอบเข้ามหาวิทยาลัย',
          'tag' => 'แผนการจัดการเรียนรู้',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูสุชาติ สมการ',
          'cats' => ['แผนการจัดการเรียนรู้']
        ],
        [
          'image' => 'https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=800&q=80',
          'title' => 'วิดีโอสอนเรื่องการสื่อสารด้วยภาษาอังกฤษ',
          'description' => 'วิดีโอสอนเทคนิคการพูดภาษาอังกฤษในสถานการณ์ต่าง ๆ พร้อมบทสนทนาและกิจกรรมฝึกฝนการฟังและพูด',
          'tag' => 'วิดีโอ',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'author' => 'ครูเจนจิรา อังกฤษ',
          'cats' => ['วิดีโอ']
        ],
        [
          "image"=> "https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=800&q=80",
          "title"=> "แผนการจัดการเรียนรู้ประวัติศาสตร์ไทย ม.3 เรื่องอยุธยา",
          "description"=> "แผนการสอนที่เน้นการใช้แหล่งข้อมูลปฐมภูมิและทุติยภูมิในการวิเคราะห์เหตุการณ์สำคัญในสมัยอยุธยา พร้อมกิจกรรมสวมบทบาท (Role-play).",
          "tag"=> "แผนการจัดการเรียนรู้",
          "src"=> "https://dev.kittelweb.xyz/student/storage",
          "author"=> "อาจารย์พงศาวดาร สุขสมบูรณ์",
          "cats"=> [
            "แผนการจัดการเรียนรู้"
          ]
        ],
        [
          "image"=> "https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80",
          "title"=> "วิดีโอสอนเทคนิคการวาดภาพสีน้ำเบื้องต้น",
          "description"=> "วิดีโอแนะนำขั้นตอนการลงสีน้ำ การผสมสี และเทคนิคการสร้างมิติแสงเงา เหมาะสำหรับผู้เริ่มต้นฝึกวาดภาพทิวทัศน์.",
          "tag"=> "วิดีโอ",
          "src"=> "https://dev.kittelweb.xyz/student/storage",
          "author"=> "ครูอาร์ต ศิลปะดี",
          "cats"=> [
            "วิดีโอ"
          ]
        ],
        [
          "image"=> "https://images.unsplash.com/photo-1509228468518-180dd4864904?auto=format&fit=crop&w=800&q=80",
          "title"=> "กรณีศึกษา: สิทธิและหน้าที่พลเมืองตามรัฐธรรมนูญ",
          "description"=> "กรณีศึกษาเชิงลึกเกี่ยวกับการใช้สิทธิเสรีภาพและการปฏิบัติตามหน้าที่พลเมืองในสังคมประชาธิปไตย พร้อมประเด็นให้วิเคราะห์ทางกฎหมาย.",
          "tag"=> "กรณีศึกษา",
          "src"=> "https://dev.kittelweb.xyz/student/storage",
          "author"=> "ครูยุติธรรม มั่นคง",
          "cats"=> [
            "กรณีศึกษา"
          ]
        ],
        [
          "image"=> "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=800&q=80",
          "title"=> "Script บทสนทนาภาษาญี่ปุ่นระดับต้น (การสั่งอาหาร)",
          "description"=> "Script สำหรับฝึกการสื่อสารภาษาญี่ปุ่นพื้นฐานในร้านอาหาร พร้อมคำศัพท์และโครงสร้างประโยคที่ใช้บ่อยในชีวิตประจำวัน.",
          "tag"=> "Script",
          "src"=> "https://dev.kittelweb.xyz/student/storage",
          "author"=> "ครูนานาชาติ จิระภา",
          "cats"=> [
            "Script"
          ]
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
          'image' => 'https://media.graphassets.com/resize=width:2500,height:1308/lEHk9VdiTIGReHjEP55T',
          'title' => 'บทความ: การเรียนรู้แบบ Active Learning',
          'author' => 'ครูนานาชาติ จิระภา',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 26',
          'readTime' => '10 Mins'
        ],
        [
          'image' => 'https://codegeniusacademy.com/wp-content/uploads/2022/11/%E0%B8%81%E0%B8%B4%E0%B8%88%E0%B8%81%E0%B8%A3%E0%B8%A3%E0%B8%A1-stem.jpg',
          'title' => 'บทความ: การออกแบบกิจกรรม STEM',
          'author' => 'ครูยุติธรรม มั่นคง',
          'src' => 'https://dev.kittelweb.xyz/student/storage',
          'date' => 'Jan 27',
          'readTime' => '15 Mins'
        ],
      ]
    ]);
    ?>
  </div>
</div>
