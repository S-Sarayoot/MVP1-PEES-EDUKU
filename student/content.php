<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/content.php');

echo layout('/base.php', $pageHtml, ['title'  => 'Content',]);
