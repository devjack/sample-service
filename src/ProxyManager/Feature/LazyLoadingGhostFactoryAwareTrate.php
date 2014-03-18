<?php

namespace SampleService\ProxyManager\Feature;

use ProxyManager\Factory\LazyLoadingGhostFactory;
use Zend\Stdlib\Exception\LogicException;

trait LazyLoadingGhostFactoryAwareTrait
{
    /**
     * @var LazyLoadingGhostFactory
     */
    protected $lazyLoadingGhostFactory;

    /**
     * @param LazyLoadingGhostFactory $lazyLoadingGhostFactory
     */
    public function setLazyLoadingGhostFactory($lazyLoadingGhostFactory)
    {
        $this->lazyLoadingGhostFactory = $lazyLoadingGhostFactory;
    }

    /**
     * @return LazyLoadingGhostFactory
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function getLazyLoadingGhostFactory()
    {
        if (null === $this->lazyLoadingGhostFactory) {
            throw new LogicException('Lazy loading GhostObject factory must be defined');
        }

        return $this->lazyLoadingGhostFactory;
    }
}
