<?php
return [
    'textDomain'             => 'galaksion-tag-manager',
    'bootstrap'              => [
        'admin',
        'activation',
        'front',
        'welcome',
    ],
    'pluginsLoadedBootstrap' => [
        'settings',
    ],
    'components'             => [
        'admin'      => \glxtm\scriptsControl\admin\Admin::class,
        'activation' => \glxtm\scriptsControl\plugin\Activation::class,
        'front'      => \glxtm\scriptsControl\front\Front::class,
        'items'      => \glxtm\scriptsControl\plugin\repositories\ItemRepository::class,
        'sidebars'   => \glxtm\scriptsControl\plugin\repositories\SidebarRepository::class,
        'options'    => \glxtm\scriptsControl\core\wp\Options::class,
        'rate'       => \glxtm\scriptsControl\admin\Rate::class,
        'request'    => \glxtm\scriptsControl\core\base\Request::class,
        'settings'   => [
            'class'                => \glxtm\scriptsControl\plugin\Settings::class,
            'initGroupsConfigFile' => __DIR__ . '/settings.php',
        ],
        'view'       => \glxtm\scriptsControl\core\base\View::class,
        'welcome'    => \glxtm\scriptsControl\modules\welcome\Welcome::class,
    ],
];
