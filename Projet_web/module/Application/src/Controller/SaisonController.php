<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

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

        //Récupère ids depuis url
        $this->_idSerie=$this->params()->fromRoute('idSerie');
        $this->_idSaison=$this->params()->fromRoute('idSaison');

        return new ViewModel([
            'idSerie'=>$this->_idSerie,
            'idSaison'=>$this->_idSaison,
        ]);
    }
}
