<?php

namespace glxtm\scriptsControl\plugin\entities;

use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\plugin\repositories\SidebarRepository;

class Area
{
    const HEAD = 1;
    const BODY_BEGIN = 2;
    const BODY_END = 3;
    const POST_BEGIN = 4;
    const POST_END = 5;
    const CONTENT_PLACEHOLDER_1 = 11;
    const CONTENT_PLACEHOLDER_2 = 12;
    const CONTENT_PLACEHOLDER_3 = 13;
    const SIDEBAR_FIRST_PREFIX = 's_0_';
    const SIDEBAR_LAST_PREFIX = 's_9_';

    /**
     * @param mixed $v
     * @return bool
     */
    public static function isValid($v)
    {
        return in_array($v, static::toValues(), false);
    }

    /**
     * @return array
     */
    public static function toValues()
    {
        static $list = null;
        if (null === $list) {
            $list = [
                static::HEAD, static::BODY_BEGIN, static::BODY_END, static::POST_BEGIN, static::POST_END,
                static::CONTENT_PLACEHOLDER_1, static::CONTENT_PLACEHOLDER_2, static::CONTENT_PLACEHOLDER_3,
            ];
            foreach (Core::$plugin->sidebars->findAll() as $sidebar) {
                $list[] = static::SIDEBAR_FIRST_PREFIX . $sidebar->id;
                $list[] = static::SIDEBAR_LAST_PREFIX . $sidebar->id;
            }
        }

        return $list;
    }
}
