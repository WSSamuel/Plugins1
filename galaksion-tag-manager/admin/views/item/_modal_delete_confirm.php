<?php
/**
 * @var $item \glxtm\scriptsControl\plugin\entities\Item
 */

use glxtm\scriptsControl\core\admin\helpers\AdminHtml;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\helpers\Html;

?>
<div class="glxtmModalBox">
    <div class="glxtmModalBox_close glxtmModal-close" title="<?= esc_attr__('Cancel', 'galaksion-tag-manager') ?>"></div>
    <div class="glxtmModalBox_title"><?= esc_html__('Confirmation', 'galaksion-tag-manager') ?></div>
    <form
        action="<?= AdminUrl::toAjax('glxtm_delete_item', ['id' => $item->id]) ?>"
        data-ajax-form="1"
    >
        <div class="glxtmModalBox_body">
            <?php if ($item->caption) { ?>
                <p>
                    <b><?= Html::encode($item->caption) ?></b>
                </p>
            <?php } ?>
            <p>
                <i><?= nl2br(Html::encode($item->body)) ?></i>
            </p>
            <p>
                <?= esc_html__('Are you sure to delete this code?', 'galaksion-tag-manager') ?>
            </p>
            <?= Html::hiddenInput('delete', 1) ?>
        </div>
        <div class="glxtmModalBox_footer">
            <div class="glxtmModalBox_footer_buttons">
                <?= AdminHtml::button(esc_html__('Cancel', 'galaksion-tag-manager'), [
                    'class' => 'glxtmModal-close ' . (is_rtl() ? 'glxtmFloatRight' : 'glxtmFloatLeft'),
                ]) ?>
                <?= AdminHtml::button(esc_html__('Delete', 'galaksion-tag-manager'), [
                    'theme' => AdminHtml::BUTTON_THEME_LINK_DELETE,
                    'submit' => true,
                    'class' => is_rtl() ? 'glxtmFloatLeft' : 'glxtmFloatRight',
                ]) ?>
            </div>
        </div>
    </form>
</div>