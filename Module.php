<?php

namespace SampleService;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use SampleService\Mvc\View\InjectProxyTemplateListener;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Fix for controllers that use proxy manager
        $sharedEvents = $eventManager->getSharedManager();
        $sharedEvents->attach('Zend\Stdlib\DispatchableInterface', MvcEvent::EVENT_DISPATCH,
            array(new InjectProxyTemplateListener(), 'injectTemplate'),
            -80
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
