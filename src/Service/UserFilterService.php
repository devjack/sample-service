<?php

namespace SampleService\Service;

use Zend\Cache\Storage\StorageInterface;

class UserFilterService
{
    protected $options = array();

    protected $filters = array();

    protected $validOptions = array();

    protected $validFilters = array();

    protected $defaultOptions = array(
        'page' => 1,
        'perpage' => 10,
        'order' => 'id',
        'direction' => 'DESC',
    );

    /** @var StorageInterface */
    protected $filterStorage;

    public function configure(array $data)
    {
        $options = array_intersect_key($data, $this->getValidOptions());
        $filters = array_intersect_key($data, $this->getValidFilters());

        $this->setOptions($options);
        $this->setFilters($filters);

        $storage = $this->getFilterStorage();
        $storage->setItem('options', $this->getOptions());
        $storage->setItem('filters', $this->getFilters());
    }

    /**
     * @param StorageInterface $filterStorage
     */
    public function setFilterStorage(StorageInterface $filterStorage)
    {
        $this->filterStorage = $filterStorage;
    }

    /**
     * @return StorageInterface
     */
    public function getFilterStorage()
    {
        return $this->filterStorage;
    }

    /**
     * @param array $filters
     */
    public function setFilters(array $filters)
    {
        // Remove empty strings. E.G. from form submissions etc.
        $newFilters = array();
        foreach ($filters as $key => $val) {
            $newFilters[$key] = $val;
        }
        $this->filters = $newFilters;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        if (!$this->filters) {
            $storage = $this->getFilterStorage();
            if ($storage->hasItem('filters')) {
                $this->setFilters($storage->getItem('filters') );
            }
        }

        return $this->filters;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = array_replace_recursive($this->defaultOptions, $options);
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $validFilters
     */
    public function setValidFilters($validFilters)
    {
        $this->validFilters = $validFilters;
    }

    /**
     * @return array
     */
    public function getValidFilters()
    {
        return $this->validFilters;
    }

    /**
     * @param array $validOptions
     */
    public function setValidOptions($validOptions)
    {
        $this->validOptions = $validOptions;
    }

    /**
     * @return array
     */
    public function getValidOptions()
    {
        return $this->validOptions;
    }
}
