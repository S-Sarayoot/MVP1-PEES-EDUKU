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
        <?php include_once '../component/sidebar.php' ?>

        <!-- Main Content -->
        <div
            class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">
            <div class="flex flex-col">
                <div class="flex justify-between mb-4 md:mx-4">
                    <h1 class="text-xl text-[#433878]">My instructional</h1>
                    <div>
                        <a href="https://dev.kittelweb.xyz/admin/dashboard_admin"
                                class="text-gray-400  hover:font-semibold hover:text-[#433878]">Home</a>
                        <span class="text-gray-400">> Storage > </span><span class="text-gray-700"></span>My instructional</span>
                    </div>
                </div>
                <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                    <div class="mb-2 flex justify-between items-center">
                        <h2 class="text-xl text-[#433878] font-semibold">สื่อการสอนของฉัน</h2>
                        <?php include '../component/dropdown.php' ?>
                    </div>
                    <hr class="border-0.5 border-gray-100 my-4 -mx-4">
                    <!--  -->
                    <!-- Card Container -->
                    <div id="cardWrapper" class="grid grid-cols-3 gap-4"></div>
                </div>
            </div>
        </div>
</body>

</html>