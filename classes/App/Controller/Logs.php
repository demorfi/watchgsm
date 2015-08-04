<?php

namespace App\Controller;

class Logs extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title           = 'Logs';
        $this->view->log_daemon      = '';
        $this->view->log_regular_run = '';

        $log_path = $this->pixie->get_smstools_var('logfile');
        if (is_readable($log_path)) {
            $this->view->log_daemon = trim(htmlspecialchars(file_get_contents($log_path)));
        }

        $device = $this->pixie->get_smstools_var($this->pixie->get_smstools_var('devices'));
        if (isset($device['regular_run_logfile']) && is_readable($device['regular_run_logfile'])) {
            $this->view->log_regular_run = trim(htmlspecialchars(file_get_contents($device['regular_run_logfile'])));
        }
    }

}
