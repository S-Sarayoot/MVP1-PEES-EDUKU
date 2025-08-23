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
        <?php include_once('../component/sidebar.php') ?>

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
                        <button class="bg-green-100 text-green-800 rounded-md text-sm p-2">
                            + เพิ่มสื่อการสอน
                        </button>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- content -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:h-full max-h-[200px] overflow-y-auto">
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/image_icon.png" alt="image" class="size-14">
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Image</p>
                                    <p class="text-gray-500">213 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">21 %</p>
                                    <p class="text-gray-500">21.24 GB</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#FCEDFF] p-4 rounded-xl">
                                <img src="../image/play_icon.png" alt="image" class="h-6 w-7">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Videos</p>
                                    <p class="text-gray-500">189 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">17 %</p>
                                    <p class="text-gray-500">19.54 GB</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <img src="../image/document_icon.png" alt="image" class="size-14">
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Documents</p>
                                    <p class="text-gray-500">283 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">28 %</p>
                                    <p class="text-gray-500">26.21 GB</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#E0E9FF] p-4 rounded-xl">
                                <img src="../image/storyboard_icon.png" alt="image" class="h-6 w-7">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Story board</p>
                                    <p class="text-gray-500">47 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">9 %</p>
                                    <p class="text-gray-500">10 GB</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#E7FFE0] p-4 rounded-xl">
                                <img src="../image/exam_icon.png" alt="image" class="h-6 w-7">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Exams</p>
                                    <p class="text-gray-500">128 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">16 %</p>
                                    <p class="text-gray-500">18.24 GB</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex p-2 rounded-lg border-1 border-gray-100 hover:border-gray-300 transition">
                            <div class="bg-[#FFE0F9] p-4 rounded-xl">
                                <img src="../image/script_icon.png" alt="image" class="h-6 w-7">
                            </div>
                            <div class="flex flex-col w-full">
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500 font-semibold ">Script</p>
                                    <p class="text-gray-500">109 files</p>
                                </div>
                                <div class="flex justify-between text-sm my-1 mx-6">
                                    <p class="text-gray-500">14 %</p>
                                    <p class="text-gray-500">14.23 GB</p>
                                </div>
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
                        <h2 class="text-lg text-[#433878]">สื่อการทั้งหมด</h2>
                        <a class="text-gray-800 rounded-md text-sm p-2">
                            View all
                        </a>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!-- table th -->
                    <table class="w-full h-full">
                        <thead class="bg-gray-100 h-fit">
                            <tr class="text-left text-sm font-semibold text-gray-500">
                                <th class="py-2 px-4">File Name</th>
                                <th class="py-2 px-4">Type</th>
                                <th class="py-2 px-4">size</th>
                                <th class="py-2 px-4">Date</th>
                                <th class="py-2 px-4">Action</th>
                            </tr>
                        </thead>
                    </table>
                    <!--  -->
                    <!-- table td -->
                    <div class="overflow-y-auto max-h-55 md:max-h-43 overflow-auto">
                        <table class="w-full">
                            <tbody>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">ก-ฮ.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">1 MB</td>
                                    <td class="py-2 px-4">2022-08-02</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">exam_1.jpg</td>
                                    <td class="py-2 px-4">Exam</td>
                                    <td class="py-2 px-4">3 MB</td>
                                    <td class="py-2 px-4">2024-11-11</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="text-sm text-gray-500 border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-2 px-4">example_image.jpg</td>
                                    <td class="py-2 px-4">Image</td>
                                    <td class="py-2 px-4">2.5 MB</td>
                                    <td class="py-2 px-4">2023-10-01</td>
                                    <td class="py-2 px-4">
                                        <div class="flex flex-col md:flex-row">
                                            <button class="text-blue-500 hover:underline">Edit</button>
                                            <button class="text-red-500 hover:underline ml-2">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--  -->
                </div>
            </div>
</body>

</html>