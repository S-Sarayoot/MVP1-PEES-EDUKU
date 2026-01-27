<?php
    require_once 'base.php';
?>
	<title>EquityLearnKU - Workshop</title>
</head> 


<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        
        <?php include_once '../component/sidebar.php' ?>


        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">Workshop</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="./"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Workshop</p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200">
                    <h1 class="text-center text-xl font-semibold text-[#433878] py-4 ">
                        สำหรับคุณครูและผู้ทรงคุณวุฒิ
                    </h1>
                    <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200">
                        <span class="font-semibold underline mx-4">คำอธิบาย</span>
                        <span>คลิกที่ Workshop เพื่อดูรายละเอียดกิจกรรม</span>
                    </div>
                    <div id="workshopBox" class="flex flex-col lg:flex-row justify-center gap-5 mb-2 mt-4 w-full">
                        
                        <a href="activity.php?workshop=1" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block w-full lg:flex-1 lg:basis-0">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 1</p>
                        </a>
                        <a href="activity.php?workshop=2" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block w-full lg:flex-1 lg:basis-0">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 2</p>
                        </a>
                        <a href="activity.php?workshop=3" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block w-full lg:flex-1 lg:basis-0">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 3</p>
                        </a>
                    </div>
                </div>


                <!-- รายชื่อนิสิตที่ส่ง workshop (ตามภาพ: ปุ่มสี + tab + search) -->
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                    

                    <div class="mt-6 bg-gray-100/60 rounded-lg p-4">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div >คลิกเพื่อตรวจสอบรายชื่อนิสิตที่ส่งงาน</div>
                            <div class="inline-flex rounded border border-purple-200 overflow-hidden bg-white">
                                <button type="button" class="ws-tab px-4 py-2 text-sm font-semibold bg-[#433878] text-white" data-cat="workshop 1">Workshop 1</button>
                                <button type="button" class="ws-tab px-4 py-2 text-sm font-semibold" data-cat="workshop 2">Workshop 2</button>
                                <button type="button" class="ws-tab px-4 py-2 text-sm font-semibold" data-cat="workshop 3">Workshop 3</button>
                            </div>

                            

                            <div class="relative w-full sm:w-72">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input id="wsSearch" type="search" class="block w-full py-1.5 ps-10 text-sm text-gray-900 border border-purple-300 rounded bg-purple-50 focus:ring-purple-500 focus:border-purple-500" placeholder="search" />
                            </div>
                        </div>
                        <button id="wsExport" type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-semibold rounded border border-purple-200 bg-white hover:bg-purple-50 text-purple-700">
                                <span>Export CSV</span>
                            </button>

                        <div class="mt-4 w-full overflow-x-auto border border-gray-200 bg-white">
                            <table class="w-full text-sm">
                                <thead class="whitespace-nowrap">
                                    <tr class="bg-gray-200">
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">ชื่อ - นามสกุล</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">รหัสนิสิต</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">สาขาวิชา</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">วันที่ส่ง</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">คะแนน</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-left">สะท้อนคิด</th>
                                        <th class="py-2 px-3 font-semibold border border-gray-300 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="wsBody">
                                    <tr id="wsLoading">
                                        <td colspan="7" class="py-4 px-3 text-center text-gray-500">กำลังโหลดข้อมูล...</td>
                                    </tr>
                                    <tr id="wsEmpty" class="hidden">
                                        <td colspan="7" class="py-4 px-3 text-center text-gray-500">ไม่มีข้อมูล</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between flex-wrap gap-3">
                            <div id="wsPageInfo" class="text-sm text-gray-600"></div>
                            <div class="flex items-center gap-2">
                                <button id="wsPrev" type="button" class="px-3 py-1.5 text-sm rounded border border-gray-300 bg-white hover:bg-gray-50">ก่อนหน้า</button>
                                <button id="wsNext" type="button" class="px-3 py-1.5 text-sm rounded border border-gray-300 bg-white hover:bg-gray-50">ถัดไป</button>
                                <select id="wsPageSize" class="px-2 py-1.5 text-sm rounded border border-gray-300 bg-white">
                                    <option value="10">10 แถว</option>
                                    <option value="20" selected>20 แถว</option>
                                    <option value="50">50 แถว</option>
                                    <option value="100">100 แถว</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            const tabs = Array.from(document.querySelectorAll('.ws-tab'));
                            const summary = Array.from(document.querySelectorAll('.ws-summary'));
                            const search = document.getElementById('wsSearch');
                            const exportBtn = document.getElementById('wsExport');
                            const emptyRow = document.getElementById('wsEmpty');
                            const loadingRow = document.getElementById('wsLoading');
                            const tbody = document.getElementById('wsBody');

                            const pageInfo = document.getElementById('wsPageInfo');
                            const btnPrev = document.getElementById('wsPrev');
                            const btnNext = document.getElementById('wsNext');
                            const pageSizeSelect = document.getElementById('wsPageSize');

                            let activeCat = 'workshop 1';
                            let allItems = [];
                            let currentPage = 1;
                            let pageSize = Number(pageSizeSelect?.value || 20) || 20;

                            function formatDateDisplay(value) {
                                if (!value) return '-';
                                const s = String(value);
                                // if looks like MySQL DATETIME, keep date part
                                const m = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
                                if (m) return `${m[3]}/${m[2]}/${m[1]}`;
                                return s;
                            }

                            function csvEscape(v) {
                                const s = String(v ?? '');
                                if (/[",\n\r]/.test(s)) return '"' + s.replace(/"/g, '""') + '"';
                                return s;
                            }

                            function downloadCsv(filename, rows) {
                                const csv = '\ufeff' + rows.map((r) => r.map(csvEscape).join(',')).join('\r\n');
                                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8' });
                                const url = URL.createObjectURL(blob);
                                const a = document.createElement('a');
                                a.href = url;
                                a.download = filename;
                                document.body.appendChild(a);
                                a.click();
                                a.remove();
                                URL.revokeObjectURL(url);
                            }

                            function setActiveUI() {
                                tabs.forEach(btn => {
                                    const isActive = (btn.dataset.cat === activeCat);
                                    btn.classList.toggle('bg-[#433878]', isActive);
                                    btn.classList.toggle('text-white', isActive);
                                    btn.classList.toggle('bg-white', !isActive);
                                    btn.classList.toggle('text-gray-800', !isActive);
                                });
                            }

                            function toText(v) {
                                return (v === null || v === undefined) ? '' : String(v);
                            }

                            function getFilteredItems() {
                                const q = (search && search.value ? search.value : '').trim().toLowerCase();
                                const catNeedle = String(activeCat).toLowerCase();
                                const out = [];

                                for (const it of (Array.isArray(allItems) ? allItems : [])) {
                                    const cat = toText(it.cat).toLowerCase();
                                    if (cat !== catNeedle) continue;

                                    const id = toText(it.student_id);
                                    const name = toText(it.name);
                                    const major = toText(it.major);

                                    const matchQ = !q
                                        || name.toLowerCase().includes(q)
                                        || id.toLowerCase().includes(q)
                                        || major.toLowerCase().includes(q);
                                    if (!matchQ) continue;
                                    out.push(it);
                                }
                                return out;
                            }

                            function setPageInfo(total, fromIdx, toIdx) {
                                if (!pageInfo) return;
                                if (total <= 0) {
                                    pageInfo.textContent = '0 รายการ';
                                    return;
                                }
                                pageInfo.textContent = `แสดง ${fromIdx}-${toIdx} จาก ${total} รายการ`;
                            }

                            function setPagerButtons(totalPages) {
                                if (btnPrev) btnPrev.disabled = currentPage <= 1;
                                if (btnNext) btnNext.disabled = currentPage >= totalPages;
                            }

                            function renderRows(items) {
                                if (!tbody) return;

                                // Clear all rows except placeholders (loading/empty)
                                Array.from(tbody.querySelectorAll('.ws-row')).forEach(tr => tr.remove());

                                const list = Array.isArray(items) ? items : [];
                                const total = list.length;
                                const totalPages = Math.max(1, Math.ceil(total / pageSize));
                                if (currentPage > totalPages) currentPage = totalPages;
                                if (currentPage < 1) currentPage = 1;

                                const start = (currentPage - 1) * pageSize;
                                const end = Math.min(total, start + pageSize);

                                setPageInfo(total, total ? (start + 1) : 0, end);
                                setPagerButtons(totalPages);

                                let visible = 0;
                                for (let idx = start; idx < end; idx++) {
                                    const it = list[idx];

                                    const id = toText(it.student_id);
                                    const name = toText(it.name);
                                    const major = toText(it.major);
                                    const submittedAt = toText(it.submitted_at);
                                    const scoreTotal = Number(it.score_total || 0) || 0;
                                    const maxScoreTotal = Number(it.max_score_total || 0) || 0;
                                    const reflection = Boolean(it.reflection);

                                    const workshopNo = toText(it.workshop_id || '').trim();
                                    const activityHref = workshopNo
                                        ? ('activity.php?workshop=' + encodeURIComponent(workshopNo) + '&student_id=' + encodeURIComponent(id))
                                        : '#';
                                    const reflectionHref = workshopNo
                                        ? ('reflection.php?workshop=' + encodeURIComponent(workshopNo) + '&student_id=' + encodeURIComponent(id))
                                        : '#';

                                    const tr = document.createElement('tr');
                                    tr.className = 'ws-row';
                                    tr.dataset.cat = toText(it.cat);
                                    tr.dataset.name = name;
                                    tr.dataset.id = id;
                                    tr.dataset.major = major;

                                    const tdUser = document.createElement('td');
                                    tdUser.className = 'py-2 px-3 border border-gray-200';
                                    const nameDiv = document.createElement('div');
                                    nameDiv.className = 'font-semibold';
                                    nameDiv.textContent = name || '-';
                                    // const subDiv = document.createElement('div');
                                    // subDiv.className = 'text-xs text-gray-500';
                                    // subDiv.textContent = id ? ('Username | ' + id.slice(-4)) : 'Username';
                                    tdUser.appendChild(nameDiv);
                                    // tdUser.appendChild(subDiv);

                                    const tdId = document.createElement('td');
                                    tdId.className = 'py-2 px-3 border border-gray-200 text-blue-800';
                                    tdId.textContent = id || '-';

                                    const tdMajor = document.createElement('td');
                                    tdMajor.className = 'py-2 px-3 border border-gray-200';
                                    tdMajor.textContent = major || '-';

                                    const tdDate = document.createElement('td');
                                    tdDate.className = 'py-2 px-3 border border-gray-200';
                                    tdDate.textContent = submittedAt ? formatDateDisplay(submittedAt) : '-';

                                    const tdScore = document.createElement('td');
                                    tdScore.className = 'py-2 px-3 border border-gray-200 whitespace-nowrap';
                                    if (maxScoreTotal > 0) {
                                        tdScore.textContent = `${scoreTotal}/${maxScoreTotal}`;
                                    } else {
                                        tdScore.textContent = scoreTotal > 0 ? String(scoreTotal) : '-';
                                    }

                                    const tdRef = document.createElement('td');
                                    tdRef.className = 'py-2 px-3 border border-gray-200';
                                    const refSpan = document.createElement('span');
                                    if (reflection) {
                                        refSpan.className = 'text-purple-700 font-semibold';
                                        refSpan.textContent = 'ส่งแล้ว';
                                    } else {
                                        refSpan.className = 'text-gray-500';
                                        refSpan.textContent = 'ยังไม่ส่ง';
                                    }
                                    tdRef.appendChild(refSpan);

                                    const tdAction = document.createElement('td');
                                    tdAction.className = 'py-2 px-3 border border-gray-200 text-center whitespace-nowrap';
                                    if (workshopNo) {
                                        const a1 = document.createElement('a');
                                        a1.className = 'inline-flex items-center justify-center px-3 py-1 rounded border border-gray-300 hover:bg-gray-50 text-xs';
                                        a1.href = activityHref;
                                        a1.textContent = 'กิจกรรม';

                                        const a2 = document.createElement('a');
                                        a2.className = 'inline-flex items-center justify-center px-3 py-1 rounded border border-gray-300 hover:bg-gray-50 text-xs ml-2';
                                        a2.href = reflectionHref;
                                        a2.textContent = 'สะท้อนคิด';

                                        tdAction.appendChild(a1);
                                        tdAction.appendChild(a2);
                                    } else {
                                        const dash = document.createElement('span');
                                        dash.className = 'text-xs text-gray-400';
                                        dash.textContent = '-';
                                        tdAction.appendChild(dash);
                                    }

                                    tr.appendChild(tdUser);
                                    tr.appendChild(tdId);
                                    tr.appendChild(tdMajor);
                                    tr.appendChild(tdDate);
                                    tr.appendChild(tdScore);
                                    tr.appendChild(tdRef);
                                    tr.appendChild(tdAction);

                                    // Insert before empty row
                                    if (emptyRow) {
                                        tbody.insertBefore(tr, emptyRow);
                                    } else {
                                        tbody.appendChild(tr);
                                    }
                                    visible++;
                                }

                                if (emptyRow) emptyRow.classList.toggle('hidden', visible > 0);
                            }

                            function applyFilter() {
                                const filtered = getFilteredItems();
                                renderRows(filtered);
                            }

                            tabs.forEach(btn => {
                                btn.addEventListener('click', function () {
                                    activeCat = btn.dataset.cat || 'คลังทรัพยากร';
                                    currentPage = 1;
                                    setActiveUI();
                                    applyFilter();
                                });
                            });
                            summary.forEach(btn => {
                                btn.addEventListener('click', function () {
                                    activeCat = btn.dataset.cat || 'workshop 1';
                                    currentPage = 1;
                                    setActiveUI();
                                    applyFilter();
                                });
                            });
                            if (search) {
                                search.addEventListener('input', () => {
                                    currentPage = 1;
                                    applyFilter();
                                });
                            }

                            if (pageSizeSelect) {
                                pageSizeSelect.addEventListener('change', () => {
                                    pageSize = Number(pageSizeSelect.value || 20) || 20;
                                    currentPage = 1;
                                    applyFilter();
                                });
                            }

                            if (btnPrev) {
                                btnPrev.addEventListener('click', () => {
                                    currentPage = Math.max(1, currentPage - 1);
                                    applyFilter();
                                });
                            }
                            if (btnNext) {
                                btnNext.addEventListener('click', () => {
                                    currentPage = currentPage + 1;
                                    applyFilter();
                                });
                            }

                            if (exportBtn) {
                                exportBtn.addEventListener('click', () => {
                                    const filtered = getFilteredItems();
                                    const headers = ['Workshop', 'ชื่อ-นามสกุล', 'รหัสนิสิต', 'สาขาวิชา', 'วันที่ส่ง', 'คะแนน', 'สะท้อนคิด'];
                                    const rows = [headers];

                                    for (const it of filtered) {
                                        const w = toText(it.workshop_id) ? ('Workshop ' + toText(it.workshop_id)) : '';
                                        const name = toText(it.name) || '-';
                                        const sid = toText(it.student_id) || '-';
                                        const major = toText(it.major) || '-';
                                        const submittedAt = it.submitted_at ? formatDateDisplay(it.submitted_at) : '-';
                                        const scoreTotal = Number(it.score_total || 0) || 0;
                                        const maxScoreTotal = Number(it.max_score_total || 0) || 0;
                                        const score = (maxScoreTotal > 0) ? `${scoreTotal}/${maxScoreTotal}` : (scoreTotal > 0 ? String(scoreTotal) : '-');
                                        const ref = it.reflection ? 'ส่งแล้ว' : 'ยังไม่ส่ง';

                                        rows.push([w, name, sid, major, submittedAt, score, ref]);
                                    }

                                    const today = new Date();
                                    const y = String(today.getFullYear());
                                    const m = String(today.getMonth() + 1).padStart(2, '0');
                                    const d = String(today.getDate()).padStart(2, '0');
                                    const catSafe = String(activeCat || 'workshop').replace(/\s+/g, '-');
                                    const filename = `${catSafe}-submissions-${y}${m}${d}.csv`;
                                    downloadCsv(filename, rows);
                                });
                            }

                            setActiveUI();

                            // Fetch real data from backend API
                            fetch('../backend/api/get_teacher_workshop_submissions.php')
                                .then((res) => res.json().then((j) => ({ ok: res.ok, json: j })).catch(() => ({ ok: res.ok, json: null })))
                                .then(({ ok, json }) => {
                                    if (!ok || !json || !json.success) {
                                        throw new Error((json && json.message) ? json.message : 'โหลดข้อมูลไม่สำเร็จ');
                                    }
                                    allItems = Array.isArray(json.items) ? json.items : [];
                                })
                                .catch(() => {
                                    allItems = [];
                                })
                                .finally(() => {
                                    if (loadingRow) loadingRow.remove();
                                    currentPage = 1;
                                    applyFilter();
                                });
                        })();
                    </script>
                </div>
                <!--  -->
                
            </div>
        </div>
</body>

</html>