<?php

namespace glxtm\scriptsControl\core\wp;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;

class Options extends BaseObject
{

    public function get($option, $default = false)
    {
        return get_option(Core::$plugin->prefix . $option, $default);
    }

    public function set($option, $value, $autoload = null)
    {
        return update_option(Core::$plugin->prefix . $option, $value, $autoload);
    }

    public function delete($option)
    {
        delete_option(Core::$plugin->prefix . $option);
    }
}
