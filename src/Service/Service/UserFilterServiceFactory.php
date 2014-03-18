<?php

namespace SampleService\Service\Service;

use SampleService\Service\UserFilterService;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFilterServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var \SampleService\Mapper\UserMapper $userMapper */
        $userMapper = $serviceLocator->get('SampleService\Mapper\UserMapper');
        $filterStorage = $serviceLocator->get('SampleService\Service\UserFilterStorage');

        $validFilters = $userMapper->getValidFilterFields();
        $validOptions = $userMapper->getValidOptionKeys();

        $service = new UserFilterService();
        $service->setValidFilters(array_flip($validFilters));
        $service->setValidOptions(array_flip($validOptions));

        $service->setFilterStorage($filterStorage);

        return $service;
    }

}
