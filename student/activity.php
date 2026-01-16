<?php
require_once __DIR__ . '/base.php';

$workshopId = isset($_GET['workshop']) ? intval($_GET['workshop']) : 0;
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptParts = explode('/', trim($scriptName, '/'));
$appBase = '/' . ($scriptParts[0] ?? '');
?>

	<title>EquityLearnKU - กิจกรรม Workshop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
		<!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>


		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			<div class="bg-white p-4 rounded-lg shadow-md">
				<h1 id="ws-title" class="text-2xl font-bold mx-2mt-2">Workshop#<?php echo htmlspecialchars((string)$workshopId); ?> กิจกรรม</h1>
				<div class="flex flex-col md:flex-row w-full gap-4 mt-4">
					<div class="w-full md:w-1/3">
						<div class="border-2 border-purple-200 p-4 rounded-lg">
							<div>
								<h2 class="text-xl underline font-bold text-purple-800">คำชี้แจง</h2>
								<p id="ws-instruction" class="text-gray-700">-</p>
								<p id="ws-time" class="text-sm text-gray-500 mt-2">เวลา: -</p>
							</div>

							<div class="mt-4">
								<h2 class="text-xl font-bold">วัตถุประสงค์</h2>
								<p id="ws-objective" class="text-gray-700 mt-1">-</p>
							</div>

							<div class="mt-4">
								<h2 class="text-xl font-bold">ทรัพยากรที่เกี่ยวข้อง</h2>
								<ul class="list-disc list-inside mt-2">
									<li><a id="ws-storage-link" href="#" class="text-purple-600 hover:underline">คลังทรัพยากรของ Workshop นี้</a></li>
								</ul>
							</div>

							<details id="ws-rubric" class="mt-4">
								<summary class="text-xl font-bold cursor-pointer select-none">Rubrics (ดูแนวทางประเมิน)</summary>
								<div id="ws-rubric-body" class="text-sm text-gray-700 mt-2">-</div>
							</details>

							<div class="mt-4">
								<a id="ws-reflection-link" href="#" class="w-full block text-center px-4 py-2 border-2 border-purple-500 text-purple-500 font-bold hover:bg-purple-500 hover:text-white rounded-lg my-4 cursor-pointer">สะท้อนคิด</a>
							</div>
						</div>
					</div>

					<div class="w-full md:w-2/3">
						<div class="px-1">
							<div class="mb-4 flex items-center justify-between gap-2">
								<div class="font-semibold">ทำแบบทดสอบ / ตอบคำถาม</div>
								<div class="text-right">
									<div id="ws-status" class="text-sm text-gray-500">-</div>
									<div id="ws-submission" class="text-xs text-blue-600"></div>
								</div>
							</div>

							<div id="ws-loading" class="flex justify-center items-center w-full py-10">
								<img src="<?php echo htmlspecialchars($appBase); ?>/image/loading.gif" alt="loading" class="w-16 h-16">
							</div>
							<div id="ws-error" class="hidden p-4 text-red-600 bg-red-50 border border-red-200 rounded"></div>

							<form id="activityForm" class="hidden">
								<div id="ws-questions" class="flex flex-col gap-4"></div>
								<div class="mt-6 flex items-center justify-end gap-2">
									<button id="saveDraftBtn" type="button" class="px-4 py-2 border border-purple-300 text-purple-700 rounded-lg hover:bg-purple-50">บันทึกฉบับร่าง</button>
									<button id="submitBtn" type="submit" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-700">ส่งคำตอบ</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</body>
</html>

<script>
	(() => {
		const workshopId = <?php echo (int)$workshopId; ?>;
		const APP_BASE = <?php echo json_encode($appBase, JSON_UNESCAPED_SLASHES); ?>;

		const elTitle = document.getElementById('ws-title');
		const elInstruction = document.getElementById('ws-instruction');
		const elObjective = document.getElementById('ws-objective');
		const elTime = document.getElementById('ws-time');
		const elStatus = document.getElementById('ws-status');
		const elSubmission = document.getElementById('ws-submission');
		const elRubricBody = document.getElementById('ws-rubric-body');
		const elStorageLink = document.getElementById('ws-storage-link');
		const elReflectionLink = document.getElementById('ws-reflection-link');
		const elLoading = document.getElementById('ws-loading');
		const elError = document.getElementById('ws-error');
		const form = document.getElementById('activityForm');
		const questionsWrap = document.getElementById('ws-questions');
		const saveDraftBtn = document.getElementById('saveDraftBtn');
		const submitBtn = document.getElementById('submitBtn');

		const escapeHtml = (v) => String(v ?? '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');

		const parseLocalDatetime = (value) => {
			if (!value) return null;
			const d = new Date(String(value));
			return Number.isNaN(d.getTime()) ? null : d;
		};

		const computeStatus = (workshop) => {
			const now = new Date();
			const open = parseLocalDatetime(workshop?.open_time_local);
			const close = parseLocalDatetime(workshop?.close_time_local);
			if (!open || !close) return 'upcoming';
			if (now < open) return 'upcoming';
			if (now > close) return 'close';
			return 'active';
		};

		const setError = (msg) => {
			if (elLoading) elLoading.classList.add('hidden');
			if (form) form.classList.add('hidden');
			if (elError) {
				elError.textContent = msg;
				elError.classList.remove('hidden');
			}
		};

		const draftKey = `elk_activity_draft_workshop_${workshopId}`;
		const saveDraft = () => {
			if (!form) return;
			const payload = collectAnswers();
			localStorage.setItem(draftKey, JSON.stringify(payload));
			Swal.fire({ icon: 'success', title: 'บันทึกฉบับร่างแล้ว', timer: 1200, showConfirmButton: false });
		};

		const loadDraft = () => {
			try {
				const raw = localStorage.getItem(draftKey);
				if (!raw) return null;
				const parsed = JSON.parse(raw);
				return parsed && typeof parsed === 'object' ? parsed : null;
			} catch {
				return null;
			}
		};

		const collectAnswers = () => {
			const answers = [];
			if (!questionsWrap) return { workshop_id: workshopId, answers };
			questionsWrap.querySelectorAll('[data-q-idx]').forEach((card) => {
				const idx = Number(card.getAttribute('data-q-idx') || '0');
				const type = card.getAttribute('data-q-type') || 'choice';
				if (type === 'choice') {
					const checked = card.querySelector('input[type="radio"]:checked');
					answers.push({ index: idx, type, answer: checked ? checked.value : null });
				} else {
					const textarea = card.querySelector('textarea');
					answers.push({ index: idx, type, answer: textarea ? textarea.value : '' });
				}
			});
			return { workshop_id: workshopId, answers };
		};

		const applyDraftToUI = (draft) => {
			if (!draft || !Array.isArray(draft.answers) || !questionsWrap) return;
			for (const a of draft.answers) {
				const card = questionsWrap.querySelector(`[data-q-idx="${a.index}"]`);
				if (!card) continue;
				const type = card.getAttribute('data-q-type') || 'choice';
				if (type === 'choice') {
					const input = card.querySelector(`input[type="radio"][value="${CSS.escape(String(a.answer ?? ''))}"]`);
					if (input) input.checked = true;
				} else {
					const textarea = card.querySelector('textarea');
					if (textarea && typeof a.answer === 'string') textarea.value = a.answer;
				}
			}
		};

		const renderChoiceQuestion = (q, index) => {
			const choices = Array.isArray(q?.choices) ? q.choices : [];
			const label = `ข้อที่ ${index + 1} (คะแนน ${Number(q?.score || 0) || 0})`;
			const name = `q_${index}`;
			return `
				<div class="border border-gray-200 rounded-lg p-4 bg-white" data-q-idx="${index}" data-q-type="choice">
					<div class="font-semibold text-purple-800">${escapeHtml(label)}</div>
					<div class="mt-2 text-gray-800">${escapeHtml(q?.text || '-')}</div>
					<div class="mt-3 flex flex-col gap-2">
						${choices.map((c, i) => `
							<label class="flex items-start gap-2 text-sm">
								<input type="radio" name="${escapeHtml(name)}" value="${i}" class="mt-1" required>
								<span>${escapeHtml(c)}</span>
							</label>
						`).join('')}
					</div>
				</div>
			`;
		};

		const renderOpenQuestion = (q, index) => {
			const label = `ข้อที่ ${index + 1} (คะแนน ${Number(q?.score || 0) || 0})`;
			const rubricDesc = Array.isArray(q?.rubric_desc) ? q.rubric_desc : [];
			const openAnswer = q?.open_answer ? String(q.open_answer) : '';
			return `
				<div class="border border-gray-200 rounded-lg p-4 bg-white" data-q-idx="${index}" data-q-type="open">
					<div class="font-semibold text-purple-800">${escapeHtml(label)}</div>
					<div class="mt-2 text-gray-800">${escapeHtml(q?.text || '-')}</div>
					<textarea class="mt-3 w-full border border-purple-300 rounded-lg p-3 outline-none focus:ring focus:ring-purple-200" rows="5" required></textarea>
					${openAnswer ? `<div class="text-xs text-gray-500 mt-2">คำตอบตัวอย่าง: ${escapeHtml(openAnswer)}</div>` : ''}
					${rubricDesc.length === 5 ? `
						<details class="mt-3">
							<summary class="text-sm font-semibold cursor-pointer select-none text-gray-700">ดู Rubric ของข้อนี้</summary>
							<div class="mt-2 text-sm text-gray-700 space-y-1">
								${[5,4,3,2,1].map((level, i) => `<div><span class="font-semibold">ระดับ ${level}:</span> ${escapeHtml(rubricDesc[i] || '')}</div>`).join('')}
							</div>
						</details>
					` : ''}
				</div>
			`;
		};

		if (!workshopId) {
			setError('กรุณาเลือก Workshop จากหน้ารวม Workshop');
			if (elStatus) elStatus.textContent = 'missing workshop id';
			return;
		}

		//if (elStorageLink) elStorageLink.href = `../student/storage.php?workshop=${encodeURIComponent(String(workshopId))}`;
        if (elStorageLink) elStorageLink.href = `../student/post?id=25`;
		if (elReflectionLink) elReflectionLink.href = `../student/reflection.php?workshop=${encodeURIComponent(String(workshopId))}`;

		// Submission indicator: show if user has already submitted at least once
		fetch(`../backend/api/get_my_workshop_attempts.php?workshop_id=${encodeURIComponent(String(workshopId))}`)
			.then((res) => res.json())
			.then((payload) => {
				const map = payload?.by_workshop_id || {};
				const attempt = map[String(workshopId)] || (Array.isArray(payload?.attempts) ? payload.attempts[0] : null);
				if (attempt && attempt.attempt_id) {
					if (elSubmission) elSubmission.textContent = 'มีการส่งคำตอบแล้ว';
				}
			})
			.catch(() => {});

		fetch(`../backend/api/get_workshop.php?id=${encodeURIComponent(String(workshopId))}`)
			.then((res) => res.json())
			.then((payload) => {
				if (!payload?.success || !payload.workshop) {
					throw new Error(payload?.message || 'โหลดข้อมูล workshop ไม่สำเร็จ');
				}
				return payload.workshop;
			})
			.then((w) => {
				if (elTitle) elTitle.textContent = `Workshop#${w.id} กิจกรรม`;
				if (elInstruction) elInstruction.textContent = w.instruction || '-';
				if (elObjective) elObjective.textContent = w.objective || '-';
				if (elTime) {
					const open = w.open_time_local || w.open_time || '-';
					const close = w.close_time_local || w.close_time || '-';
					elTime.textContent = `เวลาเปิด: ${String(open).replace('T',' ')} | เวลาปิด: ${String(close).replace('T',' ')}`;
				}

				const status = computeStatus(w);
				if (elStatus) elStatus.textContent = `สถานะ: ${status}`;

				const isActive = status === 'active';
				if (submitBtn) submitBtn.disabled = !isActive;
				if (saveDraftBtn) saveDraftBtn.disabled = !isActive;

				const qs = Array.isArray(w.questions) ? w.questions : [];
				if (!questionsWrap) return;

				if (qs.length === 0) {
					questionsWrap.innerHTML = '<div class="p-4 text-gray-400 bg-gray-50 border border-gray-200 rounded">ยังไม่มีข้อคำถามสำหรับ Workshop นี้</div>';
				} else {
					questionsWrap.innerHTML = qs.map((q, idx) => {
						if ((q?.type || 'choice') === 'open') return renderOpenQuestion(q, idx);
						return renderChoiceQuestion(q, idx);
					}).join('');
				}

				if (elRubricBody) {
					const openQs = qs.filter((q) => (q?.type || '') === 'open');
					if (openQs.length === 0) {
						elRubricBody.textContent = 'Workshop นี้ไม่มีข้อคำถามปลายเปิด';
					} else {
						elRubricBody.innerHTML = openQs.map((q, i) => {
							const rubricDesc = Array.isArray(q?.rubric_desc) ? q.rubric_desc : [];
							return `
								<div class="mt-3">
									<div class="font-semibold">ข้อปลายเปิด #${i + 1}:</div>
									<div class="text-gray-700">${escapeHtml(q?.text || '-')}</div>
									${rubricDesc.length === 5 ? `<div class="mt-2 text-sm space-y-1">${[5,4,3,2,1].map((lvl, idx) => `<div><span class=\"font-semibold\">ระดับ ${lvl}:</span> ${escapeHtml(rubricDesc[idx] || '')}</div>`).join('')}</div>` : '<div class="text-sm text-gray-500">ไม่มี rubric</div>'}
								</div>
							`;
						}).join('');
					}
				}

				if (elLoading) elLoading.classList.add('hidden');
				if (elError) elError.classList.add('hidden');
				if (form) form.classList.remove('hidden');

				const draft = loadDraft();
				if (draft) applyDraftToUI(draft);
			})
			.catch((err) => {
				console.error(err);
				setError((err && err.message) ? err.message : 'ไม่สามารถโหลดข้อมูลได้');
			});

		if (saveDraftBtn) {
			saveDraftBtn.addEventListener('click', (e) => {
				e.preventDefault();
				saveDraft();
			});
		}

		if (form) {
			form.addEventListener('submit', (e) => {
				e.preventDefault();
				const payload = collectAnswers();

				const hasMissing = payload.answers.some((a) => a.answer === null || String(a.answer).trim() === '');
				if (hasMissing) {
					Swal.fire({ icon: 'warning', title: 'ข้อมูลไม่ครบ', text: 'กรุณาตอบคำถามให้ครบทุกข้อ' });
					return;
				}

				if (submitBtn) submitBtn.disabled = true;
				Swal.fire({
					title: 'กำลังส่งคำตอบ...',
					allowOutsideClick: false,
					allowEscapeKey: false,
					didOpen: () => Swal.showLoading(),
				});

				fetch(`../backend/api/submit_workshop_attempt.php`, {
					method: 'POST',
					headers: { 'Content-Type': 'application/json' },
					body: JSON.stringify({
						workshop_id: workshopId,
						answers: payload.answers,
					}),
				})
					.then((res) => res.json().then((j) => ({ ok: res.ok, json: j })).catch(() => ({ ok: res.ok, json: null })))
					.then(({ ok, json }) => {
						if (!ok || !json || !json.success) {
							throw new Error((json && json.message) ? json.message : 'ส่งคำตอบไม่สำเร็จ');
						}

						// store latest payload as draft too
						localStorage.setItem(draftKey, JSON.stringify(payload));
						localStorage.setItem(`elk_activity_last_attempt_workshop_${workshopId}`, String(json.attempt_id || ''));
						const pendingManual = Boolean(json.pending_manual);
                        
                        // คะแนนปลายเปิดต้องรอผู้สอนให้คะแนน มีคะแนนอัตโนมัติเ
						Swal.fire({
							icon: 'success',
							title: 'ส่งคำตอบสำเร็จ',
							html: pendingManual
								? `<div>ระบบได้รับคำตอบแล้ว</div><div style="color:#6b7280">ข้อปลายเปิดรอผู้ประเมินให้คะแนน</div>`
								: `<div>ระบบได้รับคำตอบแล้ว</div>`,
							confirmButtonText: 'ตกลง',
						}).then(() => {
							window.location.href = `../student/workshop.php`;
						});
					})
					.catch((err) => {
						Swal.fire({
							icon: 'error',
							title: 'ส่งคำตอบไม่สำเร็จ',
							text: (err && err.message) ? err.message : 'ส่งคำตอบไม่สำเร็จ',
							confirmButtonText: 'ตกลง'
						});
					})
					.finally(() => {
						if (submitBtn) submitBtn.disabled = false;
					});
			});
		}
	})();
</script>
