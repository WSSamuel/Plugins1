<?php

namespace glxtm\scriptsControl\admin\forms\sidebar;

use glxtm\scriptsControl\core\base\Model;
use glxtm\scriptsControl\plugin\entities\Sidebar;

class SidebarForm extends Model
{

    /**
     * @var string
     */
    public $id;

    public function __construct(Sidebar $sidebar = null, array $config = [])
    {
        if ($sidebar) {
            $this->id = $sidebar->id;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['id', 'filter', 'filter' => 'trim'],
            ['id', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => esc_html__('Sidebar ID', 'galaksion-tag-manager'),
        ];
    }

    public function toSidebar(Sidebar $sidebar)
    {
        $sidebar->id = $this->id;
    }
}
