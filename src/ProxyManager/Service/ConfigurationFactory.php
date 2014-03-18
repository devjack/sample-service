<?php

namespace SampleService\ProxyManager\Service;

use ProxyManager\Configuration;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Exception\RuntimeException;

class ConfigurationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        // Config must be available
        if (!isset($config['proxyManager'])) {
            throw new RuntimeException('Proxy Manager configuration must be defined. Did you copy the config file?');
        }

        $config = $config['proxyManager'];
        $configuration = new Configuration();


        // ProxiesTargetDir for caching, where set.
        if (isset($config['proxiesTargetDir'])) {

            // Directory cross-platform sensitivity
            str_replace('\\', DIRECTORY_SEPARATOR, $config['proxiesTargetDir']);

            $configuration->setProxiesTargetDir($config['proxiesTargetDir']);
            spl_autoload_register($configuration->getProxyAutoloader());
        }

        return $configuration;
    }
}
