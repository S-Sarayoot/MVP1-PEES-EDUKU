<?php 
    require_once 'base.php';
?>
    <title>EquityLearnKU - ประวัติกิจกรรม</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">รายงาน/ประวัติการใช้งานระบบ</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="index.php"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Log </p>
            </div>
            <div
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                <h1 class="text-xl mx-2 text-[#433878]"> Logs</h1>
                
                <div class="mt-6 px-2">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-3">
                     <div class="text-xs text-gray-500" id="logs-meta">กำลังโหลด...</div>
                        <div class="flex items-center gap-2">
                            <label class="text-xs text-gray-500">จำนวนรายการ</label>
                            <select id="logs-limit" class="border border-gray-200 rounded px-2 py-1 bg-white text-sm">
                                <option value="50">50</option>
                                <option value="100" selected>100</option>
                                <option value="200">200</option>
                            </select>
                            <button id="logs-reload" type="button" class="px-3 py-1.5 text-sm rounded bg-purple-100 text-purple-800 hover:bg-purple-200">รีเฟรช</button>
                        </div>
                    </div>

                    <div id="logs-container" class="space-y-6">
                        <div class="text-gray-400 text-sm">กำลังโหลด...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    const escapeHtml = (v) => String(v ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

    function toThaiDateLabel(dt) {
        if (!dt) return '';
        const d = new Date(String(dt).replace(' ', 'T'));
        if (isNaN(d.getTime())) return String(dt);
        return d.toLocaleDateString('th-TH', { year: 'numeric', month: 'long', day: '2-digit' });
    }

    function toThaiTimeLabel(dt) {
        if (!dt) return '';
        const d = new Date(String(dt).replace(' ', 'T'));
        if (isNaN(d.getTime())) return '';
        return d.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' }) + ' น.';
    }

    function groupByDate(items) {
        const map = new Map();
        items.forEach((it) => {
            const raw = String(it.when ?? '');
            const key = raw ? raw.slice(0, 10) : 'unknown';
            if (!map.has(key)) map.set(key, []);
            map.get(key).push(it);
        });
        return Array.from(map.entries()).sort((a, b) => (a[0] < b[0] ? 1 : -1));
    }

    async function loadLogs() {
        const container = document.getElementById('logs-container');
        const meta = document.getElementById('logs-meta');
        const limitSel = document.getElementById('logs-limit');
        const limit = Number(limitSel?.value) || 100;

        if (container) container.innerHTML = '<div class="text-gray-400 text-sm">กำลังโหลด...</div>';
        if (meta) meta.textContent = 'กำลังโหลด...';

        try {
            const res = await fetch(`../backend/api/get_activity_logs.php?limit=${encodeURIComponent(String(limit))}`).then(r => r.json());
            if (!res?.success) throw new Error(res?.message || 'โหลดข้อมูลไม่สำเร็จ');

            const items = Array.isArray(res.data) ? res.data : [];
            if (meta) meta.textContent = `แสดง ${items.length} รายการล่าสุด`;

            if (!container) return;
            if (items.length === 0) {
                container.innerHTML = '<div class="text-gray-400 text-sm">ยังไม่มีข้อมูลกิจกรรม</div>';
                return;
            }

            const groups = groupByDate(items);
            container.innerHTML = '';

            groups.forEach(([dateKey, rows]) => {
                const dateLabel = dateKey === 'unknown' ? 'ไม่ทราบวันที่' : toThaiDateLabel(dateKey);

                const section = document.createElement('div');
                section.innerHTML = `
                    <div class="text-sm text-gray-700 font-semibold mb-2">${escapeHtml(dateLabel)}</div>
                    <div class="space-y-3"></div>
                `;
                const list = section.querySelector('div.space-y-3');

                rows.forEach((it) => {
                    const time = toThaiTimeLabel(it.when);
                    const who = escapeHtml(it.who ?? '-');
                    const action = escapeHtml(it.action ?? '-');

                    const row = document.createElement('div');
                    row.className = 'flex gap-3';
                    row.innerHTML = `
                        <div class="w-20 shrink-0 text-xs text-gray-500 pt-2">${escapeHtml(time)}</div>
                        <div class="pt-3">
                            <div class="size-3 rounded-full bg-purple-400"></div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-white border border-purple-200 rounded-lg w-full p-2 hover:border-purple-300 transition-all hover:-translate-y-0.5 hover:shadow-md duration-200 ease-in-out">
                                <p class="text-blue-500 font-semibold">${who}</p>
                                <p class="text-gray-700 text-sm">${action}</p>
                            </div>
                        </div>
                    `;
                    list.appendChild(row);
                });

                container.appendChild(section);
            });
        } catch (e) {
            console.error(e);
            if (meta) meta.textContent = 'โหลดข้อมูลไม่สำเร็จ';
            if (container) container.innerHTML = '<div class="text-red-500 text-sm">เกิดข้อผิดพลาดในการโหลด logs</div>';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('logs-reload')?.addEventListener('click', loadLogs);
        document.getElementById('logs-limit')?.addEventListener('change', loadLogs);
        loadLogs();
    });
</script>