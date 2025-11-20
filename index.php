<?php 
  
  require_once __DIR__.'/vendor/autoload.php';
  $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotenv->load();
  $base_url = $_ENV['APP_URL'] ?? '';

  require_once(__DIR__ . '/backend/config/credential.php');
  if (empty($credential_username)) {
    // หากยังไม่ได้ล็อกอิน ให้ redirect ไปหน้า logout
    header("Location: " . $base_url . "/logout.php");
    exit();
  }
  
  //require_once 'header.php';

  
  if($credential_user_type == 'admin') {
    $sideBarMenu = [
      [ "name" => "Dashboard", "path" => $base_url . "/admin/" ],
      [ "name" => "คลังทรัพยากร", "path" => $base_url . "/admin/storage_admin" ],
      [ "name" => "Workshop/แผนฯ", "path" => $base_url . "/admin/workshop_admin" ],
      [ "name" => "ผู้ใช้งาน", "path" => $base_url . "/admin/users_admin" ],
      [ "name" => "ระบบให้คำปรึกษา", "path" => $base_url . "/admin/consulting" ],
      [ "name" => "รายงาน/log", "path" => $base_url . "/admin/log_admin" ]
    ];
    echo '<script>';
    echo 'localStorage.setItem("sideMenu", ' . json_encode(json_encode($sideBarMenu)) . ');';
    echo 'window.location.href = "' . $base_url . '/admin/";';
    echo '</script>';
    exit();
  } else if($credential_user_type == 'student') {     
        $sideBarMenu = [
          [ "name" => "Dashboard", "path" => $base_url . "/student/" ],
          [ "name" => "Workshop/แผนฯ", "path" => $base_url . "/student/workshop" ],
          [ "name" => "คลังทรัพยากร", "path" => $base_url . "/student/storage" ],
          
          [ "name" => "ระบบสะท้อนความคิด", "path" => $base_url . "/student/workshop/reflection" ],
          [ "name" => "ระบบให้คำปรึกษา", "path" => $base_url . "/student/consulting" ],
          [ "name" => "ผู้ใช้งาน", "path" => $base_url . "/student/user" ]
        ];
        echo '<script>';
        echo 'localStorage.setItem("sideMenu", ' . json_encode(json_encode($sideBarMenu)) . ');';
        echo 'window.location.href = "' . $base_url . '/student/";';
        echo '</script>';
        exit();
  } else if($credential_user_type == 'teacher') {   
        $sideBarMenu = [
          [ "name" => "Dashboard", "path" => $base_url . "/teacher/" ],
          [ "name" => "คลังทรัพยากร", "path" => $base_url . "/teacher/media" ],
          [ "name" => "Workshop", "path" => $base_url . "/teacher/workshop" ],
          [ "name" => "ผู้ใช้งาน", "path" => $base_url . "/teacher/user" ]
        ];
        echo '<script>';
        echo 'localStorage.setItem("sideMenu", ' . json_encode(json_encode($sideBarMenu)) . ');';
        echo 'window.location.href = "' . $base_url . '/teacher/";';
        echo '</script>';
        exit();
  } else{
    header("Location: ".$base_url."/logout.php");
    exit();
  }
  
  //include_once 'footer.php';
  
?>
