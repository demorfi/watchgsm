<?php

namespace App\Controller;

class Logs extends \App\Controller\App
{

    public function action_index()
    {
        $this->view->title         = 'Logs';
        $this->view->logDaemon     = '';
        $this->view->logRegularRun = '';

        $logPath = $this->getHelper()->getConfigVariable('logfile');
        if (is_readable($logPath)) {
            $this->view->logDaemon = trim(htmlspecialchars(file_get_contents($logPath)));
        }

        $device = $this->getHelper()->getConfigVariable($this->getHelper()->getConfigVariable('devices'));
        if (isset($device['regular_run_logfile']) && is_readable($device['regular_run_logfile'])) {
            $this->view->logRegularRun = trim(htmlspecialchars(file_get_contents($device['regular_run_logfile'])));
        }
    }

}
