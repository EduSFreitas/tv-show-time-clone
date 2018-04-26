<?php
namespace Application\Services;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Product;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ProductTable {
    protected $_tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->_tableGateway = $tableGateway;
    }

    //Récupère tous les produits
    public function fetchAll($paginated=false) {
        //Si pagination, on ne récupère pas tout d'un coup
        if ($paginated) {
            return $this->fetchPaginatedResults();
        }
        return $this->_tableGateway->select();
    }

    //Récupère la liste de produits paginés
    public function fetchPaginatedResults(){
        $select = new Select($this->_tableGateway->getTable());
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Product());
        $paginatorAdapter = new DbSelect(
            $select,
            $this->_tableGateway->getAdapter(),
            $resultSetPrototype
        );
        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }

    //Ajoute un produit à la liste
    public function insert($name,$description,$price){
        $tab=['name' => $name,'description' => $description,'price' => $price];
        $this->_tableGateway->insert($tab);
    }

    //Met à jour un produit
    public function update($id,$name,$description,$price){
        $tab=['name' => $name,'description' => $description,'price' => $price];
        $this->_tableGateway->update($tab,['id' => $id]);
    }

    //Supprime un produit
    public function delete($id){
        $this->_tableGateway->delete(['id' => $id]);
    }

    //Renvoie le résultat d'une requete avec un id de produit. Si il n'existe pas, renvoie false
    public function find($id){
        $select=$this->_tableGateway->select(['id' => $id]);
        if(!$select){
            return false;
        }else{
            return $select->current();
        }
    }
}
?>