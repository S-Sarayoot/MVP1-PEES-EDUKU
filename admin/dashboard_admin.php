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
    <title>EDU KU - Dashboard</title>
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include_once('../component/sidebar.php') ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-4 sm:mb-8">
                <div
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 ">
                            <h3 class="text-lg text-wrap font-semibold text-gray-800">สื่อการสอนทั้งหมด</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="allFile" class="text-lime-400 text-2xl font-bold"></p>
                        <p class="text-sm text-gray-500 ml-2">สื่อการสอน</p>
                    </span>
                </div>
                <!--  -->
                <div
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 h-full w-full">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 ">
                            <h3 class="text-lg text-wrap font-semibold text-gray-800">แผนการสอนในคลัง</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="store" class="text-lime-400 text-2xl font-bold"></p>
                        <p class="text-sm text-gray-500 ml-2">แผนการสอน</p>
                    </span>
                </div>
                <!--  -->
                <div
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 ">
                            <h3 class="text-lg text-wrap font-semibold text-gray-800">ผู้ใช้งานทั้งหมด</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="user" class="px-2 text-lime-400 text-2xl font-bold"></p>
                        <p class="text-sm text-gray-500 ">คน</p>
                    </span>
                </div>
                <!--  -->
                <div
                    class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 ">
                            <h3 class="text-lg text-wrap font-semibold text-gray-800">การเข้าถึงวันนี้</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="online" class="px-2 text-lime-400 text-2xl font-bold"></p>
                        <p class="text-sm text-gray-500 ">คน</p>
                    </span>
                </div>
                <!--  -->
            </div>
            <!-- line 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-8">
                <div
                    class="bg-white rounded-lg shadow-md p-4 h-full w-full hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 ">
                    <h1 class="text-lg ps-2 xl:ps-3 font-bold  antialiased text-[#433878]">
                        แผนการสอน Workshop
                    </h1>
                    <div class="flex justify-between text-wrap mx-4 mt-6 mb-3">
                        <div class="text-gray-500">
                            <p class="text-sm bg-purple-50 py-2 px-4">ครั้งที่ 1</p>
                            <p class="text-sm py-2 px-4">ครั้งที่ 2</p>
                            <p class="text-sm bg-purple-50 py-2 px-4">ครั้งที่ 3</p>
                            <p class="text-lg py-2 px-4 text-[#156E68] font-bold">รวมทั้งหมด</p>
                        </div>
                        <div class="text-end text-[#866BC2] grow">
                            <p class="text-sm font-semibold bg-purple-50 py-2 px-4">40
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-sm font-semibold py-2 px-4">39
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-sm font-semibold bg-purple-50 py-2 px-4">32
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-lg font-semibold py-2 px-4 text-[#B1BB1E]">123
                                <span class="text-sm">Files</span>
                            </p>
                        </div>
                    </div>
                    <div class="mx-4">
                        <button type="button"
                            class="text-base bg-violet-100 text-violet-700 h-full py-1 w-full rounded-lg">เรียกดู</button>
                    </div>
                </div>
                <!--  -->
                <div
                    class="bg-white rounded-lg shadow-md p-4 h-full w-full hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 ">
                    <h1 class="text-lg ps-2 xl:ps-3 font-bold  antialiased text-[#433878]">
                        คลังทรัพยากร
                    </h1>
                    <div class="mx-4 my-5">
                        <div class="flex w-full h-full items-center mb-4">
                            <div class="w-full h-full bg-purple-50 rounded-l-lg px-4 py-5 text-center">
                                <p class="text-2xl font-bold text-[#156E68] pb-5 pt-2">67</p>
                                <p class="text-sm font-bold text-gray-500">สื่อการสอน</p>
                            </div>
                            <div class="w-full h-full bg-gray-50 rounded-r-lg px-4 py-5 text-center">
                                <p class="text-2xl font-bold text-[#156E68] pb-5 pt-2">152</p>
                                <p class="text-sm font-bold text-gray-500">แผนฯ ที่คัดเลือก</p>
                            </div>
                        </div>
                        <div class="flex w-full mb-2 items-center">
                            <button type="button" class="w-full py-1 bg-green-100 text-green-800 text-base rounded-lg">
                                +
                                เพิ่มสื่อการสอน</button>
                        </div>
                        <div class="flex w-full items-center">
                            <button type="button" class="w-full py-1 bg-gray-100 text-purple-500 text-base rounded-lg">
                                ดูเพิ่มเติม</button>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div
                    class="flex flex-col bg-white rounded-lg shadow-md p-6 h-full w-full hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 ">
                    <div class="flex items-center justify-between max-md:mb-2">
                        <h1 class="text-lg ps-2 xl:ps-3 font-bold  antialiased text-[#433878]">
                            ผู้ใช้งาน
                        </h1>
                        <button type="button" class="text-base bg-green-100 text-green-800 px-4 py-1 rounded-lg">+
                            เพิ่มผู้ใช้งาน</button>
                    </div>
                    <div class="mx-4 my-auto">
                        <div class="flex flex-col lg:flex-row items-center w-full h-full max-sm:overflow-x-auto">
                            <div
                                class="flex max-lg:justify-between lg:block w-full bg-purple-50 rounded-l-lg p-4 lg:text-center mt-2">
                                <div class="flex flex-col">
                                    <h1 class="text-base font-bold text-[#433878] pb-4">นิสิต</h1>
                                    <p class="text-lg font-bold text-[#156E68]">67 คน</p>
                                </div>
                                <div class="flex max-lg:flex-col mt-4">
                                    <button type="button"
                                        class="text-sm bg-orange-100 text-orange-600 h-full py-1 w-full rounded-full mt-2 mr-2 px-4">แก้ไข</button>
                                    <button type="button"
                                        class="text-sm bg-red-100 text-red-700 h-full py-1 w-full rounded-full mt-2 px-4">ลบ</button>
                                </div>
                            </div>
                            <div
                                class="flex max-lg:justify-between lg:block w-full bg-gray-50 rounded-r-lg p-4 lg:text-center mt-2">
                                <div class="flex flex-col">
                                    <h1 class="text-base font-bold text-[#433878] pb-4">ผู้ทรงคุณวุฒิ
                                    </h1>
                                    <p class="text-lg font-bold text-[#156E68]">152 คน</p>
                                </div>
                                <div class="flex max-lg:flex-col mt-4">
                                    <button type="button"
                                        class="text-sm bg-orange-100 text-orange-600 h-full py-1 w-full rounded-full mt-2 mr-2 px-4 ">แก้ไข</button>
                                    <button type="button"
                                        class="text-sm bg-red-100 text-red-700 h-full py-1 w-full rounded-full mt-2 px-4">ลบ</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- line 3 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                <div
                    class="bg-white rounded-lg shadow-md p-6 h-full w-full hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 ">
                    <h1 class="text-lg ps-2 font-bold antialiased text-[#433878]">
                        กิจกรรมล่าสุด
                    </h1>
                    <div class="mx-4 my-5">
                        <ul class="list-disc w-full mx-4 text-gray-600 text-sm space-y-2">
                            <li>
                                <span class="lg:flex">
                                    <p class="text-purple-600 max-lg:pb-2 pr-2 font-semibold">นิสิต [6858483838]</p>
                                    <p>อัพโหลดแผนการสอน Workshop 1 เวลา 12/08/68 08:48 น.</p>
                                </span>
                            </li>
                            <li>
                                <span class="lg:flex">
                                    <p class="text-purple-600 max-lg:pb-2 pr-2 font-semibold">ผู้ทรงคุณวุฒิ [2901]</p>
                                    <p>แสดงความคิดเห็น Workshop 2 เวลา 10/08/68 10:19 น.</p>
                                </span>
                            </li>
                            <li>
                                <span class="lg:flex">
                                    <p class="text-purple-600 max-lg:pb-2 pr-2 font-semibold">ผู้ดูแลระบบ [อัญชัญ]</p>
                                    <p>ลบผู้ใช้งาน นิสิต [876899440] เวลา 10/08/68 12:08 น.</p>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg shadow-md p-6 h-full w-full hover:shadow-lg transition-shadow transition-transform ease-in-out duration-200 hover:-translate-y-1 ">
                    <h1 class="text-lg ps-2 font-bold  antialiased text-[#433878]">
                        สำรองข้อมูลล่าสุด
                    </h1>
                    <div class="flex justify-between mx-4 my-5 text-sm text-gray-600">
                        <p>สำรองข้อมูลระบบ</p>
                        <p class="text-purple-800 font-semibold">21/04/68</p>
                    </div>
                    <div class="flex mx-4">
                        <button type="button"
                            class="text-base bg-violet-100 text-violet-700 py-1 mr-1 h-full w-full rounded-full">
                            Backup
                        </button>
                        <button type="button"
                            class="text-base bg-green-100 text-green-700 py-1 h-full w-full rounded-full">
                            Restore
                        </button>
                    </div>
                    <!--  -->
                </div>
</body>

</html>