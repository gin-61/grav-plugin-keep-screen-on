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
    'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigInitialized' => ['onTwigInitialized', 0],
            'onPageContent' => ['onPageContent', 0],
        ]);
    }

public function onTwigSiteVariables()
{
    $twig = $this->grav['twig'];
    $twig->twig_vars['page'] = $this->grav['page'];
    $twig->twig_vars['uri'] = $this->grav['uri'];
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
        
        // Add twig function for manual inclusion (optional)
        $twig->twig->addFunction(
            new \Twig\TwigFunction('keepScreenOn', [$this, 'renderKeepScreenOn'], ['is_safe' => ['html']])
        );
    }

    /**
     * Inject keep screen on content to ALL pages
     */
    public function onPageContent()
    {
        $page = $this->grav['page'];
        $config = $this->mergeConfig($page);
        
        // Check if plugin is enabled for this page (you can add config logic here)
        if ($this->shouldIncludeOnPage($page)) {
            // Get the rendered content
            $content = $page->getRawContent();
            
            // Inject the keep screen on HTML
            $keepScreenOnHtml = $this->renderKeepScreenOn();
            
            // Add to the page content (you can choose where to inject it)
            // Option 1: Add to beginning
            // $page->setRawContent($keepScreenOnHtml . $content);
            
            // Option 2: Add to end (recommended)
            $page->setRawContent($content . $keepScreenOnHtml);
        }
    }

    /**
     * Determine if the plugin should be included on this page
     * You can add custom logic here to exclude certain pages
     */
    private function shouldIncludeOnPage($page): bool
    {
        $config = $this->config->get('plugins.keep-screen-on');
        
        // Check if plugin is globally enabled
        if (isset($config['enabled']) && !$config['enabled']) {
            return false;
        }
        
        return true;
    }

    /**
     * Render the keep screen on template
     */
    public function renderKeepScreenOn($params = [])
    {
        $config = $this->config->get('plugins.keep-screen-on');
        
        // Merge default config with any passed parameters
        $data = array_merge([
            'enabled' => true
        ], $params);

        // Get the full absolute URL of the current page
        $page = $this->grav['page'];
        $absoluteUrl = $this->getAbsoluteUrl($page->url(true));

        try {
            return $this->grav['twig']->twig()->render('keep-screen-on.html.twig', [
                'kso' => $config,
                'enabled' => $data['enabled'],
                'page_absolute_url' => $absoluteUrl,
            ]);
        } catch (\Exception $e) {
            return '<!-- Keep Screen On Error: ' . $e->getMessage() . ' -->';
        }
    }

    /**
     * Get absolute URL with proper scheme and domain
     */
    private function getAbsoluteUrl($relativeUrl): string
    {
        $uri = $this->grav['uri'];
        $baseUrl = $this->grav['base_url_absolute'];
        
        // If it's already an absolute URL, return as is
        if (parse_url($relativeUrl, PHP_URL_SCHEME)) {
            return $relativeUrl;
        }
        
        // Build the absolute URL
        $scheme = $uri->scheme(true) ?: 'http';
        $host = $uri->host();
        $port = $uri->port() ? ':' . $uri->port() : '';
        
        return $scheme . '://' . $host . $port . $relativeUrl;
    }
}
