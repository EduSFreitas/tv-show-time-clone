<?php
namespace User\Services;

use Zend\Db\TableGateway\TableGatewayInterface;

class UtilisateurSerieTable {
    protected $_tableGateway;
    protected $authService;
    protected $userManager;

    public function __construct(TableGatewayInterface $tableGateway,$authService,$userManager){
        $this->_tableGateway = $tableGateway;
        $this->authService = $authService;
        $this->userManager = $userManager;
    }

    //Renvoie tout
    public function fetchAll() {
        $resultSet = $this->_tableGateway->select();
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    //Renvoie requete pour un id utilisateur
    public function findById($idUser){
        return $this->_tableGateway->select(['idUtilisateur' => $idUser])->current();
    }


    //Récupère tous les objets du panier de l'utilisateur connecté
    public function fetchByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->getUserConnected();

        //Récupère les objets
        $resultSet=$this->_tableGateway->select(['idUtilisateur' => $id]);
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }



    //Récupère l'id de l'utilisateur connecté
    public function getUserConnected(){
        return $this->userManager->findByMail($this->authService->getIdentity())->_id;
    }

}
?>