<?php
// public/index.php
require __DIR__ . '/../helpers.php';

$pageHtml = render('pages/Workshop.php');

echo layout('/base.php', $pageHtml, ['title'  => 'Workshop',]);
