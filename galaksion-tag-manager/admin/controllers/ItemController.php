<?php

namespace glxtm\scriptsControl\admin\controllers;

use glxtm\scriptsControl\admin\forms\item\ItemForm;
use glxtm\scriptsControl\admin\widgets\itemRow\ItemRow;
use glxtm\scriptsControl\core\admin\AdminController;
use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\core\helpers\Json;
use glxtm\scriptsControl\plugin\entities\Area;
use glxtm\scriptsControl\plugin\entities\Item;
use ReflectionException;
use RuntimeException;

class ItemController extends AdminController
{

    public function init()
    {
        parent::init();
        add_action('plugins_loaded', [$this, 'initAjax']);
    }

    public function initAjax()
    {
        if (current_user_can('manage_options')) {
            add_action('wp_ajax_glxtm_add_item', [$this, 'ajaxAddItem']);
            add_action('wp_ajax_glxtm_edit_item', [$this, 'ajaxEditItem']);
            add_action('wp_ajax_glxtm_disable_item', [$this, 'ajaxDisableItem']);
            add_action('wp_ajax_glxtm_enable_item', [$this, 'ajaxEnableItem']);
            add_action('wp_ajax_glxtm_delete_item', [$this, 'ajaxDeleteItem']);
            add_action('wp_ajax_glxtm_sort', [$this, 'ajaxSort']);
        }
    }

    /**
     * Добавить элемент
     * @throws ReflectionException
     */
    public function ajaxAddItem()
    {
        $areaId = (string)Core::$plugin->request->get('areaId');
        if (!Area::isValid($areaId)) {
            throw new RuntimeException('Uncorrect area ID.');
        }

        $model = new ItemForm();
        if ($model->load(Core::$plugin->request->post()) && $model->validate()) {
            $item = new Item();
            $item->active = true;
            $item->areaId = $areaId;
            $model->toItem($item);
            Core::$plugin->items->add($item);
            echo '<script>jQuery(document).trigger("glxtmItemCreated", ' . Json::encode([
                                                                                            'areaId' => $item->areaId,
                                                                                            'html'   => ItemRow::widget(['item' => $item]),
                                                                                        ]) . ')</script>';
            wp_die();
        }

        $this->render('_modal_add', [
            'model'  => $model,
            'areaId' => $areaId,
        ]);
        wp_die();
    }

    /**
     * Редактировать элемент
     * @throws ReflectionException
     */
    public function ajaxEditItem()
    {
        $item = Core::$plugin->items->get(Core::$plugin->request->get('id'));
        if ($item === false) {
            throw new RuntimeException('Uncorrect item ID.');
        }

        $model = new ItemForm($item);
        if ($model->load(Core::$plugin->request->post()) && $model->validate()) {
            $model->toItem($item);
            Core::$plugin->items->saveAll();
            echo '<script>jQuery(document).trigger("glxtmItemUpdated", ' . Json::encode([
                                                                                            'id'   => $item->id,
                                                                                            'html' => ItemRow::widget(['item' => $item]),
                                                                                        ]) . ')</script>';
            wp_die();
        }

        $this->render('_modal_edit', [
            'model'  => $model,
            'itemId' => $item->id,
        ]);
        wp_die();
    }

    /**
     * Отключить элемент
     * @throws ReflectionException
     */
    public function ajaxDisableItem()
    {
        $item = Core::$plugin->items->get(Core::$plugin->request->get('id'));
        if ($item === false) {
            throw new RuntimeException('Uncorrect item ID.');
        }
        $item->active = false;
        Core::$plugin->items->saveAll();
        echo ItemRow::widget(['item' => $item]);
        wp_die();
    }

    /**
     * Включить элемент
     * @throws ReflectionException
     */
    public function ajaxEnableItem()
    {
        $item = Core::$plugin->items->get(Core::$plugin->request->get('id'));
        if ($item === false) {
            throw new RuntimeException('Uncorrect item ID.');
        }
        $item->active = true;
        Core::$plugin->items->saveAll();
        echo ItemRow::widget(['item' => $item]);
        wp_die();
    }

    /**
     * Удалить элемент
     * @throws ReflectionException
     */
    public function ajaxDeleteItem()
    {
        $item = Core::$plugin->items->get(Core::$plugin->request->get('id'));
        if ($item === false) {
            throw new RuntimeException('Uncorrect item ID.');
        }

        if (Core::$plugin->request->post('delete')) {
            Core::$plugin->items->delete($item);
            echo '<script>jQuery(document).trigger("glxtmItemDeleted", ' . Json::encode([
                                                                                            'id'   => $item->id,
                                                                                            'html' => '<div class="glxtmManage_deletedItem">' . esc_html__('Code Deleted', 'galaksion-tag-manager') . ' <small class="glxtmManage_deletedItem_hide">' . esc_html__('Hide', 'galaksion-tag-manager') . '</small></div>',
                                                                                        ]) . ')</script>';
            wp_die();
        }

        $this->render('_modal_delete_confirm', [
            'item' => $item,
        ]);
        wp_die();
    }

    public function ajaxSort()
    {
        Core::$plugin->items->updateSort(Core::$plugin->request->post('data'));
        wp_die();
    }
}
