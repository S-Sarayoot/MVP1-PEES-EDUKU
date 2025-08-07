<!-- for mobile size -->
<div class="bg-white w-full h-14 fixed top-0 left-0 md:hidden">
    <button id="openSidebar" class="md:hidden py-3 px-4 text-xl font-bold ">☰</button>
</div>

<div id="sidebar"
    class="fixed md:static row-span-10 md:row-span-10 md:col-span-3 xl:col-span-2 top-0 left-0 md:mt-2 h-screen max-w-[300px] px-4 bg-white flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0 md:h-[calc(100vh-25px)] md:max-w-[300px] rounded-r-2xl text-gray-800 shadow-xl z-40 ">
    <div class="flex py-3 font-semibold text-lg mb-4">
        <button id="openSidebar2" class="md:hidden px-2 text-xl font-bold">☰</button>
        <h1 class="text-2xl md:text-3xl ps-4 font-bold font-sans antialiased">EDU KU</h1>
    </div>
    <nav class="flex-1 overflow-y-auto w-full">
        <ul class="space-y-2 px-2 max-md:w-60 ">
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100 text-base">adxn</a>
            </li>
            <li>
                <a href="https://dev.kittelweb.xyz/admin/storage_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">คลังทรัพยากร</a>
            </li>
            <li>
                <a href="https://dev.kittelweb.xyz/admin/workshop_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">Workshop / แผนกฯ</a>
            </li>
            <li>
                <a href="https://dev.kittelweb.xyz/admin/users_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">การจัดการผู้ใช้งาน</a>
            </li>
            <li>
                <a href="https://dev.kittelweb.xyz/admin/log_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">รายงาน / Log</a>
            </li>
        </ul>
    </nav>
</div>
<!-- for desktop size -->
<div class="md:col-span-9 xl:col-span-10 row-span-1 bg-white w-full h-full mt-2 rounded-l-xl shadow-md max-md:hidden ">
    <button id="openSidebar" class="md:hidden py-3 px-4 text-xl font-bold z-50">☰</button>
</div>
<script>
    window.onload = function () {
        const openSidebar = document.getElementById('openSidebar');
        const openSidebar2 = document.getElementById('openSidebar2');
        const sidebar = document.getElementById('sidebar');
        [openSidebar, openSidebar2].forEach(btn => {
            if (btn && sidebar) {
                btn.onclick = function () {
                    sidebar.classList.toggle('translate-x-0');
                    sidebar.classList.toggle('-translate-x-full');
                };
            }
        });
    };
</script>