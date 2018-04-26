<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PaiementController extends AbstractActionController
{

    public function __construct()
    {

    }

    //Au clic sur le bouton de paiement, dit si le paiement a réussi
    public function paiementAction(){

        $result=false;
        $nb=rand(0,1);
        if($nb==1){
            $result=true;
        }
        return new ViewModel([
            'result'=>$result,
        ]);
    }

}

