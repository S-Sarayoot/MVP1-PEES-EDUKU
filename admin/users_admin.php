<?php 
    require_once 'base.php';
?>

    <title>EquityLearnKU - ผู้ใช้งาน</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">จัดการผู้ใช้งาน</h1>
                <p class="text-gray-700 mb-4 mr-4">
                    <a href="#" class="text-gray-400  hover:font-semibold hover:text-[#433878]">
                        Home
                    </a>
                    > Users</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p class="text-xl text-[#433878]">ผู้ใช้งานทั้งหมด</p>
                        <p class="text-xl text-green-600 px-2 font-semibold" id="total-count">0</p>
                        <p class="text-xl text-[#433878]">คน</p>
                    </div>
                    <div class="flex items-center gap-2">
                        
                        <button class="bg-purple-100 text-purple-800 rounded-md text-sm py-2 px-4 cursor-pointer hover:bg-purple-200" onclick="toggleModal(true, 'manageLookupModal'); window.loadLookupManager && window.loadLookupManager();">
                            จัดการคณะ/สาขา
                        </button>
                        <button class="bg-green-100 text-green-800 rounded-md text-sm py-2 px-4 cursor-pointer" onclick="toggleModal(true, 'uploadModal')">
                            + เพิ่มผู้ใช้งาน
                        </button>
                        <button class="bg-blue-100 text-blue-800 rounded-md text-sm py-2 px-4 cursor-pointer hover:bg-blue-200" onclick="toggleModal(true, 'importStudentsModal');">
                            นำเข้านิสิต (Excel)
                        </button>
                    </div>
                </div>
                <!-- table student -->
                <!--  -->
                <div class="flex justify-between items-end mt-6">
                    <div class="flex items-center w-fit p-2 rounded-t-xl bg-purple-200">
                        <p class="text-purple-900 ">นิสิต</p>
                        <p class="text-green-600 font-semibold mx-2" id="student-count">0</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/search.php' ?>
                </div>
                <!--  -->
                <div class="max-h-47 md:max-h-54 overflow-auto border-2 border-purple-100 rounded-b-xl rounded-tr-xl">
                    <table class="w-full h-full text-sm whitespace-nowrap">
                        <thead class="bg-purple-100 text-left rounded-rt-xl">
                            <tr>
                                <th class="py-2 px-4 font-semibold">ลำดับที่</th>
                                <th class="py-2 px-4 font-semibold">รหัสนิสิต</th>
                                <th class="py-2 px-4 font-semibold">อีเมลผู้ใช้งาน</th>
                                <th class="py-2 px-4 font-semibold">ชื่อ - นามสกุล</th>
                                <th class="py-2 px-4 font-semibold">สาขาวิชา</th>
                                <th class="py-2 px-4 font-semibold">คณะ</th>
                                <th class="py-2 px-4 font-semibold">เพิ่มโดย</th>
                                <th class="py-2 px-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="student">

                        </tbody>
                    </table>
                </div>
                <!--  -->
                <!-- table ผู้ทรงคุณวุฒิ -->
                <!--  -->
                <div class="flex justify-between items-end mt-10">
                    <div class="flex flex-wrap items-center w-fit p-2 rounded-t-xl bg-purple-200">
                        <p class="text-purple-900 whitespace-nowrap">ผู้ทรงคุณวุฒิ</p>
                        <p class="text-green-600 font-semibold mx-2" id="teacher-count">0</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/search.php' ?>
                </div>
                <!--  -->
                <div class="max-h-47 md:max-h-54 overflow-auto border-2 border-purple-100 rounded-b-xl rounded-tr-xl">
                    <table class="w-full h-full text-sm whitespace-nowrap">
                        <thead class="bg-purple-100 text-left rounded-rt-xl">
                            <tr>
                                <th class="py-2 px-4 font-semibold">ลำดับที่</th>
                                <th class="py-2 px-4 font-semibold">รหัสผู้ใช้งาน</th>
                                <th class="py-2 px-4 font-semibold">อีเมลผู้ใช้งาน</th>
                                <th class="py-2 px-4 font-semibold">ชื่อ - นามสกุล</th>
                                <th class="py-2 px-4 font-semibold">สาขาวิชา</th>
                                <th class="py-2 px-4 font-semibold">คณะ</th>
                                <th class="py-2 px-4 font-semibold">เพิ่มโดย</th>
                                <th class="py-2 px-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="teacher">

                        </tbody>
                    </table>
                </div>
                <!--  -->
                <!-- table ผู้ดูแล -->
                <!--  -->
                <div class="flex justify-between items-end mt-10">
                    <div class="flex items-center w-fit p-2 rounded-t-xl bg-purple-200">
                        <p class="text-purple-900 whitespace-nowrap">ผู้ดูแลระบบ</p>
                        <p class="text-green-600 font-semibold mx-2" id="admin-count">0</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/search.php' ?>
                </div>
                <!--  -->
                <div class="max-h-47 md:max-h-54 overflow-auto border-2 border-purple-100 rounded-b-xl rounded-tr-xl">
                    <table class="w-full h-full text-sm whitespace-nowrap">
                        <thead class="bg-purple-100 text-left rounded-rt-xl">
                            <tr>
                                <th class="py-2 px-4 font-semibold">ลำดับที่</th>
                                <th class="py-2 px-4 font-semibold">id ผู้ใช้งาน</th>
                                <th class="py-2 px-4 font-semibold">ชื่อ - นามสกุล</th>
                                <th class="py-2 px-4 font-semibold">เพิ่มโดย</th>
                                <th class="py-2 px-4 font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody id="admin">

                        </tbody>
                    </table>
                </div>
                <!--  -->
            </div>
            <?php include '../component/uploadusers.php' ?>
            <?php include '../component/editusers.php'; ?>

            <!-- Manage Faculty/Major Modal -->
            <div id="manageLookupModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-4 md:p-6 relative">
                    <button onclick="toggleModal(false, 'manageLookupModal')"
                        class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>
                    <h2 class="text-2xl font-semibold text-purple-700 mb-3 text-shadow-sm">จัดการคณะและสาขาวิชา</h2>
                    <p class="text-sm text-gray-500 mb-4">เพิ่ม/แก้ไข/ลบ รายการสำหรับ dropdown ในการเพิ่มผู้ใช้งาน</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Faculty panel -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-semibold text-[#433878]">คณะ</h3>
                                <button id="refresh-faculty" type="button" class="text-sm text-gray-500 hover:underline">รีเฟรช</button>
                            </div>
                            <div class="flex gap-2 mb-3">
                                <input id="new-faculty-name" type="text" placeholder="เพิ่มชื่อคณะ..." class="flex-1 border border-gray-200 rounded px-3 py-2 focus:ring-purple-500 focus:border-purple-500" />
                                <button id="add-faculty" type="button" class="px-3 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">เพิ่ม</button>
                            </div>
                            <div id="faculty-list" class="max-h-72 overflow-auto divide-y divide-gray-100 border border-gray-100 rounded">
                                <div class="p-3 text-gray-400 text-sm">กำลังโหลด...</div>
                            </div>
                        </div>

                        <!-- Major panel -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-semibold text-[#433878]">สาขาวิชา</h3>
                                <button id="refresh-major" type="button" class="text-sm text-gray-500 hover:underline">รีเฟรช</button>
                            </div>
                            <div class="flex gap-2 mb-3">
                                <input id="new-major-name" type="text" placeholder="เพิ่มชื่อสาขาวิชา..." class="flex-1 border border-gray-200 rounded px-3 py-2 focus:ring-purple-500 focus:border-purple-500" />
                                <button id="add-major" type="button" class="px-3 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">เพิ่ม</button>
                            </div>
                            <div id="major-list" class="max-h-72 overflow-auto divide-y divide-gray-100 border border-gray-100 rounded">
                                <div class="p-3 text-gray-400 text-sm">กำลังโหลด...</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-5">
                        <button type="button" onclick="toggleModal(false, 'manageLookupModal')" class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-100 transition">ปิด</button>
                    </div>
                </div>
            </div>

            <!-- Import Students (Excel) Modal -->
            <div id="importStudentsModal" class="fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm bg-black/30 hidden">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-4 md:p-6 relative">
                    <button onclick="toggleModal(false, 'importStudentsModal')"
                        class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl cursor-pointer text-[32px]">&times;</button>
                    <h2 class="text-2xl font-semibold text-blue-700 mb-2 text-shadow-sm">นำเข้าผู้ใช้งาน (เฉพาะนิสิต)</h2>
                    <p class="text-sm text-gray-600 mb-4">
                        ระบบจะอ่านคอลัมน์ <span class="font-semibold">B/C/D/E</span> เป็น ปีการศึกษา/เทอม/ชื่อ-นามสกุล/รหัสนิสิต
                        และตั้ง <span class="font-semibold">รหัสผ่านพื้นฐานคือรหัสนิสิต</span>
                    </p>

                    <div class="flex items-center justify-between gap-2 mb-4">
                        <a href="../backend/api/download_student_import_template.php" class="text-sm text-blue-600 hover:underline">
                            ดาวน์โหลดไฟล์ตัวอย่าง
                        </a>
                        <p class="text-xs text-gray-400">แนะนำให้ตั้งคอลัมน์รหัสนิสิต (E) เป็นชนิดข้อความ (Text)</p>
                    </div>

                    <form id="importStudentsForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ไฟล์ Excel (.xlsx/.xls)</label>
                            <input id="importStudentsFile" name="excel_file" type="file" accept=".xlsx,.xls"
                                class="w-full border border-gray-200 rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="toggleModal(false, 'importStudentsModal')" class="px-4 py-2 rounded-full border border-gray-300 text-black hover:bg-gray-100 transition">ปิด</button>
                            <button type="submit" class="px-4 py-2 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition">นำเข้า</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    // --- Faculty/Major dropdown reloader (used by upload/edit user modals) ---
    window.reloadUserLookups = async function reloadUserLookups() {
        const facultySelect = document.getElementById('faculty_id');
        const editFacultySelect = document.getElementById('edit_faculty_id');
        const majorSelect = document.getElementById('major_id');
        const editMajorSelect = document.getElementById('edit_major_id');

        const resetSelect = (sel) => {
            if (!sel) return;
            // keep the first placeholder option if present
            const first = sel.querySelector('option');
            sel.innerHTML = '';
            if (first) sel.appendChild(first.cloneNode(true));
        };

        resetSelect(facultySelect);
        resetSelect(editFacultySelect);
        resetSelect(majorSelect);
        resetSelect(editMajorSelect);

        const [faculties, majors] = await Promise.all([
            fetch('../backend/api/get_faculty.php').then(r => r.json()).catch(() => []),
            fetch('../backend/api/get_major.php').then(r => r.json()).catch(() => []),
        ]);

        (Array.isArray(faculties) ? faculties : []).forEach((f) => {
            const opt = document.createElement('option');
            opt.value = f.id;
            opt.textContent = f.name;
            facultySelect?.appendChild(opt);
            editFacultySelect?.appendChild(opt.cloneNode(true));
        });

        (Array.isArray(majors) ? majors : []).forEach((m) => {
            const opt = document.createElement('option');
            opt.value = m.id;
            opt.textContent = m.name;
            majorSelect?.appendChild(opt);
            editMajorSelect?.appendChild(opt.cloneNode(true));
        });
    };

    // --- Lookup manager modal logic ---
    window.loadLookupManager = async function loadLookupManager() {
        const facultyList = document.getElementById('faculty-list');
        const majorList = document.getElementById('major-list');
        if (!facultyList || !majorList) return;

        const [fac, maj] = await Promise.all([
            fetch('../backend/api/get_faculty.php').then(r => r.json()).catch(() => []),
            fetch('../backend/api/get_major.php').then(r => r.json()).catch(() => []),
        ]);

        const renderItems = (container, items, kind) => {
            container.innerHTML = '';
            const arr = Array.isArray(items) ? items : [];
            if (arr.length === 0) {
                container.innerHTML = '<div class="p-3 text-gray-400 text-sm">ไม่พบข้อมูล</div>';
                return;
            }
            arr.forEach((it) => {
                const row = document.createElement('div');
                row.className = 'p-3 flex items-center justify-between gap-2';

                const name = document.createElement('div');
                name.className = 'min-w-0 flex-1 truncate text-gray-800';
                name.textContent = it.name || '-';

                const actions = document.createElement('div');
                actions.className = 'flex items-center gap-3';

                const btnEdit = document.createElement('button');
                btnEdit.type = 'button';
                btnEdit.className = 'text-blue-600 hover:underline text-sm';
                btnEdit.textContent = 'แก้ไข';
                btnEdit.addEventListener('click', async () => {
                    const result = await Swal.fire({
                        title: kind === 'faculty' ? 'แก้ไขชื่อคณะ' : 'แก้ไขชื่อสาขาวิชา',
                        input: 'text',
                        inputValue: it.name || '',
                        showCancelButton: true,
                        confirmButtonText: 'บันทึก',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonColor: '#6D28D9',
                    });
                    if (!result.isConfirmed) return;
                    const newName = String(result.value || '').trim();
                    if (!newName) return;

                    Swal.fire({
                        title: 'กำลังบันทึก...',
                        text: 'โปรดรอสักครู่',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading(),
                    });

                    const url = kind === 'faculty' ? '../backend/api/update_faculty.php' : '../backend/api/update_major.php';
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: it.id, name: newName })
                    }).then(r => r.json()).catch(() => ({ success: false, message: 'Server error' }));

                    Swal.close();

                    if (res?.success) {
                        await window.loadLookupManager();
                        await window.reloadUserLookups();
                        Swal.fire({ icon: 'success', title: 'บันทึกสำเร็จ', timer: 1200, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: res?.message || 'ไม่สามารถบันทึกได้' });
                    }
                });

                const btnDelete = document.createElement('button');
                btnDelete.type = 'button';
                btnDelete.className = 'text-red-600 hover:underline text-sm';
                btnDelete.textContent = 'ลบ';
                btnDelete.addEventListener('click', async () => {
                    const confirm = await Swal.fire({
                        title: 'ยืนยันการลบ?',
                        text: (kind === 'faculty' ? 'คณะ' : 'สาขาวิชา') + `: ${it.name || ''}`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'ลบ',
                        cancelButtonText: 'ยกเลิก',
                        confirmButtonColor: '#EF4444',
                    });
                    if (!confirm.isConfirmed) return;

                    Swal.fire({
                        title: 'กำลังลบ...',
                        text: 'โปรดรอสักครู่',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => Swal.showLoading(),
                    });

                    const url = kind === 'faculty' ? '../backend/api/delete_faculty.php' : '../backend/api/delete_major.php';
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id: it.id })
                    }).then(r => r.json()).catch(() => ({ success: false, message: 'Server error' }));

                    Swal.close();

                    if (res?.success) {
                        await window.loadLookupManager();
                        await window.reloadUserLookups();
                        Swal.fire({ icon: 'success', title: 'ลบแล้ว', timer: 1200, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: res?.message || 'ไม่สามารถลบได้' });
                    }
                });

                actions.appendChild(btnEdit);
                actions.appendChild(btnDelete);
                row.appendChild(name);
                row.appendChild(actions);
                container.appendChild(row);
            });
        };

        renderItems(facultyList, fac, 'faculty');
        renderItems(majorList, maj, 'major');
    };

    document.addEventListener('DOMContentLoaded', () => {
        const btnAddFaculty = document.getElementById('add-faculty');
        const btnAddMajor = document.getElementById('add-major');
        const inputFaculty = document.getElementById('new-faculty-name');
        const inputMajor = document.getElementById('new-major-name');
        const btnRefreshFaculty = document.getElementById('refresh-faculty');
        const btnRefreshMajor = document.getElementById('refresh-major');

        btnRefreshFaculty?.addEventListener('click', () => window.loadLookupManager && window.loadLookupManager());
        btnRefreshMajor?.addEventListener('click', () => window.loadLookupManager && window.loadLookupManager());

        const addItem = async (kind) => {
            const input = kind === 'faculty' ? inputFaculty : inputMajor;
            const name = String(input?.value || '').trim();
            if (!name) {
                Swal.fire({ icon: 'warning', title: 'กรุณากรอกชื่อ' });
                return;
            }

            Swal.fire({
                title: 'กำลังบันทึก...',
                text: 'โปรดรอสักครู่',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            const url = kind === 'faculty' ? '../backend/api/create_faculty.php' : '../backend/api/create_major.php';
            const res = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name })
            }).then(r => r.json()).catch(() => ({ success: false, message: 'Server error' }));

            Swal.close();

            if (res?.success) {
                if (input) input.value = '';
                await window.loadLookupManager();
                await window.reloadUserLookups();
                Swal.fire({ icon: 'success', title: 'เพิ่มสำเร็จ', timer: 1000, showConfirmButton: false });
            } else {
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: res?.message || 'ไม่สามารถเพิ่มได้' });
            }
        };

        btnAddFaculty?.addEventListener('click', () => addItem('faculty'));
        btnAddMajor?.addEventListener('click', () => addItem('major'));

        inputFaculty?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); addItem('faculty'); }
        });
        inputMajor?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') { e.preventDefault(); addItem('major'); }
        });

        // --- Import Students (Excel) ---
        const importForm = document.getElementById('importStudentsForm');
        importForm?.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fileInput = document.getElementById('importStudentsFile');
            const file = fileInput?.files?.[0];
            if (!file) {
                Swal.fire({ icon: 'warning', title: 'กรุณาเลือกไฟล์ Excel' });
                return;
            }

            const fd = new FormData();
            fd.append('excel_file', file);

            Swal.fire({
                title: 'กำลังนำเข้า... ',
                text: 'โปรดรอสักครู่',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            const res = await fetch('../backend/api/import_students_excel.php', {
                method: 'POST',
                body: fd,
            }).then(r => r.json()).catch(() => ({ success: false, message: 'Server error' }));

            Swal.close();

            if (res?.success) {
                const inserted = res.inserted ?? 0;
                const duplicates = res.duplicates ?? 0;
                const errors = res.errors ?? 0;

                toggleModal(false, 'importStudentsModal');
                renderTable('student', 'student');
                fetchUserCounts();

                Swal.fire({
                    icon: 'success',
                    title: 'นำเข้าเสร็จสิ้น',
                    html: `เพิ่มใหม่: <b>${inserted}</b> คน<br/>ซ้ำ: <b>${duplicates}</b> คน<br/>ผิดพลาด: <b>${errors}</b> แถว`,
                });
            } else {
                Swal.fire({ icon: 'error', title: 'นำเข้าไม่สำเร็จ', text: res?.message || 'เกิดข้อผิดพลาด' });
            }
        });
    });

    function renderTable(type, tableId) {
        fetch(`../backend/api/get_users_by_type.php?type=${type}`)
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById(tableId);
                table.innerHTML = '';
                if (data.success && Array.isArray(data.data)) {
                    data.data.forEach((item, i) => {
                        if(type === 'student') {
                            const displayUsername = item.user_code || item.username || '-';
                            table.innerHTML += `
                            <tr class="bg-white">
                                <td class="py-2 px-4">${i+1}</td>
                                <td class="py-2 px-4 text-blue-500">${item.user_code || '-'}</td>
                                <td class="py-2 px-4">${displayUsername}</td>
                                <td class="py-2 px-4">${item.user_name || '-'}</td>
                                <td class="py-2 px-4">${item.major_name || '-'}</td>
                                <td class="py-2 px-4">${item.faculty_name || '-'}</td>
                                <td class="py-2 px-4 text-blue-500">${item.created_by || '-'}</td>
                                <td>
                                    <div class="flex flex-col md:flex-row">
                                        <button class="text-blue-500 hover:underline" onclick='showEditUser(${JSON.stringify(item)})'>Edit</button>
                                        <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            `;
                        } else if(type === 'teacher') {
                            table.innerHTML += `
                            <tr class="bg-white">
                                <td class="py-2 px-4">${i+1}</td>
                                <td class="py-2 px-4 text-blue-500">${item.user_code || '-'}</td>
                                <td class="py-2 px-4">${item.username || '-'}</td>
                                <td class="py-2 px-4">${item.user_name || '-'}</td>
                                <td class="py-2 px-4">${item.major_name || '-'}</td>
                                <td class="py-2 px-4">${item.faculty_name || '-'}</td>
                                <td class="py-2 px-4 text-blue-500">${item.created_by || '-'}</td>
                                <td>
                                    <div class="flex flex-col md:flex-row">
                                        <button class="text-blue-500 hover:underline" onclick='showEditUser(${JSON.stringify(item)})'>Edit</button>
                                        <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            `;
                        } else if(type === 'admin') {
                            table.innerHTML += `
                            <tr class="bg-white">
                                <td class="py-2 px-4">${i+1}</td>
                                <td class="py-2 px-4 text-blue-500">${item.user_code || '-'}</td>
                                <td class="py-2 px-4">${item.username || '-'}</td>
                                <td class="py-2 px-4">${item.user_name || '-'}</td>
                                <td>
                                    <div class="flex flex-col md:flex-row">
                                        <button class="text-blue-500 hover:underline" onclick='showEditUser(${JSON.stringify(item)})'>Edit</button>
                                        <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            `;
                        }
                    });
                }
            });
    }

    // เรียก renderTable สำหรับแต่ละประเภท
    renderTable('student', 'student');
    renderTable('teacher', 'teacher');
    renderTable('admin', 'admin');


    function fetchUserCounts() {
        fetch('../backend/api/get_users_count.php')
            .then(res => res.json())
            .then((data) => {
                // ทั้งหมด
                document.getElementById('total-count').textContent = data.total || 0;
                // นิสิต
                document.getElementById('student-count').textContent = data.student || 0;
                // ผู้ทรงคุณวุฒิ
                document.getElementById('teacher-count').textContent = data.teacher || 0;
                // ผู้ดูแลระบบ
                document.getElementById('admin-count').textContent = data.admin || 0;
            });
    }
    fetchUserCounts();

    // โหลดข้อมูลผู้ใช้งานเดิมมาแสดงในฟอร์ม (ตัวอย่างการใช้งาน)
    window.showEditUser = function(user) {
        document.getElementById('user_id').value = user.user_id || user.id || '';
        document.getElementById('edit_username').value = user.username || '';
        document.getElementById('edit_user_type').value = user.user_type || '';
        document.getElementById('edit_faculty_id').value = user.faculty_id || '';
        document.getElementById('edit_major_id').value = user.major_id || '';
        document.getElementById('edit_user_code').value = user.user_code || '';
        const editUserName = document.getElementById('edit_user_name');
        if (editUserName) editUserName.value = user.user_name || '';
        const editAcademicYear = document.getElementById('edit_academic_year');
        if (editAcademicYear) editAcademicYear.value = user.academic_year || '';
        const editAcademicTerm = document.getElementById('edit_academic_term');
        if (editAcademicTerm) editAcademicTerm.value = user.academic_term || '';
        if (user.user_type === 'student') {
            document.getElementById('editStudentCodeGroup').classList.remove('hidden');
            const editAcademicGroup = document.getElementById('editAcademicGroup');
            if (editAcademicGroup) editAcademicGroup.classList.remove('hidden');

            const editUsernameGroup = document.getElementById('editUsernameGroup');
            if (editUsernameGroup) editUsernameGroup.classList.add('hidden');
            const editUsername = document.getElementById('edit_username');
            if (editUsername) { editUsername.required = false; editUsername.disabled = true; editUsername.value = ''; }

            const editUserCode = document.getElementById('edit_user_code');
            if (editUserCode) editUserCode.required = true;
            if (editAcademicYear) editAcademicYear.required = true;
            if (editAcademicTerm) editAcademicTerm.required = true;
        } else {
            document.getElementById('editStudentCodeGroup').classList.add('hidden');
            const editAcademicGroup = document.getElementById('editAcademicGroup');
            if (editAcademicGroup) editAcademicGroup.classList.add('hidden');

            const editUsernameGroup = document.getElementById('editUsernameGroup');
            if (editUsernameGroup) editUsernameGroup.classList.remove('hidden');
            const editUsername = document.getElementById('edit_username');
            if (editUsername) { editUsername.required = true; editUsername.disabled = false; }

            const editUserCode = document.getElementById('edit_user_code');
            if (editUserCode) { editUserCode.required = false; }
            if (editAcademicYear) { editAcademicYear.required = false; }
            if (editAcademicTerm) { editAcademicTerm.required = false; }
        }
        toggleModal(true, 'editModal');
    };
</script>