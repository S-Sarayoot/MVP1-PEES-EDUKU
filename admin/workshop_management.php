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
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200">
                
                    <form id="workshopForm" class="flex flex-col gap-6 bg-white rounded-lg  p-6 max-w-3xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block font-semibold mb-1">เวลาเปิด</label>
                                <input type="datetime-local" name="open_time" class="w-full border border-gray-200 rounded px-2 py-1" required>
                            </div>
                            <div>
                                <label class="block font-semibold mb-1">เวลาปิด</label>
                                <input type="datetime-local" name="close_time" class="w-full border border-gray-200 rounded px-2 py-1" required>
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">วัตถุประสงค์</label>
                            <textarea name="objective" class="w-full border border-gray-200 rounded px-2 py-1" rows="2" required></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">คำชี้แจง</label>
                            <textarea name="instruction" class="w-full border border-gray-200 rounded px-2 py-1" rows="2" required></textarea>
                        </div>
                        <div>
                            <label class="block font-semibold mb-1">ข้อคำถาม</label>
                            <div id="questions-list" class="flex flex-col gap-4">
                                
                            </div>
                            <button id="add-question-btn" type="button" onclick="addQuestion()" class="mt-2 px-4 py-1 bg-green-100 text-green-800 rounded">+ เพิ่มคำถาม</button>
                            <div id="question-limit-hint" class="text-xs text-gray-500 mt-1">เพิ่มได้ไม่เกิน 10 ข้อ</div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-6 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">บันทึก Workshop</button>
                        </div>
                        <div class="text-xs text-gray-500 mt-2">* คะแนนรวมทุกข้อควรเท่ากับ 100 คะแนน</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
const MAX_QUESTIONS = 10;
const MAX_CHOICES = 4;
let questionCount = 0;

const CHOICE_LABELS = ['A', 'B', 'C', 'D'];

function setChoiceEnabled(idx, enabled) {
    const wrap = document.getElementById('choices-' + idx);
    if (!wrap) return;

    // Text inputs
    wrap.querySelectorAll('input[type="text"]').forEach((el) => {
        el.disabled = !enabled;
        el.required = enabled;
    });

    // Radios (not required by default; we validate ourselves on submit)
    wrap.querySelectorAll('input[type="radio"]').forEach((el) => {
        el.disabled = !enabled;
        if (!enabled) el.checked = false;
    });
}

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
    const qType = q && q.type ? q.type : 'choice';
    const qText = q && q.text ? q.text : '';
    const qScore = q && q.score ? q.score : '';
    const qChoices = q && q.choices ? q.choices : ['',''];
    const qAnswer = q && q.answer ? q.answer : '';
    const qOpenAnswer = q && (q.open_answer !== undefined) ? q.open_answer : '';
    const qRubricDesc = q && Array.isArray(q.rubric_desc) ? q.rubric_desc : ['','','','',''];
    const qRubricScore = q && Array.isArray(q.rubric_score) ? q.rubric_score : ['','','','',''];
    const qOpen = qType === 'open';
    const currentDisplayNo = getCurrentQuestionCount() + 1;
    const choiceRequiredAttr = qOpen ? '' : 'required';
    const html = `
    <div class="border border-gray-200 rounded p-4 shadow-sm bg-gray-50 relative" data-idx="${idx}">
        <button type="button" onclick="removeQuestion(this)" class="absolute top-2 right-2 text-red-500">&times;</button>
        <div class="flex items-center justify-between mb-2">
            <div class="font-semibold text-[#433878]" data-qtitle>ข้อที่ ${currentDisplayNo}</div>
        </div>
        <div class="flex flex-col md:flex-row gap-2 mb-2">
            <input type="text" name="question_text[]" class="flex-1 border border-gray-200 rounded px-2 py-1" placeholder="พิมพ์คำถาม..." value="${qText}" required>
            <select name="question_type[]" class="border border-gray-200 rounded px-2 py-1" onchange="toggleType(this, ${idx})">
                <option value="choice" ${!qOpen ? 'selected' : ''}>แบบตัวเลือก</option>
                <option value="open" ${qOpen ? 'selected' : ''}>ปลายเปิด</option>
            </select>
            <input type="number" name="question_score[]" class="w-24 border border-gray-200 rounded px-2 py-1" placeholder="คะแนน" min="1" max="100" value="${qScore}" required>
        </div>
        <div id="choices-${idx}" data-choices-wrap style="display:${qOpen ? 'none':'block'}">
            ${(qChoices||['','']).map((c,i) => {
                const label = CHOICE_LABELS[i] || (i + 1);
                return `
                <div class="flex gap-2 mb-1" data-choice-row>
                    <div class="w-8 text-gray-600 font-semibold flex items-center justify-center" data-choice-label>${label}</div>
                    <input type="text" name="choice_${idx}[]" class="flex-1 border border-gray-200 rounded px-2 py-1" placeholder="ตัวเลือก ${label}" value="${c||''}" ${choiceRequiredAttr}>
                    <input type="radio" name="answer_${idx}" value="${i}" ${qAnswer==i?'checked':''}> เฉลย
                    <button type="button" onclick="removeChoice(this, ${idx})" class="text-red-400">ลบ</button>
                </div>
            `;
            }).join('')}
            <button type="button" data-add-choice-btn onclick="addChoice(${idx})" class="text-green-700 mt-1">+ เพิ่มตัวเลือก</button>
        </div>
        <div id="open-${idx}" style="display:${qOpen ? 'block':'none'}">
            <label class="block text-sm font-semibold text-gray-700 mt-2">คำตอบตัวอย่าง (ถ้ามี)</label>
            <input type="text" name="open_answer_${idx}" class="border border-gray-200 rounded px-2 py-1 w-full mt-1" placeholder="ตัวอย่างคำตอบ..." value="${qOpenAnswer || ''}">

            <div class="mt-4 border border-gray-200 rounded p-3 bg-white">
                <div class="font-semibold text-gray-700 mb-2">Rubric score (5 ระดับ)</div>
                <div class="grid grid-cols-1 gap-2">
                    ${[5,4,3,2,1].map((level, levelIdx) => `
                        <div class=\"grid grid-cols-12 gap-2 items-center\">
                            <div class=\"col-span-12 md:col-span-2 text-sm font-semibold text-gray-600\">ระดับ ${level}</div>
                            <div class=\"col-span-12 md:col-span-8\">
                                <input type=\"text\" name=\"rubric_desc_${idx}[]\" class=\"w-full border border-gray-200 rounded px-2 py-1\" placeholder=\"คำอธิบายระดับ ${level}\" value=\"${(qRubricDesc[levelIdx] ?? '').toString().replace(/\"/g,'&quot;')}\" required>
                            </div>
                            <div class=\"col-span-12 md:col-span-2\">
                                <input type=\"number\" name=\"rubric_score_${idx}[]\" class=\"w-full border border-gray-200 rounded px-2 py-1\" placeholder=\"คะแนน\" min=\"0\" max=\"100\" value=\"${qRubricScore[levelIdx] ?? ''}\" required>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <div class="text-xs text-gray-500 mt-2">* ระบุคะแนนของแต่ละระดับตาม rubric ของข้อนี้</div>
            </div>
        </div>
    </div>`;
    document.getElementById('questions-list').insertAdjacentHTML('beforeend', html);
    updateQuestionLimitUI();
    renumberQuestions();
    updateChoiceLimitUI(idx);

    // Ensure hidden choice inputs don't break HTML validation
    setChoiceEnabled(idx, !qOpen);

    // init required for rubric fields (open only)
    const openWrap = document.getElementById('open-' + idx);
    if (openWrap) {
        openWrap.querySelectorAll('input').forEach(el => {
            if (el.name && (el.name.startsWith('rubric_desc_') || el.name.startsWith('rubric_score_'))) {
                el.required = (qType === 'open');
            }
        });
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
function toggleType(sel, idx) {
    const isOpen = sel.value === 'open';
    document.getElementById('choices-'+idx).style.display = isOpen ? 'none' : 'block';
    document.getElementById('open-'+idx).style.display = isOpen ? 'block' : 'none';

    // Disable/enable choice controls so hidden required inputs don't block submit
    setChoiceEnabled(idx, !isOpen);

    // เมื่อเปลี่ยนไปเป็นแบบตัวเลือก ให้ปิด required ของ rubric (เพื่อไม่ให้ submit ติด)
    const openWrap = document.getElementById('open-' + idx);
    if (openWrap) {
        openWrap.querySelectorAll('input, textarea, select').forEach(el => {
            if (el.name && (el.name.startsWith('rubric_desc_') || el.name.startsWith('rubric_score_'))) {
                el.required = isOpen;
            }
        });
    }
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
            const typeEl = card.querySelector('select[name="question_type[]"]');
            const scoreEl = card.querySelector('input[name="question_score[]"]');

            const qText = (textEl ? textEl.value : '').trim();
            const qType = (typeEl ? typeEl.value : 'choice');
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

            if (qType === 'choice') {
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
            } else {
                const openWrap = document.getElementById('open-' + idx);
                const openAnswerEl = openWrap ? openWrap.querySelector('input[name="open_answer_' + idx + '"]') : null;
                const rubricDescEls = openWrap ? openWrap.querySelectorAll('input[name="rubric_desc_' + idx + '[]"]') : [];
                const rubricScoreEls = openWrap ? openWrap.querySelectorAll('input[name="rubric_score_' + idx + '[]"]') : [];

                const rubric_desc = Array.from(rubricDescEls).map(el => (el.value || '').trim());
                const rubric_score = Array.from(rubricScoreEls).map(el => parseInt(el.value || '0', 10) || 0);

                if (rubric_desc.length !== 5 || rubric_score.length !== 5) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Rubric ไม่ครบ',
                        text: 'Rubric ต้องมีครบ 5 ระดับ',
                        confirmButtonText: 'ตกลง'
                    });
                    return false;
                }
                if (rubric_desc.some(d => !d)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Rubric ไม่ครบ',
                        text: 'กรุณากรอกคำอธิบาย rubric ให้ครบทุกระดับ',
                        confirmButtonText: 'ตกลง'
                    });
                    return false;
                }

                questions.push({
                    type: 'open',
                    text: qText,
                    score: qScore,
                    open_answer: (openAnswerEl ? (openAnswerEl.value || '').trim() : ''),
                    rubric_desc,
                    rubric_score,
                });
            }
        }

        const payload = {
            workshop_id: <?php echo (int)$workshop_id; ?>,
            open_time: form.open_time.value,
            close_time: form.close_time.value,
            objective: form.objective.value,
            instruction: form.instruction.value,
            questions,
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
                confirmButtonText: 'ตกลง'
            });
            // location.href = 'workshop_admin.php';
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
            if (w.instruction !== undefined) form.instruction.value = w.instruction;

            // Reset questions
            const list = document.getElementById('questions-list');
            if (list) list.innerHTML = '';
            questionCount = 0;

            const qs = Array.isArray(w.questions) ? w.questions : [];
            qs.forEach((q) => addQuestion(q));

            updateQuestionLimitUI();
            renumberQuestions();
        })
        .catch((err) => {
            console.error(err);
            // ไม่ alert เพื่อไม่รบกวน ถ้าเป็น workshop ใหม่/ยังไม่มีข้อมูล
        });
})();
</script>