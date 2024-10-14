<?php

namespace glxtm\scriptsControl\plugin\entities;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\helpers\ArrayHelper;

class Sidebar extends BaseObject
{

    /**
     * @var string
     */
    public $id;

    /**
     * @param array $row
     * @return Sidebar|false
     */
    public static function make($row)
    {
        $item = new self();

        $item->id = (string)ArrayHelper::getValue($row, 'id');
        if (!strlen($item->id)) {
            return false;
        }

        return $item;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
        ];
    }
}
