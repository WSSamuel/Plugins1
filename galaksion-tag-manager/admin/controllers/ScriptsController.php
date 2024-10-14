<?php

namespace glxtm\scriptsControl\admin\controllers;

use glxtm\scriptsControl\admin\forms\sidebar\SidebarForm;
use glxtm\scriptsControl\core\admin\AdminController;
use glxtm\scriptsControl\core\admin\helpers\AdminUrl;
use glxtm\scriptsControl\core\Core;
use glxtm\scriptsControl\plugin\entities\Sidebar;

class ScriptsController extends AdminController
{

    public function handleIndex()
    {
        Core::$plugin->welcome->setShowed();
    }

    public function actionIndex()
    {
        $this->render('index', [
            'usePlaceholders' => Core::$plugin->settings->getUsePlaceholders(),
            'sidebars'        => Core::$plugin->sidebars->findAll(),
            'itemsByArea'     => Core::$plugin->items->findAllGroupedByArea(),
        ]);
    }

    public function actionSettings()
    {
        $this->render('settings');
    }

    /**
     * @throws \ReflectionException
     */
    public function actionAddSidebar()
    {
        $successUrl = AdminUrl::toOptions('scripts');
        $model = new SidebarForm();
        $data = Core::$plugin->request->get();
        if ($model->load($data, '') && $model->validate()) {
            $sidebar = new Sidebar();
            $model->toSidebar($sidebar);
            $successUrl .= '#sidebar-' . $sidebar->id;
            Core::$plugin->sidebars->add($sidebar);
        }
        echo '<script>document.location="' . htmlspecialchars($successUrl) . '";</script>';
        wp_die();
    }

    public function actionRemoveSidebar()
    {
        $successUrl = AdminUrl::toOptions('scripts');
        $model = new SidebarForm();
        $data = Core::$plugin->request->post();
        if ($model->load($data, '') && $model->validate()) {
            $sidebar = new Sidebar();
            $model->toSidebar($sidebar);
            Core::$plugin->sidebars->delete($sidebar);
        }
        echo '<script>document.location="' . htmlspecialchars($successUrl) . '";</script>';
        wp_die();
    }
}
