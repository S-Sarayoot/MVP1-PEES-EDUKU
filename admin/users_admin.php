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
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">ผู้ใช้งาน</h1>
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
                    <button class="bg-green-100 text-green-800 rounded-md text-sm py-2 px-4 cursor-pointer" onclick="toggleModal(true, 'uploadModal')">
                        + เพิ่มผู้ใช้งาน
                    </button>
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
        </div>
    </div>
</body>

</html>
<script>
    function renderTable(type, tableId) {
        fetch(`../backend/api/get_users_by_type.php?type=${type}`)
            .then(res => res.json())
            .then(data => {
                const table = document.getElementById(tableId);
                table.innerHTML = '';
                if (data.success && Array.isArray(data.data)) {
                    data.data.forEach((item, i) => {
                        if(type === 'student') {
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
        if (user.user_type === 'student') {
            document.getElementById('editStudentCodeGroup').classList.remove('hidden');
        } else {
            document.getElementById('editStudentCodeGroup').classList.add('hidden');
        }
        toggleModal(true, 'editModal');
    };
</script>