<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/instructional.php');

echo layout('/base.php', $pageHtml, ['title'  => 'personal information',]);
