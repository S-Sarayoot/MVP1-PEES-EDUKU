<?php
// public/index.php
require __DIR__ . '/helpers.php';

$pageHtml = render('pages/consulting.php');

echo layout('/base.php', $pageHtml, ['title'  => 'consulting',]);
