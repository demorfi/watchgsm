<?php

namespace App\Controller;

class Compose extends \App\Controller\App {

    public function action_index() {
        $this->view->title = 'Compose New SMS';
    }

}
