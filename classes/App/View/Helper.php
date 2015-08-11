<?php

namespace App\View;

class Helper extends \PHPixie\View\Helper
{

    public function has_active_page(\PHPixie\Request $request, $controller, $action = null, $append = false)
    {
        $controllerName = $request->param('controller');
        $actionName     = $request->param('action');

        if ((is_array($controller) && in_array($controllerName, $controller)) ||
            (is_string($controller) && $controller == $controllerName && empty($action)) ||
            (is_string($controller) && $controller == $controllerName && $action == $actionName)
        ) {
            echo(!$append ? 'class="active"' : 'active');
        }
    }

    public function has_smstools_var($name)
    {
        $config = $this->pixie->config->get('smstools3.config');
        return (isset($config[$name]) && !empty($config[$name]));
    }

    public function date_format($timestamp, $format = 'd-m-Y H:i:s')
    {
        $date = (new \DateTime())->setTimestamp($timestamp);
        return ($date->format($format));
    }

}