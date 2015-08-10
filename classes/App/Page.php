<?php

namespace App;

class Page extends \PHPixie\Controller
{
    protected $data = array();
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

        // add timezone for handler javascript
        if ($this->request->is_ajax()) {
            $this->data['timezone'] = $this->pixie->config->get('general.timezone');
        }
    }

    public function after()
    {
        $this->response->body = $this->request->is_ajax() ? json_encode($this->data) : $this->view->render();
    }

    public function add_view_data($key, $data)
    {
        if ($this->request->is_ajax()) {
            $this->data[$key] = $data instanceof \PHPixie\ORM\Result ? $data->as_array(true) : $data;
        } else {
            $this->view->__set($key, $data);
        }
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
