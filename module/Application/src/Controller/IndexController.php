<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Services\ProductTable;

class IndexController extends AbstractActionController
{
    private $_table;

    public function __construct(ProductTable $table)
    {
        $this->_table = $table;
    }

    //Arrivée sur l'index
    public function indexAction()
    {
        $paginated=true;

        //Crée les objets du paginator
        $paginator = $this->_table->fetchAll($paginated);

        if($paginated){
            //Set le numéro de la page à celui de l'url
            $paginator->setCurrentPageNumber((int) $this->params()->fromRoute('page', 1));
            //Set le nombre d'objets affichés à 8
            $paginator->setItemCountPerPage(8);
        }

        return new ViewModel([
            'products' => $paginator,
            'paginated'=> $paginated
        ]);
    }

    // / renvoie vers /page/1
    public function redirectAction(){
        return $this->redirect()->toRoute('paginator');
    }
}
