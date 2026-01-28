<?php 
    require_once 'base.php';
    $workshop_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
?>
<title>EquityLearnKU - Workshop Management</title>
</head>
<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">

        <?php include_once '../component/sidebar.php' ?>

        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">จัดการ Workshop #<?php echo $workshop_id; ?> </h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="../admin" class="text-gray-400 hover:font-semibold hover:text-[#433878]">Home</a> > <a href="workshop_admin" class="text-gray-400 hover:font-semibold hover:text-[#433878]">Workshop</a> > Management</p>
            </div>
            
            <div class="flex flex-col gap-4">
                <form id="workshopForm" class="space-y-4">
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-4">
                        <!-- Left: Workshop settings -->
                        <section class="xl:col-span-5 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200 p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <h2 class="text-lg font-semibold text-[#433878]">ตั้งค่า Workshop</h2>
                                    <div class="text-xs text-gray-500">กำหนดเวลาและรายละเอียดของ Workshop</div>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-semibold mb-1">เวลาเปิด</label>
                                    <input type="datetime-local" name="open_time" class="w-full border border-gray-200 rounded px-3 py-2" required>
                                </div>
                                <div>
                                    <label class="block font-semibold mb-1">เวลาปิด</label>
                                    <input type="datetime-local" name="close_time" class="w-full border border-gray-200 rounded px-3 py-2" required>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block font-semibold mb-1">คำชี้แจง</label>
                                <textarea name="instruction" class="w-full border border-gray-200 rounded px-3 py-2" rows="6" required></textarea>
                            </div>
                            <div class="mt-4">
                                <label class="block font-semibold mb-1">วัตถุประสงค์</label>
                                <textarea name="objective" class="w-full border border-gray-200 rounded px-3 py-2" rows="6" required></textarea>
                            </div>
                            <div class="mt-4">
                                <label class="block font-semibold mb-1">แนวคิดหลัก</label>
                                <textarea name="main_concept" class="w-full border border-gray-200 rounded px-3 py-2" rows="6" required></textarea>
                            </div>
                        </section>

                        <!-- Right: Questions + Rubric -->
                        <div class="xl:col-span-7 flex flex-col gap-4">
                            <section class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h2 class="text-lg font-semibold text-[#433878]">ข้อคำถาม (แบบตัวเลือก)</h2>
                                        <div class="text-xs text-gray-500">ตั้งค่าข้อคำถามและเฉลย</div>
                                    </div>
                                    <button id="add-question-btn" type="button" onclick="addQuestion()" class="px-4 py-2 bg-green-100 text-green-800 rounded hover:bg-green-200">+ เพิ่มคำถาม</button>
                                </div>

                                <div id="questions-list" class="mt-4 flex flex-col gap-4"></div>
                                <div id="question-limit-hint" class="text-xs text-gray-500 mt-2">เพิ่มได้ไม่เกิน 10 ข้อ</div>
                            </section>

                            <section class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200 p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <h2 class="text-lg font-semibold text-[#433878]">Rubric score (กำหนดต่อ 1 Workshop)</h2>
                                        <div class="text-xs text-gray-500">เพิ่มหัวข้อเกณฑ์และคำอธิบายระดับ 3 หรือ 5 ระดับ</div>
                                    </div>
                                    <button id="add-rubric-btn" type="button" onclick="addRubricItem()" class="px-4 py-2 bg-green-100 text-green-800 rounded hover:bg-green-200">+ เพิ่มเกณฑ์</button>
                                </div>

                                <div id="rubric-list" class="mt-4 flex flex-col gap-4"></div>
                                <div id="rubric-limit-hint" class="text-xs text-gray-500 mt-2">เพิ่มได้ไม่เกิน 10 ข้อ</div>
                            </section>
                        </div>
                    </div>

                    <!-- Resources -->
                    <div class="mt-4 bg-white p-5 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-3">
                            <div>
                                <h2 class="text-lg font-semibold text-[#433878]">ทรัพยากรที่เกี่ยวข้อง (โพสต์)</h2>
                                <div class="text-xs text-gray-500">เลือกจากคลังทรัพยากร (เลือกได้หลายโพสต์)</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" id="openPostPickerBtn" class="px-4 py-2 bg-purple-700 text-white rounded hover:bg-purple-800">เลือกโพสต์</button>
                                <button type="button" id="refreshPostPickerBtn" class="px-3 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">รีเฟรช</button>
                            </div>
                        </div>
                        <div id="selected-posts" class="border border-gray-100 rounded-lg divide-y">
                            <div class="p-4 text-gray-400">กำลังโหลด...</div>
                        </div>
                    </div>

                    <!-- Sticky save bar -->
                    <div class="sticky bottom-0 z-10 bg-white/90 backdrop-blur border border-gray-200 rounded-lg shadow-sm px-4 py-3">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                            <div class="text-sm">
                                <span class="text-gray-600">คะแนนรวม:</span>
                                <span id="total-score" class="font-semibold text-gray-800">0</span>
                                <span class="text-gray-500">/ 100</span>
                                <span id="total-score-hint" class="ml-2 text-xs text-gray-500">* คะแนนรวมทุกข้อควรเท่ากับ 100 คะแนน</span>
                            </div>
                            <div class="flex items-center justify-end gap-2">
                                <!-- ปุ่มย้อนกลับ -->
                                <a href="workshop_admin" class="px-6 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">ย้อนกลับ</a>
                                <button type="submit" class="px-6 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">บันทึก Workshop</button>
                            </div>
                        </div>
                    </div>
                </form>

                
            </div>
        </div>
    </div>

    <!-- Post Picker Modal -->
    <div id="postPickerModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" data-close-post-picker></div>
        <div class="relative mx-auto mt-20 w-[95%] max-w-3xl bg-white rounded-xl shadow-xl overflow-hidden">
            <div class="p-4 border-b flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold text-[#433878]">เลือกโพสต์จากระบบ</div>
                    <div id="postPickerSub" class="text-xs text-gray-500">เลือกได้หลายโพสต์ แล้วกดบันทึก</div>
                </div>
                <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl leading-none" data-close-post-picker>&times;</button>
            </div>
            <div class="p-4 flex items-center gap-3">
                <input id="postPickerSearch" type="search" placeholder="ค้นหาชื่อ/หมวดหมู่..." class="w-full border border-gray-200 rounded px-3 py-2" />
                <button type="button" id="postPickerSelectAll" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200">เลือกทั้งหมด</button>
                <button type="button" id="postPickerClearAll" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200">ล้าง</button>
            </div>
            <div id="postPickerList" class="max-h-[60vh] overflow-y-auto border-t border-b">
                <div class="p-4 text-gray-400">กำลังโหลด...</div>
            </div>
            <div class="p-4 flex items-center justify-between">
                <div class="text-sm text-gray-600"><span id="postPickerCount">0</span> โพสต์ที่เลือก</div>
                <div class="flex items-center gap-2">
                    <button type="button" class="px-4 py-2 bg-gray-100 rounded hover:bg-gray-200" data-close-post-picker>ยกเลิก</button>
                    <button type="button" id="postPickerSave" class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
const MAX_QUESTIONS = 10;
const MAX_CHOICES = 4;
const MAX_RUBRIC_ITEMS = 10;
let questionCount = 0;
let rubricCount = 0;

const CHOICE_LABELS = ['A', 'B', 'C', 'D'];

function getCurrentQuestionCount() {
    return document.querySelectorAll('#questions-list [data-idx]').length;
}

function updateQuestionLimitUI() {
    const btn = document.getElementById('add-question-btn');
    if (!btn) return;
    const count = getCurrentQuestionCount();
    const isLimit = count >= MAX_QUESTIONS;
    btn.disabled = isLimit;
    btn.classList.toggle('opacity-50', isLimit);
    btn.classList.toggle('cursor-not-allowed', isLimit);
}

function renumberQuestions() {
    const cards = document.querySelectorAll('#questions-list [data-idx]');
    cards.forEach((card, i) => {
        const titleEl = card.querySelector('[data-qtitle]');
        if (titleEl) titleEl.textContent = `ข้อที่ ${i + 1}`;
    });
}

function removeQuestion(el) {
    const card = el.closest('[data-idx]');
    if (card) card.remove();
    updateQuestionLimitUI();
    renumberQuestions();
    updateTotalScoreUI();
}

function addQuestion(q = null) {
    const current = getCurrentQuestionCount();
    if (current >= MAX_QUESTIONS) {
        Swal.fire({
            icon: 'warning',
            title: 'เพิ่มคำถามไม่ได้',
            text: 'เพิ่มคำถามได้ไม่เกิน 10 ข้อ',
            confirmButtonText: 'ตกลง'
        });
        updateQuestionLimitUI();
        return;
    }
    questionCount++;
    const idx = questionCount;
    const qText = q && q.text ? q.text : '';
    const qScore = q && q.score ? q.score : '';
    const qChoices = q && q.choices ? q.choices : ['',''];
    const qAnswer = q && q.answer ? q.answer : '';
    const currentDisplayNo = getCurrentQuestionCount() + 1;
    const html = `
    <div class="border border-gray-200 rounded p-4 shadow-sm bg-gray-50 relative" data-idx="${idx}">
        <button type="button" onclick="removeQuestion(this)" class="absolute top-2 right-2 text-red-500">&times;</button>
        <div class="flex items-center justify-between mb-2">
            <div class="font-semibold text-[#433878]" data-qtitle>ข้อที่ ${currentDisplayNo}</div>
        </div>
        <div class="flex flex-col md:flex-row gap-2 mb-2">
            <input type="text" name="question_text[]" class="flex-1 border border-gray-200 rounded px-2 py-1" placeholder="พิมพ์คำถาม..." value="${qText}" required>
            <input type="number" name="question_score[]" class="w-24 border border-gray-200 rounded px-2 py-1" placeholder="คะแนน" min="1" max="100" value="${qScore}" required>
        </div>
        <div id="choices-${idx}" data-choices-wrap>
            ${(qChoices||['','']).map((c,i) => {
                const label = CHOICE_LABELS[i] || (i + 1);
                return `
                <div class="flex gap-2 mb-1" data-choice-row>
                    <div class="w-8 text-gray-600 font-semibold flex items-center justify-center" data-choice-label>${label}</div>
                    <input type="text" name="choice_${idx}[]" class="flex-1 border border-gray-200 rounded px-2 py-1" placeholder="ตัวเลือก ${label}" value="${c||''}" required>
                    <input type="radio" name="answer_${idx}" value="${i}" ${qAnswer==i?'checked':''}> เฉลย
                    <button type="button" onclick="removeChoice(this, ${idx})" class="text-red-400">ลบ</button>
                </div>
            `;
            }).join('')}
            <button type="button" data-add-choice-btn onclick="addChoice(${idx})" class="text-green-700 mt-1">+ เพิ่มตัวเลือก</button>
        </div>
    </div>`;
    document.getElementById('questions-list').insertAdjacentHTML('beforeend', html);
    updateQuestionLimitUI();
    renumberQuestions();
    updateChoiceLimitUI(idx);
    updateTotalScoreUI();
}

function updateTotalScoreUI() {
    let total = 0;
    document.querySelectorAll('input[name="question_score[]"]').forEach((i) => {
        total += parseInt(i.value || 0, 10) || 0;
    });

    const el = document.getElementById('total-score');
    const hint = document.getElementById('total-score-hint');
    if (el) el.textContent = String(total);
    if (hint) {
        if (total === 100) {
            hint.textContent = 'พร้อมบันทึก (คะแนนรวมครบ 100)';
            hint.classList.remove('text-gray-500', 'text-red-600');
            hint.classList.add('text-green-700');
        } else {
            hint.textContent = '* คะแนนรวมทุกข้อควรเท่ากับ 100 คะแนน';
            hint.classList.remove('text-green-700');
            hint.classList.add(total > 100 ? 'text-red-600' : 'text-gray-500');
            if (total <= 100) hint.classList.remove('text-red-600');
        }
    }
}
function getChoiceCount(idx) {
    const wrap = document.getElementById('choices-' + idx);
    if (!wrap) return 0;
    return wrap.querySelectorAll('[data-choice-row]').length;
}

function updateChoiceLimitUI(idx) {
    const wrap = document.getElementById('choices-' + idx);
    if (!wrap) return;
    const btn = wrap.querySelector('[data-add-choice-btn]');
    if (!btn) return;
    const count = getChoiceCount(idx);
    const isLimit = count >= MAX_CHOICES;
    btn.disabled = isLimit;
    btn.classList.toggle('opacity-50', isLimit);
    btn.classList.toggle('cursor-not-allowed', isLimit);
}

function reflowChoices(idx) {
    const wrap = document.getElementById('choices-' + idx);
    if (!wrap) return;
    const rows = wrap.querySelectorAll('[data-choice-row]');
    rows.forEach((row, i) => {
        const label = CHOICE_LABELS[i] || (i + 1);

        const labelEl = row.querySelector('[data-choice-label]');
        if (labelEl) labelEl.textContent = label;

        const inputEl = row.querySelector('input[type="text"]');
        if (inputEl) inputEl.placeholder = `ตัวเลือก ${label}`;

        const radioEl = row.querySelector('input[type="radio"]');
        if (radioEl) radioEl.value = String(i);
    });
}

function removeChoice(el, idx) {
    const row = el.closest('[data-choice-row]');
    if (row) row.remove();
        reflowChoices(idx);
        updateChoiceLimitUI(idx);
}

function addChoice(idx) {
    const count = getChoiceCount(idx);
    if (count >= MAX_CHOICES) {
        Swal.fire({
            icon: 'warning',
            title: 'เพิ่มตัวเลือกไม่ได้',
            text: 'เพิ่มตัวเลือกได้ไม่เกิน 4 ตัวเลือก',
            confirmButtonText: 'ตกลง'
        });
        updateChoiceLimitUI(idx);
        return;
    }
    const div = document.createElement('div');
    div.className = 'flex gap-2 mb-1';
    div.setAttribute('data-choice-row', '');
    const label = CHOICE_LABELS[count] || (count + 1);
    div.innerHTML = `<div class="w-8 text-gray-600 font-semibold flex items-center justify-center" data-choice-label>${label}</div>
        <input type="text" name="choice_${idx}[]" class="flex-1 border border-gray-200 rounded px-2 py-1" placeholder="ตัวเลือก ${label}" required>
        <input type="radio" name="answer_${idx}" value="${count}"> เฉลย
        <button type="button" onclick="removeChoice(this, ${idx})" class="text-red-400">ลบ</button>`;
    const wrap = document.getElementById('choices-' + idx);
    wrap.insertBefore(div, wrap.querySelector('[data-add-choice-btn]'));
    updateChoiceLimitUI(idx);
}

// ----------------------------
// Rubric builder (workshop-level)
// ----------------------------
function getCurrentRubricCount() {
    return document.querySelectorAll('#rubric-list [data-ridx]').length;
}

function updateRubricLimitUI() {
    const btn = document.getElementById('add-rubric-btn');
    if (!btn) return;
    const count = getCurrentRubricCount();
    const isLimit = count >= MAX_RUBRIC_ITEMS;
    btn.disabled = isLimit;
    btn.classList.toggle('opacity-50', isLimit);
    btn.classList.toggle('cursor-not-allowed', isLimit);
}

function renumberRubricItems() {
    const cards = document.querySelectorAll('#rubric-list [data-ridx]');
    cards.forEach((card, i) => {
        const titleEl = card.querySelector('[data-rtitle]');
        if (titleEl) titleEl.textContent = `เกณฑ์ที่ ${i + 1}`;
    });
}

function removeRubricItem(el) {
    const card = el.closest('[data-ridx]');
    if (card) card.remove();
    updateRubricLimitUI();
    renumberRubricItems();
}

function rubricLevels(levelCount) {
    return levelCount === 3 ? [3, 2, 1] : [5, 4, 3, 2, 1];
}

function renderRubricDescFields(idx, levelCount, descArr = []) {
    const levels = rubricLevels(levelCount);
    const safe = Array.isArray(descArr) ? descArr : [];
    return `
        <div class="grid grid-cols-1 gap-2">
            ${levels.map((lvl, i) => `
                <div class="grid grid-cols-12 gap-2 items-center">
                    <div class="col-span-12 md:col-span-2 text-sm font-semibold text-gray-600">ระดับ ${lvl}</div>
                    <div class="col-span-12 md:col-span-10">
                        <input type="text" name="rubric_desc_${idx}[]" class="w-full border border-gray-200 rounded px-2 py-1" placeholder="คำอธิบายระดับ ${lvl}" value="${String(safe[i] ?? '').replace(/\"/g,'&quot;')}" required>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

function onRubricLevelChange(sel, idx) {
    const card = document.querySelector(`#rubric-list [data-ridx="${idx}"]`);
    if (!card) return;
    const wrap = card.querySelector('[data-rubric-desc-wrap]');
    if (!wrap) return;

    const oldCount = parseInt(card.getAttribute('data-level-count') || '5', 10);
    const newCount = parseInt(sel.value || '5', 10);
    if (![3, 5].includes(newCount)) return;

    const existing = Array.from(wrap.querySelectorAll('input[name^="rubric_desc_"]')).map((el) => (el.value || '').trim());

    let nextDesc = [];
    if (oldCount === 5 && newCount === 3) {
        nextDesc = [existing[2] ?? '', existing[3] ?? '', existing[4] ?? ''];
    } else if (oldCount === 3 && newCount === 5) {
        nextDesc = ['', '', existing[0] ?? '', existing[1] ?? '', existing[2] ?? ''];
    } else {
        nextDesc = existing;
    }

    card.setAttribute('data-level-count', String(newCount));
    wrap.innerHTML = renderRubricDescFields(idx, newCount, nextDesc);
}

function addRubricItem(item = null) {
    const current = getCurrentRubricCount();
    if (current >= MAX_RUBRIC_ITEMS) {
        Swal.fire({
            icon: 'warning',
            title: 'เพิ่มเกณฑ์ไม่ได้',
            text: 'เพิ่มเกณฑ์ได้ไม่เกิน 10 ข้อ',
            confirmButtonText: 'ตกลง'
        });
        updateRubricLimitUI();
        return;
    }

    rubricCount++;
    const idx = rubricCount;
    const title = item && item.title ? String(item.title) : '';
    const levelCount = item && item.level_count ? parseInt(item.level_count, 10) : 5;
    const desc = item && Array.isArray(item.desc) ? item.desc : (levelCount === 3 ? ['','',''] : ['','','','','']);
    const currentDisplayNo = getCurrentRubricCount() + 1;

    const html = `
        <div class="border border-gray-200 rounded p-4 shadow-sm bg-gray-50 relative" data-ridx="${idx}" data-level-count="${levelCount}">
            <button type="button" onclick="removeRubricItem(this)" class="absolute top-2 right-2 text-red-500">&times;</button>
            <div class="flex items-center justify-between mb-2">
                <div class="font-semibold text-[#433878]" data-rtitle>เกณฑ์ที่ ${currentDisplayNo}</div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2 mb-2">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">หัวข้อ</label>
                    <input type="text" class="w-full border border-gray-200 rounded px-2 py-1" placeholder="เช่น ความถูกต้อง / ความคิดสร้างสรรค์" value="${title.replace(/\"/g,'&quot;')}" data-rubric-title required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">จำนวนระดับ</label>
                    <select class="w-full border border-gray-200 rounded px-2 py-1" onchange="onRubricLevelChange(this, ${idx})" data-rubric-level>
                        <option value="3" ${levelCount === 3 ? 'selected' : ''}>3 ระดับ</option>
                        <option value="5" ${levelCount === 5 ? 'selected' : ''}>5 ระดับ</option>
                    </select>
                </div>
            </div>
            <div class="mt-2 border border-gray-200 rounded p-3 bg-white" data-rubric-desc-wrap>
                ${renderRubricDescFields(idx, levelCount, desc)}
            </div>
        </div>
    `;

    document.getElementById('rubric-list').insertAdjacentHTML('beforeend', html);
    updateRubricLimitUI();
    renumberRubricItems();
}
document.getElementById('workshopForm').onsubmit = function(e) {
    e.preventDefault();
    // ตรวจสอบคะแนนรวม
    let total = 0;
    document.querySelectorAll('input[name="question_score[]"]').forEach(i=>{ total += parseInt(i.value||0); });
    if (total !== 100) {
        Swal.fire({
            icon: 'warning',
            title: 'คะแนนรวมไม่ถูกต้อง',
            text: 'คะแนนรวมต้องเท่ากับ 100 คะแนน',
            confirmButtonText: 'ตกลง'
        });
        return false;
    }

    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) submitBtn.disabled = true;

    try {
        const cards = document.querySelectorAll('#questions-list [data-idx]');
        const questions = [];

        for (const card of cards) {
            const idx = card.getAttribute('data-idx');
            const textEl = card.querySelector('input[name="question_text[]"]');
            const scoreEl = card.querySelector('input[name="question_score[]"]');

            const qText = (textEl ? textEl.value : '').trim();
            const qScore = parseInt(scoreEl ? scoreEl.value : '0', 10) || 0;

            if (!qText) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ข้อมูลไม่ครบ',
                    text: 'กรุณากรอกข้อความคำถามให้ครบทุกข้อ',
                    confirmButtonText: 'ตกลง'
                });
                return false;
            }
            if (qScore <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'คะแนนไม่ถูกต้อง',
                    text: 'กรุณาระบุคะแนนคำถามให้ถูกต้อง',
                    confirmButtonText: 'ตกลง'
                });
                return false;
            }

            const choicesWrap = document.getElementById('choices-' + idx);
            const choiceInputs = choicesWrap ? choicesWrap.querySelectorAll('input[type="text"][name^="choice_"]') : [];
            const choices = Array.from(choiceInputs).map(el => (el.value || '').trim());
            const answerEl = choicesWrap ? choicesWrap.querySelector('input[type="radio"][name="answer_' + idx + '"]:checked') : null;
            const answerIdx = answerEl ? parseInt(answerEl.value, 10) : null;

            if (choices.length < 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ตัวเลือกไม่ครบ',
                    text: 'ข้อคำถามแบบตัวเลือกต้องมีอย่างน้อย 2 ตัวเลือก',
                    confirmButtonText: 'ตกลง'
                });
                return false;
            }
            if (choices.some(c => !c)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ตัวเลือกไม่ครบ',
                    text: 'กรุณากรอกข้อความตัวเลือกให้ครบ',
                    confirmButtonText: 'ตกลง'
                });
                return false;
            }
            if (answerIdx === null || Number.isNaN(answerIdx)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'ยังไม่ได้เลือกเฉลย',
                    text: 'กรุณาเลือกเฉลยสำหรับข้อคำถามแบบตัวเลือก',
                    confirmButtonText: 'ตกลง'
                });
                return false;
            }

            questions.push({
                type: 'choice',
                text: qText,
                score: qScore,
                choices,
                answer: answerIdx,
            });
        }

        if (questions.length === 0) {
            Swal.fire({ icon: 'warning', title: 'ยังไม่มีคำถาม', text: 'กรุณาเพิ่มข้อคำถามอย่างน้อย 1 ข้อ', confirmButtonText: 'ตกลง' });
            return false;
        }

        // Build workshop-level rubric
        const rubricCards = document.querySelectorAll('#rubric-list [data-ridx]');
        const rubric = [];

        for (const card of rubricCards) {
            const titleEl = card.querySelector('[data-rubric-title]');
            const levelEl = card.querySelector('[data-rubric-level]');
            const title = (titleEl ? titleEl.value : '').trim();
            const levelCount = parseInt(levelEl ? levelEl.value : '0', 10);
            const descEls = card.querySelectorAll('input[name^="rubric_desc_"]');
            const desc = Array.from(descEls).map((el) => (el.value || '').trim());

            if (!title) {
                Swal.fire({ icon: 'warning', title: 'Rubric ไม่ครบ', text: 'กรุณากรอกหัวข้อ Rubric ให้ครบทุกข้อ', confirmButtonText: 'ตกลง' });
                return false;
            }
            if (![3, 5].includes(levelCount)) {
                Swal.fire({ icon: 'warning', title: 'Rubric ไม่ถูกต้อง', text: 'จำนวนระดับต้องเป็น 3 หรือ 5', confirmButtonText: 'ตกลง' });
                return false;
            }
            if (desc.length !== levelCount || desc.some((d) => !d)) {
                Swal.fire({ icon: 'warning', title: 'Rubric ไม่ครบ', text: 'กรุณากรอกคำอธิบาย Rubric ให้ครบทุกระดับ', confirmButtonText: 'ตกลง' });
                return false;
            }

            rubric.push({ title, level_count: levelCount, desc });
        }

        if (rubric.length === 0) {
            Swal.fire({ icon: 'warning', title: 'Rubric ไม่ครบ', text: 'กรุณาเพิ่ม Rubric อย่างน้อย 1 ข้อ', confirmButtonText: 'ตกลง' });
            return false;
        }

        const payload = {
            workshop_id: <?php echo (int)$workshop_id; ?>,
            open_time: form.open_time.value,
            close_time: form.close_time.value,
            objective: form.objective.value,
            main_concept: form.main_concept.value,
            instruction: form.instruction.value,
            questions,
            rubric,
        };

        Swal.fire({
            title: 'กำลังบันทึกข้อมูล...',
            text: 'โปรดรอสักครู่',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch('../backend/api/create_workshop.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
        .then(async (res) => {
            const data = await res.json().catch(() => null);
            if (!res.ok || !data || !data.success) {
                throw new Error((data && data.message) ? data.message : 'บันทึกข้อมูลไม่สำเร็จ');
            }
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'บันทึกข้อมูลสำเร็จ',
                confirmButtonText: 'ตกลง',
                didClose: () => {
                    // reload page to reflect new workshop ID
                    window.location.href = `workshop_admin.php`;
                }
            });
        })
        .catch((err) => {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'บันทึกข้อมูลไม่สำเร็จ',
                text: (err && err.message) ? err.message : 'บันทึกข้อมูลไม่สำเร็จ',
                confirmButtonText: 'ตกลง'
            });
        })
        .finally(() => {
            if (submitBtn) submitBtn.disabled = false;
        });

        return false;
    } catch (err) {
        if (submitBtn) submitBtn.disabled = false;
        Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาด',
            text: (err && err.message) ? err.message : 'เกิดข้อผิดพลาด',
            confirmButtonText: 'ตกลง'
        });
        return false;
    }
}

// init
updateQuestionLimitUI();
updateRubricLimitUI();
updateTotalScoreUI();

// default rubric item for new workshop
addRubricItem();

// preload workshop when opened with ?id=...
(function preloadWorkshop() {
    const workshopId = <?php echo (int)$workshop_id; ?>;
    if (!workshopId) return;

    fetch(`../backend/api/get_workshop.php?id=${encodeURIComponent(workshopId)}`)
        .then(async (res) => {
            const data = await res.json().catch(() => null);
            if (!res.ok || !data || !data.success || !data.workshop) {
                throw new Error((data && data.message) ? data.message : 'โหลดข้อมูล workshop ไม่สำเร็จ');
            }
            return data.workshop;
        })
        .then((w) => {
            const form = document.getElementById('workshopForm');
            if (!form) return;

            if (w.open_time_local) form.open_time.value = w.open_time_local;
            if (w.close_time_local) form.close_time.value = w.close_time_local;
            if (w.objective !== undefined) form.objective.value = w.objective;
            if (w.main_concept !== undefined) form.main_concept.value = w.main_concept;
            if (w.instruction !== undefined) form.instruction.value = w.instruction;

            // Reset questions
            const list = document.getElementById('questions-list');
            if (list) list.innerHTML = '';
            questionCount = 0;

            // Reset rubric
            const rlist = document.getElementById('rubric-list');
            if (rlist) rlist.innerHTML = '';
            rubricCount = 0;

            const qs = Array.isArray(w.questions) ? w.questions : [];
            const openQs = qs.filter((q) => (q && q.type === 'open'));
            const choiceQs = qs.filter((q) => !(q && q.type === 'open'));
            if (openQs.length > 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'อัปเดตระบบคำถาม',
                    text: 'ระบบยกเลิกคำถามปลายเปิดแล้ว จึงไม่แสดงคำถามปลายเปิดในหน้านี้',
                    confirmButtonText: 'ตกลง'
                });
            }
            choiceQs.forEach((q) => addQuestion(q));

            const rs = Array.isArray(w.rubric) ? w.rubric : [];
            if (rs.length > 0) {
                rs.forEach((it) => addRubricItem(it));
            } else {
                addRubricItem();
            }

            updateQuestionLimitUI();
            renumberQuestions();
            updateTotalScoreUI();
            updateRubricLimitUI();
            renumberRubricItems();
        })
        .catch((err) => {
            console.error(err);
            // ไม่ alert เพื่อไม่รบกวน ถ้าเป็น workshop ใหม่/ยังไม่มีข้อมูล
        });
})();

// ----------------------------
// Workshop <-> Posts selector
// ----------------------------
const workshopId = <?php echo (int)$workshop_id; ?>;
let allPostsCache = null;
let selectedPostIds = new Set();
let selectedPostsCache = new Map();

function escapeHtml(s) {
    return String(s ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function setPostPickerCount() {
    const el = document.getElementById('postPickerCount');
    if (el) el.textContent = String(selectedPostIds.size);
}

function renderSelectedPosts() {
    const box = document.getElementById('selected-posts');
    if (!box) return;

    const ids = Array.from(selectedPostIds);
    if (ids.length === 0) {
        box.innerHTML = '<div class="p-4 text-gray-400">ยังไม่ได้เลือกโพสต์</div>';
        return;
    }

    const rows = ids.map((id) => {
        const p = selectedPostsCache.get(id) || {};
        const title = escapeHtml(p.title || `Post #${id}`);
        const category = escapeHtml(p.category || '-');
        return `
            <div class="p-3 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <div class="font-medium text-gray-800 truncate">${title}</div>
                    <div class="text-xs text-gray-500 truncate">หมวด: ${category} • ID: ${id}</div>
                </div>
                <button type="button" class="px-3 py-1 text-sm bg-red-50 text-red-700 rounded hover:bg-red-100" data-remove-post="${id}">ลบ</button>
            </div>
        `;
    }).join('');
    box.innerHTML = rows;

    box.querySelectorAll('[data-remove-post]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = parseInt(btn.getAttribute('data-remove-post') || '0', 10);
            if (!id) return;
            selectedPostIds.delete(id);
            selectedPostsCache.delete(id);
            renderSelectedPosts();
            setPostPickerCount();
        });
    });
}

async function fetchAllPosts() {
    if (Array.isArray(allPostsCache)) return allPostsCache;
    const res = await fetch('../backend/api/get_posts.php');
    const data = await res.json().catch(() => null);
    if (!res.ok || !data || !data.success || !Array.isArray(data.data)) {
        throw new Error((data && data.message) ? data.message : 'โหลดโพสต์ไม่สำเร็จ');
    }
    allPostsCache = data.data;
    return allPostsCache;
}

async function fetchSelectedPostsFromServer() {
    const res = await fetch(`../backend/api/get_workshop_posts.php?workshop_id=${encodeURIComponent(String(workshopId))}`);
    const data = await res.json().catch(() => null);
    if (!res.ok || !data || !data.success) {
        throw new Error((data && data.message) ? data.message : 'โหลดโพสต์ที่เลือกไม่สำเร็จ');
    }
    selectedPostIds = new Set(Array.isArray(data.post_ids) ? data.post_ids.map((x) => parseInt(x, 10)).filter(Boolean) : []);
    selectedPostsCache = new Map();
    (Array.isArray(data.posts) ? data.posts : []).forEach((p) => {
        const id = parseInt(p?.id, 10);
        if (!id) return;
        selectedPostsCache.set(id, { id, title: p.title, category: p.category });
    });
    setPostPickerCount();
}

function renderPostPickerList(filterText = '') {
    const list = document.getElementById('postPickerList');
    if (!list) return;
    const q = String(filterText || '').trim().toLowerCase();

    const posts = Array.isArray(allPostsCache) ? allPostsCache : [];
    const filtered = q
        ? posts.filter((p) => String(p?.title || '').toLowerCase().includes(q) || String(p?.category || '').toLowerCase().includes(q))
        : posts;

    if (filtered.length === 0) {
        list.innerHTML = '<div class="p-4 text-gray-400">ไม่พบโพสต์</div>';
        return;
    }

    list.innerHTML = filtered.map((p) => {
        const id = parseInt(p?.id, 10);
        const checked = selectedPostIds.has(id) ? 'checked' : '';
        const title = escapeHtml(p?.title || `Post #${id}`);
        const category = escapeHtml(p?.category || '-');
        return `
            <label class="flex items-start gap-3 p-3 hover:bg-gray-50 cursor-pointer" data-post-row="${id}">
                <input type="checkbox" class="mt-1" data-post-check="${id}" ${checked} />
                <div class="min-w-0">
                    <div class="font-medium text-gray-800 truncate">${title}</div>
                    <div class="text-xs text-gray-500 truncate">หมวด: ${category} • ID: ${id}</div>
                </div>
            </label>
        `;
    }).join('');

    list.querySelectorAll('[data-post-check]').forEach((cb) => {
        cb.addEventListener('change', () => {
            const id = parseInt(cb.getAttribute('data-post-check') || '0', 10);
            if (!id) return;

            if (cb.checked) {
                selectedPostIds.add(id);
                const found = (allPostsCache || []).find((x) => parseInt(x?.id, 10) === id);
                if (found) selectedPostsCache.set(id, { id, title: found.title, category: found.category });
            } else {
                selectedPostIds.delete(id);
                selectedPostsCache.delete(id);
            }
            setPostPickerCount();
        });
    });
}

function openPostPicker() {
    const modal = document.getElementById('postPickerModal');
    if (!modal) return;
    modal.classList.remove('hidden');
}

function closePostPicker() {
    const modal = document.getElementById('postPickerModal');
    if (!modal) return;
    modal.classList.add('hidden');
}

async function initPostPicker(openModal = false) {
    try {
        const list = document.getElementById('postPickerList');
        if (list) list.innerHTML = '<div class="p-4 text-gray-400">กำลังโหลด...</div>';
        await fetchSelectedPostsFromServer();
        await fetchAllPosts();
        const search = document.getElementById('postPickerSearch');
        renderPostPickerList(search ? search.value : '');
        renderSelectedPosts();
        if (openModal) openPostPicker();
    } catch (err) {
        console.error(err);
        Swal.fire({ icon: 'error', title: 'โหลดข้อมูลไม่สำเร็จ', text: (err && err.message) ? err.message : 'เกิดข้อผิดพลาด' });
    }
}

async function saveSelectedPosts() {
    try {
        Swal.fire({
            title: 'กำลังบันทึก... ',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading(),
        });

        const post_ids = Array.from(selectedPostIds);
        const res = await fetch('../backend/api/set_workshop_posts.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ workshop_id: workshopId, post_ids }),
        });
        const data = await res.json().catch(() => null);
        if (!res.ok || !data || !data.success) {
            throw new Error((data && data.message) ? data.message : 'บันทึกไม่สำเร็จ');
        }

        Swal.close();
        closePostPicker();
        renderSelectedPosts();
        Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', text: `บันทึก ${data.count ?? post_ids.length} โพสต์` });
    } catch (err) {
        Swal.close();
        Swal.fire({ icon: 'error', title: 'บันทึกไม่สำเร็จ', text: (err && err.message) ? err.message : 'เกิดข้อผิดพลาด' });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const openBtn = document.getElementById('openPostPickerBtn');
    const refreshBtn = document.getElementById('refreshPostPickerBtn');
    const saveBtn = document.getElementById('postPickerSave');
    const search = document.getElementById('postPickerSearch');
    const selectAllBtn = document.getElementById('postPickerSelectAll');
    const clearAllBtn = document.getElementById('postPickerClearAll');

    openBtn?.addEventListener('click', () => initPostPicker(true));
    refreshBtn?.addEventListener('click', () => {
        allPostsCache = null;
        initPostPicker(false);
    });
    saveBtn?.addEventListener('click', saveSelectedPosts);
    search?.addEventListener('input', () => renderPostPickerList(search.value));

    selectAllBtn?.addEventListener('click', () => {
        const posts = Array.isArray(allPostsCache) ? allPostsCache : [];
        posts.forEach((p) => {
            const id = parseInt(p?.id, 10);
            if (!id) return;
            selectedPostIds.add(id);
            selectedPostsCache.set(id, { id, title: p.title, category: p.category });
        });
        setPostPickerCount();
        renderPostPickerList(search ? search.value : '');
    });

    clearAllBtn?.addEventListener('click', () => {
        selectedPostIds = new Set();
        selectedPostsCache = new Map();
        setPostPickerCount();
        renderPostPickerList(search ? search.value : '');
    });

    document.querySelectorAll('[data-close-post-picker]').forEach((el) => {
        el.addEventListener('click', closePostPicker);
    });

    // initial load of selected posts panel (no modal)
    initPostPicker(false);
});
</script>