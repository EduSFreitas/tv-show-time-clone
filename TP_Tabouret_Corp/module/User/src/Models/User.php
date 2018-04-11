<?php
namespace User\Models;

class User {
    public $_id;
    public $_username;
    public $_salt;
    public $_mail;
    public $_password;

    public function __construct(){

    }

    public function exchangeArray($data) {
        $this->_id = (!empty($data['id'])) ? $data['id'] : null;
        $this->_username = (!empty($data['username'])) ? $data['username'] : null;
        $this->_salt = (!empty($data['salt'])) ? $data['salt'] : null;
        $this->_mail = (!empty($data['mail'])) ? $data['mail'] : null;
        $this->_password = (!empty($data['password'])) ? $data['password'] : null;
    }

    public function toValues(){
        return [
            'id' => $this->_id,
            'username' => $this->_username,
            'salt' => $this->_salt,
            'mail' => $this->_mail,
            'password' => $this->_password
        ];
    }
}
?>