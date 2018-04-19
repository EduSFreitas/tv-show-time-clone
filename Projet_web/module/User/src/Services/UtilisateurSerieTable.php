<?php
namespace User\Services;

use Zend\Db\TableGateway\TableGatewayInterface;
use User\Models\Utilisateurserie;

class UtilisateurSerieTable {
    protected $_tableGateway;
    protected $authService;
    protected $userManager;

    public function __construct(TableGatewayInterface $tableGateway,$authService,$userManager){
        $this->_tableGateway = $tableGateway;
        $this->authService = $authService;
        $this->userManager = $userManager;
    }

     // Fonction permettant d'insérer une série dans la base de donnée
    public function insertSerie(Utilisateurserie $s){
        $this->_tableGateway->insert($s->toValues());
    }

    // Fonction permettant de modifier une valeur dans la base de donnée
    public function UpdateStatutSerie(Utilisateurserie $toUpdate, $data){
        return $this->_tableGateway->update(['idUtilisateur' => $data['_idUtilisateur'],'favoris'=>$data['_favoris']],['idUtilisateur' => $toUpdate->_idUtilisateur,'favoris'=>$toUpdate->_favoris]);
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

    //Renvoie requete pour un id utilisateur
    public function findByIdSerie($idSerie){
        return $this->_tableGateway->select(['idSerie' => $idSerie])->current();
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

    //Où episodesVus>0
    public function fetchSeriesEnCoursByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->getUserConnected();

        //Récupère les objets
        $resultSet=$this->_tableGateway->select(['idUtilisateur' => $id,'episodesVus>0']);
        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }

    //Où episodesVus==0
    public function fetchSeriesADemarrerByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->getUserConnected();

        //Récupère les objets
        $resultSet=$this->_tableGateway->select(['idUtilisateur' => $id,'episodesVus=0']);

        $return = array();
        foreach( $resultSet as $r )
            $return[]=$r;
        return $return;
    }


    //Où favoris==1
    public function fetchSeriesFavoritesByUserConnected(){

        //Récupère id de l'utilisateur connecté
        $id=$this->getUserConnected();

        //Récupère les objets
        $resultSet=$this->_tableGateway->select(['idUtilisateur' => $id,'favoris=1']);

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