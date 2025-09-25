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


// จัดการส่งข้อความ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = trim($_POST['userInput'] ?? '');
    if ($msg !== '') {
        $_SESSION['chat'][] = ['role' => 'user', 'text' => $msg];
        $bot = 'คำถามน่าสนใจนะครับ/ค่ะ แต่ขออภัย ระบบจำลองยังไม่สามารถตอบคำถามได้ในขณะนี้ ลองถามใหม่อีกครั้งนะครับ/ค่ะ';
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

    <div class="max-w-3xl">
        <!-- กล่องแชท -->
        <div class="bg-white p-4 rounded-lg shadow-md h-[45rem] flex flex-col justify-between">
            <div class="flex items-center p-2 justify-between border-b-2 border-gray-400">
                <h2 class="text-2xl font-semibold">Chatbot ให้คำปรึกษา</h2>
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

