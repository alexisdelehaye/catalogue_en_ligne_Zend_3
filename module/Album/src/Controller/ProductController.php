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

    public function detailsAction(){

        $id = (int) $this->params()->fromRoute('id', 0);
    /*
        if (0 === $id) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {

        } catch (\Exception $e) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

    */
        $product = $this->table->getProduct($id);
        $view = new ViewModel();
        $view->setVariable('details',$product);
        return $view;

    }
}