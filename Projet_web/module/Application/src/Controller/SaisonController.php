<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;
use Zend\Json\Json;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Json\Decoder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Services\UserManager;
use User\Services\UtilisateurSerieTable;

use User\Models\Utilisateurserie; 

class SaisonController extends AbstractActionController
{

    private $_idSerie;
    private $_idSaison;
    private $authService;
    private $userManager;
    private $_utilisateurSerie;

    public function __construct($authService,UserManager $userManager,UtilisateurSerieTable $utilisateurSerie)
    {
        $this->authService = $authService;
        $this->userManager = $userManager;
        $this->_utilisateurSerie = $utilisateurSerie;
    }

    public function saisonAction()
    {
        //Récupère de la série et de la saison depuis l'url
        $this->_idSerie=$this->params()->fromRoute('idSerie');
        $this->_idSaison=$this->params()->fromRoute('idSaison');

        //Prépare requete pour obtenir nom et date de la série 
        $request = new Request();
        $request->setMethod(Request::METHOD_GET);
        $request->setUri('http://api.trakt.tv/shows/'.$this->_idSerie.'/seasons/'.$this->_idSaison);
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'trakt-api-key' => '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6',
            'trakt-api-version' => '2',
            'Authorization' => 'Bearer [access_token]',
        ));

        //Envoie requete
        $client = new Client();
        $api = $client->send($request);

        //Décode le json vers php
        $episode = Json::decode($api->getBody());

        return new ViewModel([
            'idSerie'=>$this->_idSerie,
            'idSaison'=>$this->_idSaison,
            'episode'=>$episode,
        ]);
    }

    public function ajoutSerieAction(){
        //Récupère id de l'utilisateur connecté
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;
        // Récupère l'id de la série
        $idSerie = $this->_idSerie=$this->params()->fromRoute('idSerie');
        $object = new Utilisateurserie(); 
        $object->_idUtilisateur =$idUser; 
        $object->_idSerie = $idSerie; 
        $object->_episodesRestants = NULL; 
        $object->_episodesVus= 0; 
        $object->_note=NULL;
        $object->_favoris=0;
        $ajouterListe = $this->_utilisateurSerie->insertSerie($object); 
        return $this->redirect()->toRoute('user');      
    }

    public function ajoutFavorisAction(){
        $idSerie=$this->params()->fromRoute('idSerie');
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;
    
        $resultSet=$this->_utilisateurSerie->findByIdSerie($idSerie);
        $resultUpdate=$this->_utilisateurSerie->findByIdSerie($idSerie);
         
        $resultUpdate->_favoris = 1 ; 
        // Transformer l'objet en array
        $resultUpdateA = (array) $resultUpdate ;
        $updateRes = $this->_utilisateurSerie->UpdateStatutSerie($resultSet, $resultUpdateA); 
        return $this->redirect()->toRoute('user');
    }

   public function supprimerFavorisAction(){
        $idSerie=$this->params()->fromRoute('idSerie');
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;
    
        $resultSet=$this->_utilisateurSerie->findByIdSerie($idSerie);
        $resultUpdate=$this->_utilisateurSerie->findByIdSerie($idSerie);
         
        $resultUpdate->_favoris = 0 ; 
        // Transformer l'objet en array
        $resultUpdateA = (array) $resultUpdate ;
        $updateRes = $this->_utilisateurSerie->UpdateStatutSerie($resultSet, $resultUpdateA); 
        return $this->redirect()->toRoute('user');
    } 
}
