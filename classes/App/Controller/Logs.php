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
        $device   = $this->pixie->get_smstools_var($this->pixie->get_smstools_var('devices'));

        // clear logs
        if (($clear = $this->request->get('clear')) !== null) {
            switch ($clear) {
                case('daemon'):
                    if (is_readable($log_path)) {
                        file_put_contents($log_path, '');
                    }
                    break;
                case('regular-run'):
                    if (isset($device['regular_run_logfile']) && is_readable($device['regular_run_logfile'])) {
                        file_put_contents($device['regular_run_logfile'], '');
                    }
                    break;
            }
            $this->add_message_success('Log file is cleared!');
        }

        if (is_readable($log_path)) {
            $this->view->log_daemon = trim(htmlspecialchars(file_get_contents($log_path)));
        }

        if (isset($device['regular_run_logfile']) && is_readable($device['regular_run_logfile'])) {
            $this->view->log_regular_run = trim(htmlspecialchars(file_get_contents($device['regular_run_logfile'])));
        }
    }

}
