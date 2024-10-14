<?php

namespace glxtm\scriptsControl\admin\widgets\itemRow;

use glxtm\scriptsControl\core\base\Widget;
use glxtm\scriptsControl\plugin\entities\Item;
use ReflectionException;

class ItemRow extends Widget
{

    /**
     * @var Item
     */
    public $item;

    /**
     * @return null|string
     * @throws ReflectionException
     */
    public function run()
    {
        return $this->render('row', [
            'item' => $this->item,
        ]);
    }
}
