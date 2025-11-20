<?php 
    require_once 'base.php';
?>


<title>EquityLearnKU - คลังทรัพยากร</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-[#433878]">คลังทรัพยากร</h1>
                    <p class="text-gray-700"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                            class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                        > Storage</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl text-[#433878]">ประเภทสื่อการสอน</h2>
                        <button onclick="toggleModal(true)"
                            class="bg-green-100 text-green-800 rounded-md text-sm p-2 cursor-pointer">+
                            เพิ่มสื่อการสอน</button>
                        <?php include '../component/uploadform.php' ?>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- content -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:h-full max-h-[200px] overflow-y-auto">
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/image_icon.png" alt="image" class="size-14">
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">รูปภาพ</p>
                                <p class="text-gray-500 text-sm">17 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#FCEDFF] p-4 rounded-xl">
                                <img src="../image/play_icon.png" alt="image" class="h-6 w-6">
                            </div>
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">วิดีโอ</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/document_icon.png" alt="image" class="size-14">
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">แหล่งการเรียนรู้แนะนำ</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#E0E9FF] p-4 rounded-xl">
                                <img src="../image/storyboard_icon.png" alt="image" class="h-6 w-6">
                            </div>
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">แผนการจัดการเรียนรู้</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                       
                    </div>
                    <!--  -->
                </div>
            </div>
            <!--  -->
            <div class="flex flex-col">
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-xl text-[#433878]">สื่อการสอนทั้งหมด</h2>
                        
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- table th -->
                    <div class="flex flex-col w-full h-full">
                        <!-- th -->
                        <div class="flex text-left text-sm font-semibold text-gray-500 bg-gray-100">
                            <p class="py-2 px-4 w-2/5">File Name</p>
                            <p class="py-2 px-4 w-1/5">Type</p>
                            <p class="py-2 px-4 w-1/5">Date</p>
                            <p class="py-2 text-center w-1/5">Action</p>
                        </div>
                    
                        <!-- td -->
                        <div class="max-h-400 md:max-h-200 overflow-y-auto" id="media-table">
                            <!-- ข้อมูลจะถูกเติมด้วย JS -->
                        </div>
                    </div>
                    <script>
                        fetch('../backend/api/get_teaching_media.php')
                            .then(res => res.json())
                            .then(data => {
                                const table = document.getElementById('media-table');
                                table.innerHTML = '';
                                if (data.success && Array.isArray(data.data)) {
                                    data.data.forEach(item => {
                                        table.innerHTML += `
                                        <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                            <div class="py-2 px-4 w-2/5 flex items-center gap-3">
                                                <img src="${item.file_name ? '../uploads/' + item.file_name : '../image/no-thumbnail.png'}" alt="thumbnail" class="w-10 h-10 object-cover rounded" />
                                                <span class="break-all">${item.file_name || '-'}</span>
                                            </div>
                                            <p class="py-2 px-4 w-1/5">${item.category || '-'}</p>
                                            <p class="py-2 px-4 w-1/5">${item.uploaded_at ? item.uploaded_at.substring(0,10) : '-'}</p>
                                            <div class="flex flex-col md:flex-row justify-center w-1/5">
                                                <button class="text-blue-500 hover:underline">Edit</button>
                                                <button class="text-red-500 hover:underline md:ml-2" onclick="deleteMedia(${item.id})">Delete</button>
                                            </div>
                                        </div>
                                        `;
                                    });
                                } else {
                                    table.innerHTML = '<div class="p-4 text-gray-400">ไม่พบข้อมูล</div>';
                                }
                            });
                        </script>
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
function deleteMedia(id) {
    Swal.fire({
        title: 'ยืนยันการลบ?',
        text: 'คุณต้องการลบรายการนี้ใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'ลบ',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('../backend/api/delete_teaching_media.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('ลบแล้ว!', 'รายการถูกลบเรียบร้อย', 'success');
                    // รีโหลดข้อมูลใหม่
                    location.reload();
                } else {
                    Swal.fire('ผิดพลาด', data.message || 'ไม่สามารถลบได้', 'error');
                }
            });
        }
    });
}
</script>