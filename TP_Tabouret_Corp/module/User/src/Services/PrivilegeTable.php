<?php
namespace User\Services;

use Zend\Db\TableGateway\TableGatewayInterface;

class PrivilegeTable {
    protected $_tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->_tableGateway = $tableGateway;
    }

    //Récupère tous les privileges
    public function fetchAll() {
        $resultSet = $this->_tableGateway->select();
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    //Renvoie la requete pour un id
    public function findById($id){
        return $this->_tableGateway->select(['id' => $id])->current();
    }

}
?>