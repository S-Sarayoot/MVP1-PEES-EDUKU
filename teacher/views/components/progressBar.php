<?php
// ===== Hatched Progress (PHP) =====
// ใช้: include ไฟล์นี้ แล้วส่ง $items (label, value 0..100)
// ตัวเลือก: $height(px), $color(hex/rgb), $rounded(bool), $showPercent(bool)

$items       = $items       ?? [
  ['label' => 'workshop 1', 'value' => 75],
  ['label' => 'workshop 2', 'value' => 60],
  ['label' => 'workshop 3', 'value' => 50],
];
$height      = $height      ?? 16;
$color       = $color       ?? '#4F46E5'; // สีแท่งฝั่งที่ทำแล้ว
$rounded     = $rounded     ?? true;
$showPercent = $showPercent ?? true;

$cid = 'hp_' . substr(md5(json_encode($items) . rand()), 0, 6);
$h = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>
<style>
  #<?= $cid ?> .hp-row { margin-bottom: 12px; }
  #<?= $cid ?> .hp-head { display:flex; align-items:baseline; justify-content:space-between; margin-bottom:6px; }
  #<?= $cid ?> .hp-bar  { position:relative; background:#EEF0F7; overflow:hidden; }
  #<?= $cid ?> .hp-fill { position:absolute; left:0; top:0; height:100%; }
  #<?= $cid ?> .hp-hatch{
    position:absolute; right:0; top:0; height:100%;
    background-image: repeating-linear-gradient(
      135deg,
      rgba(0,0,0,0.12) 0,
      rgba(0,0,0,0.12) 6px,
      transparent 6px,
      transparent 12px
    );
  }
</style>

<div id="<?= $cid ?>" class="hp-wrap" style="w-full background:#fff; border-radius:12px; box-shadow:0 6px 16px rgba(0,0,0,.08); padding:16px;">
  <?php foreach ($items as $it): 
    $label = $it['label'] ?? '';
    $val   = max(0, min(100, (float)($it['value'] ?? 0)));
    $remain= 100 - $val;
  ?>
    <div class="hp-row">
      <div class="hp-head">
        <span style="color:#374151;"><?= $h($label) ?></span>
        <?php if ($showPercent): ?>
          <span style="color:#6B7280; font-size:12px;"><?= $val ?>%</span>
        <?php endif; ?>
      </div>
      <div class="hp-bar h-8"
           role="progressbar"
           aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= $val ?>"
           aria-label="<?= $h($label) . ' ' . $val . '%' ?>"
           style="">
        <div class="hp-fill"  style="width:<?= $val ?>%; background: <?= $h($color) ?>;"></div>
        <div class="hp-hatch" style="width:<?= $remain ?>%;"></div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
