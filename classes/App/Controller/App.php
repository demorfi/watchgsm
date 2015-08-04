<?php

namespace App\Controller;

class App extends \App\Page
{

    public function before()
    {
        parent::before();
        $this->view->device = $this->pixie->get_smstools_var('devices');

        // sync messages
        if ($this->request->get('sync', 0) == 1) {
            $this->sync();
            $this->execute = false;
        }
    }

    public function getHelper()
    {
        return ($this->pixie->view_helper());
    }

    protected function sync()
    {
        return (true);
    }

}
