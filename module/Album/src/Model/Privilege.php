<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 15:51
 */

class Privilege {
    public $id;
    public $valeur;



    public function exchangeArray(array $data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->valeur = !empty($data['valeur']) ? $data['valeur'] : null;
    }

    public function toValues()
    {

        return [
            'id' => $this->id,
            'valeur' => $this->valeur,


        ];
    }
}