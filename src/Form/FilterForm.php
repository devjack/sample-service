<?php

namespace SampleService\Form;

use Zend\Form\Form;

class FilterForm extends Form
{

    /**
     * Construct list of items to appear on the form
     * @param string $name
     * @param array  $options
     */
    public function __construct($name = 'UserFilterForm', $options = array())
    {
        parent::__construct($name, $options);

        $this->add(array(
            'type' => '\Zend\Form\Element\Text',
            'name' => 'id',
            'options' => array(
                'required' => false,
                'label' => 'User ID',
                'label_attributes' => array(
                    'class'  => 'radio inline'
                ),
            ),
            'attributes' => array(
                'id' => 'id',
            ),
        ));

        $this->add(array(
            'name' => 'search',
            'type' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Search',
                'class' => 'btn'
            ),
        ));
    }

}
