<?php
namespace SampleService\Mapper\Service;

use SampleService\Mapper\UserMapper;
use SampleService\Entity\User;

use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db = $serviceLocator->get('Zend\Db\Adapter');

        $entity = new User();

        $set = new HydratingResultSet();
        $set->setObjectPrototype($entity);
        $set->setHydrator(new ClassMethods());

        $tableGateway = new TableGateway('User', $db, null, $set);
        $mapper = new UserMapper($tableGateway);

        return $mapper;
    }
}