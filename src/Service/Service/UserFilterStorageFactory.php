<?php

namespace SampleService\Service\Service;

use Zend\Cache\Storage\Adapter\Session;
use Zend\Cache\Storage\StorageInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Session\Container;

class UserFilterStorageFactory implements FactoryInterface
{
    /**
     * @param  ServiceLocatorInterface $serviceLocator
     * @return StorageInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $storage = new Session();
        $storage->getOptions()->setSessionContainer(new Container('user_filter'));

        return $storage;
    }

}
