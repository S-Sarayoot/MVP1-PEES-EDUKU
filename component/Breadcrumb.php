<?php
// component/Breadcrumb.php 
function Breadcrumb() {
    $parts = explode("/", string:  $_SERVER['REQUEST_URI']);

    // ลบค่าว่างออก (เพราะมี / ขึ้นต้นและท้าย)
    $parts = array_filter($parts);

    // จัด index ใหม่ให้เป็น array ปกติ (0,1,2,...)
    $parts = array_values($parts);

    $newPath = [];
    foreach ($parts as $index => $part) {
        $newPath[$index] = ['name'=>($index == 0 ? 'Home' : $part), 'path'=> 'https://dev.kittelweb.xyz/'.implode("/", array_slice($parts, 0, $index + 1))];
    }

    return $newPath;
}

$Breadcrumb = Breadcrumb(); 
?>


<p class="text-gray-700 mb-4 mr-4">
          <?php 

          foreach($Breadcrumb as $index => $item){ 
            if(count($Breadcrumb) == 1) break;
            if($index == count($Breadcrumb) -1){
              echo '<span class="text-gray-700 mb-4 mr-4">'.$item['name'].'</span>';
            }else{
              echo '<a href="'.$item['path'].'" class="text-gray-400  hover:font-semibold hover:text-[#433878]">'.$item['name'].'</a> > ';
            }
          }
        
          
          ?>
</p>

