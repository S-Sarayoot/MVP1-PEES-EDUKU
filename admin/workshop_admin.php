<?php 
    require_once 'base.php';
?>
    <title>EquityLearnKU - Workshop</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">Workshop</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="../"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Workshop</p>
            </div>
            <div class="flex flex-col gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow transition-tranform ease-in-out duration-200">
                    <h1 class="text-center text-xl font-semibold text-[#433878] py-4 ">
                        สำหรับผู้ดูแลระบบ
                    </h1>
                    <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200">
                        <span class="font-semibold underline mx-4">คำอธิบาย</span>
                        <span>คลิกที่ Workshop เพื่อดูรายละเอียด</span>
                    </div>
                    <div id="workshopBox" class="flex max-lg:flex-col justify-center max-md:flex-col gap-5 mb-2 mt-4">
                        
                        <a href="workshop_management?id=1" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 1</p>
                        </a>
                        <a href="workshop_management?id=2" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 2</p>
                        </a>
                        <a href="workshop_management?id=3" class="rounded-lg shadow-md hover:shadow-lg hover:ring hover:ring-purple-300 p-4 bg-white transition-all border border-purple-100 block">
                            <p class="text-center text-lg text-violet-900 font-semibold">Workshop 3</p>
                        </a>
                    </div>
                </div>
                <!--  -->
                <div
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                    <h2 class="text-xl font-semibold text-center text-[#433878] my-2">
                        การจัดการนิสิต
                    </h2>
                    <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200 my-4">
                        <span class="font-semibold underline mx-4">คำชี้แจง</span>
                        <span>คำชี้แจงการจัดการนิสิต...</span>
                    </div>
                    <div class="w-full max-h-52 md:max-h-60 overflow-x-auto my-4 border border-purple-200 shadow-md">
                        <table class="w-full h-full text-sm">
                            <thead class="whitespace-nowrap">
                                <tr class="bg-purple-200">
                                    <th rowspan="2" class="py-1 px-3 font-semibold border border-purple-200">ลำดับที่
                                    </th>
                                    <th rowspan="2" class="py-1 px-3 font-semibold border border-purple-200">รหัสนิสิต
                                    </th>
                                    <th rowspan="2" class="py-1 px-3 font-semibold border border-purple-200">ชื่อ -
                                        นามสกุล</th>
                                    <th rowspan="2" class="py-1 px-3 font-semibold border border-purple-200">สาขาวิชา
                                    </th>
                                    <th colspan="3" class="py-1 px-3 font-semibold border border-purple-200">Workshop
                                        1</th>
                                    <th colspan="3" class="py-1 px-3 font-semibold border border-purple-200">Workshop
                                        2</th>
                                    <th colspan="3" class="py-1 px-3 font-semibold border border-purple-200">Workshop
                                        3</th>
                                </tr>
                                <tr class="bg-purple-10">
                                    <th class="py-1 px-3 font-semibold border border-purple-200">กิจกรรม</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">สะท้อนคิด</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">จำนวนครั้ง</th>

                                    <th class="py-1 px-3 font-semibold border border-purple-200">กิจกรรม</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">สะท้อนคิด</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">จำนวนครั้ง</th>

                                    <th class="py-1 px-3 font-semibold border border-purple-200">กิจกรรม</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">สะท้อนคิด</th>
                                    <th class="py-1 px-3 font-semibold border border-purple-200">จำนวนครั้ง</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                                <script>
                                    for (let i = 1; i < 10; i++) {
                                        let table = document.getElementById('data');
                                        table.innerHTML += ` <tr>
                                                <td class="py-1 px-2 border border-purple-200 text-center">${i}</td>
                                                <td class="py-1 px-2 text-blue-800 border border-purple-200">687039241</td>
                                                <td class="py-1 px-2 border border-purple-200">นายสมชัย คงคอย</td>
                                                <td class="py-1 px-2 border border-purple-200">เทคโนโลยีสารสนเทศ</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">6</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">2</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center ">
                                                    <p class="py-1">การดูทรัพยากร
                                                        <span class="text-green-600 px-1">8</span>
                                                        ครั้ง
                                                    </p>
                                                    <p class="py-1">ปรึกษา
                                                        <span class="text-green-600  px-1">4</span>
                                                        ครั้ง
                                                    </p>
                                                </td>

                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">6</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">2</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center">
                                                    <p class="py-1">การดูทรัพยากร
                                                        <span class="text-green-600 px-1">8</span>
                                                        ครั้ง
                                                    </p>
                                                    <p class="py-1">ปรึกษา
                                                        <span class="text-green-600  px-1">4</span>
                                                        ครั้ง
                                                    </p>
                                                </td>

                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">6</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center"><span
                                                        class="text-green-600">2</span>/10</td>
                                                <td class="py-1 px-2 border border-purple-200 text-center ">
                                                    <p class="py-1">การดูทรัพยากร
                                                        <span class="text-green-600 px-1">8</span>
                                                        ครั้ง
                                                    </p>
                                                    <p class="py-1">ปรึกษา
                                                        <span class="text-green-600  px-1">4</span>
                                                        ครั้ง
                                                    </p>
                                                </td>
                                            </tr>`
                                    }
                                </script>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--  -->
                <div
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                    <h2 class="text-xl font-semibold text-center text-[#433878] my-2">
                        เกณฑ์การประเมิณ
                    </h2>
                    <table class="text-sm w-full h-full text-center border border-purple-200 table-auto">
                        <thead>
                            <tr class="font-semibold bg-purple-100 text-purple-800">
                                <th class="py-1 px-3 border border-purple-400 w-60">บทเรียน</th>
                                <th class="py-1 px-3 border border-purple-400">Workshop 1</th>
                                <th class="py-1 px-3 border border-purple-400">Workshop 2</th>
                                <th class="py-1 px-3 border border-purple-400">Workshop 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2 px-3 border border-purple-400">กิจกรรม</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">10%</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">10%</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">40%</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 border border-purple-400">สะท้อนคิด</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">10%</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">10%</td>
                                <td class="py-2 px-3 text-green-600 border border-purple-400">10%</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-3 border border-purple-400">จำนวนครั้งการเข้าดูทรัพยากร</td>
                                <td colspan="3" class="py-2 px-3 border border-purple-400">
                                    <div class="flex justify-center py-4">
                                        <ul class="list-disc pl-4 text-left">
                                            <li>
                                                <p>1 - 5 ครั้ง = ตามจำนวนครั้ง สูงสุด
                                                    <span class="text-green-600 font-semibold">5</span>
                                                    คะแนน
                                                </p>
                                            </li>
                                            <li>
                                                <p>6 - 10 ครั้ง = ตามจำนวนครั้ง สูงสุด <span
                                                        class="text-green-600 font-semibold">6</span> คะแนน</p>
                                            </li>
                                            <li>
                                                <p>11 - 20 ครั้ง = ตามจำนวนครั้ง สูงสุด <span
                                                        class="text-green-600 font-semibold">8</span> คะแนน</p>
                                            </li>
                                            <li>
                                                <p>มากกว่า 20 ครั้ง = <span
                                                        class="text-green-600 font-semibold">10</span> คะแนน</p>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="flex max-md:flex-col gap-3 my-4 justify-center">
                        <?php
                        $text = "Rubwc Workshop 1";
                        $subtext = "(กิจกรรมคำถามปลายเปิด)";
                        $style = "workshop";
                        include "../component/button.php";
                        ?>

                        <?php
                        $text = "Rubwc Workshop 2";
                        $subtext = "(กิจกรรมออกแบบแผนการจัดการเรียนรู้)";
                        $style = "workshop";
                        include "../component/button.php";
                        ?>

                        <?php
                        $text = "Rubwc Workshop 3";
                        $subtext = "สะท้อนคิด";
                        $style = "workshop";
                        include "../component/button.php";
                        ?>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>