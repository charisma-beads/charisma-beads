<?php

namespace ThemeManager\View;

use Common\View\AbstractViewHelper;
use ThemeManager\Options\ThemeOptions;


class BootStrapTheme extends AbstractViewHelper
{
    const CLOUDFLARE_CDN        = '//cdnjs.cloudflare.com/ajax/libs';

    const BOOTSTRAP_VERSION     = '3.3.7';
    const BOOTSTRAP_PART        = 'twitter-bootstrap';
    const BOOTSTRAP_JS          = 'js/bootstrap.min.js';
    const BOOTSTRAP_CSS         = 'bootstrap.min.css';
    const BOOTSTRAP_THEME_CSS   = 'bootstrap-theme.min.css';

    const BOOTSWATCH_VERSION    = '3.3.7';
    const BOOTSWATCH_PART       = 'bootswatch';

    const FONT_AWESOME_VERSION  = '4.7.0';
    const FONT_AWESOME_PART     = 'font-awesome';
    const FONT_AWESOME_CSS      = 'css/font-awesome.min.css';

    const JQUERY_VERSION        = '3.2.1';
    const JQUERY_PATH           = 'jquery';
    const JQUERY_JS             = 'jquery.min.js';

    const JQUERY_UI_VERSION     = '1.12.1';
    const JQUERY_UI_PATH        = 'jqueryui';
    const JQUERY_UI_JS          = 'jquery-ui.min.js';
    const JQUERY_UI_CSS         = 'jquery-ui.min.css';

    protected $theme = 'default';

    /**
     * @var ThemeOptions
     */
    protected $options;

    public function __invoke($theme = null)
    {
        if ($theme) {
            $this->setTheme($theme);
        }

        return $this;
    }

    public function getThemeChooserSelect()
    {

    }

    public function enable()
    {
        $view = $this->getView();

        // assemble css and js files from cdn
        if ($view->themeOptions('bootstrap')) {

            if (!$view->themeOptions('bootswatch_theme')) {
                $view->headLink()->offsetSetStylesheet(0, join('/', [
                    self::CLOUDFLARE_CDN,
                    self::BOOTSTRAP_PART,
                    self::BOOTSTRAP_VERSION,
                    'css',
                    self::BOOTSTRAP_CSS
                ]), 'screen,print');

                $view->headLink()->offsetSetStylesheet(1, join('/', [
                    self::CLOUDFLARE_CDN,
                    self::BOOTSTRAP_PART,
                    self::BOOTSTRAP_VERSION,
                    'css',
                    self::BOOTSTRAP_THEME_CSS
                ]), 'screen,print');

            } else {

                $view->headLink()->offsetSetStylesheet(0, join('/', [
                    self::CLOUDFLARE_CDN,
                    self::BOOTSWATCH_PART,
                    self::BOOTSWATCH_VERSION,
                    $view->themeOptions('bootswatch_theme'),
                    self::BOOTSTRAP_CSS
                ]), 'screen,print');
            }

            //netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js
            $view->inlineScript()->prependFile(join('/', [
                self::CLOUDFLARE_CDN,
                self::BOOTSTRAP_PART,
                self::BOOTSTRAP_VERSION,
                self::BOOTSTRAP_JS
            ]));
        }

        if ($view->themeOptions('font_awesome')) {
            $view->headLink()->offsetSetStylesheet(2, join('/', [
                self::CLOUDFLARE_CDN,
                self::FONT_AWESOME_PART,
                self::FONT_AWESOME_VERSION,
                self::FONT_AWESOME_CSS
            ]));
        }

        // JS
        //ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js

        if ($view->themeOptions('jquery_ui')) {
            $view->inlineScript()->prependFile(join('/', [
                self::CLOUDFLARE_CDN,
                self::JQUERY_UI_PATH,
                self::JQUERY_UI_VERSION,
                self::JQUERY_UI_JS
            ]));

            $view->headLink()->offsetSetStylesheet(1, join('/', [
                self::CLOUDFLARE_CDN,
                self::JQUERY_UI_PATH,
                self::JQUERY_UI_VERSION,
                self::JQUERY_UI_CSS
            ]));
        }

        $view->inlineScript()->prependFile(join('/', [
            self::CLOUDFLARE_CDN,
            self::JQUERY_PATH,
            self::JQUERY_VERSION,
            self::JQUERY_JS
        ]));
    }

    public function getTheme()
    {
        return $this->options->getDefaultTheme();
    }

    public function setTheme($theme)
    {
        $this->options->setDefaultTheme($theme);
        return $this;
    }
}
