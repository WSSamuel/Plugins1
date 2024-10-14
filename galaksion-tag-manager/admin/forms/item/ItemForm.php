<?php

namespace glxtm\scriptsControl\admin\forms\item;

use glxtm\scriptsControl\core\base\Model;
use glxtm\scriptsControl\plugin\entities\Item;

class ItemForm extends Model
{

    /**
     * @var string
     */
    public $caption;

    /**
     * @var string
     */
    public $body;

    public function __construct(Item $item = null, array $config = [])
    {
        if ($item) {
            $this->caption = $item->caption;
            $this->body = $item->body;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['caption', 'body'], 'filter', 'filter' => 'trim'],
            ['body', 'required']
        ];
    }

    public function attributeLabels()
    {
        return [
            'caption' => esc_html__('Caption', 'galaksion-tag-manager'),
            'body' => esc_html__('Body', 'galaksion-tag-manager'),
        ];
    }

    public function toItem(Item $item)
    {
        $item->caption = $this->caption;
        $item->body = $this->body;
    }
}
