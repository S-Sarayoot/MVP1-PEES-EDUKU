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
			<div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">Workshop</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="./"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > <a href="./workshop" class="text-gray-400  hover:font-semibold hover:text-[#433878]">Workshop</a> > activity</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
				<h1 id="ws-title" class="text-2xl font-bold mx-2mt-2">Workshop#<?php echo htmlspecialchars((string)$workshopId); ?> กิจกรรม</h1>
				<div class="mt-4 flex flex-col gap-4">
					<!-- 1) Intro: long paragraphs first -->
					<div class="border-2 border-purple-200 p-4 rounded-lg bg-white">
						<div>
							<h2 class="text-xl  font-bold">คำชี้แจง</h2>
							<p id="ws-instruction" class="text-gray-700 whitespace-pre-line">-</p>
							<p id="ws-time" class="text-sm text-gray-500 mt-2">เวลา: -</p>
						</div>

						<div class="mt-4">
							<h2 class="text-xl font-bold">วัตถุประสงค์</h2>
							<p id="ws-objective" class="text-gray-700 mt-1 whitespace-pre-line">-</p>
						</div>

						<div class="mt-4">
							<h2 class="text-xl font-bold">แนวคิดหลัก</h2>
							<p id="ws-main-concept" class="text-gray-700 mt-1 whitespace-pre-line">-</p>
						</div>
					</div>

					<!-- 2) Questions -->
					<div class="px-1">
						<div class="mb-4 flex items-center justify-between gap-2">
							<div class="font-semibold">ทำแบบทดสอบ / ตอบคำถาม</div>
							<div class="text-right">
								<div id="ws-status" class="text-sm text-gray-500">-</div>
								<div id="ws-submission" class="text-xs text-blue-600"></div>
							</div>
						</div>
						<div class="mb-3 p-3 rounded-lg border border-purple-200 bg-purple-50 text-sm text-purple-900">
							โหมดดูรายละเอียดเท่านั้น (ปิดการตอบคำถาม)
						</div>

						<div id="ws-loading" class="flex justify-center items-center w-full py-10">
							<img src="<?php echo htmlspecialchars($appBase); ?>/image/loading.gif" alt="loading" class="w-16 h-16">
						</div>
						<div id="ws-error" class="hidden p-4 text-red-600 bg-red-50 border border-red-200 rounded"></div>

						<form id="activityForm" class="hidden">
							<div id="ws-questions" class="flex flex-col gap-4"></div>
						</form>
					</div>

					<!-- 3) Reflection -->
					<div>
						<a id="ws-reflection-link" href="#" class="w-full block text-center px-4 py-2 border-2 border-purple-500 text-purple-500 font-bold hover:bg-purple-500 hover:text-white rounded-lg cursor-pointer">สะท้อนคิด</a>
					</div>

					<!-- 4) Rubric score -->
					<details id="ws-rubric" class="border border-gray-200 rounded-lg p-4 bg-white">
						<summary class="text-xl font-bold cursor-pointer select-none">เกณฑ์การให้คะแนน Rubric score</summary>
						<div id="ws-rubric-body" class="text-sm text-gray-700 mt-2">-</div>
					</details>

					<!-- 5) Resources (last) -->
					<div class="border border-gray-200 rounded-lg p-4 bg-white">
						<h2 class="text-xl font-bold">ทรัพยากรที่เกี่ยวข้อง</h2>
						<ul id="ws-resources" class="list-disc list-inside mt-2">
							<li class="text-gray-500">-</li>
						</ul>
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
		const elMainConcept = document.getElementById('ws-main-concept');
		const elTime = document.getElementById('ws-time');
		const elStatus = document.getElementById('ws-status');
		const elSubmission = document.getElementById('ws-submission');
		const elRubricBody = document.getElementById('ws-rubric-body');
		const elResources = document.getElementById('ws-resources');
		const elReflectionLink = document.getElementById('ws-reflection-link');
		const elLoading = document.getElementById('ws-loading');
		const elError = document.getElementById('ws-error');
		const form = document.getElementById('activityForm');
		const questionsWrap = document.getElementById('ws-questions');

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

			const renderChoiceQuestion = (q, originalIndex, displayIndex) => {
			const choices = Array.isArray(q?.choices) ? q.choices : [];
				const label = `ข้อที่ ${displayIndex + 1} (คะแนน ${Number(q?.score || 0) || 0})`;
			return `
					<div class="border border-gray-200 rounded-lg p-4 bg-white" data-q-idx="${originalIndex}">
					<div class="font-semibold text-purple-800">${escapeHtml(label)}</div>
					<div class="mt-2 text-gray-800">${escapeHtml(q?.text || '-')}</div>
					<ul class="mt-3 list-disc list-inside text-sm text-gray-700">
						${choices.map((c) => `<li>${escapeHtml(c)}</li>`).join('')}
					</ul>
				</div>
			`;
		};

			const normalizeRubricItem = (item) => {
				const title = String(item?.title ?? '').trim();
				const levelCount = Number(item?.level_count ?? 0);
				const desc = Array.isArray(item?.desc) ? item.desc.map((x) => String(x ?? '').trim()) : [];
				if (!title) return null;
				if (![3, 5].includes(levelCount)) return null;
				if (desc.length !== levelCount) return null;
				return { title, level_count: levelCount, desc };
			};

			const rubricHeaders = (levelCount) => {
				if (levelCount === 3) {
					return [
						{ level: 3, label: 'ระดับ 3\nดีมาก' },
						{ level: 2, label: 'ระดับ 2\nพอใช้' },
						{ level: 1, label: 'ระดับ 1\nควรปรับปรุง' },
					];
				}
				return [
					{ level: 5, label: 'ระดับ 5\nดีมาก' },
					{ level: 4, label: 'ระดับ 4\nดี' },
					{ level: 3, label: 'ระดับ 3\nปานกลาง' },
					{ level: 2, label: 'ระดับ 2\nพอใช้' },
					{ level: 1, label: 'ระดับ 1\nควรปรับปรุง' },
				];
			};

			const renderRubricTable = (items, levelCount, title = '') => {
				const headers = rubricHeaders(levelCount);
				const headerHtml = headers.map((h) => {
					return `<th class="border border-gray-300 px-3 py-2 text-center font-semibold whitespace-pre-line">${escapeHtml(h.label)}</th>`;
				}).join('');

				const rowsHtml = items.map((it, i) => {
					const cells = headers.map((h, headerIdx) => {
						// Desc array is stored highest->lowest (e.g., for 5: [5,4,3,2,1])
						return `<td class="border border-gray-300 px-3 py-2 align-top whitespace-pre-line">${escapeHtml(it.desc[headerIdx] || '')}</td>`;
					}).join('');
					return `
						<tr>
							<td class="border border-gray-300 px-3 py-2 align-top font-semibold">${escapeHtml(String(i + 1) + '. ' + it.title)}</td>
							${cells}
						</tr>
					`;
				}).join('');

				const heading = title
					? `<div class="font-semibold text-gray-800 mb-2">${escapeHtml(title)}</div>`
					: '';

				return `
					${heading}
					<div class="overflow-x-auto">
						<table class="w-full border-collapse text-sm">
							<thead>
								<tr class="bg-gray-50">
									<th class="border border-gray-300 px-3 py-2 text-left font-semibold">ประเด็นประเมิน</th>
									${headerHtml}
								</tr>
							</thead>
							<tbody>
								${rowsHtml}
							</tbody>
						</table>
					</div>
				`;
			};

		if (!workshopId) {
			setError('กรุณาเลือก Workshop จากหน้ารวม Workshop');
			if (elStatus) elStatus.textContent = 'missing workshop id';
			return;
		}

		const setResourcesLoading = () => {
			if (!elResources) return;
			elResources.innerHTML = '<li class="text-gray-500">กำลังโหลด...</li>';
		};

		const renderResources = (posts) => {
			if (!elResources) return;
			const items = Array.isArray(posts) ? posts : [];
			if (items.length === 0) {
				elResources.innerHTML = '<li class="text-gray-500">ยังไม่ได้กำหนดทรัพยากร</li>';
				return;
			}

			elResources.innerHTML = items.map((p) => {
				const id = Number(p?.id || 0) || 0;
				const title = escapeHtml(p?.title || (id ? `Post #${id}` : '-'));
				const category = escapeHtml(p?.category || '');
				const href = id ? `../teacher/post?id=${encodeURIComponent(String(id))}` : '#';
				const cat = category ? ` <span class="text-xs text-gray-500">(${category})</span>` : '';
				return `<li><a href="${href}" class="text-purple-600 hover:underline">${title}</a>${cat}</li>`;
			}).join('');
		};

		setResourcesLoading();
		fetch(`../backend/api/get_workshop_posts.php?workshop_id=${encodeURIComponent(String(workshopId))}`)
			.then((res) => res.json())
			.then((payload) => {
				if (!payload?.success) throw new Error(payload?.message || 'โหลดทรัพยากรไม่สำเร็จ');
				renderResources(payload.posts);
			})
			.catch(() => {
				renderResources([]);
			});
		if (elReflectionLink) elReflectionLink.href = `../teacher/reflection.php?workshop=${encodeURIComponent(String(workshopId))}`;

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
				if (elMainConcept) elMainConcept.textContent = (w.main_concept && String(w.main_concept).trim() !== '') ? w.main_concept : '-';
				if (elTime) {
					const open = w.open_time_local || w.open_time || '-';
					const close = w.close_time_local || w.close_time || '-';
					elTime.textContent = `เวลาเปิด: ${String(open).replace('T',' ')} | เวลาปิด: ${String(close).replace('T',' ')}`;
				}

				const status = computeStatus(w);
				if (elStatus) elStatus.textContent = `สถานะ: ${status}`;

				const qs = Array.isArray(w.questions) ? w.questions : [];
				if (!questionsWrap) return;

				if (qs.length === 0) {
					questionsWrap.innerHTML = '<div class="p-4 text-gray-400 bg-gray-50 border border-gray-200 rounded">ยังไม่มีข้อคำถามสำหรับ Workshop นี้</div>';
				} else {
					const choiceOnly = qs
						.map((q, originalIndex) => ({ q, originalIndex }))
						.filter((x) => (x?.q?.type || 'choice') !== 'open');
					questionsWrap.innerHTML = choiceOnly.map((x, displayIndex) => renderChoiceQuestion(x.q, x.originalIndex, displayIndex)).join('');
				}

				if (elRubricBody) {
					const itemsRaw = Array.isArray(w?.rubric) ? w.rubric : [];
					const items = itemsRaw.map(normalizeRubricItem).filter(Boolean);
					if (items.length === 0) {
						elRubricBody.textContent = 'Workshop นี้ยังไม่ได้กำหนดเกณฑ์ Rubric';
					} else {
						const items5 = items.filter((x) => x.level_count === 5);
						const items3 = items.filter((x) => x.level_count === 3);

						// If mixed, show separate tables for clarity.
						if (items5.length > 0 && items3.length > 0) {
							elRubricBody.innerHTML =
								renderRubricTable(items5, 5, 'Rubric (5 ระดับ)') +
								`<div class="h-4"></div>` +
								renderRubricTable(items3, 3, 'Rubric (3 ระดับ)');
						} else if (items5.length > 0) {
							elRubricBody.innerHTML = renderRubricTable(items5, 5);
						} else {
							elRubricBody.innerHTML = renderRubricTable(items3, 3);
						}
					}
				}

				if (elLoading) elLoading.classList.add('hidden');
				if (elError) elError.classList.add('hidden');
				if (form) form.classList.remove('hidden');
			})
			.catch((err) => {
				console.error(err);
				setError((err && err.message) ? err.message : 'ไม่สามารถโหลดข้อมูลได้');
			});

	})();
</script>
