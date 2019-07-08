<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 16:22
 */

namespace Album\Controller;

use Album\Form\ProductForm;
use Album\Form\searchForm;
use Album\Model\PanierTable;
use Album\Model\Product;
use Album\Model\ProductTable;
use Zend\Db\Sql\Sql;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Db\Adapter\AdapterInterface;

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
        $paginator = $this->table->fetchAll(true);

        // Set the current page to what has been passed in query string,
        // or to 1 if none is set, or the page is invalid:
        $page = (int) $this->params()->fromQuery('page', 1);
        $page = ($page < 1) ? 1 : $page;
        $paginator->setCurrentPageNumber($page);

        // Set the number of items per page to 10:
        $paginator->setItemCountPerPage(10);

        return new ViewModel(['paginator' => $paginator]);
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

    public function payerpanierAction(){
        $echecTrans= rand(0,1);

        $view = new ViewModel();
        $view->setVariable('echecTrans',$echecTrans);
        $this->tablePanier->deleteAll();
        $view->setTemplate('album/product/PayerPanier');
        return $view;

}


public function rechercheProduitAction(){

    $form = new searchForm();
    $form->get('submit')->setValue('rechercher');

    $request = $this->getRequest();
    $form->setData($request->getPost());

    if (! $request->isPost()) {
        return ['form' => $form];
    }

    $productName = (string) $form->get('search')->getValue();//$this->table->getProductByName($request);
     $product = $this->table->getProductByName($productName);
    $view = new ViewModel();
    $view->setVariable('produitRechercher',$product);
    $view->setTemplate('album/RechercheProduit/AfficheRecherche');
    return $view;

}


public function supprimerProduitPanierAction(){

    $id = (int) $this->params()->fromRoute('id', 0);

    if (!$id) {
        return $this->redirect()->toRoute('product');
    }

    $request = $this->getRequest();

    if ($request->isPost()) {
        $del = $request->getPost('del', 'No');

        if ($del == 'Yes') {
            $id = (int) $request->getPost('id');
            $this->tablePanier->deleteProduct($id);
        }

        // Redirect to list of albums
        return $this->redirect()->toRoute('panier');
    }

    $view = new ViewModel();
    $view->setVariable('id',$id);
    $view->setVariable('product',$this->tablePanier->getProduct($id));
    $view->setTemplate('album/panier/supprimer-produit-panier');
    return $view;




}


    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('product', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $product = $this->table->getProduct($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('product', ['action' => 'index']);
        }

        $form = new ProductForm();
        $form->bind($product);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($product->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveProduct($product);

        // Redirect to album list
        return $this->redirect()->toRoute('product', ['action' => 'index']);
    }




}