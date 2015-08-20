<?php

namespace App\Controller;

class App extends \App\Page
{

    public function before()
    {
        parent::before();
        $this->view->device = $this->pixie->get_smstools_var('devices');

        if ($this->request->param('action') == 'sync') {
            $this->request->method = 'GET';
        }
    }

    public function after()
    {
        if (!$this->request->is_ajax() && $this->request->param('action') == 'sync') {
            $this->response->redirect(
                $this->pixie->router->get('default')->url(
                    array('controller' => $this->request->param('controller'))
                )
            );
            return;
        }
        parent::after();
    }

    public function action_sync()
    {
        return (true);
    }

}
