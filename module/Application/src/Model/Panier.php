<?php
namespace Application\Model;

class Panier {
    public $_id;
    public $_idUser;
    public $_idProduct;
    public $_quantity;

    public function __construct(){

    }

    public function exchangeArray($data) {
        $this->_id = (!empty($data['id'])) ? $data['id'] : null;
        $this->_idUser = (!empty($data['idUser'])) ? $data['idUser'] : null;
        $this->_idProduct = (!empty($data['idProduct'])) ? $data['idProduct'] : null;
        $this->_quantity = (!empty($data['quantity'])) ? $data['quantity'] : null;
    }

    public function toValues(){
        return [
            'id' => $this->_id,
            'idUser' => $this->_idUser,
            'idProduct' => $this->_idProduct,
            'quantity' => $this->_quantity,
        ];
    }
}
?>