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
    <title>EDU KU - Consulting</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-lg sm:text-xl text-[#433878] mb-4 md:mx-4">ประวัติ</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Consulting </p>
            </div>
            <div
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                <h1 class="text-xl font-semibold mx-2 text-[#433878]"> ระบบให้คำปรึกษา</h1>
                <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200 my-3">
                    <span class="font-semibold underline mx-4">คำชี้แจง</span>
                    <span>คำชี้แจงระบบให้คำปรึกษา...</span>
                </div>
                <div class="grid grid-cols-2 gap-4 my-4">
                    <button
                        class="border border-purple-100 rounded-lg shadow-sm p-4 hover:shadow-lg hover:ring hover:ring-purple-300"
                        onclick="ShowContent(true,'fnq')">
                        <span class="text-lg text-purple-700 p-2">1</span>
                        <span class="text-lg text-purple-600">FAQ</span>
                    </button>
                    <button
                        class="border border-purple-100 rounded-lg shadow-sm p-4 hover:shadow-lg hover:ring hover:ring-purple-300"
                        onclick="window.location.reload();">
                        <span class="text-lg text-purple-700 p-2">2</span>
                        <span class="text-lg text-purple-600">Email</span>
                    </button>
                    <button
                        class="border border-purple-100 rounded-lg shadow-sm p-4 hover:shadow-lg hover:ring hover:ring-purple-300"
                        onclick="ShowContent(true,'ai')">
                        <span class="text-lg text-purple-700 p-2">3</span>
                        <span class="text-lg text-purple-600">AI Chatbot</span>
                    </button>
                    <button
                        class="border border-purple-100 rounded-lg shadow-sm p-4 hover:shadow-lg hover:ring hover:ring-purple-300"
                        onclick="window.location.reload();">
                        <span class="text-lg text-purple-700 p-2">4</span>
                        <span class="text-lg text-purple-600">Line group</span>
                    </button>
                </div>
            </div>
            <div id="content"
                class="hidden mt-4 bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                <h2 class="text-xl mx-2 font-semibold text-[#433878]" id="header"></h2>
                <div id="box" class="my-4 ">
                    <!-- faq -->
                    <div id="faq" class="hidden border-b border-gray-200 p-4">

                        <!-- Question 1 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none"
                            onclick="toggleFAQ(1)">
                            <span>Q: ระบบนี้คืออะไร?</span>
                            <span id="icon-1" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-1" class="hidden pb-3 text-gray-600">
                            ระบบนี้คือแพลตฟอร์มให้คำปรึกษาสำหรับนิสิตและบุคลากร
                        </div>

                        <!-- Question 2 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none"
                            onclick="toggleFAQ(2)">
                            <span>Q: ติดต่อผู้ดูแลระบบได้อย่างไร?</span>
                            <span id="icon-2" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-2" class="hidden pb-3 text-gray-600">
                            ติดต่อได้ที่อีเมล <span class="text-blue-500">admin@example.com</span>
                        </div>

                        <!-- Question 3 -->
                        <button
                            class="w-full flex justify-between items-center py-3 text-left text-gray-800 font-medium focus:outline-none"
                            onclick="toggleFAQ(3)">
                            <span>Q: ใช้งานบนมือถือได้ไหม?</span>
                            <span id="icon-3" class="text-purple-600">+</span>
                        </button>
                        <div id="faq-3" class="hidden pb-3 text-gray-600">
                            ได้แน่นอน รองรับทั้งมือถือและแท็บเล็ต
                        </div>
                    </div>
                    <!--  -->
                    <!-- ai -->
                    <div id="ai" class="hidden border border-gray-200 py-2 md:p-4 m-4 rounded-lg">
                        <div class="flex-col px-4">
                            <div id="chat-content"></div>
                            <form onsubmit="massage(); return false;">
                                <div class="flex">
                                    <input id="userInput"
                                        class="rounded-md border border-gray-400 shadow-md w-full px-4 py-1">
                                    <button type="submit" class="bg-green-300 rounded-md px-4 py-1 ml-2">
                                        Send
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
        </div>
</body>

</html>
<script>
    function ShowContent(show, nameContent) {
        let content = document.getElementById('content');
        let header = document.getElementById('header');
        let box = document.getElementById("box");
        let faq = document.getElementById('faq')
        let ai = document.getElementById("ai")

        if (show === true) {
            content.classList.remove('hidden');

            switch (nameContent) {
                case "fnq":
                    header.textContent = "FAQ";
                    ai.classList.add("hidden")
                    faq.classList.remove("hidden"); // ✅ ต้องใส่ #
                    break;
                case "ai":
                    header.textContent = "AI Chatbot";
                    faq.classList.add("hidden")
                    ai.classList.remove("hidden")
                    break;
            }
        } else {
            content.classList.add('hidden');
        }
    }

    function toggleFAQ(id) {
        const content = document.getElementById(`faq-${id}`);
        const icon = document.getElementById(`icon-${id}`);
        content.classList.toggle("hidden");
        icon.textContent = content.classList.contains("hidden") ? "+" : "-";
    }
    function massage() {
        let content = document.getElementById("chat-content");
        let input = document.getElementById("userInput").value.trim();

        if (!input) return; // กันส่งว่าง

        // ลบของเก่าทิ้ง แล้วใส่ใหม่ (มีแค่ 1 set)
        content.innerHTML = `
        <!-- user -->
        <div class="flex w-full h-full justify-end my-4">
            <div class="bg-gray-200 rounded-sm shadow-md p-3 w-fit">
                <p>${input}</p>
            </div>
        </div>
    `;

        // รอ bot ตอบ
        setTimeout(() => {
            content.innerHTML += `
            <!-- bot -->
            <div class="flex w-full h-full mb-4">
                <div class="bg-green-200 p-3 rounded-md shadow-md w-fit">
                    <p>
                        การศึกษาคือ กระบวนการเรียนรู้ตลอดชีวิตเพื่อพัฒนาตนเองและสังคม 
                        ผ่านการถ่ายทอดความรู้ ทักษะ ค่านิยม และวัฒนธรรม
                    </p>
                </div>
            </div>
        `;
        }, 1500);

        // ล้างช่อง input
        document.getElementById("userInput").value = "";
    }


</script>