<?php

namespace App\View;

class Helper extends \PHPixie\View\Helper{

    public function hasActivePage(\PHPixie\Request $request, $controller, $action = null, $append = false)
    {
        $controllerName = $request->param('controller');
        $actionName = $request->param('action');

        if (($controller == $controllerName && empty($action)) ||
            ($controller == $controllerName && $action == $actionName)) {
            echo (!$append ? 'class="active"' : 'active');
        }
    }


}