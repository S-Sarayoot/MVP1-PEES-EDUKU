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
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-4 sm:mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="ml-2 p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 lg:ml-7">
                            <h3 class="text-[25px] text-wrap font-semibold text-gray-800">สื่อการสอนทั้งหมด</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="allFile" class="text-lime-400 text-3xl lg:text-4xl font-bold"></p>
                        <p class="text-lg lg:text-base text-gray-500 ml-2">สื่อการสอน</p>
                    </span>
                </div>
                <!--  -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow h-full w-full">
                    <div class="flex items-center">
                        <div class="ml-2 p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 lg:ml-7">
                            <h3 class="text-[25px] text-wrap font-semibold text-gray-800">แผนการสอนในคลัง</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="store" class="text-lime-400 text-3xl lg:text-4xl font-bold"></p>
                        <p class="text-lg lg:text-base text-gray-500 ml-2">แผนการสอน</p>
                    </span>
                </div>
                <!--  -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="ml-2 p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="ml-5 lg:ml-7">
                            <h3 class="text-[25px] text-wrap font-semibold text-gray-800">ผู้ใช้งานทั้งหมด</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="user" class="px-2 text-lime-400 text-3xl lg:text-4xl font-bold"></p>
                        <p class="text-lg lg:text-base text-gray-500 ">คน</p>
                    </span>
                </div>
                <!--  -->
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow h-full w-full">
                    <div class="flex text-wrap items-center">
                        <div class="ml-2 p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-5 lg:ml-7">
                            <h3 class="text-[25px] text-wrap font-semibold text-gray-800">การเข้าถึงวันนี้</h3>
                        </div>
                    </div>
                    <span class="flex justify-center items-end my-7">
                        <p id="online" class="px-2 text-lime-400 text-3xl lg:text-4xl font-bold"></p>
                        <p class="text-lg lg:text-base text-gray-500 ">คน</p>
                    </span>
                </div>
                <!--  -->
            </div>
            <!-- line 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 h-full w-full">
                    <h1 class="text-2xl md:text-3xl  ps-2 xl:ps-3 font-bold font-sans antialiased text-[#433878]">
                        แผนการสอน Workshop
                    </h1>
                    <div class="flex justify-between text-wrap mx-4 my-7">
                        <div class="text-gray-500">
                            <p class="text-lg md:text-xl bg-purple-50 p-4">ครั้งที่ 1</p>
                            <p class="text-lg md:text-xl p-4">ครั้งที่ 2</p>
                            <p class="text-lg md:text-xl bg-purple-50 p-4">ครั้งที่ 3</p>
                            <p class="text-xl md:text-2xl p-4 text-[#156E68] font-bold">รวมทั้งหมด</p>
                        </div>
                        <div class="text-end text-[#866BC2] grow">
                            <p class="text-lg md:text-xl font-semibold bg-purple-50 p-4">40
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-lg md:text-xl font-semibold p-4">39
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-lg md:text-xl font-semibold bg-purple-50 p-4">32
                                <span class="text-sm">Files</span>
                            </p>
                            <p class="text-xl md:text-2xl font-semibold p-4 text-[#B1BB1E]">123
                                <span class="text-base">Files</span>
                            </p>
                        </div>
                    </div>
                    <div class="mx-4">
                        <button type="button"
                            class="bg-[#866BC2] text-2xl text-white font-seminbold h-14 w-full rounded-lg">เรียกดู</button>
                    </div>
                </div>
                <!--  -->
                <div class="bg-white rounded-lg shadow-md p-6 h-full md:h-[450px] w-full">
                    <h1 class="text-2xl md:text-3xl  ps-2 xl:ps-3 font-bold font-sans antialiased text-[#433878]">
                        คลังทรัพยากร
                    </h1>
                    <div class="mx-4 my-7">
                        <div class="flex w-full h-40 items-center">
                            <div class="w-full h-full bg-purple-50 rounded-l-lg p-4 text-center">
                                <p class="text-3xl md:text-4xl font-bold text-[#156E68] py-5">67</p>
                                <p class="text-xl md:text-xl font-bold text-gray-500">สื่อการสอน</p>
                            </div>
                            <div class="w-full h-full bg-gray-50 rounded-r-lg p-4 text-center">
                                <p class="text-3xl md:text-4xl font-bold text-[#156E68] py-5">152</p>
                                <p class="text-xl md:text-xl font-bold text-gray-500">แผนฯ ที่คัดเลือก</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="bg-white rounded-lg shadow-md p-6 h-full md:h-[450px] w-full">

                </div>
            </div>
        </div>
</body>

</html>