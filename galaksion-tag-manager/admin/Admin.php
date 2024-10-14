<?php

namespace glxtm\scriptsControl\admin;

use glxtm\scriptsControl\admin\controllers\ItemController;
use glxtm\scriptsControl\admin\controllers\RateController;
use glxtm\scriptsControl\admin\controllers\ScriptsController;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\core\helpers\Html;
use ReflectionException;

class Admin extends BaseObject
{

    protected $pageScriptsHook;

    /**
     * @throws ReflectionException
     */
    public function init()
    {
        if (is_admin()) {
            add_action('admin_menu', [$this, 'menu']);
            add_action('admin_enqueue_scripts', [$this, 'assets']);

            // Ссылки в списке плагинов
            add_filter('plugin_action_links_' . Core::$plugin->basename, function ($links) {
                array_unshift($links, Html::a(esc_html__('Scripts', 'galaksion-tag-manager'), AdminUrl::toOptions('scripts')));
                return $links;
            });

            // Контроллеры
            ItemController::getInstance();
            RateController::getInstance();
            ScriptsController::getInstance();
        }
    }

    public function menu()
    {
        $this->pageScriptsHook = add_submenu_page(
            'options-general.php',
            esc_html__('Scripts', 'galaksion-tag-manager'),
            esc_html__('Scripts', 'galaksion-tag-manager'),
            'manage_options',
            Core::$plugin->prefix . 'scripts',
            [ScriptsController::class, 'router']
        );
    }

    /**
     * Подключение ресурсов
     * @param string $hook
     */
    public function assets($hook)
    {
        if ($hook == $this->pageScriptsHook ||
            Core::$plugin->rate->isShow() ||
            Core::$plugin->welcome->isShow()
        ) {
            wp_enqueue_style(Core::$plugin->prefix . 'adminMain', Core::$plugin->url . '/admin/assets/main.min.css', [], Core::$plugin->version);
            wp_enqueue_script(Core::$plugin->prefix . 'adminMain', Core::$plugin->url . '/admin/assets/main.min.js', ['jquery', 'jquery-ui-sortable'], Core::$plugin->version);
            wp_localize_script(Core::$plugin->prefix . 'adminMain', 'glxtmMain', [
                'ajaxUrl' => admin_url('admin-ajax.php'),
            ]);
        }
    }
}
