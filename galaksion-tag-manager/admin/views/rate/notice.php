<?php

use glxtm\scriptsControl\admin\Rate;
use glxtm\scriptsControl\core\admin\helpers\AdminHtml;

?>
<div class="notice notice-info glxtmNotice glxtmRate">
    <p>
        <?= esc_html__('Hello!', 'galaksion-tag-manager') ?>
        <br>
        <?= sprintf(
            esc_html__('We are very pleased that you are using the %s plugin within a few days.', 'galaksion-tag-manager'),
            '<b>Galaksion Tag Manager</b>'
        ) ?>
        <br>
        <?= esc_html__('Please rate plugin. It will help us a lot.', 'galaksion-tag-manager') ?>
    </p>
    <p class="glxtmNotice_buttons">
        <?= AdminHtml::buttonLink(esc_html__('Rate the plugin', 'galaksion-tag-manager'), Rate::LINK, [
            'attrs' => [
                'data-action' => 'glxtm_rate',
                'target' => '_blank',
            ],
            'theme' => AdminHtml::BUTTON_THEME_PRIMARY,
        ]) ?>
        <?= AdminHtml::button(esc_html__('Remind later', 'galaksion-tag-manager'), [
            'attrs' => [
                'data-action' => 'glxtm_show_later',
            ],
            'theme' => AdminHtml::BUTTON_THEME_LINK,
        ]) ?>
        <?= AdminHtml::button(esc_html__('I\'ve already rated the plugin', 'galaksion-tag-manager'), [
            'attrs' => [
                'data-action' => 'glxtm_already_rate',
            ],
            'theme' => AdminHtml::BUTTON_THEME_LINK,
        ]) ?>
    </p>
    <p>
        <b><?= esc_html__('Thank you very much!', 'galaksion-tag-manager') ?></b>
    </p>
</div>