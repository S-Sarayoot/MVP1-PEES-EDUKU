<?php

component('components/workshop-list.php', [
  'title' => 'workshop',
  'instruction_title' => 'คำชี้แจง',
  'instruction_text'  => 'คำชี้แจง workshop รวม…',
  'workshops' => [
    [
      'name' => 'Workshop 1',
      'desc' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
      'buttons' => [
        ['label' => 'กิจกรรม',  'href' => '/workshop/1/activity'],
        ['label' => 'ทรัพยากร', 'href' => '/workshop/1/resources'],
        ['label' => 'สะท้อนคิด', 'href' => '/workshop/1/reflection'],
      ],
    ],
    [
      'name' => 'Workshop 2',
      'desc' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
    ],
    [
      'name' => 'Workshop 3',
      'desc' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Et corrupti similique nemo ratione earum?',
    ],
  ],
]);


?>

