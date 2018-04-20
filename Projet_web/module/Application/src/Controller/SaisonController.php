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

class SaisonController extends AbstractActionController
{

    private $_idSerie;
    private $_idSaison;
    

    public function __construct()
    {
       
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
}
