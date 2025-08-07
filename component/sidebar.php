<!-- for mobile size -->
<div class="bg-white w-full h-14 fixed top-0 left-0 md:hidden">
    <button id="openSidebar" class="md:hidden py-3 px-4 text-xl font-bold text-[#866BC2]">☰</button>
</div>

<div id="sidebar"
    class="fixed md:static row-span-10 md:row-span-12 md:row-span-10 md:col-span-3 xl:col-span-2 top-0 left-0 md:mt-2 h-screen max-w-[300px] px-4 bg-white flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0 md:h-[calc(100vh-25px)] md:max-w-[300px] rounded-r-2xl text-gray-800 shadow-xl z-40 ">
    <div class="flex items-center py-3 font-semibold text-base mb-4 mt-3">
        <button id="openSidebar2" class="md:hidden px-2 text-xl font-bold text-[#866BC2]">☰</button>
        <img src="../image/logo.png" alt="Logo" class="h-8 w-9 md:h-10 md:w-11 xl:h-11 xl:w-12 ms-6">
        <h1 class="text-xl md:text-3xl xl:text-3xl ps-2 xl:ps-3 font-bold antialiased text-[#866BC2]">EDU KU
        </h1>
    </div>
    <hr class="border-[#866BC2] mb-4 mx-5">
    <nav class="flex-1 overflow-y-auto w-full">
        <ul class="space-y-2 px-2 max-md:w-60 text-sm lg:text-base  text-gray-700">
            <li>
                <a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">Dashboard</a>
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
<script>
    window.onload = function () {
        const openSidebar = document.getElementById('openSidebar');
        const sidebar = document.getElementById('sidebar');
        if (openSidebar && sidebar) {
            openSidebar.onclick = function () {
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
            };
        }
    };
</script>