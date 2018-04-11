<?php
namespace Application\Services;

use Zend\Db\TableGateway\TableGatewayInterface;
use Application\Model\Panier;

class PanierTable {
    protected $_tableGateway;
    private $authService;
    private $userManager;


    public function __construct(TableGatewayInterface $tableGateway, $authService,$userManager){
        $this->_tableGateway = $tableGateway;
        $this->authService = $authService;
        $this->userManager = $userManager;

    }

    //Récupère tous les objets de la table panier
    public function fetchAll() {
        $resultSet = $this->_tableGateway->select();
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    //Récupère tous les objets du panier de l'utilisateur connecté
    public function fetchByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->getUserConnected();

        //Récupère les objets
        $resultSet=$this->_tableGateway->select(['idUser' => $id]);
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    //Récupère l'id de l'utilisateur connecté
    public function getUserConnected(){
        return $this->userManager->findByMail($this->authService->getIdentity())->_id;
    }

    //Ajoute le produit au panier de l'utilisateur connecté
    public function insert($idProduct){

        //Récupère l'id de l'utilisateur connecté
        $idUser=$this->getUserConnected();

        //Teste si l'entrée existe déjà
        $testExistence=$this->_tableGateway->select(['idUser' => $idUser,'idProduct'=>$idProduct]);

        //Si une entrée existe déjà, on augmente la quantité du produit et on update
        if($testExistence->count()>0){

            foreach ($testExistence as $test){
                $quantity=$test->_quantity+1;
                $id=$test->_id;
            }

            $tab=['idUser' => $idUser,'idProduct' => $idProduct,'quantity'=>$quantity];
            $this->_tableGateway->update($tab,['id'=>$id]);

        //Sinon, on insere une nouvelle ligne avec une quantité de 1
        }else{
            $quantity=1;

            $tab=['idUser' => $idUser,'idProduct' => $idProduct,'quantity'=>$quantity];
            $this->_tableGateway->insert($tab);
        }
    }

    //Supprime un élément du panier de l'utilisateur connecté
    public function delete($idProduct){

        //Récupère l'id de l'utilisateur connecté
        $idUser=$this->getUserConnected();

        //Permet de récupérer la quantité de l'objet voulu
        foreach ($this->_tableGateway->select(['idProduct' => $idProduct,'idUser'=>$idUser]) as $panier){
            $quantity=$panier->_quantity;
        }

        //Si la quantité de l'objet dans le panier est 1, on supprime directement la ligne
        if($quantity==1){
            $this->_tableGateway->delete(['idUser'=>$idUser, 'idProduct' => $idProduct]);
        }
        //Sinon, on réduit de 1 la quantité
        else{
            $tab=['idUser' => $idUser,'idProduct' => $idProduct,'quantity'=>$quantity-1];
            $this->_tableGateway->update($tab,['id'=>$idProduct]);
        }
    }

    //Supprime un produit de tous les paniers (voir suppressionAction() dans AdministrationController)
    public function deleteAll($idProduct){
        $this->_tableGateway->delete(['idProduct' => $idProduct]);
    }

}
?>