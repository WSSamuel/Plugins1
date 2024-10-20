<?php

namespace glxtm\scriptsControl\admin;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;

class Rate extends BaseObject
{

    const LINK = 'https://wordpress.org/support/plugin/galaksion-tag-manager/reviews/?rate=5#new-post'; // todo update link

    private $_isShow;

    /**
     * @return bool
     */
    public function isShow()
    {
        if ($this->_isShow === null) {
            if (current_user_can('manage_options')) {
                $time = Core::$plugin->options->get('rate_time');
                if ($time === false) {
                    Core::$plugin->options->set('rate_time', time() + DAY_IN_SECONDS);
                    $this->_isShow = false;
                } else {
                    $this->_isShow = time() > $time;
                }
            } else {
                $this->_isShow = false;
            }
        }
        return $this->_isShow;
    }

    public function rate()
    {
        Core::$plugin->options->set('rate_time', time() + YEAR_IN_SECONDS);
    }

    public function alreadyRate()
    {
        Core::$plugin->options->set('rate_time', time() + YEAR_IN_SECONDS);
    }

    public function showLater()
    {
        Core::$plugin->options->set('rate_time', time() + WEEK_IN_SECONDS);
    }
}
