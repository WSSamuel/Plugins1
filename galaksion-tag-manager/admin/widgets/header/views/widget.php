<?php
/**
 * @var $tab string
 */

use glxtm\scriptsControl\admin\Rate;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;

?>
<h1>Galaksion Tag Manager</h1>
<h2 class="nav-tab-wrapper glxtmTabs">
    <a href="<?= AdminUrl::toOptions('scripts') ?>" class="nav-tab<?= $tab == 'scripts' ? ' nav-tab-active' : '' ?>">
        <span class="dashicons dashicons-editor-code"></span>
        <?= esc_html__('Scripts', 'galaksion-tag-manager') ?>
    </a>
    <a href="<?= AdminUrl::toOptions('scripts', 'settings') ?>" class="nav-tab<?= $tab == 'settings' ? ' nav-tab-active' : '' ?>">
        <span class="dashicons dashicons-admin-generic"></span>
        <?= esc_html__('Settings', 'galaksion-tag-manager') ?>
    </a>
    <a href="<?= Rate::LINK ?>" target="_blank" class="glxtmTabs_rate"><?= sprintf(
            esc_html__('Leave a %s plugin review on WordPress.org', 'galaksion-tag-manager'),
            '★★★★★'
        ) ?></a>
</h2>