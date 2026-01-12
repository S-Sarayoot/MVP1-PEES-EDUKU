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
                        <h2 class="text-xl text-[#433878]">โพสต์ทั้งหมด</h2>
                        <a href="addpost" type="button"
                            class="bg-green-100 text-green-800 rounded-md text-sm p-2 cursor-pointer">+
                            สร้างโพสต์ใหม่</a>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- content -->
                    <div id="posts-list" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        
                    </div>
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
                    <!--  -->
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    const list = document.getElementById('posts-list');
    list.innerHTML = '<div class="flex justify-center items-center w-full col-span-3 py-12"><img src="../image/loading.gif" alt="loading" class="w-16 h-16"></div>';
    fetch('../backend/api/get_posts.php')
    .then(res => res.json())
    .then(data => {
        list.innerHTML = '';
        if (data.success && Array.isArray(data.data)) {
            data.data.forEach(item => {
                list.innerHTML += `
                <div class="bg-white rounded-lg shadow-lg flex flex-col overflow-hidden">
                    <a href="post?id=${item.id}">
                        <img src="${item.thumbnail}" alt="thumbnail" class="w-full h-60 object-cover bg-gray-100">
                    </a>
                    <div class="p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-semibold text-[#433878] text-lg mb-1">
                                <a href="post?id=${item.id}" class="hover:underline">${item.title || '-'}</a>
                            </h3>
                            <p class="text-gray-500 text-sm mb-2">${item.category || '-'}<\/p>
                            <p class="text-gray-400 text-xs">${item.uploaded_at ? item.uploaded_at.substring(0,10) : '-'}<\/p>
                        <\/div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button class="text-blue-500 hover:underline" onclick="goToEditPost(${item.id})">Edit<\/button>
                            
                            <button class="text-red-500 hover:underline" onclick="deletePost(${item.id})">Delete<\/button>
                        <\/div>
                    <\/div>
                <\/div>
                `;
            });
        } else {
            list.innerHTML = '<div class="p-4 text-gray-400">ไม่พบข้อมูล<\/div>';
        }
    });
    function goToEditPost(id) {
        window.location.href = `editpost?id=${id}`;
    }
    // ลบโพสต์
    function deletePost(id) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: 'คุณต้องการลบโพสต์นี้ใช่หรือไม่',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'กำลังลบ...',
                    text: 'กรุณารอสักครู่',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                fetch('../backend/api/delete_post.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id })
                })
                .then(res => res.json())
                .then(data => {
                    Swal.close();
                    if (data.success) {
                        Swal.fire('ลบแล้ว!', 'โพสต์ถูกลบเรียบร้อย', 'success');
                        setTimeout(() => { location.reload(); }, 5000);
                    } else {
                        Swal.fire('ผิดพลาด', data.message || 'ไม่สามารถลบได้', 'error');
                    }
                });
            }
        });
    }
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
            fetch('../backend/api/  .php', {
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