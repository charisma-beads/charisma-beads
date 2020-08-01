<?php

namespace ThemeManager\View;

use Common\View\AbstractViewHelper;


class ThemePath extends AbstractViewHelper
{
    public function __invoke($file = null)
    {
        if (null !== $file) {
            $file = ltrim($file, '/');
        }

        $isAdmin = $this->getServiceLocator()
            ->getServiceLocator()
            ->get('Application')
            ->getMvcEvent()
            ->getRouteMatch()
            ->getParam('is-admin');

        $view = $this->getView();
        $theme = ($isAdmin) ? $view->themeOptions('admin_theme') : $view->themeOptions('default_theme');

        $file = join('/', array(
            $theme,
            $file
        ));

        return $this->getView()->basePath($file);
    }
}
