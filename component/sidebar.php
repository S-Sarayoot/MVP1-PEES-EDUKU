<button id="openSidebar" class="sm:hidden py-3 px-4 text-xl font-bold fixed top-2 left-2 z-50">☰</button>
<div id="sidebar"
    class="fixed top-0 left-0 max-sm:pt-10 h-screen w-64 px-4 bg-red-400 flex flex-col transition-transform duration-300 -translate-x-full sm:translate-x-0 sm:static sm:h-[calc(100vh-25px)] sm:max-w-[300px] rounded-r-xl text-gray-800 shadow-lg z-40 shadow-md">
    <div class="p-5 font-semibold text-lg">
        <h1 class="text-2xl font-bold">Sidebar</h1>
    </div>
    <nav class="flex-1 overflow-y-auto min-w-[300px] px-4 ">
        <ul class="space-y-2">
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">a</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">b</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">c</a>
            </li>
            <li>
                <a href="#" class="flex items-center px-4 py-2 rounded hover:bg-gray-100">d</a>
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