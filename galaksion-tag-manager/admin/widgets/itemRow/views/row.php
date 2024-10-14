<?php
/**
 * @var $item \glxtm\scriptsControl\plugin\entities\Item
 */

use glxtm\scriptsControl\core\helpers\Html;

if ('' === $caption = $item->caption) {
    $caption = '<i>' . Html::encode(function_exists('mb_substr') ? mb_substr($item->body, 0, 32) : substr($item->body, 0, 32)) . '</i>';
} else {
    $caption = Html::encode($caption);
}
?>
<div class="glxtmManage_item<?= $item->active ? '' : ' glxtmManage_item-disabled' ?>" data-id="<?= $item->id ?>">
    <div class="glxtmManage_item_sortHandle">::</div>
    <div class="glxtmManage_item_caption"><?= $caption ?></div>
    <div class="glxtmManage_item_actions">
        <?php if ($item->active) { ?>
            <div class="glxtmManage_item_disable glxtmManage_item_action dashicons dashicons-hidden" title="<?= esc_attr__('Disable', 'galaksion-tag-manager') ?>"></div>
        <?php } else { ?>
            <div class="glxtmManage_item_enable glxtmManage_item_action dashicons dashicons-visibility" title="<?= esc_attr__('Enable', 'galaksion-tag-manager') ?>"></div>
        <?php } ?>
        <div class="glxtmManage_item_edit glxtmManage_item_action dashicons dashicons-edit" title="<?= esc_attr__('Edit', 'galaksion-tag-manager') ?>"></div>
        <div class="glxtmManage_item_delete glxtmManage_item_action dashicons dashicons-trash" title="<?= esc_attr__('Delete', 'galaksion-tag-manager') ?>"></div>
    </div>
</div>