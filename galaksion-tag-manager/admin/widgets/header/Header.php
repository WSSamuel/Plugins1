<?php

namespace glxtm\scriptsControl\admin\widgets\header;

use glxtm\scriptsControl\core\base\Widget;

class Header extends Widget
{

    /**
     * @var string
     */
    public $tab;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('widget', [
            'tab' => $this->tab,
        ]);
    }
}
