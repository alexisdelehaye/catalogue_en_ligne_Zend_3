<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 16:22
 */

namespace Album\Controller;

use Album\Form\ProductForm;
use Album\Model\PanierTable;
use Album\Model\Product;
use Album\Model\ProductTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Form\Form;

class  ProductController extends AbstractActionController
{
    private $table;
    private $tablePanier;

// Add this constructor:
    public function __construct(ProductTable $table, PanierTable $panierTable)
    {
        $this->table = $table;
        $this->tablePanier = $panierTable;
    }

    public function indexAction()
    {
        return new ViewModel([
            'product' => $this->table->fetchAll(),
        ]);
    }

    public function detailsAction(){

        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $product = $this->table->getProduct($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }


        $view = new ViewModel();
        $view->setVariable('details',$product);
        return $view;

    }

    public function AjoutPanierAction(){
        $id = (int) $this->params()->fromRoute('id', 0);;


        if (0 === $id) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.

        try {
            $product =  $this->table->getProduct($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }


        $this->tablePanier->saveProduct($product);
        $view = new ViewModel();
        $view->setVariable('ajoutPanier',$product);
        return $view;
    }

    public function IndexPanierAction(){
        return new ViewModel([
            'panier' => $this->tablePanier->fetchAll(),
        ]);
    }


    public function addAction()
    {
        $form = new ProductForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $product = new Product();
        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $product->exchangeArray($form->getData());
        $this->table->saveProduct($product);
        return $this->redirect()->toRoute('product');
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('product');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteProduct($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('product');
        }

        return [
            'id'    => $id,
            'product' => $this->table->getProduct($id),
        ];
    }



}