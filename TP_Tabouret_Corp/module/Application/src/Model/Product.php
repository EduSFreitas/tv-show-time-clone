<?php
namespace Application\Model;

class Product {
    public $_id;
    public $_name;
    public $_description;
    public $_price;


    public function __construct(){

    }

    public function exchangeArray($data) {
        $this->_id = (!empty($data['id'])) ? $data['id'] : null;
        $this->_name = (!empty($data['name'])) ? $data['name'] : null;
        $this->_description = (!empty($data['description'])) ? $data['description'] : null;
        $this->_price = (!empty($data['price'])) ? $data['price'] : null;
    }

    // Converti le model vers un tableau associatif
    public function toValues(){
        return [
            'id' => $this->_id,
            'name' => $this->_name,
            'description' => $this->_description,
            'price' => $this->_price,
            ];
    }
}
?>