<?php
// public/index.php
require  '../helpers.php';

$pageHtml = render('pages/workshop.php');

echo layout('base.php', $pageHtml, ['title'  => 'workshop',]);
