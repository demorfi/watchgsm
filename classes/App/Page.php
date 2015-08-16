<?php

namespace App;

class Page extends \PHPixie\Controller
{
    protected $data = array();
    protected $view;

    public function before()
    {
        $controller_name = $this->request->param('controller');
        $action_name     = $this->request->param('action');

        $this->view               = $this->pixie->view('main');
        $this->view->request      = $this->request;
        $this->view->title        = ucfirst($controller_name);
        $this->view->subview      = $controller_name . ($action_name !== 'index' ? '_' . $action_name : '');
        $this->view->message_type = $this->pixie->session->flash('message_type') ?: '';
        $this->view->message_text = $this->pixie->session->flash('message_text') ?: '';

        // add timezone for handler javascript
        if ($this->request->is_ajax()) {
            $this->data['timezone'] = $this->pixie->config->get('general.timezone');
        }
    }

    public function after()
    {
        $has_redirect = false;
        foreach($this->response->headers as $header) {
            $has_redirect = strpos($header, 'Location:') !== false;
        }

        // Prevent the execution of the template when redirect
        if (!$has_redirect) {
            $this->response->body = $this->request->is_ajax() ? json_encode($this->data) : $this->view->render();
        }
    }

    public function add_view_data($key, $data)
    {
        if ($this->request->is_ajax()) {
            $this->data[$key] = $data instanceof \PHPixie\ORM\Result ? $data->as_array(true) : $data;
        } else {
            $this->view->__set($key, $data);
        }
    }

    public function add_message_success($message, $session = false)
    {
        $this->view->message_type = 'success';
        $this->view->message_text = $message;

        if ($session) {
            $this->add_message_flash($this->view->message_type, $this->view->message_text);
        }
    }

    public function add_message_error($message, $session = false)
    {
        $this->view->message_type = 'error';
        $this->view->message_text = $message;

        if ($session) {
            $this->add_message_flash($this->view->message_type, $this->view->message_text);
        }
    }

    public function add_message_flash($message_type, $message_text)
    {
        $this->pixie->session->flash('message_type', $message_type);
        $this->pixie->session->flash('message_text', $message_text);
    }
}
