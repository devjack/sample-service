<?php
namespace SampleService\Form\Feature;


use SampleService\Form\FilterForm;

use Zend\Stdlib\Exception\LogicException;

trait FilterFormAwareTrait
{

    protected $filterForm;

    /**
     * @param FilterForm $form
     */
    public function setFilterForm(FilterForm $form)
    {
        $this->filterForm = $form;
    }

    /**
     * @return FilterForm
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function getFilterForm()
    {
        if (null === $this->filterForm) {
            throw new LogicException('Filter form must be defined');
        }

        return $this->filterForm;
    }

}
