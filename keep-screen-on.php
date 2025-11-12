<?php
namespace Grav\Plugin;

use Composer\Autoload\ClassLoader;
use Grav\Common\Plugin;
use Grav\Common\Twig\Twig;

/**
 * Class KeepScreenOnPlugin
 * @package Grav\Plugin
 */
class KeepScreenOnPlugin extends Plugin
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'onPluginsInitialized' => [
                ['autoload', 100000],
                ['onPluginsInitialized', 0]
            ]
        ];
    }

    /**
     * Composer autoload
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized(): void
    {
        // Don't proceed if we are in the admin plugin
        if ($this->isAdmin()) {
            return;
        }

        // Enable the main events we are interested in
        $this->enable([
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigInitialized' => ['onTwigInitialized', 0],
            'onPageContentRaw' => ['onPageContentRaw', 0],
        ]);
    }

    /**
     * Add plugin templates path
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Initialize Twig configuration
     */
    public function onTwigInitialized()
    {
        $twig = $this->grav['twig'];
        
        // Add twig function for manual inclusion
        $twig->twig->addFunction(
            new \Twig\TwigFunction('keepScreenOn', [$this, 'renderKeepScreenOn'], ['is_safe' => ['html']])
        );
    }

    /**
     * Process page content to handle shortcodes
     */
    public function onPageContentRaw()
    {
        $page = $this->grav['page'];
        $config = $this->mergeConfig($page);
        
        if ($config->get('enabled')) {
            $rawContent = $page->getRawContent();
            
            // Simple shortcode replacement
            if (preg_match('/\[keep-screen-on(?:\s+([^\]]+))?\]/i', $rawContent)) {
                $content = $this->processKeepScreenOnShortcode($rawContent);
                $page->setRawContent($content);
            }
        }
    }

    /**
     * Process keep-screen-on shortcode
     */
    private function processKeepScreenOnShortcode($content)
    {
        $pattern = '/\[keep-screen-on(?:\s+([^\]]+))?\]/i';
        
        return preg_replace_callback($pattern, function($matches) {
            $params = [];
            
            // Simple enabled/disabled parsing
            if (isset($matches[1])) {
                $paramString = trim($matches[1]);
                if (in_array(strtolower($paramString), ['false', '0', 'no', 'off', 'disable'])) {
                    $params['enabled'] = false;
                }
            }
            
            return $this->renderKeepScreenOn($params);
        }, $content);
    }

    /**
     * Render the keep screen on template
     */
    public function renderKeepScreenOn($params = [])
    {
        $config = $this->config->get('plugins.keep-screen-on');
        
        // Merge default config with any passed parameters
        $data = array_merge([
            'enabled' => $config['enabled'] ?? true
        ], $params);

        try {
            return $this->grav['twig']->twig()->render('keep-screen-on.html.twig', $data);
        } catch (\Exception $e) {
            return '<!-- Keep Screen On Error: ' . $e->getMessage() . ' -->';
        }
    }
}
