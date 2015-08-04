<?php

namespace App;

class Page extends \PHPixie\Controller
{
    protected $view;

    public function before()
    {
        $controllerName = $this->request->param('controller');

        $this->view               = $this->pixie->view('main');
        $this->view->request      = $this->request;
        $this->view->title        = ucfirst($controllerName);
        $this->view->subview      = $controllerName;
        $this->view->message_type = '';
        $this->view->message_text = '';
    }

    public function after()
    {
        $this->response->body = $this->view->render();
    }

    public function add_message_success($message)
    {
        $this->view->message_type = 'success';
        $this->view->message_text = $message;
    }

    public function add_message_error($message)
    {
        $this->view->message_type = 'error';
        $this->view->message_text = $message;
    }

}
