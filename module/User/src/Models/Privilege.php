<?php
namespace User\Models;

class Privilege {
    public $_id;
    public $_value;

    public function __construct(){}

    public function exchangeArray($data) {
        $this->_id = (!empty($data['id'])) ? $data['id'] : null;
        $this->_value = (!empty($data['value'])) ? $data['value'] : null;
    }

    public function toValues(){
        return [
            'id' => $this->_id,
            'value' => $this->_value
        ];
    }
}
?>