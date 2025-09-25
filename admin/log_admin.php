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
    <title>EDU KU - Log</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex justify-between">
                <h1 class="text-xl text-[#433878] mb-4 md:mx-4">ประวัติ</h1>
                <p class="text-gray-700 mb-4 mr-4"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                        class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                    > Log </p>
            </div>
            <div
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shdow transition-tranform ease-in-out duration-200">
                <h1 class="text-xl mx-2 text-[#433878]"> History</h1>
                <div class="flex text-sm mb-2 p-2 bg-purple-50 rounded-lg border border-purple-200 my-4 mx-2">
                    <span class="font-semibold underline mx-4 text-purple-800">คำชี้แจง</span>
                    <span>ประวัตกิจกรรมภายในเว็บไซต์</span>
                </div>
                <div class="mt-6">
                    <p class="text-sm">May 03 2020</p>
                    <div class="flex my-2">
                        <div class="flex flex-col items-center whitespace-nowrap">
                            <p class="text-xs">13:23 น.</p>
                            <div class="size-7 rounded-full bg-purple-400"></div>
                            <div class="border border-gray-600 w-0 h-8"></div>
                            <p class="text-xs">13:23 น.</p>
                            <div class="size-7 rounded-full bg-gray-400/30"></div>
                            <div class="border border-gray-600 w-0 h-8"></div>
                            <p class="text-xs">13:23 น.</p>
                            <div class="size-7 rounded-full bg-gray-400/30"></div>
                            <div class="border border-gray-600 w-0 h-8"></div>
                            <p class="text-xs">13:23 น.</p>
                            <div class="size-7 rounded-full bg-gray-400/30"></div>
                        </div>
                        <div class="w-full h-full my-4 flex flex-col gap-7 text-xs">
                            <div
                                class="bg-white border border-purple-200 rounded-lg w-full p-2 hover:border-purple-200 transition-all hover:-translate-y-0.5 hover:shadow-md duration-200 ease-in-out">
                                <p class="text-blue-500 font-semibold">นิสิต [6849572002]</p>
                                <p class="text-gray-700">ส่งกิจกรรม Workshop 1</p>
                            </div>
                            <div
                                class="bg-white border border-purple-200 rounded-lg w-full p-2 hover:border-purple-200 transition-all hover:-translate-y-0.5 hover:shadow-md duration-200 ease-in-out">
                                <p class="text-blue-500 font-semibold">ผู้ทรงคุณวุฒิ [TCH1922]</p>
                                <p class="text-gray-700">เพิ่มสื่อการสอน</p>
                            </div>
                            <div
                                class="bg-white border border-purple-200 rounded-lg w-full p-2 hover:border-purple-200 transition-all hover:-translate-y-0.5 hover:shadow-md duration-200 ease-in-out">
                                <p class="text-blue-500 font-semibold">ผู้ทรงคุณวุฒิ [TCH1922]</p>
                                <p class="text-gray-700">เพิ่มสื่อการสอน</p>
                            </div>
                            <div
                                class="bg-white border border-purple-200 rounded-lg w-full p-2 hover:border-purple-200 transition-all hover:-translate-y-0.5 hover:shadow-md duration-200 ease-in-out">
                                <p class="text-blue-500 font-semibold">ผู้ทรงคุณวุฒิ [TCH1922]</p>
                                <p class="text-gray-700">เพิ่มสื่อการสอน</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>