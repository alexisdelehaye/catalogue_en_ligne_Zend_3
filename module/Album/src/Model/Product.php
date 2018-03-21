<?php
namespace Album\Model;

use DomainException;

class Product
{

    public $id;
    public $nom;
    public $description;
    public $prix;



    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->nom = !empty($data['nom']) ? $data['nom'] : null;
        $this->description = !empty($data['description']) ? $data['description'] : null;
        $this->prix = !empty($data['prix']) ? $data['prix'] : null;
    }

    public function getArrayCopy()
    {

        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'prix' => $this->prix

        ];
    }

}

?>