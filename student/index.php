<?php
    require_once __DIR__ . '/base.php';
?>
	<title>EquityLearnKU - หน้าแรก</title>
</head>

<body class="bg-gray-100">
	<div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

		<!-- Main Content -->
		<div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
			

			<?php
				$bannerId = 'home1';
				$bannerTitle = 'Game based learning';
				$bannerSubtitle = 'ช่วยคุณได้มากกว่าที่คิด';
				// Banner images (slideshow). Add more images to this array when needed.
				$bannerImages = [
					'../image/Banner-1.png',
					'../image/Banner-2.png',
				];
			?>

			<div class="flex w-full rounded-lg overflow-hidden shadow-lg">
				<!-- <div class="w-1/3 bg-gray-200 p-6 flex flex-col justify-center">
					<h2 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($bannerTitle); ?></h2>
					<p class="text-gray-700"><?php echo htmlspecialchars($bannerSubtitle); ?></p>
				</div> -->
				<div class="relative w-full h-[320px] md:h-[420px] lg:h-[520px] bg-white overflow-hidden">
					<div id="banner-media-<?php echo htmlspecialchars($bannerId); ?>" class="w-full h-full"></div>
				</div>
			</div>

			<script>
				(() => {
					const bannerEl = document.getElementById("banner-media-<?php echo $bannerId; ?>");
					if (!bannerEl) return;

					const images = <?php echo json_encode($bannerImages ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
					const slides = Array.isArray(images) ? images.filter(Boolean) : [];

					if (slides.length === 0) {
						bannerEl.innerHTML = '<div class="flex items-center justify-center w-full h-full text-gray-400">No banner</div>';
						return;
					}

					let index = 0;
					let timer = null;
					const canSlide = slides.length > 1;

					bannerEl.innerHTML = `
						<div class="relative w-full h-full" data-carousel>
							<div class="w-full h-full overflow-hidden">
								<div class="flex w-full h-full transition-transform duration-500 ease-in-out" data-track></div>
							</div>
							<button type="button" class="hidden md:flex items-center justify-center absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white hover:bg-black/60" data-prev aria-label="Previous">‹</button>
							<button type="button" class="hidden md:flex items-center justify-center absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 text-white hover:bg-black/60" data-next aria-label="Next">›</button>
							<div class="absolute bottom-3 left-0 right-0 flex items-center justify-center gap-2" data-dots></div>
						</div>
					`;

					const root = bannerEl.querySelector('[data-carousel]');
					const track = bannerEl.querySelector('[data-track]');
					const dots = bannerEl.querySelector('[data-dots]');
					const btnPrev = bannerEl.querySelector('[data-prev]');
					const btnNext = bannerEl.querySelector('[data-next]');
					if (!track || !dots) return;

					slides.forEach((src, i) => {
						const slide = document.createElement('div');
						slide.className = 'w-full h-full flex-shrink-0';
						slide.innerHTML = `<img src="${src}" alt="Banner ${i + 1}" class="w-full object-contain bg-white" />`;
						track.appendChild(slide);

						const dot = document.createElement('button');
						dot.type = 'button';
						dot.className = 'w-2.5 h-2.5 rounded-full bg-white/60 hover:bg-white transition';
						dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
						dot.addEventListener('click', () => setIndex(i));
						dots.appendChild(dot);
					});

					function render() {
						track.style.transform = `translateX(-${index * 100}%)`;
						const dotEls = dots.querySelectorAll('button');
						dotEls.forEach((d, i) => {
							d.classList.toggle('bg-white', i === index);
							d.classList.toggle('bg-white/60', i !== index);
						});
					}

					function setIndex(next) {
						if (!canSlide) return;
						index = (next + slides.length) % slides.length;
						render();
						restart();
					}

					function next() { setIndex(index + 1); }
					function prev() { setIndex(index - 1); }

					function stop() {
						if (timer) clearInterval(timer);
						timer = null;
					}

					function start() {
						if (!canSlide) return;
						stop();
						timer = setInterval(next, 6000);
					}

					function restart() {
						start();
					}

					if (btnPrev && btnNext) {
						if (canSlide) {
							btnPrev.classList.remove('hidden');
							btnNext.classList.remove('hidden');
							btnPrev.addEventListener('click', prev);
							btnNext.addEventListener('click', next);
						} else {
							btnPrev.classList.add('hidden');
							btnNext.classList.add('hidden');
						}
					}

					if (!canSlide) {
						dots.classList.add('hidden');
					}

					root?.addEventListener('mouseenter', stop);
					root?.addEventListener('mouseleave', start);
					render();
					start();
				})();
			</script>


			

            <!-- Section Workshop -->

			<?php
				$workshopBlockTitle = 'Workshop';
				$instructionTitle = 'คำชี้แจง';
				$instructionText = 'Workshop นี้จะช่วยให้คุณเข้าใจหลักการของความเสมอภาคและสามารถสร้างสภาพแวดล้อมการทำงาน/สังคมที่เปิดกว้างและเคารพความแตกต่างได้อย่างแท้จริง';
			?>

			<div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 mt-6">
				<h2 class="text-2xl font-bold mb-4"><?php echo htmlspecialchars($workshopBlockTitle); ?></h2>
				<div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200">
					<p class="text-lg">
						<span class="underline font-bold text-purple-800 mx-4"><?php echo htmlspecialchars($instructionTitle); ?></span>
						<?php echo htmlspecialchars($instructionText); ?>
					</p>
				</div>

				<div id="home-workshops" class="relative flex w-full max-lg:flex-col justify-center max-md:flex-col gap-5 mb-2 mt-4"></div>
			</div>

			<script>
				(() => {
					const container = document.getElementById('home-workshops');
					if (!container) return;

					container.innerHTML = '<div class="flex justify-center items-center w-full col-span-full py-10"><img src="../image/loading.gif" alt="loading" class="w-16 h-16"></div>';

					const workshopIds = [1, 2, 3];
					const links = {
						activity: (id) => `workshop?workshop=${encodeURIComponent(String(id))}`,
						storage: () => 'storage',
						reflection: () => 'reflection',
					};

					const parseLocalDatetime = (value) => {
						if (!value) return null;
						const s = String(value);
						// Expect YYYY-MM-DDTHH:MM (from API open_time_local/close_time_local)
						const d = new Date(s);
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

					const renderCard = (workshop) => {
						const id = workshop?.id ?? '';
						const status = computeStatus(workshop);
						const badge = badgeMeta(status);
						const title = `Workshop ${id}`;
						const desc = workshop?.objective || workshop?.instruction || '-';

						const isActive = status === 'active';
						const activeBoxClass = isActive
							? ' shadow-sm hover:shadow-lg hover:ring hover:ring-purple-300 border-purple-500 hover:border-purple-0'
							: 'border-gray-200';

						const buttonHtml = (label, href, icon) => {
							if (isActive) {
								return `
									<a href="${href}" class="w-full border rounded-md py-1 px-4 ease-in-out duration-200 text-center transition-transform shadow-sm bg-purple-50 border-purple-200 hover:bg-purple-100 hover:border-purple-300 hover:shadow-lg hover:-translate-y-0.5 text-purple-900">
										<p>${icon}</p>
										<p>${label}</p>
									</a>
								`;
							}
							return `
								<div class="w-full border rounded-md py-1 px-4 ease-in-out duration-200 text-center transition-transform shadow-sm bg-gray-50 border-gray-200 cursor-default text-gray-400">
									<p>${icon}</p>
									<p>${label}</p>
								</div>
							`;
						};

						return `
							<div class="relative border-2 rounded-lg p-4 w-full ${activeBoxClass}">
								<p class="text-center font-semibold text-lg text-violet-900">${title}</p>
								<div class="flex gap-1 absolute top-2 left-2 text-xs px-2 py-1 rounded text-white ${badge.className}">
									${badge.icon}
									${status}
								</div>
								<div class="flex flex-col text-sm my-3 flex-wrap">
									<p class="underline font-semibold text-purple-800">คำชี้แจง</p>
									<p>${String(desc).replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
								</div>
								<div class="flex flex-col mt-4 mb-2 gap-2 w-full items-center">
									${buttonHtml('เข้าร่วมกิจกรรม', links.activity(id), '📚')}
								</div>
							</div>
						`;
					};

					const requests = workshopIds.map((id) =>
						fetch(`../backend/api/get_workshop.php?id=${encodeURIComponent(String(id))}`)
							.then((res) => res.json())
							.then((payload) => {
								if (!payload?.success || !payload.workshop) return null;
								return payload.workshop;
							})
							.catch(() => null)
					);

					Promise.all(requests)
						.then((workshops) => {
							const items = (workshops || []).filter(Boolean);
							if (items.length === 0) {
								container.innerHTML = '<div class="p-4 text-gray-400">ไม่พบข้อมูล</div>';
								return;
							}
							container.innerHTML = items.map(renderCard).join('');
						})
						.catch((err) => {
							console.error(err);
							container.innerHTML = '<div class="p-4 text-gray-400">ไม่สามารถโหลดข้อมูลได้</div>';
						});
				})();
			</script>

            <div class="w-full bg-white p-[35px] mt-6">
				<div class="flex items-center justify-between mb-4 gap-4">
					<h2 class="text-2xl font-bold">ทรัพยากร</h2>
					<a href="storage" class="text-sm text-purple-700 hover:underline whitespace-nowrap">ดูทั้งหมด</a>
				</div>
				<div id="random-posts" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
			</div>

			<script>
				(() => {
					const container = document.getElementById('random-posts');
					if (!container) return;

					container.innerHTML = '<div class="flex justify-center items-center w-full col-span-full py-12"><img src="../image/loading.gif" alt="loading" class="w-16 h-16"></div>';

					const limit = 6;
					const storageUrl = 'post';

					const shuffleInPlace = (arr) => {
						for (let i = arr.length - 1; i > 0; i--) {
							const j = Math.floor(Math.random() * (i + 1));
							[arr[i], arr[j]] = [arr[j], arr[i]];
						}
						return arr;
					};

					fetch('../backend/api/get_posts.php')
						.then((res) => res.json())
						.then((payload) => {
							if (!payload?.success || !Array.isArray(payload.data)) {
								throw new Error(payload?.message || 'Invalid response');
							}

							const posts = shuffleInPlace(payload.data.slice());
							const selected = posts.slice(0, Math.max(0, limit));
							container.innerHTML = '';

							if (selected.length === 0) {
								container.innerHTML = '<div class="p-4 text-gray-400">ไม่พบข้อมูล</div>';
								return;
							}

							selected.forEach((item) => {
								const card = document.createElement('div');
								card.className = 'bg-white rounded-lg shadow-lg flex flex-col overflow-hidden border border-gray-100 hover:shadow-xl transition';

								const link = document.createElement('a');
								link.href = `${storageUrl}?id=${encodeURIComponent(item?.id ?? '')}`;

								const img = document.createElement('img');
								img.src = item?.thumbnail || '../image/no-thumbnail.png';
								img.alt = 'thumbnail';
								img.className = 'w-full h-60 object-cover bg-gray-100';
								link.appendChild(img);
								card.appendChild(link);

								const body = document.createElement('div');
								body.className = 'p-4 flex-1 flex flex-col justify-between';

								const titleWrap = document.createElement('div');
								const title = document.createElement('h3');
								title.className = 'font-semibold text-[#433878] text-lg mb-1';
								const titleLink = document.createElement('a');
								titleLink.href = `${storageUrl}?id=${encodeURIComponent(item?.id ?? '')}`;
								titleLink.className = 'hover:underline';
								titleLink.textContent = item?.title || '-';
								title.appendChild(titleLink);
								titleWrap.appendChild(title);

								const category = document.createElement('p');
								category.className = 'text-gray-500 text-sm mb-2';
								category.textContent = item?.category || '-';
								titleWrap.appendChild(category);

								const date = document.createElement('p');
								date.className = 'text-gray-400 text-xs';
								date.textContent = item?.uploaded_at ? String(item.uploaded_at).substring(0, 10) : '-';
								titleWrap.appendChild(date);

								body.appendChild(titleWrap);
								card.appendChild(body);

								container.appendChild(card);
							});
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
