<?php

use glxtm\scriptsControl\admin\widgets\header\Header;
use glxtm\scriptsControl\core\Core;

?>
<div class="wrap">
    <?= Header::widget(['tab' => 'settings']) ?>
    <?php Core::$plugin->settings->showPage(false) ?>
</div>