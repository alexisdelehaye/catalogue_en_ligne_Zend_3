<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 15:48
 */
class UserPrivilege {

    public $idUser;
    public $idPrivilege;


    public function exchangeArray(array $data)
    {
        $this->idUser = !empty($data['idUser']) ? $data['idUser'] : null;
        $this->idPrivilege = !empty($data['idPrivilege']) ? $data['idPrivilege'] : null;
    }

    public function toValues()
    {

        return [
            'idUser' => $this->idUser,
            'idPrivilege' => $this->idPrivilege,


        ];
    }
}