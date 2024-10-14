<?php

namespace glxtm\scriptsControl\plugin\entities;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\helpers\ArrayHelper;

class Item extends BaseObject
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var bool
     */
    public $active;

    /**
     * @var string
     */
    public $areaId;

    /**
     * @var string
     */
    public $caption;

    /**
     * @var string
     */
    public $body;

    /**
     * @param array $row
     * @return Item|false
     */
    public static function make($row)
    {
        $item = new self();

        $item->id = (int)ArrayHelper::getValue($row, 'id');
        if (!$item->id) {
            return false;
        }

        $item->areaId = (string)ArrayHelper::getValue($row, 'areaId');
        if (!Area::isValid($item->areaId)) {
            return false;
        }

        $item->active = (bool)ArrayHelper::getValue($row, 'active');
        $item->caption = (string)ArrayHelper::getValue($row, 'caption');
        $item->body = (string)ArrayHelper::getValue($row, 'body');
        return $item;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'areaId' => $this->areaId,
            'active' => $this->active ? 1 : 0,
            'caption' => $this->caption,
            'body' => $this->body,
        ];
    }
}
