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

            if (!$this->request->is_ajax()) {
                $this->execute = false;
            }
        }
    }

    protected function sync()
    {
        return (true);
    }

}
