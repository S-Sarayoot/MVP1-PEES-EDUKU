<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/workshop.php');

echo layout('/base.php', $pageHtml, ['title'  => 'workshop',]);
