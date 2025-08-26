<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/personal.php');

echo layout('/base.php', $pageHtml, ['title'  => 'personal information',]);
