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
        ]
    ]
]);
?>
