<?php

namespace glxtm\scriptsControl\front;

use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\core\helpers\ArrayHelper;
use glxtm\scriptsControl\plugin\entities\Area;

class Front extends BaseObject
{

    public function init()
    {
        add_action('plugins_loaded', function () {
            $itemsByArea = Core::$plugin->items->findAllGroupedByArea(true);

            if ($itemsByArea[Area::HEAD]) {
                add_action('wp_head', function () use ($itemsByArea) {
                    echo implode("\n", ArrayHelper::getColumn($itemsByArea[Area::HEAD], 'body'));
                });
            }

            if ($itemsByArea[Area::BODY_BEGIN]) {
                $html = implode("\n", ArrayHelper::getColumn($itemsByArea[Area::BODY_BEGIN], 'body'));
                if (Core::$plugin->settings->getUseWpBodyOpen()) {
                    add_action('wp_body_open', function () use ($html) {
                        echo $html;
                    }, 1);
                } else {
                    add_action('template_include', function ($template) use ($html) {
                        ob_start(function ($buffer) use ($html) {
                            return preg_replace('/<body[^>]*>/imu', '$0' . $html, $buffer, 1);
                        });

                        return $template;
                    }, 999);
                }
            }

            if ($itemsByArea[Area::POST_BEGIN] || $itemsByArea[Area::POST_END]) {
                add_action('the_post', function (&$post) use ($itemsByArea) {
                    $post->post_content =
                        implode('', ArrayHelper::getColumn($itemsByArea[Area::POST_BEGIN], 'body')) .
                        $post->post_content .
                        implode('', ArrayHelper::getColumn($itemsByArea[Area::POST_END], 'body'));
                }, 999);
            }

            $sidebarExpose = false;

            $sidebarTags = [];

            wp_register_sidebar_widget(
                'glxtm-sidebar-first',
                '',
                function ($args) use (&$sidebarTags) {
                    if (isset($sidebarTags[$args['id']]['first'])) {
                        echo $args['before_widget'];
                        echo $sidebarTags[$args['id']]['first'];
                        echo $args['after_widget'];
                    }
                }
            );

            wp_register_sidebar_widget(
                'glxtm-sidebar-last',
                '',
                function ($args) use (&$sidebarTags) {
                    if (isset($sidebarTags[$args['id']]['last'])) {
                        echo $args['before_widget'];
                        echo $sidebarTags[$args['id']]['last'];
                        echo $args['after_widget'];
                    }
                }
            );

            foreach (Core::$plugin->sidebars->findAll() as $sidebar) {
                if (count($tags = ArrayHelper::getColumn($itemsByArea[Area::SIDEBAR_FIRST_PREFIX . $sidebar->id], 'body'))) {
                    $sidebarTags[$sidebar->id]['first'] = implode('', $tags);
                }
                if (count($tags = ArrayHelper::getColumn($itemsByArea[Area::SIDEBAR_LAST_PREFIX . $sidebar->id], 'body'))) {
                    $sidebarTags[$sidebar->id]['last'] = implode('', $tags);
                }
            }

            if (isset($_COOKIE['__expose_sidebars']) && $_COOKIE['__expose_sidebars']) {
                $sidebarExpose = true;
                wp_register_sidebar_widget(
                    'glxtm-sidebar-exposer',
                    'Galaksion sidebar exposer',
                    function ($args) {
                        echo $args['before_widget'];
                        echo '<style>
                            .glxtmSidebarHeader {
                                    display:block!important;
                                    box-sizing: border-box!important; 
                                    width: 100%!important;
                                    border: 0!important;
                                    padding: 10px!important;
                                    margin: 10px 0!important;
                                    text-align:center!important;
                            }
                            .glxtmSidebarExposer,.glxtmSidebarExposer:active, .glxtmSidebarExposer:link, .glxtmSidebarExposer:visited {
                                    display:block!important;
                                    box-sizing: border-box!important;
                                    width: 100%!important;
                                    margin: 10px 0 0 0!important;
                                    padding:7px 14px!important;
                                    text-align:center!important;
                                    color: #0071a1!important; 
                                    background: #f3f5f6!important; 
                                    border: 1px solid #0071a1!important;
                                    border-radius: 10px;
                                    white-space: nowrap;
                                    font: 22px/36px Arial!important;
                                    text-decoration: none!important;
                            }
                            .glxtmSidebarExposer:hover {color: #333!important; border: 1px solid #555!important; background: #ccc!important;}
                        </style>';
                        echo '<div class="glxtmSidebarHeader">';
                        echo 'Sidebar ID: <u>' . $args['id'] . '</u><br />';
                        echo '<a class="glxtmSidebarExposer"
                         href="' . AdminUrl::toOptions('scripts', 'addSidebar', ['id' => $args['id']]) . '"
                         >Add tags to this sidebar</a>';
                        echo '</div>';
                        echo $args['after_widget'];
                    }
                );
            }

            if ($sidebarExpose || count($sidebarTags) > 0) {
                add_action('sidebars_widgets', function ($widgets) use ($sidebarExpose, $sidebarTags) {
                    // first run
                    foreach ($widgets as $sidebar => $_) {
                        if ($sidebar != 'wp_inactive_widgets') {
                            if (isset($sidebarTags[$sidebar]['first'])) {
                                array_unshift($widgets[$sidebar], 'glxtm-sidebar-first');
                            }
                            if ($sidebarExpose) {
                                array_unshift($widgets[$sidebar], 'glxtm-sidebar-exposer');
                            }
                            if (isset($sidebarTags[$sidebar]['last'])) {
                                array_push($widgets[$sidebar], 'glxtm-sidebar-last');
                            }
                        }
                    }

                    return $widgets;
                }, 999);
            }

            if (Core::$plugin->settings->getUsePlaceholders()) {
                $placeholders = [];
                if ($itemsByArea[Area::CONTENT_PLACEHOLDER_1]) {
                    $placeholders['<!-- glx-tag-1 -->'] = implode("\n", ArrayHelper::getColumn($itemsByArea[Area::CONTENT_PLACEHOLDER_1], 'body'));
                }
                if ($itemsByArea[Area::CONTENT_PLACEHOLDER_2]) {
                    $placeholders['<!-- glx-tag-2 -->'] = implode("\n", ArrayHelper::getColumn($itemsByArea[Area::CONTENT_PLACEHOLDER_2], 'body'));
                }
                if ($itemsByArea[Area::CONTENT_PLACEHOLDER_3]) {
                    $placeholders['<!-- glx-tag-3 -->'] = implode("\n", ArrayHelper::getColumn($itemsByArea[Area::CONTENT_PLACEHOLDER_3], 'body'));
                }
                if ($placeholders) {
                    add_action('template_include', function ($template) use ($placeholders) {
                        ob_start(function ($buffer) use ($placeholders) {
                            return strtr($buffer, $placeholders);
                        });

                        return $template;
                    }, 999);
                }
            }

            if ($itemsByArea[Area::BODY_END]) {
                add_action('wp_footer', function () use ($itemsByArea) {
                    echo implode("\n", ArrayHelper::getColumn($itemsByArea[Area::BODY_END], 'body'));
                });
            }
        });
    }
}
