<?php

namespace App;

/**
 * Base controller
 *
 * @property-read \App\Pixie $pixie Pixie dependency container
 */
class Page extends \PHPixie\Controller {

	protected $view;

	public function before() {
        $controllerName = $this->request->param('controller');

        $this->view = $this->pixie->view('main');
        $this->view->request = $this->request;
        $this->view->title = ucfirst($controllerName);
        $this->view->subview = $controllerName;
        $this->view->messageType = ' hidden';
        $this->view->messageText = '';
	}

	public function after() {
		$this->response->body = $this->view->render();
	}

}
