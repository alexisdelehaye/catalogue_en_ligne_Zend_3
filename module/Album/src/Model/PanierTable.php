<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 16:27
 */

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class PanierTable {

    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

    public function getProduct($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveProduct(Product $product)
    {
       $id = (int) $product->id;

        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();

        while ($row != null){
            $id++;
            $rowset = $this->tableGateway->select(['id' => $id]);
            $row = $rowset->current();
        }

        $data = [
            'id'=> (int) $id,
            'nom'  => $product->nom,
            'description'=>$product->description,
            'prix'=>$product->prix
        ];

                $this->tableGateway->insert($data);
                }
        /*

        if (! $this->getProduct($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
        */
       // $this->tableGateway->insert($data);


    public function deleteProduct($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }


}