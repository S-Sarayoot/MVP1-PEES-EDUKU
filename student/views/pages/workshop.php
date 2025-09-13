<?php
component('components/workshop-list.php', [
  'title' => 'workshop',
  'instruction_title' => 'คำชี้แจง',
  'instruction_text'  => 'คำชี้แจง workshop รวม…',
  'workshops' => [
    [
      'id'  => 1,
      'name' => 'Workshop 1',
      'desc' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum? ',
      'status'  => 'active', // active, upcoming, completed
    ],
    [
      'id'  => 2,
      'name' => 'Workshop 2',
      'desc' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
      'status'  => 'active', // active, upcoming, completed
    ],
    [
      'id'  => 3,
      'name' => 'Workshop 3',
      'desc' => 'ระบบยังไม่เปิดให้ทำในขณะนี้',
      'status'  => 'upcoming', // active, upcoming, completed
    ],
  ],
]);
?>

