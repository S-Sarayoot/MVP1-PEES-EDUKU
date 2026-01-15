<?php
    require_once 'base.php';
?>
	<title>EquityLearnKU - Workshop</title>
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
		<!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			

			<?php
				$workshopBlockTitle = 'Workshop';
				$instructionTitle = 'คำชี้แจง';
				$instructionText = 'Workshop นี้จะช่วยให้คุณเข้าใจหลักการของความเสมอภาคและสามารถสร้างสภาพแวดล้อมการทำงาน/สังคมที่เปิดกว้างและเคารพความแตกต่างได้อย่างแท้จริง';
				$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
				$scriptParts = explode('/', trim($scriptName, '/'));
				$appBase = '/' . ($scriptParts[0] ?? '');
			?>

			<div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200">
				<h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($workshopBlockTitle); ?></h2>
                <?php echo htmlspecialchars($instructionText); ?>
				

				<div id="workshops" class="relative flex w-full max-lg:flex-col justify-center max-md:flex-col gap-5 mb-2 mt-4"></div>
			</div>

			<script>
				(() => {
					const container = document.getElementById('workshops');
					if (!container) return;

					const APP_BASE = <?php echo json_encode($appBase, JSON_UNESCAPED_SLASHES); ?>;
					container.innerHTML = `<div class="flex justify-center items-center w-full col-span-full py-10"><img src="${APP_BASE}/image/loading.gif" alt="loading" class="w-16 h-16"></div>`;

					const links = {
						activity: (id) => `../student/activity?workshop=${encodeURIComponent(String(id))}`,
						storage: (id) => `../student/storage?workshop=${encodeURIComponent(String(id))}`,
						reflection: (id) => `../student/reflection?workshop=${encodeURIComponent(String(id))}`,
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

					const badgeMeta = (status) => {
						if (status === 'active') {
							return {
								className: 'bg-green-600',
								icon: '<svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#FFFFFF"><path d="M240-640h360v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85h-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640Zm0 480h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM240-160v-400 400Z"/></svg>',
							};
						}
						if (status === 'close') {
							return {
								className: 'bg-red-600',
								icon: '<svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#FFFFFF"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm0-80h480v-400H240v400Zm240-120q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80ZM240-160v-400 400Z"/></svg>',
							};
						}
						return {
							className: 'bg-gray-400',
							icon: '<svg xmlns="http://www.w3.org/2000/svg" height="14px" viewBox="0 -960 960 960" width="14px" fill="#FFFFFF"><path d="M680-80q-83 0-141.5-58.5T480-280q0-83 58.5-141.5T680-480q83 0 141.5 58.5T880-280q0 83-58.5 141.5T680-80Zm67-105 28-28-75-75v-112h-40v128l87 87Zm-547 65q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h167q11-35 43-57.5t70-22.5q40 0 71.5 22.5T594-840h166q33 0 56.5 23.5T840-760v250q-18-13-38-22t-42-16v-212h-80v120H280v-120h-80v560h212q7 22 16 42t22 38H200Zm280-640q17 0 28.5-11.5T520-800q0-17-11.5-28.5T480-840q-17 0-28.5 11.5T440-800q0 17 11.5 28.5T480-760Z"/></svg>',
						};
					};

					const escapeHtml = (v) => String(v ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
					const formatDatetimeLocal = (value) => {
						if (!value) return '-';
						return String(value).replace('T', ' ');
					};

					const renderCard = (workshop, attemptsByWorkshopId) => {
						const id = workshop?.id ?? '';
						const status = computeStatus(workshop);
						const badge = badgeMeta(status);
						const submittedAttempt = attemptsByWorkshopId ? attemptsByWorkshopId[String(id)] : null;
						const isSubmitted = Boolean(submittedAttempt && submittedAttempt.attempt_id);
						const name = `Workshop ${id}`;
						const desc = workshop?.objective || workshop?.instruction || '-';
						const openText = formatDatetimeLocal(workshop?.open_time_local || workshop?.open_time);
						const closeText = formatDatetimeLocal(workshop?.close_time_local || workshop?.close_time);
						const isActive = status === 'active';

						const boxClass = isActive
							? ' shadow-sm hover:shadow-lg hover:ring hover:ring-purple-300 border-purple-500 hover:border-purple-0'
							: 'border-gray-200';

						const button = (label, href, icon) => {
							if (isActive) {
								return `
									<a href="${href}" class="w-full border rounded-md py-1 px-4 ease-in-out duration-200 text-center transition-transform shadow-sm bg-purple-50 border-purple-200 hover:bg-purple-100 hover:border-purple-300 hover:shadow-lg hover:-translate-y-0.5 text-purple-900">
										<p>${escapeHtml(icon)}</p>
										<p>${escapeHtml(label)}</p>
									</a>
								`;
							}
							return `
								<div class="w-full border rounded-md py-1 px-4 ease-in-out duration-200 text-center transition-transform shadow-sm bg-gray-50 border-gray-200 cursor-default text-gray-400">
									<p>${escapeHtml(icon)}</p>
									<p>${escapeHtml(label)}</p>
								</div>
							`;
						};

						return `
							<div class="relative border-2 rounded-lg p-4 w-full ${boxClass}">
								<p class="text-center font-semibold text-lg text-violet-900">${escapeHtml(name)}</p>
								<div class="flex gap-1 absolute top-2 left-2 text-xs px-2 py-1 rounded text-white ${badge.className}">
									${badge.icon}
									${escapeHtml(status)}
								</div>
								${isSubmitted ? `<div class="absolute top-2 right-2 text-xs px-2 py-1 rounded bg-blue-600 text-white">ส่งแล้ว</div>` : ''}
								<div class="flex flex-col text-sm my-3 flex-wrap">
									<p class="underline font-semibold text-purple-800">คำชี้แจง</p>
									<p>${escapeHtml(desc)}</p>
									<p class="text-xs text-gray-500 mt-2">เวลาเปิด: ${escapeHtml(openText)} | เวลาปิด: ${escapeHtml(closeText)}</p>
								</div>
								<div class="flex flex-col mt-4 mb-2 gap-2 w-full items-center">
									${button('กิจกรรม', links.activity(id), '📚')}
									${button('ทรัพยากร', links.storage(id), '🗂️')}
									${button('สะท้อนคิด', links.reflection(id), '📝')}
								</div>
							</div>
						`;
					};

					Promise.all([
						fetch(`../backend/api/get_workshops.php`).then((res) => res.json()),
						fetch(`../backend/api/get_my_workshop_attempts.php`).then((res) => res.json()).catch(() => null),
					])
						.then(([workshopsPayload, attemptsPayload]) => {
							const items = (workshopsPayload?.workshops || workshopsPayload?.data || []).filter(Boolean);
							if (!workshopsPayload?.success || !Array.isArray(items) || items.length === 0) {
								container.innerHTML = '<div class="p-4 text-gray-400">ไม่พบข้อมูล</div>';
								return;
							}

							const attemptsByWorkshopId = (attemptsPayload && attemptsPayload.success && attemptsPayload.by_workshop_id)
								? attemptsPayload.by_workshop_id
								: {};

							items.sort((a, b) => (Number(a?.id || 0) - Number(b?.id || 0)));
							container.innerHTML = items.map((w) => renderCard(w, attemptsByWorkshopId)).join('');
						})
						.catch((err) => {
							console.error(err);
							container.innerHTML = '<div class="p-4 text-gray-400">ไม่สามารถโหลดข้อมูลได้</div>';
						});
				})();
			</script>

		</div>
	</div>
</body>
</html>
