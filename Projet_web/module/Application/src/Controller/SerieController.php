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

class SerieController extends AbstractActionController
{
    private $_idSerie;
    public function __construct()
    {
    }


    public function serieAction()
    {

        //Récupère de la série depuis l'url
        $this->_idSerie=$this->params()->fromRoute('idSerie');

        //Prépare requete pour obtenir nom et date de la série 
        $request = new Request();
        $request->setMethod(Request::METHOD_GET);
        $request->setUri('http://api.trakt.tv/shows/'.$this->_idSerie);
        $request->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'trakt-api-key' => '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6',
            'trakt-api-version' => '2',
            'Authorization' => 'Bearer [access_token]',
        ));

        //Prépare requete pour obtenir saisons
        $request2 = new Request();
        $request2->setMethod(Request::METHOD_GET);
        $request2->setUri('http://api.trakt.tv/shows/'.$this->_idSerie.'/seasons');
        $request2->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json',
            'trakt-api-key' => '7f64fc2ceef5b70439a9736df3b9b9310eddd6c57ecb55743d178bc1300a40c6',
            'trakt-api-version' => '2',
            'Authorization' => 'Bearer [access_token]',
        ));

        //Envoie requete
        $client = new Client();
        $api = $client->send($request);
        $api2 = $client->send($request2); 

        //Décode le json vers php
        $serie = Json::decode($api->getBody());
        $saison = Json::decode($api2->getBody());


        // -----------Requete sur OMDB------------- //
        
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

        //Décope le json vers php
        $resultatOMDB = Json::decode($apiOMDB->getBody());

        return new ViewModel([
            'idSerie'=>$this->_idSerie,
            'serie'=>$serie,
            'saison'=>$saison,
            'image' => $resultatOMDB
        ]);
    }
}
