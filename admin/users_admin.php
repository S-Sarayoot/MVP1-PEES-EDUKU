<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="../global.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="../global.js"></script>
    <title>EDU KU - Users</title>
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
                <p class="text-gray-700 mb-4 mr-4"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Users</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <p class="text-xl text-[#433878]">ผู้ใช้งานทั้งหมด</p>
                        <p class="text-xl text-green-600 px-2 font-semibold ">180</p>
                        <p class="text-xl text-[#433878]">คน</p>
                    </div>
                    <button class="bg-green-100 text-green-800 rounded-md text-sm py-2 px-4 cursor-pointer" onclick="toggleModal(true)">
                        + เพิ่มผู้ใช้งาน
                    </button>
                </div>
                <!-- teble student -->
                <!--  -->
                <div class="flex justify-between items-end mt-6">
                    <div class="flex items-center w-fit p-2 rounded-t-xl bg-purple-200">
                        <p class="text-purple-900 ">นิสิต</p>
                        <p class="text-green-600 font-semibold mx-2">120</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/serch.php' ?>
                </div>
                <!--  -->
                <div class="max-h-47 md:max-h-54 overflow-auto border-2 border-purple-100 rounded-b-xl rounded-tr-xl">
                    <table class="w-full h-full text-sm whitespace-nowrap">
                        <thead class="bg-purple-100 text-left rounded-rt-xl">
                            <tr>
                                <th class="py-2 px-4 font-semibold">ลำดับที่</th>
                                <th class="py-2 px-4 font-semibold">รหัสนิสิต</th>
                                <th class="py-2 px-4 font-semibold">ชื่อ - นามสกุล</th>
                                <th class="py-2 px-4 font-semibold">สาขาวิชา</th>
                                <th class="py-2 px-4 font-semibold">รหัสผ่าน</th>
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
                        <p class="text-green-600 font-semibold mx-2">50</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/serch.php' ?>
                </div>
                <!--  -->
                <div class="max-h-47 md:max-h-54 overflow-auto border-2 border-purple-100 rounded-b-xl rounded-tr-xl">
                    <table class="w-full h-full text-sm whitespace-nowrap">
                        <thead class="bg-purple-100 text-left rounded-rt-xl">
                            <tr>
                                <th class="py-2 px-4 font-semibold">ลำดับที่</th>
                                <th class="py-2 px-4 font-semibold">id ผู้ใช้งาน</th>
                                <th class="py-2 px-4 font-semibold">ชื่อ - นามสกุล</th>
                                <th class="py-2 px-4 font-semibold">สาขาวิชา</th>
                                <th class="py-2 px-4 font-semibold">รหัสผ่าน</th>
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
                        <p class="text-green-600 font-semibold mx-2">10</p>
                        <p class="text-purple-900">คน</p>
                    </div>
                    <?php include '../component/serch.php' ?>
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
        </div>
    </div>
</body>

</html>
<script>
    for (let i = 1; i < 8; i++) {
        let student = document.getElementById('student');
        let teacher = document.getElementById('teacher');
        let admin = document.getElementById('admin');
        student.innerHTML += `
                <tr class="bg-white">
                <td class="py-2 px-4">${i}</td>
                <td class="py-2 px-4 text-blue-500">689239820</td>
                <td class="py-2 px-4">นายสมชัย คงคอย</td>
                <td class="py-2 px-4">การจัดการ</td>
                <td class="py-2 px-4">abc1234</td>
                <td class="py-2 px-4 text-blue-500">ad-001</td>
                <td>
                    <div class="flex flex-col md:flex-row">
                    <button class="text-blue-500 hover:underline">Edit</button>
                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                    </div>
                </td>
                </tr>
                `;
        teacher.innerHTML += `
                <tr class="bg-white">
                <td class="py-2 px-4">${i}</td>
                <td class="py-2 px-4 text-blue-500">tch-00${i}</td>
                <td class="py-2 px-4">ดร.สมศรี ฤดี</td>
                <td class="py-2 px-4">ภาษาอังกฤษเพื่อการสื่อสาร</td>
                <td class="py-2 px-4">abc1234</td>
                <td class="py-2 px-4 text-blue-500">ad-001</td>
                <td>
                    <div class="flex flex-col md:flex-row">
                    <button class="text-blue-500 hover:underline">Edit</button>
                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                    </div>
                </td>
                </tr>
                `;
        admin.innerHTML += `
                <tr class="bg-white">
                <td class="py-2 px-4">${i}</td>
                <td class="py-2 px-4 text-blue-500">ad-00${i}</td>
                <td class="py-2 px-4">ดร.สมศรี ฤดี</td>
                <td class="py-2 px-4 text-blue-500">ad-001</td>
                <td>
                    <div class="flex flex-col md:flex-row">
                    <button class="text-blue-500 hover:underline">Edit</button>
                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                    </div>
                </td>
                </tr>
                `;
    }
</script>