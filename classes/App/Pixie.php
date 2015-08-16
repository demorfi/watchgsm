<?php

namespace App;

/**
 * Pixie dependency container
 *
 * @property-read \PHPixie\DB $db Database module
 * @property-read \PHPixie\ORM $orm ORM module
 */
class Pixie extends \PHPixie\Pixie
{

    protected $modules = array(
        'db'  => '\PHPixie\DB',
        'orm' => '\PHPixie\ORM'
    );

    public function view_helper()
    {
        return (new View\Helper($this));
    }

    public function handle_request()
    {
        return (PHP_SAPI === 'cli' ? $this->handle_cli_request() : $this->handle_http_request());
    }

    public function handle_cli_request()
    {
        try {
            $request  = $this->cli_request();
            $response = $request->execute();
            $response->send_headers()->send_body();
        } catch (\Exception $e) {
            $this->handle_exception($e);
        }
    }

    public function cli_request()
    {
        $uri        = $_SERVER['argv'][1];
        $url_parts  = parse_url(preg_replace('#^' . $this->basepath . '(?:index\.php/?)?#i', '/', $uri));
        $route_data = $this->router->match($url_parts['path']);

        $route_query = array();
        if (isset($url_parts['query'])) {
            parse_str($url_parts['query'], $route_query);
        }

        return ($this->request(
            $route_data['route'],
            'GET',
            $_POST,
            $route_query,
            $route_data['params'],
            $_SERVER,
            $_COOKIE
        ));
    }

    protected function after_bootstrap()
    {
        $configPath = $this->config->get('general.smstools3.configPath');
        if (!is_readable($configPath)) {
            throw new \Exception('Config smstols3 {' . $configPath . '} is not readable!');
        }

        // Remove hash marks (#) should no longer be used as comments and will throw a deprecation warning if used.
        $content = preg_replace('/\#.*/', '', file_get_contents($configPath));
        $this->config->set('smstools3.config', parse_ini_string($content, true, INI_SCANNER_RAW));

        // set default timezone for messages
        date_default_timezone_set($this->config->get('general.timezone'));
    }

    public function get_smstools_var($name)
    {
        $config = $this->config->get('smstools3.config');
        return (isset($config[$name]) ? $config[$name] : false);
    }

    public function read_messages($path, \Closure $callback)
    {
        $files = $this->find_files($path);
        foreach ($files as $file) {
            $content = file_get_contents($file->getPathname());
            $callback($file->getFilename(), md5($content), $content);
        }
    }

    public function send_message($to, $text, $use_voice = false)
    {
        $outPath = $this->get_smstools_var('outgoing') . DIRECTORY_SEPARATOR . 'sms_' . date('His');
        file_put_contents($outPath, ($use_voice ? "Voicecall: true\n" : '') . 'To: ' . $to . "\n\n" . $text . "\n");
        return (file_exists($outPath));
    }

    public function remove_message_file($path)
    {
        if (is_file($path)) {
            unlink($path);
        }
    }

    public function find_files($location)
    {
        $iterator = new \FilesystemIterator(
            $location,
            (\FilesystemIterator::NEW_CURRENT_AND_KEY | \FilesystemIterator::SKIP_DOTS)
        );

        $regex = new \RegexIterator($iterator, '/.*/', \RecursiveRegexIterator::MATCH);
        return (new \IteratorIterator($regex));
    }
}
