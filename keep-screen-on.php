<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;
use Grav\Common\Twig\Twig;

class KeepScreenOnPlugin extends Plugin
{
    protected $ksoConfig;
        
    public static function getSubscribedEvents(): array
    {
        return ['onPluginsInitialized' => ['onPluginsInitialized', 0]];
    }

    public function onPluginsInitialized(): void
    {
        $this->ksoConfig = $this->config->get('plugins.keep-screen-on');

        if ($this->isAdmin() || !($this->ksoConfig['enabled'] ?? true) ) {
            return;
        }

        $this->enable([
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onAssetsInitialized' => ['onAssetsInitialized', 0],
            'onPageContent' => ['onPageContent', 0],
        ]);
    }

    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    public function onAssetsInitialized(): void
    {
        $assets = $this->grav['assets'];
        $assets->addCss('plugin://keep-screen-on/css/kso.css');
        $assets->addJs('plugin://keep-screen-on/js/kso.js');
    }

    public function onPageContent()
    {
        
        $this->grav['page']->setRawContent($this->grav['page']->getRawContent() . $this->renderKeepScreenOn());
    }

    public function renderKeepScreenOn($params = [])
    {

        try {
            return $this->grav['twig']->twig()->render('keep-screen-on.html.twig', [

                'kso' => $this->ksoConfig,

                'page_absolute_url' => $this->grav['page']->url(true),

            ]);
        } catch (\Exception $e) {

            return '<!-- Keep Screen On Error: ' . $e->getMessage() . ' -->';

        }
    }
}
