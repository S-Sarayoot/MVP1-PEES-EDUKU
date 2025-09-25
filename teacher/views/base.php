<?php
// app/views/layouts/base.php
function path_external($type,$file) {
    $parts = explode("/", string:  $_SERVER['REQUEST_URI']);

    // ลบค่าว่างออก (เพราะมี / ขึ้นต้นและท้าย)
    $parts = array_filter($parts);

    // จัด index ใหม่ให้เป็น array ปกติ (0,1,2,...)
    $parts = array_values($parts);

    $sidebar_path = "";
    foreach ($parts as $index => $part) {
      if($index > 0 && $part !== "Workshop" ){ break;};
        $sidebar_path .= "../";
    }

    return $sidebar_path. ($type == "" ? "" : $type . "/") . $file;
}
?>

<!doctype html>
<html lang="th">
<head>
  <meta charset="utf-8">
  <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap"
        rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="<?php echo path_external('', 'global.css') ?>" rel="stylesheet">
    <script src="<?php echo path_external('', 'global.js') ?>"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <title>EDU KU - <?= htmlspecialchars($title ?? 'Untitled') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  </head>

  
  <body class="bg-gray-100 ">
    <div class="grid grid-cols-12 grid-rows-10 md:grid-rows-12 gap-4 max-h-screen overflow-y-auto ">
        <!-- Navigation -->
        <?php include_once(path_external('component', 'sidebar.php')) ?>

        <!-- Main Content -->
        <div class="col-span-12 md:col-span-9 xl:col-span-10 row-span-9 md:row-span-11 w-full h-full mx-auto pb-8 md:py-2 px-4 md:ps-0 pe-4 max-md:mt-16 overflow-y-auto">

        <?php include_once(path_external('component', 'Breadcrumb.php')) ?>
          <?= $content /* เนื้อหาหน้าเพจ */ ?>
        </div>
</body>