<?php

namespace glxtm\scriptsControl\plugin;

use glxtm\scriptsControl\admin\Admin;
use glxtm\scriptsControl\admin\Rate;
use glxtm\scriptsControl\core\base\BasePlugin;
use glxtm\scriptsControl\core\base\Request;
use glxtm\scriptsControl\core\base\View;
use glxtm\scriptsControl\core\wp\Options;
use glxtm\scriptsControl\modules\welcome\Welcome;
use glxtm\scriptsControl\plugin\repositories\ItemRepository;
use glxtm\scriptsControl\plugin\repositories\SidebarRepository;

/**
 * @property Admin $admin
 * @property-read Activation $activation
 * @property ItemRepository $items
 * @property SidebarRepository $sidebars
 * @property Options $options
 * @property Rate $rate
 * @property Request $request
 * @property Settings $settings
 * @property View $view
 * @property-read Welcome $welcome
 */
class Plugin extends BasePlugin
{

    private function pluginI18n()
    {
        __('A great way to insert and manage custom code (CSS, JS, meta tags, etc.) into website before &lt;/head&gt;, after &lt;body&gt; or before &lt;/body&gt;.', 'galaksion-tag-manager');
    }
}
