<?php

namespace glxtm\scriptsControl\plugin\repositories;

use glxtm\scriptsControl\core\base\BaseObject;
use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\plugin\entities\Sidebar;

class SidebarRepository extends BaseObject
{

    /**
     * @var Sidebar[]
     */
    private $_sidebars;

    /**
     * @return Sidebar[]
     */
    public function findAll()
    {
        if ($this->_sidebars === null) {
            $this->_sidebars = [];
            $rows = Core::$plugin->options->get(Core::$plugin->prefix . 'sidebars');
            if (is_array($rows)) {
                foreach ($rows as $row) {
                    if (false !== $sidebar = Sidebar::make($row)) {
                        $this->_sidebars[] = $sidebar;
                    }
                }
            }
        }

        return $this->_sidebars;
    }

    /**
     * @param string $id
     * @return Sidebar|false
     */
    public function get($id)
    {
        foreach ($this->findAll() as $sidebar) {
            if ($sidebar->id == $id) {
                return $sidebar;
            }
        }

        return false;
    }

    /**
     * @param Sidebar $sidebar
     */
    public function add(Sidebar $sidebar)
    {
        $items = $this->findAll();
        foreach ($items as $i) {
            if ($i->id == $sidebar->id) {
                return; // already exists
            }
        }
        $this->_sidebars[] = $sidebar;
        $this->saveAll();
    }

    /**
     * @param Sidebar $sidebar
     */
    public function delete($sidebar)
    {
        $this->_sidebars = array_filter($this->findAll(), function ($i) use ($sidebar) {
            return $i->id != $sidebar->id;
        });
        $this->saveAll();
    }

    public function saveAll()
    {
        if ($this->_sidebars !== null) {
            $rows = [];
            foreach ($this->_sidebars as $sidebar) {
                $rows[] = $sidebar->toArray();
            }
            Core::$plugin->options->set(Core::$plugin->prefix . 'sidebars', $rows);
        }
    }
}
