<?php
// public/index.php
require  '../helpers.php';

$pageHtml = render('pages/reflection.php');

echo layout('base.php', $pageHtml, ['title'  => 'reflection',]);
