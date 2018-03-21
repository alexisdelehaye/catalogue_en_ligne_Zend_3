<?php
/**
 * Created by PhpStorm.
 * User: cdcde
 * Date: 21/03/2018
 * Time: 15:43
 */

class users {


    public $username;
    public $email;
    public $password;
    public $salt;

    public function exchangeArray(array $data)
    {
        $this->username = !empty($data['username']) ? $data['username'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password = !empty($data['password']) ? $data['password'] : null;
        $this->salt = !empty($data['salt']) ? $data['salt'] : null;
    }

    public function toValues()
    {

        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'salt' => $this->salt

        ];
    }
}