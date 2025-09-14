<?php
// chatbot.php
session_start();

// เริ่มต้นประวัติแชทในเซสชัน
if (!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = [
        ['role' => 'user', 'text' => 'การศึกษาคือ'],
        ['role' => 'bot',  'text' => 'การศึกษาคือ กระบวนการเรียนรู้ตลอดชีวิตเพื่อพัฒนาตนเองและสังคม ผ่านการถ่ายทอดความรู้ ทักษะ ค่านิยม และวัฒนธรรม'],
    ];
}

// ฟังก์ชันป้องกัน XSS
function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// ฟังก์ชันบอทตอบกลับแบบ mockup (กติกาง่าย ๆ)
function botReply($userText) {
    $t = mb_strtolower(trim($userText), 'UTF-8');

    // รูปแบบกติกา: ถ้ามีคำเหล่านี้ ให้ตอบตามหมวด
    $rules = [
        'สวัสดี' => 'สวัสดีครับ/ค่ะ ยินดีให้คำปรึกษา 🙂 ต้องการสอบถามเรื่องอะไรเอ่ย',
        'เวลา'   => 'ตอนนี้เป็นเพียงระบบจำลอง หากต้องการติดต่อเจ้าหน้าที่ สามารถกดไอคอน LINE หรือ E-mail มุมขวาบนได้เลยครับ/ค่ะ',
        'ตาราง' => 'หากต้องการตารางนัดหมาย/เรียน โปรดแจ้งชั้นปี รายวิชา หรือช่วงเวลา เพื่อให้ช่วยตรวจสอบให้ครับ/ค่ะ',
        'ปรึกษา' => 'สามารถพิมพ์หัวข้อที่ต้องการคำปรึกษา เช่น “สมัครฝึกงาน”, “วางแผนอ่านหนังสือ”, หรือ “แนะแนวอาชีพ” ได้เลยครับ/ค่ะ',
        'สมัคร'  => 'ขั้นตอนทั่วไป: 1) เตรียมเรซูเม่ 2) ติดต่อสถานประกอบการ 3) ส่งเอกสารให้ครูที่ปรึกษา หากต้องการไฟล์ตัวอย่างพิมพ์ “ขอตัวอย่างเรซูเม่”.',
        'เรซูเม่'=> 'คำแนะนำเรซูเม่: 1 หน้า, เน้นผลงาน/ทักษะเด่น, ใช้คำกริยาเชิงผลลัพธ์ เช่น “พัฒนา”, “ปรับปรุง”, “ลดเวลา...”',
        'สอบ'    => 'ทริคเตรียมสอบ: สรุปประเด็นสำคัญ, ทำโจทย์ย้อนหลัง, จัดตารางสั้น ๆ รายวัน และพักผ่อนให้พอครับ/ค่ะ',
        'อีเมล'  => 'หากต้องการติดต่อทางอีเมล กดไอคอนซองจดหมายมุมขวาบนได้เลยครับ/ค่ะ',
        'line'   => 'หากต้องการขอคำปรึกษาผ่าน LINE ให้กดไอคอน LINE มุมขวาบนครับ/ค่ะ',
    ];

    foreach ($rules as $kw => $ans) {
        if (mb_strpos($t, $kw) !== false) {
            return $ans;
        }
    }

    // ตอบทั่วไปเมื่อไม่เข้าเงื่อนไข
    return 'รับทราบครับ/ค่ะ หากอธิบายเพิ่มอีกนิด ว่าต้องการคำปรึกษาเรื่องใด เช่น “ฝึกงาน”, “อ่านหนังสือ”, หรือ “แนะแนวอาชีพ” ฉันจะช่วยไกด์ขั้นตอนให้ได้เลย';
}

// จัดการส่งข้อความ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = trim($_POST['userInput'] ?? '');
    if ($msg !== '') {
        $_SESSION['chat'][] = ['role' => 'user', 'text' => $msg];
        $bot = botReply($msg);
        $_SESSION['chat'][] = ['role' => 'bot', 'text' => $bot];
    }

    // รองรับ fetch แบบ AJAX (ส่ง JSON กลับ)
    if (!empty($_POST['ajax'])) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true, 'chat' => $_SESSION['chat']]);
        exit;
    }

    // ไม่ใช่ AJAX → กลับไปหน้าเดิม (กันกดรีเฟรชซ้ำ)
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>

    <div class="max-w-3xl mx-auto px-4">
        <!-- กล่องแชท -->
        <div class="bg-white p-4 rounded-lg shadow-md h-[45rem] flex flex-col justify-between">
            <div class="flex items-center p-2 justify-between border-b-2 border-gray-400">
                <h2 class="text-2xl font-semibold">Chatbot ให้คำปรึกษา</h2>
                <div class="flex gap-2">
                    <a href="#" class="w-[32px] h-[32px] flex-shrink-0" title="LINE">
                        <img class="w-full h-full" src="../image/line_logo.png" alt="LINE">
                    </a>
                    <a href="mailto:name@example.com" class="w-[32px] h-[32px] flex-shrink-0" title="E-mail">
                        <img class="w-full h-full" src="../image/email.svg" alt="E-mail">
                    </a>
                </div>
            </div>

            <!-- เนื้อหาแชท -->
            <div class="flex flex-col w-full h-full p-2 gap-4 overflow-auto" id="chat-content">
                <?php foreach ($_SESSION['chat'] as $item): ?>
                    <?php if ($item['role'] === 'user'): ?>
                        <div class="w-full flex justify-end">
                            <p class="max-w-[70%] bg-gray-100 p-3 rounded-md shadow-md">
                                <?= esc($item['text']); ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <div class="w-full flex justify-start">
                            <p class="max-w-[70%] bg-green-200 p-3 rounded-md shadow-md">
                                <?= esc($item['text']); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- ฟอร์มส่งข้อความ -->
            <form id="chatForm" method="post" class="mt-2">
                <div class="flex gap-2">
                    <input id="userInput" name="userInput"
                           class="rounded-md border border-gray-400 shadow-md w-full px-4 py-2"
                           placeholder="พิมพ์ข้อความที่นี่ แล้วกด Enter หรือปุ่มส่ง..." autocomplete="off">
                    <button type="submit" class="p-2 rounded-md hover:bg-gray-50 border">
                        <!-- ไอคอนส่ง -->
                        <svg xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960" width="28px" fill="#8C1AF6">
                            <path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/>
                        </svg>
                    </button>
                </div>
                <!-- ธงบอกว่าเป็น AJAX -->
                <input type="hidden" name="ajax" value="1">
            </form>
        </div>

        <!-- ลิงก์เสริมด้านล่าง -->
        <div class="mt-4">
            <p class="flex items-center gap-2">
                ขอคำปรึกษาผ่าน
                <span class="text-rose-500 underline font-bold">line group</span>
                คลิ๊กที่ <img class="w-[24px] h-[24px]" src="../image/line_logo.png" alt="LINE">
            </p>
            <p class="flex items-center gap-2 mt-2">
                ขอคำปรึกษาผ่าน
                <span class="text-rose-500 underline font-bold">E-mail</span>
                คลิ๊กที่
                <img class="w-[24px] h-[24px]" src="../image/email.svg" alt="E-mail">
            </p>
        </div>
    </div>

    <script>
        // autoscroll ไปท้ายสุด
        const chatBox = document.getElementById('chat-content');
        const scrollToBottom = () => { chatBox.scrollTop = chatBox.scrollHeight; };
        scrollToBottom();

        // ส่งแบบ AJAX เพื่อไม่ต้องรีเฟรชหน้า
        const form = document.getElementById('chatForm');
        const input = document.getElementById('userInput');

       form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const text = input.value.trim();
    if (!text) return;

    appendBubble('user', text);
    input.value = '';

    try {
      const formData = new FormData(form);
      // กันเคสที่บางโฮสต์/รีไรต์รูตไม่ส่งค่า hidden
      formData.set('ajax', '1');

      const res = await fetch(window.location.href + '?ajax=1', {
        method: 'POST',
        body: formData,
        headers: { 'Accept': 'application/json' }
      });

      const ct = (res.headers.get('content-type') || '').toLowerCase();
      if (!ct.includes('application/json')) {
        // ถ้าไม่ได้ JSON (เช่น HTML) ให้ fallback เป็นรีโหลดหน้า
        window.location.reload();
        return;
      }

      const data = await res.json();
      if (!data || !data.chat) {
        appendBubble('bot', 'รูปแบบข้อมูลไม่ถูกต้องจากเซิร์ฟเวอร์');
        return;
      }
      renderFromSession(data.chat);

    } catch (err) {
      appendBubble('bot', 'ขออภัย ระบบจำลองมีปัญหาชั่วคราว ลองใหม่อีกครั้งนะครับ/ค่ะ');
      console.error(err);
    } finally {
      scrollToBottom();
    }
  });
        function appendBubble(role, text) {
            const wrap = document.createElement('div');
            wrap.className = 'w-full flex ' + (role === 'user' ? 'justify-end' : 'justify-start');
            const p = document.createElement('p');
            p.className = 'max-w-[70%] ' + (role === 'user' ? 'bg-gray-100' : 'bg-green-200') + ' p-3 rounded-md shadow-md whitespace-pre-wrap';
            p.textContent = text;
            wrap.appendChild(p);
            chatBox.appendChild(wrap);
            scrollToBottom();
        }

        function renderFromSession(chatArr) {
            chatBox.innerHTML = '';
            chatArr.forEach(item => appendBubble(item.role, item.text));
        }

        // ส่งด้วย Enter อย่างเดียวก็ได้
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                form.requestSubmit();
                e.preventDefault();
            }
        });
    </script>

