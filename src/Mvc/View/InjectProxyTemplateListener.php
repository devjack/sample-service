<?php

namespace SampleService\Mvc\View;

use ProxyManager\Proxy\ProxyInterface;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\View\Http\InjectTemplateListener;

class InjectProxyTemplateListener extends InjectTemplateListener
{
    /**
     * Inject a template into the view model, if none present
     *
     * Template is derived from the controller found in the route match, and,
     * optionally, the action, if present.
     *
     * @param  MvcEvent $e
     * @return void
     */
    public function injectTemplate(MvcEvent $e)
    {
        /**
         * This condition fix the template name derived from the controller
         * We have to use the service name insteadof the controller class because
         * proxy manager generate a random name
         */
        $controller = $e->getTarget();
        $routeMatch = $e->getRouteMatch();

        if ($controller instanceof ProxyInterface) {
            $e->setTarget($routeMatch->getParam('controller', ''));
        }

        parent::injectTemplate($e);

        if ($controller instanceof ProxyInterface) {
            $e->setTarget($controller);
        }
    }
}
