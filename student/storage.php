<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/resoure.php');

echo layout('/base.php', $pageHtml, ['title'  => 'storage',]);
