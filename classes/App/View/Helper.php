<?php

namespace App\View;

class Helper extends \PHPixie\View\Helper
{
    private $config;

    public function __construct($pixie)
    {
        parent::__construct($pixie);
        $this->parseSmsToolsConfig();
    }

    public function hasActivePage(\PHPixie\Request $request, $controller, $action = null, $append = false)
    {
        $controllerName = $request->param('controller');
        $actionName     = $request->param('action');

        if (($controller == $controllerName && empty($action)) ||
            ($controller == $controllerName && $action == $actionName)
        ) {
            echo(!$append ? 'class="active"' : 'active');
        }
    }

    private function parseSmsToolsConfig()
    {
        $configPath = $this->pixie->config->get('general.smstools3.configPath');
        if (!is_readable($configPath)) {
            throw new \Exception('Config smstols3 {' . $configPath . '} is not readable!');
        }

        // Remove hash marks (#) should no longer be used as comments and will throw a deprecation warning if used.
        $content      = preg_replace('/\#.*/', '', file_get_contents($configPath));
        $this->config = parse_ini_string($content, true, INI_SCANNER_RAW);
    }

    public function getConfigVariable($name)
    {
        return (isset($this->config[$name]) ? $this->config[$name] : false);
    }

    public function hasConfigVariable($name)
    {
        return (isset($this->config[$name]) && !empty($this->config[$name]));
    }

    public function getFiles($location)
    {
        $iterator = new \FilesystemIterator(
            $location,
            (\FilesystemIterator::NEW_CURRENT_AND_KEY | \FilesystemIterator::SKIP_DOTS)
        );

        $regex = new \RegexIterator($iterator, '/.*/', \RecursiveRegexIterator::MATCH);
        return (new \IteratorIterator($regex));
    }

    public function sortByTimestampDesc(array &$list)
    {
        uasort(
            $list,
            function ($a, $b) {
                return ($a['timestamp'] < $b['timestamp']);
            }
        );
        return ($list);
    }

}