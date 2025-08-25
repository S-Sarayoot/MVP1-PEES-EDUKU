<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/home.php');

echo layout('/base.php', $pageHtml, ['title'  => 'หน้าแรก',]);
