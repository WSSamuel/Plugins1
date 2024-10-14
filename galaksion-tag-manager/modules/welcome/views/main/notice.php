<?php

use glxtm\scriptsControl\core\admin\helpers\AdminHtml;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;

?>
<div class="notice notice-info glxtmNotice glxtmWelcome">
    <p>
        <?= sprintf(
        /* translators: %s: Galaksion Tag Manager */
            esc_html__('%s — a great way to insert and manage custom code (CSS, JS, meta tags, etc.) into website.', 'galaksion-tag-manager'),
            '<b>Galaksion Tag Manager</b>'
        ) ?>
    </p>
    <p class="glxtmNotice_buttons">
        <?= AdminHtml::buttonLink(esc_html__('Go to page "Scripts"', 'galaksion-tag-manager'), AdminUrl::toOptions('scripts'), [
            'theme' => AdminHtml::BUTTON_THEME_PRIMARY,
        ]) ?>
        <?= AdminHtml::button(esc_html__('Hide', 'galaksion-tag-manager'), [
            'class' => 'glxtmWelcome_hide',
            'theme' => AdminHtml::BUTTON_THEME_LINK,
        ]) ?>
    </p>
</div>