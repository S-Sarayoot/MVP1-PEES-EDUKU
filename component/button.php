<?php
// component/button.php

if (!isset($text))
    $text = "";
if (!isset($subtext))
    $subtext = "";

if (!isset($style))
    $style = "";

if (!isset($link))
    $link = "#";

switch ($style) {
    case "Workshop":
        $style = "bg-purple-50 border border-purple-700 text-purple-900 py-1 px-3 rounded-md text-shadow-md 
                  hover:ring transition-all ease-in-out 
                  hover:ring-purple-100 shadow-md hover:shadow-lg duration-300 hover:-translate-y-1 hover:bg-purple-200
                  active:-translate-y-1 active:bg-purple-200 active:shadow-lg active:ring hovactiveer:ring-purple-100";
        break;

    default:
        $style = "bg-gray-100 border border-gray-400 text-gray-700 py-1 px-3 rounded-md";
}
?>

<button class="<?= $style ?>" onclick="window.location.href='<?= htmlspecialchars($link, ENT_QUOTES, 'UTF-8') ?>'">
    <?= htmlspecialchars($text, ENT_QUOTES, 'UTF-8') ?>
    <?php if (!empty($subtext)): ?>
        <small class="block text-xs text-gray-500">
            <?= htmlspecialchars($subtext, ENT_QUOTES, 'UTF-8') ?>
        </small>
    <?php endif; ?>
</button>