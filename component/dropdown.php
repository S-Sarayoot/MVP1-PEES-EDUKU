<div>
    <!-- ปุ่ม dropdown -->
    <button id="dropdownButton" class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white/10 
                 px-3 py-2 text-sm font-semibold text-gray-800 ring-1 ring-gray-300
                 hover:bg-gray-50">
        Options
        <svg viewBox="0 0 20 20" fill="currentColor" class="-mr-1 size-5 text-gray-400">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 
                 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 
                 9.28a.75.75 0 0 1 0-1.06Z" />
        </svg>
    </button>
    <div id="dropdownMenu" class="hidden absolute right-8 mt-2 w-56 origin-top-right rounded-md 
                 bg-white shadow-lg ring-1 ring-black/5">
        <div class="py-1">
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">All</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">Image</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">Videos</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">แหล่งการเรียนรู้แนะนำ</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">แผนการจัดการเรียนรู้</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-800 
                             hover:bg-gray-100 hover:text-black">เกณฑ์การประเมิณ</a>
        </div>
    </div>
</div>
<script>
    const button = document.getElementById("dropdownButton");
    const menu = document.getElementById("dropdownMenu");

    // toggle เปิด-ปิด
    button.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });

    // คลิกข้างนอกให้ปิด dropdown
    window.addEventListener("click", (e) => {
      if (!button.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.add("hidden");
      }
    });
  </script>