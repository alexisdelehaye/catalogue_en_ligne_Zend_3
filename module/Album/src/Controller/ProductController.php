<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 16:22
 */

namespace Album\Controller;

use Album\Model\Product;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Album\Model\ProductTable;


class  ProductController extends AbstractActionController
{
    private $table;

// Add this constructor:
    public function __construct(ProductTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        return new ViewModel([
            'product' => $this->table->fetchAll(),
        ]);
    }

}