<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 15:36
 */

namespace Album\Model;


class MetaData {

public $id;
public $nom;
public $valeur;


    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->nom = !empty($data['nom']) ? $data['nom'] : null;
        $this->valeur = !empty($data['valeur']) ? $data['valeur'] : null;
    }

    public function toValues()
    {

        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'valeur' => $this->valeur

        ];
    }



}