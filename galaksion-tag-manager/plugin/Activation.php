<?php

namespace glxtm\scriptsControl\plugin;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;

class Activation extends BaseObject
{

    public function init()
    {
        register_activation_hook(Core::$plugin->fileName, [$this, 'activate']);
    }

    public function activate()
    {
        Core::$plugin->welcome->setNotShowed();
    }
}
