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
    <title>EDU KU - Storage</title>
</head>

<body class="bg-gray-100">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once'../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-gray-500">คลังทรัพยากร</h1>
                    <p class="text-gray-700"><a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                            class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                        > Storage</p>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg text-[#433878]">ประเภทสื่อการสอน</h2>
                        <button onclick="toggleModal(true)"
                            class="bg-green-100 text-green-800 rounded-md text-sm p-2 cursor-pointer">+
                            เพิ่มสื่อการสอน</button>
                        <?php include'../component/uploadform.php'?>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- content -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:h-full max-h-[200px] overflow-y-auto">
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/image_icon.png" alt="image" class="size-14">
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">Image</p>
                                <p class="text-gray-500 text-sm">17 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#FCEDFF] p-4 rounded-xl">
                                <img src="../image/play_icon.png" alt="image" class="h-6 w-6">
                            </div>
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">Videos</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/document_icon.png" alt="image" class="size-14">
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">แหล่งการเรียนรู้แนะนำ</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#E0E9FF] p-4 rounded-xl">
                                <img src="../image/storyboard_icon.png" alt="image" class="h-6 w-6">
                            </div>
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">แผนการจัดการเรียนรู้</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#FFE0F9] p-4 rounded-xl">
                                <img src="../image/script_icon.png" alt="image" class="h-6 w-6">
                            </div>
                            <div class="mx-6">
                                <p class="text-gray-500 font-semibold my-1">เกณฑ์การประเมิณ</p>
                                <p class="text-gray-500 text-sm">47 files</p>
                            </div>
                        </div>
                    </div>
                    <!--  -->
                </div>
            </div>
            <!--  -->
            <div class="flex flex-col">
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg text-[#433878]">สื่อการสอนทั้งหมด</h2>
                        <a class="text-gray-800 rounded-md text-sm p-2">
                            View all
                        </a>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- table th -->
                    <div class="flex flex-col w-full h-full">
                        <!-- th -->
                        <div class="flex text-left text-sm font-semibold text-gray-500 bg-gray-100">
                            <p class="py-2 px-4 w-2/5">File Name</p>
                            <p class="py-2 px-4 w-1/5">Type</p>
                            <p class="py-2 px-4 w-1/5">Date</p>
                            <p class="py-2 text-center w-1/5">Action</p>
                        </div>

                        <!-- td -->
                        <div class="max-h-82 md:max-h-42 overflow-y-auto">
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">tiktok video
                                </p>
                                <p class="py-2 px-4 w-1/5">Videos</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                            <div class="flex text-left text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                <p class="py-2 px-4 w-2/5 break-all">example_image.jpg
                                </p>
                                <p class="py-2 px-4 w-1/5">Image</p>
                                <p class="py-2 px-4 w-1/5">2023-10-01</p>
                                <div class="flex flex-col md:flex-row justify-center w-1/5">
                                    <button class="text-blue-500 hover:underline">Edit</button>
                                    <button class="text-red-500 hover:underline md:ml-2">Delete</button>
                                </div>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                    <!--  -->
                </div>
            </div>
</body>

</html>