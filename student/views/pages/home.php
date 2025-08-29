<?php
component('components/banner.php', [
    'id' => 'home1',
    'title' => 'Game based learning',
    'subtitle' => 'ช่วยคุณได้มากกว่าที่คิด',
    'mediaUrl' => '../image/defult.jpg'
]);

component('components/MenuCarousel.php', [
    'title' => 'สื่อการสอน',
    'items' => [
        [
            'label' => 'คลิปวิดีโอ',
            'description' => 'คลังวิดีโอ',
            'link' => '/video',
            'icon' => '/uploads/play-icon.png'
        ],
        [
            'label' => '3 คำ',
            'description' => 'Script',
            'link' => '/script',
            'icon' => ''
        ],
        [
            'label' => 'คลิปวิดีโอ',
            'description' => 'คลังวิดีโอ',
            'link' => '/video',
            'icon' => '/uploads/play-icon.png'
        ],
        [
            'label' => '3 คำ',
            'description' => 'Script',
            'link' => '/script',
            'icon' => ''
        ],
        [
            'label' => 'คลิปวิดีโอ',
            'description' => 'คลังวิดีโอ',
            'link' => '/video',
            'icon' => '/uploads/play-icon.png'
        ],
        [
            'label' => '3 คำ',
            'description' => 'Script',
            'link' => '/script',
            'icon' => ''
        ],
        [
            'label' => 'Quik 3s',
            'description' => 'Exam',
            'link' => '/exam',
            'icon' => ''
        ],
        [
            'label' => 'บทพูด',
            'description' => 'บทพูด',
            'link' => '/speech',
            'icon' => '/uploads/user-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],
        [
            'label' => 'Story board',
            'description' => 'Story board',
            'link' => '/storyboard',
            'icon' => '/uploads/storyboard-icon.png'
        ],


    ]
]);

component('components/workshop-list.php', [
  'title' => 'บทเรียน',
  'instruction_title' => 'คำชี้แจง',
  'instruction_text'  => 'คำชี้แจง workshop รวม…',
  'workshops' => [
    [
      'name' => 'Workshop 1',
      'desc' => 'คำชี้แจงเกี่ยวกับ workshop 1.. เวลา 3 ชั่วโมง',
      'buttons' => [
        ['label' => 'กิจกรรม',  'href' => '/workshop/1/activity'],
        ['label' => 'ทรัพยากร', 'href' => '/workshop/1/resources'],
        ['label' => 'สะท้อนคิด', 'href' => '/workshop/1/reflection'],
      ],
    ],
    [
      'name' => 'Workshop 2',
      'desc' => 'คำชี้แจง workshop 2.. เวลา 3 ชั่วโมง',
    ],
    [
      'name' => 'Workshop 3',
      'desc' => 'คำชี้แจง workshop 3.. เวลา 3 ชั่วโมง',
    ],
  ],
]);

?>
