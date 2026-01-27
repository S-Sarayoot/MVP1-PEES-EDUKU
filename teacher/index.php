<?php
    require_once 'base.php';
?>
	<title>EquityLearnKU - หน้าแรก</title>
</head>


<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        
        <?php include_once '../component/sidebar.php' ?>


        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            
            <div class="flex flex-col gap-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <h2 class="text-2xl font-bold">คลังทรัพยากร</h2>
                            <a href="storage" class="text-sm text-purple-700 hover:underline">ดูทั้งหมด</a>
                        </div>
                        <div id="resourceGrid" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div class="col-span-full text-sm text-gray-500">กำลังโหลด...</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-4">
                        <h2 class="text-2xl font-bold mb-4">Workshop</h2>
                        <div id="progressBox" class="space-y-3">
                            <div class="text-sm text-gray-500">กำลังโหลด...</div>
                        </div>
                        <a href="workshop" class="inline-flex mt-4 text-sm text-purple-700 hover:underline">ไปหน้า Workshop</a>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <h2 class="text-2xl font-bold">นิสิตที่ส่ง Workshop ล่าสุด</h2>
                        <a href="workshop" class="text-sm text-purple-700 hover:underline">ดูทั้งหมด</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-gray-600 border-b">
                                    <th class="py-2 pr-3">วันที่</th>
                                    <th class="py-2 pr-3">รหัสนิสิต</th>
                                    <th class="py-2 pr-3">ชื่อ-สกุล</th>
                                    <th class="py-2 pr-3">สาขา</th>
                                    <th class="py-2 pr-3">Workshop</th>
                                </tr>
                            </thead>
                            <tbody id="latestTbody">
                                <tr class="border-b last:border-b-0">
                                    <td colspan="5" class="py-3 text-center text-gray-500">กำลังโหลด...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

		</div>
	</div>
</body>
</html>

<script>
    (() => {
        const resourceGrid = document.getElementById('resourceGrid');
        const progressBox = document.getElementById('progressBox');
        const latestTbody = document.getElementById('latestTbody');

        const toText = (v) => (v === null || v === undefined) ? '' : String(v);

        const clear = (el) => {
            if (!el) return;
            while (el.firstChild) el.removeChild(el.firstChild);
        };

        const renderResources = (items) => {
            if (!resourceGrid) return;
            clear(resourceGrid);
            const list = Array.isArray(items) ? items : [];
            if (list.length === 0) {
                const div = document.createElement('div');
                div.className = 'col-span-full text-sm text-gray-500';
                div.textContent = 'ยังไม่มีทรัพยากร';
                resourceGrid.appendChild(div);
                return;
            }

            for (const it of list) {
                const a = document.createElement('a');
                a.className = 'bg-white rounded-lg border border-gray-200 hover:shadow transition overflow-hidden';
                a.href = toText(it.src) || '#';
                a.target = '_blank';
                a.rel = 'noreferrer';

                const imgWrap = document.createElement('div');
                imgWrap.className = 'h-40 bg-gray-100 overflow-hidden';
                const img = document.createElement('img');
                img.src = toText(it.image) || '../image/no-thumbnail.png';
                img.alt = '';
                img.className = 'w-full h-full object-cover';
                imgWrap.appendChild(img);

                const body = document.createElement('div');
                body.className = 'p-3';

                const meta = document.createElement('div');
                meta.className = 'flex items-center justify-between gap-2';

                const tag = document.createElement('span');
                tag.className = 'text-xs px-2 py-1 rounded bg-purple-100 text-purple-700';
                tag.textContent = toText(it.tag) || '-';

                const author = document.createElement('span');
                author.className = 'text-xs text-gray-500';
                author.textContent = toText(it.author) || '';

                meta.appendChild(tag);
                meta.appendChild(author);

                const title = document.createElement('div');
                title.className = 'mt-2 font-semibold text-gray-800 line-clamp-1';
                title.textContent = toText(it.title) || '-';

                const desc = document.createElement('div');
                desc.className = 'text-xs text-gray-500 mt-1 line-clamp-2';
                desc.textContent = toText(it.description) || '';

                body.appendChild(meta);
                body.appendChild(title);
                body.appendChild(desc);

                a.appendChild(imgWrap);
                a.appendChild(body);
                resourceGrid.appendChild(a);
            }
        };

        const renderProgress = (items) => {
            if (!progressBox) return;
            clear(progressBox);
            const list = Array.isArray(items) ? items : [];
            if (list.length === 0) {
                const div = document.createElement('div');
                div.className = 'text-sm text-gray-500';
                div.textContent = 'ยังไม่มีข้อมูล';
                progressBox.appendChild(div);
                return;
            }

            for (const row of list) {
                const wrap = document.createElement('div');

                const top = document.createElement('div');
                top.className = 'flex items-center justify-between text-sm';

                const label = document.createElement('span');
                label.className = 'font-medium text-gray-700';
                label.textContent = toText(row.label) || '-';

                const pct = document.createElement('span');
                pct.className = 'text-gray-500';
                pct.textContent = `${Number(row.value || 0) || 0}%`;

                top.appendChild(label);
                top.appendChild(pct);

                const bar = document.createElement('div');
                bar.className = 'w-full h-2 bg-gray-100 rounded overflow-hidden mt-1';
                const fill = document.createElement('div');
                fill.className = 'h-2 bg-purple-500';
                fill.style.width = `${Math.min(100, Math.max(0, Number(row.value || 0) || 0))}%`;
                bar.appendChild(fill);

                wrap.appendChild(top);
                wrap.appendChild(bar);
                progressBox.appendChild(wrap);
            }
        };

        const renderLatest = (items) => {
            if (!latestTbody) return;
            clear(latestTbody);
            const list = (Array.isArray(items) ? items : []).slice(0, 10);
            if (list.length === 0) {
                const tr = document.createElement('tr');
                tr.className = 'border-b last:border-b-0';
                const td = document.createElement('td');
                td.colSpan = 5;
                td.className = 'py-3 text-center text-gray-500';
                td.textContent = 'ยังไม่มีข้อมูลการส่ง';
                tr.appendChild(td);
                latestTbody.appendChild(tr);
                return;
            }

            for (const row of list) {
                const tr = document.createElement('tr');
                tr.className = 'border-b last:border-b-0';

                const mk = (txt) => {
                    const td = document.createElement('td');
                    td.className = 'py-2 pr-3';
                    td.textContent = toText(txt) || '-';
                    return td;
                };

                tr.appendChild(mk(row.date));
                tr.appendChild(mk(row.student_id));
                tr.appendChild(mk(row.student_name));
                tr.appendChild(mk(row.program));
                tr.appendChild(mk(row.workshop));
                latestTbody.appendChild(tr);
            }
        };

        fetch('../backend/api/teacher_dashboard.php')
            .then((res) => res.json().then((j) => ({ ok: res.ok, json: j })).catch(() => ({ ok: res.ok, json: null })))
            .then(({ ok, json }) => {
                if (!ok || !json || !json.success) {
                    throw new Error((json && json.message) ? json.message : 'โหลดข้อมูลไม่สำเร็จ');
                }
                renderResources(json.resources);
                renderProgress(json.workshopProgress);
                renderLatest(json.latestSubmissions);
            })
            .catch(() => {
                renderResources([]);
                renderProgress([]);
                renderLatest([]);
            });
    })();
</script>
