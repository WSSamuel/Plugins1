<?php

namespace glxtm\scriptsControl\plugin;

class Settings extends \glxtm\scriptsControl\core\wp\Settings
{

    /**
     * @return bool
     */
    public function getUseWpBodyOpen()
    {
        return (bool)$this->getValue('general', 'useWpBodyOpen', false);
    }

    public function getUsePlaceholders()
    {
        return (bool)$this->getValue('general', 'usePlaceholders', false);
    }
}
