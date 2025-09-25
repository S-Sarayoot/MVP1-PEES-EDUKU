<?php
// public/index.php
require  '../helpers.php';

$pageHtml = render('pages/activity.php');

echo layout('base.php', $pageHtml, ['title'  => 'Workshop',]);
