<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use User\Services\UtilisateurBadgeTable;
use Zend\Json\Json;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Json\Decoder;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use User\Services\UserManager;
use User\Services\UtilisateurSerieTable;
use User\Models\Utilisateurserie;
use User\Models\Utilisateurbadge;
use User\Services\UtilisateurEpisodeSerieTable;
use User\Models\Utilisateurepisodeserie; 


class SaisonController extends AbstractActionController
{

    private $_idSerie;
    private $_idSaison;
    private $_idEpisode;

    private $authService;
    private $userManager;
    private $_utilisateurSerie;
    private $_utilisateurBadge;
    private $_utilisateurEpisodeSerie;
    

    public function __construct($authService,UserManager $userManager,UtilisateurSerieTable $utilisateurSerie,UtilisateurEpisodeSerieTable $utilisateurEpisodeSerie,UtilisateurBadgeTable $utilisateurBadge)
    {
        $this->authService = $authService;
        $this->userManager = $userManager;
        $this->_utilisateurSerie = $utilisateurSerie;
        $this->_utilisateurBadge = $utilisateurBadge;
        $this->_utilisateurEpisodeSerie = $utilisateurEpisodeSerie;
    }

    public function saisonAction()
    {
        //Récupère de la série et de la saison depuis l'url
        $idSerie = $this->_idSerie=$this->params()->fromRoute('idSerie');
        $idSaison = $this->_idSaison=$this->params()->fromRoute('idSaison');
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;

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

        //Prépare requete pour obtenir nom et date de la série 
        $request2 = new Request();
        $request2->setMethod(Request::METHOD_GET);
        $request2->setUri('http://api.trakt.tv/shows/'.$this->_idSerie.'?extended=full');
        $request2->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'trakt-api-key' => '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6',
            'trakt-api-version' => '2',
            'Authorization' => 'Bearer [access_token]',
        ));
        $client = new Client();

        $api = $client->send($request);
        $api2 = $client->send($request2);
        $serie = Json::decode($api2->getBody());
        $arrayImages = array();
        // Récupère l'id de la série pour OMDB
        $idOMDB = $serie->ids->imdb;

        //Prépare requete
        $requestOMDB = new Request();
        $requestOMDB->setMethod(Request::METHOD_GET);
        $requestOMDB->setUri('http://www.omdbapi.com/?i='.$idOMDB.'&apikey=215947ec');
        $requestOMDB->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'trakt-api-key' => '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6',
            'trakt-api-version' => '2',
            'Authorization' => 'Bearer [access_token]',
        ));

        //Envoie requete
       
        $clientOMDB = new Client();
        
        $apiOMDB = $clientOMDB->send($requestOMDB);

        //Décode le json vers php
        $episode = Json::decode($api->getBody());
        $resultatOMDB = Json::decode($apiOMDB->getBody()); 

        $nbEpisode= count($episode) ;
        $tab = array(); 

        for($i=0 ; $i<$nbEpisode+1; $i++){
            $req= $this->_utilisateurEpisodeSerie->select($idUser, $idSerie, $idSaison, $i);
            if($req!=null){
                $tab[$i]=true;
            }
            else{
                $tab[$i]=false;
            }
        }
        return new ViewModel([
            'idSerie'=>$this->_idSerie,
            'idSaison'=>$this->_idSaison,
            'episode'=>$episode,
            'tab'=>$tab,
            'image'=>$resultatOMDB,
        ]);
    }

    public function checkAction(){
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;
        $idSerie = $this->_idSerie=$this->params()->fromRoute('idSerie');
        
        $nbEpisodeVus=$this->_utilisateurSerie->findByIdSerieUser($idUser, $idSerie);
        $nbEpisodeVusIncrément=$this->_utilisateurSerie->findByIdSerieUser($idUser, $idSerie);

        $nbEpisodeVusIncrément->_episodesVus =  $nbEpisodeVusIncrément->_episodesVus + 1 ; 
        $nbEpisodeFinal= (array) ($nbEpisodeVusIncrément) ; 
        $nbEpisodeVusUpdate = $this->_utilisateurSerie->UpdateNbEpisode($nbEpisodeVus, $nbEpisodeFinal);

        //Insertion dans la base utilisateur episode serie
        $idSaison = $this->_idSaison=$this->params()->fromRoute('idSaison');
        $idEpisode = $this->_idEpisode=$this->params()->fromRoute('idCheck'); 

        $object = new Utilisateurepisodeserie(); 
        $object->_idUtilisateur =$idUser; 
        $object->_idSerie = $idSerie; 
        $object->_idSaison = $idSaison;
        $object->_idEpisode = $idEpisode ; 
        $object->_note = 0 ; 

        $ajouterEpisode = $this->_utilisateurEpisodeSerie->insert($object);

        //Gestion des badges
        $this->_utilisateurBadge->testBadges($idUser);


        return $this->redirect()->toRoute('saison', array(
            'action' => 'saison',
            'idSerie' =>$idSerie,
            'idSaison'=>$idSaison,
        ));
    }

    public function unCheckAction(){
        $idUser=$this->userManager->findByMail($this->authService->getIdentity())->_id;
        $idSerie = $this->_idSerie=$this->params()->fromRoute('idSerie');
        
        $nbEpisodeVus=$this->_utilisateurSerie->findByIdSerieUser($idUser, $idSerie);
        $nbEpisodeVusIncrément=$this->_utilisateurSerie->findByIdSerieUser($idUser, $idSerie);

        $nbEpisodeVusIncrément->_episodesVus =  $nbEpisodeVusIncrément->_episodesVus - 1 ; 
        $nbEpisodeFinal= (array) ($nbEpisodeVusIncrément) ; 
        $nbEpisodeVusUpdate = $this->_utilisateurSerie->UpdateNbEpisode($nbEpisodeVus, $nbEpisodeFinal); 

        //Suppression dans la base utilisateur episode serie
        $idSaison = $this->_idSaison=$this->params()->fromRoute('idSaison');
        $idEpisode = $this->_idEpisode=$this->params()->fromRoute('idUnCheck'); 

        $supprimerEpisode = $this->_utilisateurEpisodeSerie->delete($idUser, $idSerie, $idSaison, $idEpisode);


        return $this->redirect()->toRoute('saison', array(
            'action' => 'saison',
            'idSerie' =>$idSerie,
            'idSaison'=>$idSaison,
        ));
    }
}
