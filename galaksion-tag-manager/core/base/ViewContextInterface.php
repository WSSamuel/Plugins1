<?php

namespace glxtm\scriptsControl\core\base;

interface ViewContextInterface
{

    /**
     * @param string $view
     * @return array
     */
    public function getViewFiles($view);
}
