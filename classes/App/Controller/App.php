<?php

namespace App\Controller;

class App extends \App\Page
{

    public function before()
    {
        parent::before();
        $this->view->device = $this->getHelper()->getConfigVariable('devices');
    }

    public function getHelper()
    {
        return ($this->pixie->view_helper());
    }

    protected function readMessages($path, \Closure $callback)
    {
        $files = $this->getHelper()->getFiles($path);
        foreach ($files as $file) {
            $content = file_get_contents($file->getPathname());
            $callback($file->getFilename(), md5($content), $content);
        }
    }

    protected function sync()
    {
        return (true);
    }

}
