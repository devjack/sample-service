<?php

namespace SampleService\Controller\Service;

use ProxyManager\Factory\LazyLoadingGhostFactory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ServiceLocatorInterface $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();

        $proxyConfig = $serviceLocator->get('ProxyManager\Configuration');
        $factory = new LazyLoadingGhostFactory($proxyConfig);
        $proxy = $factory->createProxy(
            'SampleService\Controller\UserController',
            function ($proxy, $method, $parameters, &$initializer) use ($serviceLocator) {
                static $flag = array();
                if (isset($flag[$method])) {
                    return;
                }
                $flag[$method] = true;

                /** @var \SampleService\Controller\UserController $proxy */
                if ($method == 'getFilterForm') {
                    $proxy->setFilterForm(
                        $serviceLocator->get('FormElementManager')->get('SampleService\Form\FilterForm')
                    );
                } elseif ($method == 'getUserService') {
                    $proxy->setUserService($serviceLocator->get('SampleService\Service\UserService'));
                } elseif ($method == 'getUserFilterService') {
                    $proxy->setUserFilterService($serviceLocator->get('SampleService\Service\UserFilterService'));
                }
            }
        );
        return $proxy;
    }
}
