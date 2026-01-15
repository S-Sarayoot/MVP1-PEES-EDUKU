<?php
require_once __DIR__ . '/base.php';

$workshopId = isset($_GET['workshop']) ? intval($_GET['workshop']) : 0;
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$scriptParts = explode('/', trim($scriptName, '/'));
$appBase = '/' . ($scriptParts[0] ?? '');
?>

	<title>EquityLearnKU - สะท้อนคิด</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
		<!-- Navigation -->
		<?php include_once '../component/sidebar.php' ?>

		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			<div class="bg-white p-4 rounded-lg shadow-md">
				<h1 id="ws-title" class="text-2xl font-bold mx-2mt-2">Workshop#<?php echo htmlspecialchars((string)$workshopId); ?> สะท้อนคิด</h1>
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
								<h2 class="text-xl font-bold">ลิงก์ที่เกี่ยวข้อง</h2>
								<ul class="list-disc list-inside mt-2">
									<li><a id="ws-activity-link" href="#" class="text-purple-600 hover:underline">ไปหน้ากิจกรรมของ Workshop นี้</a></li>
									<li><a id="ws-storage-link" href="#" class="text-purple-600 hover:underline">คลังทรัพยากรของ Workshop นี้</a></li>
								</ul>
							</div>
						</div>
					</div>

					<div class="w-full md:w-2/3">
						<div class="px-1">
							<div class="mb-4 flex items-center justify-between gap-2">
								<div class="font-semibold">ไทม์ไลน์สะท้อนคิด / ถาม-ตอบ</div>
								<div id="ws-status" class="text-sm text-gray-500">-</div>
							</div>

							<div id="ws-loading" class="flex justify-center items-center w-full py-10">
								<img src="<?php echo htmlspecialchars($appBase); ?>/image/loading.gif" alt="loading" class="w-16 h-16">
							</div>
							<div id="ws-error" class="hidden p-4 text-red-600 bg-red-50 border border-red-200 rounded"></div>

							<div id="note-box" class="hidden">
								<div class="border border-gray-200 rounded-lg p-4 bg-white">
									<div class="font-semibold text-purple-800">เขียนโน้ตสะท้อนคิด</div>
									<textarea id="newNote" class="mt-2 w-full border border-purple-300 rounded-lg p-3 outline-none focus:ring focus:ring-purple-200" rows="4" placeholder="พิมพ์ข้อความสะท้อนคิด หรือถามข้อสงสัย..."></textarea>
									<div class="mt-3 flex items-center justify-end gap-2">
										<button id="postNoteBtn" type="button" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-700">ส่งโน้ต</button>
									</div>
								</div>

								<div class="mt-4">
									<div class="font-semibold text-gray-700 mb-2">ข้อความทั้งหมด</div>
									<div id="timeline" class="flex flex-col gap-3"></div>
									<div id="timeline-empty" class="hidden p-4 text-gray-400 bg-gray-50 border border-gray-200 rounded">ยังไม่มีข้อความสะท้อนคิด</div>
								</div>
							</div>
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
		const elActivityLink = document.getElementById('ws-activity-link');
		const elStorageLink = document.getElementById('ws-storage-link');
		const elLoading = document.getElementById('ws-loading');
		const elError = document.getElementById('ws-error');
		const noteBox = document.getElementById('note-box');
		const newNote = document.getElementById('newNote');
		const postNoteBtn = document.getElementById('postNoteBtn');
		const timeline = document.getElementById('timeline');
		const timelineEmpty = document.getElementById('timeline-empty');

		const escapeHtml = (v) => String(v ?? '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;');

		const formatTs = (value) => {
			if (!value) return '';
			return String(value).replace('T', ' ');
		};

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
			if (noteBox) noteBox.classList.add('hidden');
			if (elError) {
				elError.textContent = msg;
				elError.classList.remove('hidden');
			}
		};

		const buildTree = (notes) => {
			const byId = new Map();
			for (const n of notes) byId.set(String(n.id), { ...n, replies: [] });
			const roots = [];
			for (const n of byId.values()) {
				if (n.parent_id) {
					const parent = byId.get(String(n.parent_id));
					if (parent) parent.replies.push(n);
					else roots.push(n);
				} else {
					roots.push(n);
				}
			}
			const sortFn = (a, b) => (String(a.created_at || '').localeCompare(String(b.created_at || '')) || (Number(a.id) - Number(b.id)));
			roots.sort(sortFn);
			for (const r of roots) r.replies.sort(sortFn);
			return roots;
		};

		const roleBadge = (userType) => {
			const t = String(userType || '').toLowerCase();
			if (t === 'teacher') return '<span class="text-xs px-2 py-0.5 rounded bg-green-100 text-green-700">อาจารย์</span>';
			if (t === 'admin') return '<span class="text-xs px-2 py-0.5 rounded bg-gray-100 text-gray-700">แอดมิน</span>';
			return '<span class="text-xs px-2 py-0.5 rounded bg-blue-100 text-blue-700">นักเรียน</span>';
		};

		const renderNote = (note, indentLevel = 0) => {
			const author = note.author_name ? escapeHtml(note.author_name) : `User#${escapeHtml(note.user_id)}`;
			const pad = indentLevel > 0 ? 'ml-6 border-l-2 border-purple-100 pl-4' : '';
			return `
				<div class="${pad}">
					<div class="border border-gray-200 rounded-lg p-4 bg-white">
						<div class="flex items-center justify-between gap-2">
							<div class="flex items-center gap-2">
								<div class="font-semibold text-purple-800">${author}</div>
								${roleBadge(note.user_type)}
							</div>
							<div class="text-xs text-gray-400">${escapeHtml(formatTs(note.created_at))}</div>
						</div>
						<div class="mt-2 text-gray-800 whitespace-pre-wrap">${escapeHtml(note.content || '')}</div>
						<div class="mt-3">
							<button class="replyBtn text-sm text-purple-700 hover:underline" data-reply-to="${escapeHtml(note.id)}">ตอบกลับ</button>
							<div class="replyBox hidden mt-2" data-reply-box="${escapeHtml(note.id)}">
								<textarea class="replyText w-full border border-purple-300 rounded-lg p-2" rows="3" placeholder="พิมพ์ข้อความตอบกลับ..."></textarea>
								<div class="mt-2 flex justify-end">
									<button class="sendReplyBtn px-3 py-1.5 bg-purple-500 text-white rounded hover:bg-purple-700" data-send-reply="${escapeHtml(note.id)}">ส่ง</button>
								</div>
							</div>
						</div>
					</div>
					${Array.isArray(note.replies) && note.replies.length ? note.replies.map((r) => renderNote(r, Math.min(indentLevel + 1, 2))).join('') : ''}
				</div>
			`;
		};

		const loadNotes = () => {
			return fetch(`${APP_BASE}/backend/api/get_workshop_notes.php?workshop_id=${encodeURIComponent(String(workshopId))}`)
				.then((res) => res.json())
				.then((payload) => {
					if (!payload?.success) throw new Error(payload?.message || 'โหลดข้อความไม่สำเร็จ');
					return Array.isArray(payload.notes) ? payload.notes : [];
				});
		};

		const postNote = ({ content, parentId = null }) => {
			return fetch(`${APP_BASE}/backend/api/post_workshop_note.php`, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify({
					workshop_id: workshopId,
					parent_id: parentId,
					content,
				}),
			})
				.then((res) => res.json().then((j) => ({ ok: res.ok, json: j })).catch(() => ({ ok: res.ok, json: null })))
				.then(({ ok, json }) => {
					if (!ok || !json || !json.success) throw new Error((json && json.message) ? json.message : 'ส่งข้อความไม่สำเร็จ');
					return json.note;
				});
		};

		if (!workshopId) {
			setError('กรุณาเลือก Workshop จากหน้ารวม Workshop');
			if (elStatus) elStatus.textContent = 'missing workshop id';
			return;
		}

		if (elActivityLink) elActivityLink.href = `${APP_BASE}/student/activity.php?workshop=${encodeURIComponent(String(workshopId))}`;
		if (elStorageLink) elStorageLink.href = `${APP_BASE}/student/storage.php?workshop=${encodeURIComponent(String(workshopId))}`;

		Promise.all([
			fetch(`${APP_BASE}/backend/api/get_workshop.php?id=${encodeURIComponent(String(workshopId))}`).then((res) => res.json()),
			loadNotes().catch(() => []),
		])
			.then(([wsPayload, notes]) => {
				if (!wsPayload?.success || !wsPayload.workshop) throw new Error(wsPayload?.message || 'โหลดข้อมูล workshop ไม่สำเร็จ');
				const w = wsPayload.workshop;
				if (elTitle) elTitle.textContent = `Workshop#${w.id} สะท้อนคิด`;
				if (elInstruction) elInstruction.textContent = w.instruction || '-';
				if (elObjective) elObjective.textContent = w.objective || '-';
				if (elTime) {
					const open = w.open_time_local || w.open_time || '-';
					const close = w.close_time_local || w.close_time || '-';
					elTime.textContent = `เวลาเปิด: ${String(open).replace('T',' ')} | เวลาปิด: ${String(close).replace('T',' ')}`;
				}

				const status = computeStatus(w);
				if (elStatus) elStatus.textContent = `สถานะ: ${status}`;

				const roots = buildTree(notes);
				if (timeline) timeline.innerHTML = roots.map((n) => renderNote(n, 0)).join('');
				if (timelineEmpty) timelineEmpty.classList.toggle('hidden', roots.length !== 0);

				if (elLoading) elLoading.classList.add('hidden');
				if (elError) elError.classList.add('hidden');
				if (noteBox) noteBox.classList.remove('hidden');
			})
			.catch((err) => {
				console.error(err);
				setError((err && err.message) ? err.message : 'ไม่สามารถโหลดข้อมูลได้');
			});

		if (postNoteBtn) {
			postNoteBtn.addEventListener('click', async () => {
				const text = String(newNote?.value || '').trim();
				if (!text) {
					Swal.fire({ icon: 'warning', title: 'ข้อมูลไม่ครบ', text: 'กรุณาพิมพ์ข้อความก่อนส่ง' });
					return;
				}
				postNoteBtn.disabled = true;
				try {
					await postNote({ content: text, parentId: null });
					if (newNote) newNote.value = '';
					const notes = await loadNotes();
					const roots = buildTree(notes);
					if (timeline) timeline.innerHTML = roots.map((n) => renderNote(n, 0)).join('');
					if (timelineEmpty) timelineEmpty.classList.toggle('hidden', roots.length !== 0);
					Swal.fire({ icon: 'success', title: 'ส่งข้อความแล้ว', timer: 1000, showConfirmButton: false });
				} catch (e) {
					Swal.fire({ icon: 'error', title: 'ส่งไม่สำเร็จ', text: e?.message || 'ส่งไม่สำเร็จ' });
				} finally {
					postNoteBtn.disabled = false;
				}
			});
		}

		document.addEventListener('click', async (e) => {
			const t = e.target;
			if (!(t instanceof HTMLElement)) return;
			if (t.classList.contains('replyBtn')) {
				const id = t.getAttribute('data-reply-to');
				const box = document.querySelector(`[data-reply-box="${CSS.escape(String(id))}"]`);
				if (box) box.classList.toggle('hidden');
			}
			if (t.classList.contains('sendReplyBtn')) {
				const id = t.getAttribute('data-send-reply');
				const box = document.querySelector(`[data-reply-box="${CSS.escape(String(id))}"]`);
				const textarea = box ? box.querySelector('textarea') : null;
				const text = String(textarea?.value || '').trim();
				if (!id || !text) {
					Swal.fire({ icon: 'warning', title: 'ข้อมูลไม่ครบ', text: 'กรุณาพิมพ์ข้อความก่อนส่ง' });
					return;
				}
				toggleDisable(t, true);
				try {
					await postNote({ content: text, parentId: Number(id) });
					if (textarea) textarea.value = '';
					if (box) box.classList.add('hidden');
					const notes = await loadNotes();
					const roots = buildTree(notes);
					if (timeline) timeline.innerHTML = roots.map((n) => renderNote(n, 0)).join('');
					if (timelineEmpty) timelineEmpty.classList.toggle('hidden', roots.length !== 0);
				} catch (err) {
					Swal.fire({ icon: 'error', title: 'ส่งไม่สำเร็จ', text: err?.message || 'ส่งไม่สำเร็จ' });
				} finally {
					toggleDisable(t, false);
				}
			}
		});

		function toggleDisable(el, disabled) {
			try {
				el.disabled = disabled;
			} catch {}
		}
	})();
</script>
