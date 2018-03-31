<?php


namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;

class searchForm extends Form
{


    public function __construct()
    {
        parent::__construct('search-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }


    protected function addElements()
    {
        // Add "search" field
        $this->add([
            'type'  => 'text',
            'name' => 'search',
            'options' => [
                'label' => 'Your search',
            ],
        ]);




        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'lancer la recherche',
                'id' => 'submit',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);



        $inputFilter->add([
            'name'     => 'search',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 256
                    ],
                ],
            ],
        ]);
    }

}
