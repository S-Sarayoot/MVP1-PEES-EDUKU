<?php
// ===== [PHP BOOTSTRAP - ต้องมาก่อนส่ง HTML ใด ๆ ออกไป] =====
session_start();

require_once __DIR__ . '/../backend/libs/faq_chatbot.php';

// เริ่มต้นประวัติแชทในเซสชัน
if (!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = [
    ['role' => 'bot',  'text' => "สวัสดีครับ/ค่ะ ฉันเป็นระบบตอบคำถามแบบ FAQ\nพิมพ์คำถามได้เลย เช่น: \"เข้าสู่ระบบไม่ได้\", \"ลืมรหัสผ่าน\", \"บันทึกเวิร์กชอปไม่ได้\""],
    ];
}

// ฟังก์ชันป้องกัน XSS
function esc($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

// จัดการส่งข้อความ (รองรับทั้งปุ่มส่งและ AJAX)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $msg = trim($_POST['userInput'] ?? '');
    if ($msg !== '') {
        $_SESSION['chat'][] = ['role' => 'user', 'text' => $msg];

    // ตอบแบบ FAQ matching
    $bot = faq_chatbot_reply($msg);
        $_SESSION['chat'][] = ['role' => 'bot', 'text' => $bot];
    }

    // มองว่าเป็น AJAX เมื่อเป็น POST และมี $_POST['ajax']=='1'
    $isAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';
    if ($isAjax) {
      // ส่งเฉพาะข้อความใหม่กลับไปด้วย (กันกรณี client นับ chatCount เพี้ยน)
      $delta = [];
      $count = is_array($_SESSION['chat']) ? count($_SESSION['chat']) : 0;
      if ($count >= 2) {
        $delta = array_slice($_SESSION['chat'], -2);
      } elseif ($count === 1) {
        $delta = array_slice($_SESSION['chat'], -1);
      }

        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store, no-cache, must-revalidate');
      echo json_encode([
        'ok' => true,
        'chat' => $_SESSION['chat'],
        'chat_count' => $count,
        'delta' => $delta,
      ], JSON_UNESCAPED_UNICODE);
        session_write_close();
        exit;
    }

    // ไม่ใช่ AJAX → กันรีเฟรชซ้ำด้วย redirect
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
?>
<?php 
    require_once 'base.php';
?>
  <title>EquityLearnKU - Consulting</title>
</head>
<body class="bg-gray-100">
  <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
    <!-- Navigation -->
    <?php include_once '../component/sidebar.php' ?>

    <!-- Main Content -->
    <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
      <div class="flex justify-between">
        <h1 class="text-xl text-[#433878] mb-4 md:mx-4">Consulting</h1>
        <p class="text-gray-700 mb-4 mr-4">
          <a href="#" class="text-gray-400 hover:font-semibold hover:text-[#433878]">Home</a>
          > Consulting
        </p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="w-full">
          <div class="max-w-3xl">
            <!-- กล่องแชท -->
            <div class="bg-white p-4 rounded-lg shadow-md h-[45rem] flex flex-col justify-between border-2 border-purple-100">
              <div class="flex items-center p-2 justify-between border-b-2 border-purple-100">
                <h2 class="text-2xl font-semibold text-[#433878]">Chatbot ให้คำปรึกษา</h2>
              </div>

            <!-- เนื้อหาแชท (เรนเดอร์จากเซิร์ฟเวอร์รอบแรก) -->
            <div class="flex flex-col w-full h-full p-2 gap-4 overflow-auto" id="chat-content">
              <?php foreach ($_SESSION['chat'] as $item): ?>
                <?php if ($item['role'] === 'user'): ?>
                  <div class="w-full flex justify-end">
                    <p class="max-w-[70%] bg-purple-100 p-3 rounded-md shadow-md"><?= esc($item['text']); ?></p>
                  </div>
                <?php else: ?>
                  <div class="w-full flex justify-start">
                    <p class="max-w-[70%] bg-green-100 p-3 rounded-md shadow-md"><?= esc($item['text']); ?></p>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>

            <!-- ฟอร์มส่งข้อความ -->
            <form id="chatForm" method="post" class="mt-2">
              <div class="flex gap-2">
                <input id="userInput" name="userInput"
                       class="rounded-md border border-purple-200 shadow-md w-full px-4 py-2 focus:outline-none focus:ring-1 focus:ring-purple-500"
                       placeholder="พิมพ์ข้อความที่นี่ แล้วกด Enter หรือปุ่มส่ง..." autocomplete="off">
                <button type="submit" class="p-2 rounded-md bg-purple-100 hover:bg-purple-200 border border-purple-200">
                  <!-- ไอคอนส่ง -->
                  <svg xmlns="http://www.w3.org/2000/svg" height="28px" viewBox="0 -960 960 960" width="28px" fill="#433878">
                    <path d="M120-160v-640l760 320-760 320Zm80-120 474-200-474-200v140l240 60-240 60v140Zm0 0v-400 400Z"/>
                  </svg>
                </button>
              </div>
              <!-- ธงบอกว่าเป็น AJAX -->
              <input type="hidden" name="ajax" value="1">
            </form>
          </div>
        </div>
      </div>

        <div class="w-full">
          <div class="bg-white p-4 rounded-lg shadow-md h-max-auto border-2 border-purple-100">
            <h2 class="text-2xl font-semibold text-[#433878]">คำถามที่พบบ่อย (FAQ)</h2>
            <div id="faq" class="border-b border-purple-100 p-4">
              <?php
                $faq = faq_chatbot_pairs();
                $faq = array_slice($faq, 0, 10);
                $idx = 1;
              ?>
              <?php foreach ($faq as $item): ?>
                <button class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none cursor-pointer"
                        onclick="toggleFAQ(<?= $idx ?>)">
                  <span>Q: <?= esc($item['q'] ?? '') ?></span>
                  <span id="icon-<?= $idx ?>" class="text-[#433878]">+</span>
                </button>
                <div id="faq-<?= $idx ?>" class="hidden pb-3 text-gray-600 shadow-md bg-purple-50 rounded-md p-3">
                  <?= esc($item['a'] ?? '') ?>
                </div>
                <?php $idx++; ?>
              <?php endforeach; ?>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>

  <script>
    // autoscroll ไปท้ายสุด
    const chatBox = document.getElementById('chat-content');
    const scrollToBottom = () => { chatBox.scrollTop = chatBox.scrollHeight; };
    scrollToBottom();

    // ==== ใช้ "ต่อท้ายเฉพาะ delta" แทนการล้างทั้งกล่อง ====
    // นับจำนวนข้อความที่เรนเดอร์ไว้แล้วจากฝั่ง PHP
    let chatCount = <?= count($_SESSION['chat']) ?>;

    // ส่งแบบ AJAX เพื่อไม่ต้องรีเฟรชหน้า
    const form = document.getElementById('chatForm');
    const input = document.getElementById('userInput');

    let sending = false;

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (sending) return;

      const text = input.value.trim();
      if (!text) return;

      // optimistic UI (ต่อท้ายฟอง user)
      appendBubble('user', text);
      input.value = '';

      try {
        sending = true;
        const btn = form.querySelector('button[type="submit"]');
        btn?.setAttribute('disabled','disabled');

        const formData = new FormData(form);
        // เราเคลียร์ input ไปแล้วเพื่อ UX → ต้องส่งค่าที่พิมพ์จริงให้ server
        formData.set('userInput', text);
        formData.set('ajax', '1'); // ให้ PHP รู้ว่าเป็น AJAX

        const res = await fetch(window.location.pathname, {
          method: 'POST',
          body: formData,
          headers: { 'Accept': 'application/json' },
          credentials: 'same-origin'
        });

        // พยายาม parse JSON โดยไม่ reload หน้า
        let data;
        try {
          data = await res.json();
        } catch {
          appendBubble('bot', 'รูปแบบข้อมูลจากเซิร์ฟเวอร์ไม่ถูกต้อง (ไม่ใช่ JSON)');
          return;
        }

        const arr = Array.isArray(data?.chat) ? data.chat : [];
        if (!arr.length) {
          appendBubble('bot', 'ไม่พบข้อมูลแชทจากเซิร์ฟเวอร์');
          return;
        }

        // Prefer delta จาก server (กัน client/chatCount เพี้ยน)
        const serverDelta = Array.isArray(data?.delta) ? data.delta : null;
        if (serverDelta && serverDelta.length) {
          // เรา append ข้อความ user ไปแล้วแบบ optimistic → ต่อท้ายเฉพาะ bot
          serverDelta.forEach(item => {
            if (item?.role === 'bot') appendBubble('bot', item.text);
          });
          chatCount = Number.isFinite(data?.chat_count) ? data.chat_count : arr.length;
        } else {
          // fallback: ต่อท้ายเฉพาะข้อความใหม่ตั้งแต่ index chatCount เป็นต้นไป
          const delta = arr.slice(chatCount);
          delta.forEach(item => {
            if (item?.role === 'bot') appendBubble('bot', item.text);
          });
          chatCount = arr.length;
        }

      } catch (err) {
        appendBubble('bot', 'ขออภัย ระบบจำลองมีปัญหาชั่วคราว ลองใหม่อีกครั้งนะครับ/ค่ะ');
        console.error(err);
      } finally {
        sending = false;
        const btn = form.querySelector('button[type="submit"]');
        btn?.removeAttribute('disabled');
        scrollToBottom();
      }
    });

    function appendBubble(role, text) {
      const wrap = document.createElement('div');
      wrap.className = 'w-full flex ' + (role === 'user' ? 'justify-end' : 'justify-start');
      const p = document.createElement('p');
      p.className = 'max-w-[70%] ' + (role === 'user' ? 'bg-purple-100' : 'bg-green-100') + ' p-3 rounded-md shadow-md whitespace-pre-wrap';
      p.textContent = text;
      wrap.appendChild(p);
      chatBox.appendChild(wrap);
      scrollToBottom();
    }

    // toggle FAQ
    const toggleFAQ = (id) => {
      const content = document.getElementById(`faq-${id}`);
      const icon = document.getElementById(`icon-${id}`);
      content.classList.toggle("hidden");
      icon.textContent = content.classList.contains("hidden") ? "+" : "-";
    };
    window.toggleFAQ = toggleFAQ;

    // ส่งด้วย Enter อย่างเดียวก็ได้
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        form.requestSubmit();
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
