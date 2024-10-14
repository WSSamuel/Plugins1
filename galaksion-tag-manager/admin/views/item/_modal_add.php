<?php
/**
 * @var $model \glxtm\scriptsControl\admin\forms\item\ItemForm
 * @var $areaId int
 */

use glxtm\scriptsControl\core\admin\helpers\AdminHtml;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\helpers\Html;

?>
<div class="glxtmModalBox">
    <div class="glxtmModalBox_close glxtmModal-close" title="<?= esc_attr__('Cancel', 'galaksion-tag-manager') ?>"></div>
    <div class="glxtmModalBox_title"><?= esc_html__('New Code', 'galaksion-tag-manager') ?></div>
    <form
        action="<?= AdminUrl::toAjax('glxtm_add_item', ['areaId' => $areaId]) ?>"
        data-ajax-form="1"
    >
        <div class="glxtmModalBox_body">

            <?php
            if ($model->hasErrors()) {
                echo '<div class="glxtmModalForm_errors">';
                foreach ($model->getErrorSummary() as $error) {
                    echo '<p>' . $error . '</p>';
                }
                echo '</div>';
            }
            ?>

            <div class="glxtmModalForm_field">
                <div class="glxtmModalForm_field_label">
                    <?= $model->getAttributeLabel('caption') ?>
                </div>
                <div class="glxtmModalForm_field_el">
                    <?= AdminHtml::textInput(Html::getInputName($model, 'caption'), $model->caption) ?>
                </div>
            </div>

            <div class="glxtmModalForm_field">
                <div class="glxtmModalForm_field_label">
                    <?= $model->getAttributeLabel('body') ?>
                </div>
                <div class="glxtmModalForm_field_el">
                    <?= AdminHtml::textarea(Html::getInputName($model, 'body'), $model->body) ?>
                </div>
            </div>

        </div>
        <div class="glxtmModalBox_footer">
            <div class="glxtmModalBox_footer_buttons">
                <?= AdminHtml::button(esc_html__('Cancel', 'galaksion-tag-manager'), [
                    'class' => 'glxtmModal-close ' . (is_rtl() ? 'glxtmFloatRight' : 'glxtmFloatLeft'),
                ]) ?>
                <?= AdminHtml::button(esc_html__('Add', 'galaksion-tag-manager'), [
                    'theme' => AdminHtml::BUTTON_THEME_PRIMARY,
                    'submit' => true,
                    'class' => is_rtl() ? 'glxtmFloatLeft' : 'glxtmFloatRight',
                ]) ?>
            </div>
        </div>
    </form>
</div>