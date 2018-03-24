<?php

namespace Album\Form;

use Zend\Form\Form;

class ProductForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('product');

        //$this->setAttribute('method', 'GET'); // Default is POST

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'nom',
            'type' => 'text',
            'options' => [
                'label' => 'nom',
            ],
        ]);

        $this->add([
            'name' => 'description',
            'type' => 'text',
            'options' => [
                'label' => 'description',
            ],

        ]);

        $this->add([
            'name'=>'prix',
        'type'=> 'number',
            'options' => [
                'label' => 'prix',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}