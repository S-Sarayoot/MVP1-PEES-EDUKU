<div class="bg-white p-4 rounded-lg shadow-md h-max-auto">

            <h2 class="text-2xl font-semibold">คำถามที่พบบ่อย (FAQ)</h2>
            <div id="faq" class=" border-b border-gray-200 p-4">

                        <!-- Question 1 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none cursor-pointer"
                            onclick="toggleFAQ(1)">
                            <span>Q: ระบบนี้คืออะไร?</span>
                            <span id="icon-1" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-1" class="hidden pb-3 text-gray-600 shadow-md">
                            ระบบนี้คือแพลตฟอร์มให้คำปรึกษาสำหรับนิสิตและบุคลากร
                        </div>

                        <!-- Question 2 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none cursor-pointer"
                            onclick="toggleFAQ(2)">
                            <span>Q: ติดต่อผู้ดูแลระบบได้อย่างไร?</span>
                            <span id="icon-2" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-2" class="hidden pb-3 text-gray-600 shadow-md">
                            ติดต่อได้ที่อีเมล <span class="text-blue-500">admin@example.com</span>
                        </div>

                        <!-- Question 3 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none cursor-pointer"
                            onclick="toggleFAQ(3)">
                            <span>Q: ใช้งานบนมือถือได้ไหม?</span>
                            <span id="icon-3" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-3" class="hidden pb-3 text-gray-600 shadow-md">
                            ได้แน่นอน รองรับทั้งมือถือและแท็บเล็ต
                        </div>
            </div>
</div>
<script>
        function toggleFAQ(id) {
        const content = document.getElementById(`faq-${id}`);
        const icon = document.getElementById(`icon-${id}`);
        content.classList.toggle("hidden");
        icon.textContent = content.classList.contains("hidden") ? "+" : "-";
    }
</script>