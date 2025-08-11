<!-- for mobile size -->
<div class="bg-white w-full h-14 fixed top-0 left-0 md:hidden">
    <button id="openSidebar" class="md:hidden py-3 px-4 text-xl font-bold text-[#866BC2]">☰</button>
</div>

<div id="sidebar"
    class="fixed md:static row-span-10 md:row-span-12 md:row-span-10 md:col-span-3 xl:col-span-2 top-0 left-0 md:mt-2 h-screen max-w-[300px] px-4 bg-white flex flex-col transition-transform duration-300 -translate-x-full md:translate-x-0 md:h-[calc(100vh-25px)] md:max-w-[300px] rounded-r-2xl text-gray-800 shadow-xl z-40 ">
    <div class="flex items-center py-3 font-semibold text-lg mb-5 mt-3">
        <button id="openSidebar2" class="md:hidden px-2 text-xl font-bold text-[#866BC2]">☰</button>
        <img src="../image/logo.png" alt="Logo" class="h-9 w-10 md:h-11 md:w-12 xl:h-12 xl:w-13 ms-6">
        <h1 class="text-2xl md:text-3xl xl:text-3xl ps-2 xl:ps-3 font-bold antialiased text-[#866BC2]">EDU KU
        </h1>
    </div>
    <hr class="border-[#866BC2] mb-4 mx-5">
    <nav class="flex-1 overflow-y-auto w-full">
        <ul class="space-y-2 px-2 max-md:w-60 text-base lg:text-lg  text-gray-700">
            <li>
                <a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                    class="flex items-center px-4 py-2 rounded hover:bg-gray-100">Dashboard</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">คลังทรัพยากร</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">Workshop / แผนกฯ</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">การจัดการผู้ใช้งาน</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">รายงาน / Log</a>
            </li>
        </ul>
    </nav>
</div>
<!-- for desktop size -->
<div
    class="flex justify-between items-center md:col-span-9 xl:col-span-10 row-span-1 bg-[#9886CE] w-full h-full rounded-bl-xl shadow-lg max-md:hidden ">
    <form class="max-w-md ms-3">
        <div class="flex items-center relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 " fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" id="search"
                class="block w-sm lg:w-md h-full py-2 ps-10 text-sm text-gray-900 border border-purple-300 rounded-lg bg-purple-50 focus:ring-purple-500 focus:border-purple-500"
                placeholder="Search" required />
            <button type="submit"
                class="absolute right-2 text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-white font-medium rounded-lg text-base lg:text-base px-2 h-[80%] lg:px-3 ">Search</button>
        </div>
    </form>
    <div class="flex items-center bg-white rounded-full w-36 mr-3 my-1">
        <div class="bg-purple-100 text-purple-800 rounded-full py-1 px-1.5">
            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <p id="nameuser" class="grow text-center text-base text-purple-800 font-semibold">Admin</p>
    </div>

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