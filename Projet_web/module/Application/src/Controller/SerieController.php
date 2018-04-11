<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

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

        return new ViewModel([
            'idSerie'=>$this->_idSerie,
        ]);
    }
}
